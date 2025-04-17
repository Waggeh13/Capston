<?php
require_once("../settings/db_class.php");

class DoctorLabClass extends db_connection {
    public function getDoctorLabRequests($doctor_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in getDoctorLabRequests");
            return [];
        }

        $doctor_id = mysqli_real_escape_string($conn, $doctor_id);

        $sql = "SELECT l.lab_id, p.patient_id, CONCAT(p.first_name, ' ', p.last_name) as patient_name, 
                       GROUP_CONCAT(tt.test_name SEPARATOR ', ') as tests,
                       l.request_date,
                       MIN(lt.result_status) as overall_status
                FROM lab_table l
                JOIN patient_table p ON l.patient_id = p.patient_id
                JOIN lab_test_table lt ON l.lab_id = lt.lab_id
                JOIN test_type_table tt ON lt.test_type_id = tt.test_type_id
                WHERE l.staff_id = ?
                GROUP BY l.lab_id
                ORDER BY l.request_date DESC";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in getDoctorLabRequests: " . mysqli_error($conn));
            mysqli_close($conn);
            return [];
        }

        mysqli_stmt_bind_param($stmt, "s", $doctor_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            error_log("Query failed in getDoctorLabRequests: " . mysqli_error($conn));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return [];
        }

        $requests = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $requests[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $requests;
    }

    public function getDoctorLabResultById($lab_id, $doctor_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in getDoctorLabResultById");
            return false;
        }

        $lab_id = mysqli_real_escape_string($conn, $lab_id);
        $doctor_id = mysqli_real_escape_string($conn, $doctor_id);

        // Fetch lab request details
        $sql = "SELECT l.lab_id, l.patient_id, l.staff_id, l.request_date, l.signature, l.extension,
                       CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                       p.DOB, p.Gender,
                       CONCAT(s.first_name, ' ', s.last_name) as doctor_name
                FROM lab_table l
                JOIN patient_table p ON l.patient_id = p.patient_id
                JOIN staff_table s ON l.staff_id = s.staff_id
                WHERE l.lab_id = ? AND l.staff_id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in getDoctorLabResultById: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "is", $lab_id, $doctor_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            error_log("Query failed in getDoctorLabResultById: " . mysqli_error($conn));
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

        // Fetch associated tests and results
        $sql_tests = "SELECT ltt.lab_test_id, ltt.test_type_id, tt.test_name, ltt.result,
                             ltt.specimen_received_by, ltt.specimen_date, ltt.specimen_time,
                             ltt.sample_accepted, ltt.lab_tech_signature, ltt.lab_tech_date,
                             ltt.supervisor_signature, ltt.supervisor_date
                      FROM lab_test_table ltt
                      JOIN test_type_table tt ON ltt.test_type_id = tt.test_type_id
                      WHERE ltt.lab_id = ?";

        $stmt_tests = mysqli_prepare($conn, $sql_tests);
        if ($stmt_tests === false) {
            error_log("Prepare failed for tests in getDoctorLabResultById: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt_tests, "i", $lab_id);
        mysqli_stmt_execute($stmt_tests);
        $result_tests = mysqli_stmt_get_result($stmt_tests);

        if ($result_tests === false) {
            error_log("Query failed for tests in getDoctorLabResultById: " . mysqli_error($conn));
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
}
?>