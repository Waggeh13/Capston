<?php
require_once("../settings/db_class.php");

class lab_class extends db_connection {

    // Add Lab Request with multiple tests
    public function requestform($doctor_fullname, $patient_fullname, $testRequests, $susdiag, $signature, $ext, $request_date) {
        // Sanitize inputs
        $doctor_fullname = $this->db_conn()->real_escape_string($doctor_fullname);
        $patient_fullname = $this->db_conn()->real_escape_string($patient_fullname);
        $susdiag = $this->db_conn()->real_escape_string($susdiag);
        $signature = $this->db_conn()->real_escape_string($signature);
        $ext = $this->db_conn()->real_escape_string($ext);
        $request_date = $this->db_conn()->real_escape_string($request_date);

        // Start transaction
        $this->db_conn()->begin_transaction();

        try {
            // Get patient_id
            $names = explode(' ', $patient_fullname, 2);
            $firstName = $this->db_conn()->real_escape_string($names[0]);
            $lastName = isset($names[1]) ? $this->db_conn()->real_escape_string($names[1]) : '';
            
            $patient_sql = "SELECT patient_id FROM patient_table 
                           WHERE first_name = '$firstName' AND last_name = '$lastName'";
            $patient_result = $this->db_query($patient_sql);
            
            if ($this->db_count() == 0) {
                throw new Exception("Patient not found: $patient_fullname");
            }
            $patient_row = $this->db_fetch($patient_result);
            $patient_id = $patient_row['patient_id'];

            // Get doctor_id (assuming doctor is in staff_table)
            $doctor_names = explode(' ', $doctor_fullname, 2);
            $docFirstName = $this->db_conn()->real_escape_string($doctor_names[0]);
            $docLastName = isset($doctor_names[1]) ? $this->db_conn()->real_escape_string($doctor_names[1]) : '';
            
            $doctor_sql = "SELECT staff_id FROM staff_table 
                          WHERE first_name = '$docFirstName' AND last_name = '$docLastName' 
                          AND position LIKE '%doctor%'";
            $doctor_result = $this->db_query($doctor_sql);
            
            if ($this->db_count() == 0) {
                throw new Exception("Doctor not found: $doctor_fullname");
            }
            $doctor_row = $this->db_fetch($doctor_result);
            $doctor_id = $doctor_row['staff_id'];

            // Insert into lab_table
            $lab_sql = "INSERT INTO lab_table (
                            patient_id, 
                            doctor_id, 
                            suspected_diagnosis, 
                            signature, 
                            extension, 
                            request_date
                        ) VALUES (
                            '$patient_id',
                            '$doctor_id',
                            '$susdiag',
                            '$signature',
                            '$ext',
                            '$request_date'
                        )";
            
            $lab_result = $this->db_query($lab_sql);
            
            if (!$lab_result) {
                throw new Exception("Failed to create lab record: " . $this->db_conn()->error);
            }

            $lab_id = $this->db_conn()->insert_id;

            // Insert each test request into lab_test_table
            foreach ($testRequests as $testName) {
                $testName = $this->db_conn()->real_escape_string($testName);
                
                // Get test_type_id
                $test_sql = "SELECT test_type_id FROM test_type_table WHERE test_name = '$testName'";
                $test_result = $this->db_query($test_sql);
                
                if ($this->db_count() == 0) {
                    // If test type doesn't exist, create it
                    $insert_test_sql = "INSERT INTO test_type_table (test_name) VALUES ('$testName')";
                    $this->db_query($insert_test_sql);
                    $test_type_id = $this->db_conn()->insert_id;
                } else {
                    $test_row = $this->db_fetch($test_result);
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
                
                $lab_test_result = $this->db_query($lab_test_sql);
                
                if (!$lab_test_result) {
                    throw new Exception("Failed to add test '$testName': " . $this->db_conn()->error);
                }
            }

            // Commit transaction
            $this->db_conn()->commit();
            return true;

        } catch (Exception $e) {
            $this->db_conn()->rollback();
            throw $e;
        }
    }

    // Get all lab results
    public function getlabresult() {
        $sql = "SELECT l.lab_id, p.first_name, p.last_name, l.request_date, 
                       GROUP_CONCAT(tt.test_name SEPARATOR ', ') as tests,
                       MIN(lt.result_status) as overall_status
                FROM lab_table l
                JOIN patient_table p ON l.patient_id = p.patient_id
                JOIN lab_test_table lt ON l.lab_id = lt.lab_id
                JOIN test_type_table tt ON lt.test_type_id = tt.test_type_id
                GROUP BY l.lab_id
                ORDER BY l.request_date DESC";
        
        return $this->db_query($sql);
    }

    // Get lab result by ID
    public function getlabresultbyid($lab_id) {
        $lab_id = $this->db_conn()->real_escape_string($lab_id);
        
        $sql = "SELECT l.*, p.first_name, p.last_name, p.contact, 
                       s.first_name as doctor_first, s.last_name as doctor_last,
                       GROUP_CONCAT(DISTINCT tt.test_name SEPARATOR ', ') as tests
                FROM lab_table l
                JOIN patient_table p ON l.patient_id = p.patient_id
                JOIN staff_table s ON l.doctor_id = s.staff_id
                JOIN lab_test_table lt ON l.lab_id = lt.lab_id
                JOIN test_type_table tt ON lt.test_type_id = tt.test_type_id
                WHERE l.lab_id = '$lab_id'";
        
        return $this->db_query($sql);
    }

    // Get all test types
    public function getTestTypes() {
        $sql = "SELECT * FROM test_type_table ORDER BY test_name";
        return $this->db_query($sql);
    }

    // Get all patient records
    public function gettests() {
        $sql = "SELECT * FROM patient_table";
        return $this->db_fetch_all($sql);
    }

    // Get patient information by id
    public function getPatientsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM patient_table WHERE patient_id = '$id'";
        return $this->db_fetch_all($sql);
    }
    

    public function patient_ID_exists($patient_id) {
        $patient_id= mysqli_real_escape_string($this->db_conn(), $patient_id);
        $sql = "SELECT patient_id FROM patient_table WHERE patient_id = '$patient_id'";
        return $this->db_fetch_all($sql);
    }

    public function addUser($patientId, $password, $userRole)
    {
        $patientId = mysqli_real_escape_string($this->db_conn(), $patientId);
        $password = mysqli_real_escape_string($this->db_conn(), $password);
        $userRole = mysqli_real_escape_string($this->db_conn(), $userRole);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_table(user_id, password, role)
                VALUES ('$patientId', '$hashed_password', '$userRole')";
        
        return $this->db_query($sql);
    }

}
?>
