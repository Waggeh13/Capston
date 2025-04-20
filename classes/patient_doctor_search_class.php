<?php
require_once("../settings/db_class.php");

class patient_doctor_search_class extends db_connection {
    public function searchDoctors($query) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in searchDoctors");
            return ['success' => false, 'doctors' => [], 'error' => 'Database connection failed'];
        }

        error_log("searchDoctors: Connected to database " . mysqli_get_host_info($conn));

        $query = '%' . mysqli_real_escape_string($conn, $query) . '%';
        $sql = "SELECT s.staff_id AS id, CONCAT(s.first_name, ' ', s.last_name) AS name, ut.role
                FROM staff_table s
                LEFT JOIN user_table ut ON s.staff_id = ut.user_id
                WHERE ut.role = 'Doctor' AND 
                      (LOWER(s.first_name) LIKE LOWER(?) OR 
                       LOWER(s.last_name) LIKE LOWER(?) OR 
                       LOWER(CONCAT(s.first_name, ' ', s.last_name)) LIKE LOWER(?))
                ORDER BY s.first_name ASC";

        error_log("searchDoctors: Executing SQL: $sql with query: $query");

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            error_log("searchDoctors: Failed to prepare statement: " . mysqli_error($conn));
            mysqli_close($conn);
            return ['success' => false, 'doctors' => [], 'error' => 'Failed to prepare statement'];
        }

        mysqli_stmt_bind_param($stmt, "sss", $query, $query, $query);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("searchDoctors: Failed to execute statement: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return ['success' => false, 'doctors' => [], 'error' => 'Failed to execute query'];
        }

        $result = mysqli_stmt_get_result($stmt);
        $doctors = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['role'] === null) {
                error_log("searchDoctors: Staff ID {$row['id']} found in staff_table but missing role in user_table");
            }
            $doctors[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }

        error_log("searchDoctors query: $query, results: " . count($doctors));

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ['success' => true, 'doctors' => $doctors];
    }
}
?>