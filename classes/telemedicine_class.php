<?php
require_once("../settings/db_class.php");

class patient_telemedicine_class extends db_connection {
    private $zoom_client_id = 'JWxNJ_siTs6WKTBZZ9IFw';
    private $zoom_client_secret = 'DNxXbSOv70Md8i5ohHgazs6ooxDuuGTW';
    private $zoom_redirect_uri = 'https://eccb-41-79-97-5.ngrok-free.app/capston/utils/zoom-callback.php';

    public function get_telemedicine_appointments($patient_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            return false;
        }

        $patient_id = mysqli_real_escape_string($conn, $patient_id);
        
        $sql = "SELECT t.telemedicine_id, t.booking_id, t.meeting_id, t.join_url, t.password, t.start_time, 
                       t.duration, t.status, CONCAT(s.first_name, ' ', s.last_name) as doctor_name
                FROM telemedicine_table t
                JOIN staff_table s ON t.staff_id = s.staff_id
                WHERE t.patient_id = ? AND t.status != 'Cancelled'
                ORDER BY t.start_time ASC";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $patient_id);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Execute failed: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            error_log("Get result failed: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }
        
        $appointments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
        
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);

        // Check for expired appointments
        $current_time = date('Y-m-d H:i:s');
        foreach ($appointments as &$appointment) {
            $end_time = date('Y-m-d H:i:s', strtotime($appointment['start_time'] . " +{$appointment['duration']} minutes"));
            if ($appointment['status'] === 'Scheduled' && $current_time > $end_time) {
                $this->update_meeting_status($appointment['booking_id'], 'Cancelled');
                $appointment['status'] = 'Cancelled';
            }
        }

        mysqli_close($conn);
        return array_filter($appointments, function($apt) { return $apt['status'] !== 'Cancelled'; });
    }

    public function get_meeting_details($booking_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed");
            return false;
        }

        $booking_id = mysqli_real_escape_string($conn, $booking_id);
        
        $sql = "SELECT telemedicine_id, booking_id, meeting_id, join_url, password, start_time, duration, status
                FROM telemedicine_table
                WHERE booking_id = ? AND status = 'Scheduled'";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Execute failed: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            error_log("Get result failed: " . mysqli_stmt_error($stmt));
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
            error_log("Database connection failed");
            return false;
        }

        $sql = "UPDATE telemedicine_table SET notes = ? WHERE booking_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "si", $notes, $booking_id);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            error_log("Execute failed: " . mysqli_stmt_error($stmt));
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
            error_log("Database connection failed");
            return false;
        }

        $sql = "UPDATE telemedicine_table SET status = ? WHERE booking_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "si", $status, $booking_id);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            error_log("Execute failed: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }

    private function generate_signature($meeting_id) {
        $iat = time();
        $exp = $iat + 60 * 60 * 2; // Signature valid for 2 hours
        
        $data = array(
            'sdkKey' => $this->zoom_client_id, // Use client_id as sdkKey
            'mn' => $meeting_id,
            'role' => 0, // 0 for participant
            'iat' => $iat,
            'exp' => $exp,
            'appKey' => $this->zoom_client_id, // Use client_id as appKey
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