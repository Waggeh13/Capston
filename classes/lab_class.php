<?php
require_once("../settings/db_class.php");

class lab_class extends db_connection {

    public function requestform($staff_id, $patient_fullname, $testRequests, $susdiag, $signature, $ext, $request_date) {
        $conn = $this->db_conn();
        
        if ($conn === false) {
            throw new Exception("Database connection failed.");
        }

        // Sanitize inputs
        $staff_id = mysqli_real_escape_string($conn, $staff_id);
        $patient_fullname = mysqli_real_escape_string($conn, $patient_fullname);
        $susdiag = mysqli_real_escape_string($conn, $susdiag);
        $signature = mysqli_real_escape_string($conn, $signature);
        $ext = mysqli_real_escape_string($conn, $ext);
        $request_date = mysqli_real_escape_string($conn, $request_date);

        // Start transaction
        if (!mysqli_begin_transaction($conn)) {
            throw new Exception("Failed to start transaction: " . mysqli_error($conn));
        }

        try {
            // Get patient_id
            $names = explode(' ', $patient_fullname, 2);
            $firstName = mysqli_real_escape_string($conn, $names[0]);
            $lastName = isset($names[1]) ? mysqli_real_escape_string($conn, $names[1]) : '';
            
            $patient_sql = "SELECT patient_id FROM patient_table 
            WHERE first_name = '$firstName' AND last_name = '$lastName'";
            $patient_result = mysqli_query($conn, $patient_sql);
            
            if ($patient_result === false || mysqli_num_rows($patient_result) == 0) {
                throw new Exception("Patient not found: $patient_fullname");
            }
            $patient_row = mysqli_fetch_assoc($patient_result);
            $patient_id = $patient_row['patient_id'];


            // Insert into lab_table with doctor_id (staff_id)
            $lab_sql = "INSERT INTO lab_table (
                            patient_id, 
                            staff_id, 
                            suspected_diagnosis, 
                            signature, 
                            extension, 
                            request_date
                        ) VALUES (
                            '$patient_id',
                            '$staff_id',
                            '$susdiag',
                            '$signature',
                            '$ext',
                            '$request_date'
                        )";
            
            if (!mysqli_query($conn, $lab_sql)) {
                throw new Exception("Failed to create lab record: " . mysqli_error($conn));
            }

            $lab_id = mysqli_insert_id($conn);
            if ($lab_id === 0) {
                throw new Exception("Failed to get lab ID");
            }

            // Deduplicate test requests
            $testRequests = array_unique($testRequests);

            // Insert each test request into lab_test_table
            foreach ($testRequests as $testName) {
                $testName = mysqli_real_escape_string($conn, $testName);
                
                // Check if test already exists for this lab_id to prevent duplicates
                $check_sql = "SELECT COUNT(*) FROM lab_test_table lt
                            JOIN test_type_table tt ON lt.test_type_id = tt.test_type_id
                            WHERE lt.lab_id = '$lab_id' AND tt.test_name = '$testName'";
                $check_result = mysqli_query($conn, $check_sql);
                $count = mysqli_fetch_row($check_result)[0];
                
                if ($count > 0) {
                    continue; // Skip if test already exists for this lab_id
                }

                // Get or create test_type_id
                $test_sql = "SELECT test_type_id FROM test_type_table WHERE test_name = '$testName'";
                $test_result = mysqli_query($conn, $test_sql);
                
                if ($test_result === false) {
                    throw new Exception("Test query failed: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($test_result) == 0) {
                    $insert_test_sql = "INSERT INTO test_type_table (test_name) VALUES ('$testName')";
                    if (!mysqli_query($conn, $insert_test_sql)) {
                        throw new Exception("Failed to create test type: " . mysqli_error($conn));
                    }
                    $test_type_id = mysqli_insert_id($conn);
                } else {
                    $test_row = mysqli_fetch_assoc($test_result);
                    $test_type_id = $test_row['test_type_id'];
                }

                // Insert into lab_test_table
                $lab_test_sql = "INSERT INTO lab_test_table (
                                    lab_id, 
                                    test_type_id, 
                                    result_status
                                ) VALUES (
                                    '$lab_id',
                                    '$test_type_id',
                                    'Pending'
                                )";
                
                if (!mysqli_query($conn, $lab_test_sql)) {
                    throw new Exception("Failed to add test '$testName': " . mysqli_error($conn));
                }
            }

            // Commit transaction
            if (!mysqli_commit($conn)) {
                throw new Exception("Failed to commit transaction: " . mysqli_error($conn));
            }
            return true;

        } catch (Exception $e) {
            mysqli_rollback($conn);
            throw $e;
        } finally {
            mysqli_close($conn);
        }
    }

    public function getlabresult() {
        $conn = $this->db_conn();
        $sql = "SELECT l.lab_id, p.first_name, p.last_name, l.request_date, 
                    GROUP_CONCAT(tt.test_name SEPARATOR ', ') as tests,
                    MIN(lt.result_status) as overall_status
                FROM lab_table l
                JOIN patient_table p ON l.patient_id = p.patient_id
                JOIN lab_test_table lt ON l.lab_id = lt.lab_id
                JOIN test_type_table tt ON lt.test_type_id = tt.test_type_id
                GROUP BY l.lab_id
                ORDER BY l.request_date DESC";
        
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }

    public function getlabresultbyid($lab_id) {
        $conn = $this->db_conn();
        $lab_id = mysqli_real_escape_string($conn, $lab_id);
        
        $sql = "SELECT l.*, p.first_name, p.last_name, p.contact, 
                       s.first_name as doctor_first, s.last_name as doctor_last,
                       GROUP_CONCAT(DISTINCT tt.test_name SEPARATOR ', ') as tests
                FROM lab_table l
                JOIN patient_table p ON l.patient_id = p.patient_id
                JOIN staff_table s ON l.staff_id = s.staff_id
                JOIN lab_test_table lt ON l.lab_id = lt.lab_id
                JOIN test_type_table tt ON lt.test_type_id = tt.test_type_id
                WHERE l.lab_id = '$lab_id'";
        
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }

    public function getTestTypes() {
        $conn = $this->db_conn();
        $sql = "SELECT * FROM test_type_table ORDER BY test_name";
        
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }

    public function gettests() {
        $conn = $this->db_conn();
        $sql = "SELECT * FROM patient_table";
        
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }

    public function getPatientsbyID($id) {
        $conn = $this->db_conn();
        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * FROM patient_table WHERE patient_id = '$id'";
        
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }
    
    public function patient_ID_exists($patient_id) {
        $conn = $this->db_conn();
        $patient_id = mysqli_real_escape_string($conn, $patient_id);
        $sql = "SELECT patient_id FROM patient_table WHERE patient_id = '$patient_id'";
        
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }

    public function addUser($patientId, $password, $userRole) {
        $conn = $this->db_conn();
        $patientId = mysqli_real_escape_string($conn, $patientId);
        $password = mysqli_real_escape_string($conn, $password);
        $userRole = mysqli_real_escape_string($conn, $userRole);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_table(user_id, password, role)
                VALUES ('$patientId', '$hashed_password', '$userRole')";
        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }
}
?>