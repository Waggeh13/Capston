<?php
require_once("../settings/db_class.php");

class LabClass extends db_connection {

    public function getPendingLabRequests() {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in getPendingLabRequests");
            return [];
        }

        $sql = "SELECT lt.lab_id, lt.patient_id, lt.staff_id, lt.request_date, 
                       CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                       CONCAT(s.first_name, ' ', s.last_name) as doctor_name
                FROM lab_table lt
                JOIN patient_table p ON lt.patient_id = p.patient_id
                JOIN staff_table s ON lt.staff_id = s.staff_id
                JOIN lab_test_table ltt ON lt.lab_id = ltt.lab_id
                WHERE ltt.result_status = 'Pending'
                GROUP BY lt.lab_id
                ORDER BY s.first_name, s.last_name, p.first_name, p.last_name, lt.request_date DESC";

        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            error_log("Query failed in getPendingLabRequests: " . mysqli_error($conn));
            mysqli_close($conn);
            return [];
        }

        $requests = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $requests[] = $row;
        }

        mysqli_free_result($result);
        mysqli_close($conn);
        return $requests;
    }

    public function getLabRequestById($lab_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in getLabRequestById");
            return false;
        }

        $lab_id = mysqli_real_escape_string($conn, $lab_id);

        $sql = "SELECT lt.lab_id, lt.patient_id, lt.staff_id, lt.request_date, lt.signature,
                       CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                       p.DOB, p.Gender,
                       CONCAT(s.first_name, ' ', s.last_name) as doctor_name
                FROM lab_table lt
                JOIN patient_table p ON lt.patient_id = p.patient_id
                JOIN staff_table s ON lt.staff_id = s.staff_id
                WHERE lt.lab_id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in getLabRequestById: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "i", $lab_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            error_log("Query failed in getLabRequestById: " . mysqli_error($conn));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }

        $request = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$request) {
            mysqli_close($conn);
            return false;
        }

        $sql_tests = "SELECT ltt.lab_test_id, ltt.test_type_id, tt.test_name
                      FROM lab_test_table ltt
                      JOIN test_type_table tt ON ltt.test_type_id = tt.test_type_id
                      WHERE ltt.lab_id = ?";
        
        $stmt_tests = mysqli_prepare($conn, $sql_tests);
        if ($stmt_tests === false) {
            error_log("Prepare failed for tests in getLabRequestById: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt_tests, "i", $lab_id);
        mysqli_stmt_execute($stmt_tests);
        $result_tests = mysqli_stmt_get_result($stmt_tests);

        if ($result_tests === false) {
            error_log("Query failed for tests in getLabRequestById: " . mysqli_error($conn));
            mysqli_stmt_close($stmt_tests);
            mysqli_close($conn);
            return false;
        }

        $tests = [];
        while ($test = mysqli_fetch_assoc($result_tests)) {
            $tests[] = $test;
        }

        $request['tests'] = $tests;
        mysqli_stmt_close($stmt_tests);
        mysqli_close($conn);
        return $request;
    }

    public function submitLabResults($lab_id, $lab_tech_id, $results, $specimen_received_by, $specimen_date, $specimen_time, $sample_accepted, $lab_tech_signature, $lab_tech_date, $supervisor_signature, $supervisor_date) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in submitLabResults");
            return ["success" => false, "message" => "Database connection failed"];
        }

        try {
            mysqli_begin_transaction($conn);

            if ($lab_tech_id) {
                $sql_check = "SELECT staff_id FROM staff_table WHERE staff_id = ?";
                $stmt_check = mysqli_prepare($conn, $sql_check);
                if ($stmt_check === false) {
                    throw new Exception("Failed to prepare staff check query: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($stmt_check, "s", $lab_tech_id);
                mysqli_stmt_execute($stmt_check);
                $result_check = mysqli_stmt_get_result($stmt_check);
                if (mysqli_num_rows($result_check) === 0) {
                    throw new Exception("Invalid lab technician ID: $lab_tech_id does not exist in staff_table");
                }
                mysqli_stmt_close($stmt_check);
            }

            $sql = "SELECT lab_test_id, test_type_id FROM lab_test_table WHERE lab_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt === false) {
                throw new Exception("Failed to prepare lab test query: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "i", $lab_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result === false) {
                throw new Exception("Failed to fetch lab tests: " . mysqli_error($conn));
            }

            $tests = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $tests[$row['test_type_id']] = $row['lab_test_id'];
            }
            mysqli_stmt_close($stmt);

            $update_sql = "UPDATE lab_test_table 
                          SET result = ?, result_status = 'Completed',
                              specimen_received_by = ?, specimen_date = ?, specimen_time = ?, 
                              sample_accepted = ?, lab_tech_id = ?, lab_tech_signature = ?, 
                              lab_tech_date = ?, supervisor_signature = ?, supervisor_date = ?
                          WHERE lab_test_id = ?";

            $stmt = mysqli_prepare($conn, $update_sql);
            if ($stmt === false) {
                throw new Exception("Failed to prepare update statement: " . mysqli_error($conn));
            }

            foreach ($results as $test_type_id => $result_value) {
                if (isset($tests[$test_type_id])) {
                    $lab_test_id = $tests[$test_type_id];
                    mysqli_stmt_bind_param($stmt, "ssssssssssi", 
                        $result_value, 
                        $specimen_received_by, 
                        $specimen_date, 
                        $specimen_time, 
                        $sample_accepted, 
                        $lab_tech_id, 
                        $lab_tech_signature, 
                        $lab_tech_date, 
                        $supervisor_signature, 
                        $supervisor_date, 
                        $lab_test_id
                    );

                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception("Failed to update lab test result: " . mysqli_error($conn));
                    }
                    error_log("Updated lab test result: lab_test_id=$lab_test_id");
                }
            }

            mysqli_stmt_close($stmt);
            mysqli_commit($conn);
            error_log("Lab results submitted successfully: lab_id=$lab_id");
            return ["success" => true, "message" => "Results submitted successfully"];
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log("Submit lab results failed: " . $e->getMessage());
            return ["success" => false, "message" => $e->getMessage()];
        } finally {
            mysqli_close($conn);
        }
    }
}
?>