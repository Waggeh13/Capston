<?php
require_once("../settings/db_class.php");

class request_class extends db_connection {
    public function get_doctors() {
        $conn = $this->db_conn();
        
        $sql = "SELECT s.staff_id, s.first_name, s.last_name
                FROM staff_table s
                WHERE s.position = 'Doctor'";
                
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            error_log("Database error in get_doctors: " . mysqli_error($conn));
            mysqli_close($conn);
            return array();
        }
        
        $doctors = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $doctors[] = $row;
        }
        
        mysqli_free_result($result);
        mysqli_close($conn);
        return $doctors;
    }

    public function make_request($patient_id, $doctor_id, $hospital_name) {
        $conn = $this->db_conn();
        
        if (empty($patient_id) || empty($doctor_id) || empty($hospital_name)) {
            error_log("Invalid input in make_request: patient_id=$patient_id, doctor_id=$doctor_id, hospital_name=$hospital_name");
            mysqli_close($conn);
            return false;
        }

        $patient_id = mysqli_real_escape_string($conn, $patient_id);
        $doctor_id = mysqli_real_escape_string($conn, $doctor_id);
        $hospital_name = mysqli_real_escape_string($conn, $hospital_name);
        
        $sql = "INSERT INTO request_table (patient_id, doctor_id, hospital_name, status)
                VALUES ('$patient_id', '$doctor_id', '$hospital_name', 'Pending')";
        
        $result = $this->db_query($sql);
        
        if (!$result) {
            error_log("Database error in make_request: " . mysqli_error($conn));
        }
        
        mysqli_close($conn);
        return $result;
    }

    public function get_pending_requests_by_doctor($doctor_id) {
        $conn = $this->db_conn();
        
        $doctor_id = mysqli_real_escape_string($conn, $doctor_id);
        
        $sql = "SELECT r.request_id, r.patient_id, r.hospital_name,
                       CONCAT(p.first_name, ' ', p.last_name) AS patient_name
                FROM request_table r
                JOIN patient_table p ON r.patient_id = p.patient_id
                WHERE r.doctor_id = '$doctor_id' AND r.status = 'Pending'
                ORDER BY r.request_id DESC";
                
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            error_log("Database error in get_pending_requests_by_doctor: " . mysqli_error($conn));
            mysqli_close($conn);
            return array();
        }
        
        $requests = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $requests[] = $row;
        }
        
        mysqli_free_result($result);
        mysqli_close($conn);
        return $requests;
    }

    public function update_request_status($request_id, $status) {
        $conn = $this->db_conn();
        
        if (empty($request_id) || empty($status)) {
            error_log("Invalid input in update_request_status: request_id=$request_id, status=$status");
            mysqli_close($conn);
            return false;
        }

        $request_id = mysqli_real_escape_string($conn, $request_id);
        $status = mysqli_real_escape_string($conn, $status);
        
        $sql = "UPDATE request_table
                SET status = '$status'
                WHERE request_id = '$request_id'";
        
        $result = $this->db_query($sql);
        
        if (!$result) {
            error_log("Database error in update_request_status: " . mysqli_error($conn));
        }
        
        mysqli_close($conn);
        return $result;
    }
}
?>