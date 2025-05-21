<?php
require_once("../settings/db_class.php");

class doctor_telemedicine_class extends db_connection {
    private $zoom_client_id = 'JWxNJ_siTs6WKTBZZ9IFw';
    private $zoom_client_secret = 'DNxXbSOv70Md8i5ohHgazs6ooxDuuGTW';
    private $zoom_redirect_uri = 'http://178.128.172.82/utils/zoom-callback.php';

    public function get_doctor_telemedicine_appointments($staff_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in get_doctor_telemedicine_appointments");
            return false;
        }

        $staff_id = mysqli_real_escape_string($conn, $staff_id);
        
        $sql = "SELECT b.booking_id, b.timeslot_id, p.patient_id, CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                       a.appointment_date as date, t.time_slot as time, b.appointment_type, c.clinic_name, b.status
                FROM booking_table b
                JOIN patient_table p ON b.patient_id = p.patient_id
                JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                JOIN appointment_table a ON t.appointment_id = a.appointment_id
                JOIN clinic_table c ON b.clinic_id = c.clinic_id
                WHERE a.staff_id = ? AND b.appointment_type = 'Virtual' AND b.status != 'Cancelled'
                ORDER BY a.appointment_date ASC, t.time_slot ASC";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in get_doctor_telemedicine_appointments: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $staff_id);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Execute failed in get_doctor_telemedicine_appointments: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            error_log("Get result failed in get_doctor_telemedicine_appointments: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }
        
        $appointments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $row['appointment_type'] = $row['appointment_type'] === 'In-Person' ? 'In-person' : 'Virtual';
            $appointments[] = $row;
        }
        
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $appointments;
    }

    public function get_meeting_details($booking_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in get_meeting_details");
            return false;
        }

        $booking_id = mysqli_real_escape_string($conn, $booking_id);
        
        $sql = "SELECT telemedicine_id, booking_id, meeting_id, join_url, password, start_time, duration, status
                FROM telemedicine_table
                WHERE booking_id = ? AND status = 'Scheduled'";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in get_meeting_details: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Execute failed in get_meeting_details: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            error_log("Get result failed in get_meeting_details: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }
        
        $meeting = mysqli_fetch_assoc($result);
        
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        if ($meeting) {
            $meeting['sdk_key'] = $this->zoom_client_id; // Use client_id as sdkKey
            $meeting['signature'] = $this->generate_signature($meeting['meeting_id']);
            return $meeting;
        }
        return false;
    }

    public function save_consultation_notes($booking_id, $notes) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in save_consultation_notes");
            return false;
        }

        $sql = "UPDATE telemedicine_table SET notes = ? WHERE booking_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in save_consultation_notes: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "si", $notes, $booking_id);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            error_log("Execute failed in save_consultation_notes: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }

    public function end_meeting($booking_id) {
        return $this->update_meeting_status($booking_id, 'Completed');
    }

    private function update_meeting_status($booking_id, $status) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in update_meeting_status");
            return false;
        }

        $sql = "UPDATE telemedicine_table SET status = ? WHERE booking_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in update_meeting_status: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "si", $status, $booking_id);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            error_log("Execute failed in update_meeting_status: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }

    private function generate_signature($meeting_id) {
        $iat = time();
        $exp = $iat + 60 * 60 * 2; 
        
        $data = array(
            'sdkKey' => $this->zoom_client_id,
            'mn' => $meeting_id,
            'role' => 1,
            'iat' => $iat,
            'exp' => $exp,
            'appKey' => $this->zoom_client_id,
            'tokenExp' => $exp
        );

        $header = array(
            'alg' => 'HS256',
            'typ' => 'JWT'
        );

        $encodedHeader = base64_encode(json_encode($header));
        $encodedPayload = base64_encode(json_encode($data));
        
        $signature = hash_hmac('sha256', "$encodedHeader.$encodedPayload", $this->zoom_client_secret, true);
        $encodedSignature = base64_encode($signature);
        
        return "$encodedHeader.$encodedPayload.$encodedSignature";
    }
}
?>