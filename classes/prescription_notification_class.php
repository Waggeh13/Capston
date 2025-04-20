<?php
require_once("../settings/db_class.php");

class prescription_notification_class extends db_connection {
    public function save_notification_preference($medication_id, $patient_id, $enabled) {
        $medication_id = mysqli_real_escape_string($this->db_conn(), $medication_id);
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $enabled = mysqli_real_escape_string($this->db_conn(), $enabled);

        $sql_check_med = "SELECT medication_id FROM prescription_medication_table WHERE medication_id = '$medication_id'";
        $sql_check_patient = "SELECT patient_id FROM patient_table WHERE patient_id = '$patient_id'";
        if (!$this->db_fetch_one($sql_check_med) || !$this->db_fetch_one($sql_check_patient)) {
            error_log("Invalid medication_id ($medication_id) or patient_id ($patient_id) in save_notification_preference");
            return false;
        }

        $sql_check = "SELECT notification_id FROM prescription_notifications WHERE medication_id = '$medication_id' AND patient_id = '$patient_id' LIMIT 1";
        $existing = $this->db_fetch_one($sql_check);

        if ($existing) {
            $sql = "UPDATE prescription_notifications SET enabled = '$enabled' WHERE medication_id = '$medication_id' AND patient_id = '$patient_id'";
        } else {
            $sql = "INSERT INTO prescription_notifications (medication_id, patient_id, enabled, notification_time)
                    VALUES ('$medication_id', '$patient_id', '$enabled', '00:00:00')";
        }

        $result = $this->db_query($sql);
        if (!$result) {
            error_log("SQL Error in save_notification_preference: " . mysqli_error($this->db_conn()) . " (Code: " . mysqli_errno($this->db_conn()) . ") | Query: $sql");
        }
        return $result;
    }

    public function save_notification_time($medication_id, $patient_id, $notification_time, $interval_hours, $client_timezone = 'UTC') {
        $medication_id = mysqli_real_escape_string($this->db_conn(), $medication_id);
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $notification_time = mysqli_real_escape_string($this->db_conn(), $notification_time);
        $interval_hours = $interval_hours !== null ? (int)$interval_hours : null;

        $sql_check_med = "SELECT medication_id FROM prescription_medication_table WHERE medication_id = '$medication_id'";
        $sql_check_patient = "SELECT patient_id FROM patient_table WHERE patient_id = '$patient_id'";
        if (!$this->db_fetch_one($sql_check_med) || !$this->db_fetch_one($sql_check_patient)) {
            error_log("Invalid medication_id ($medication_id) or patient_id ($patient_id) in save_notification_time");
            return false;
        }

        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $notification_time)) {
            error_log("Invalid notification_time format: $notification_time in save_notification_time");
            return false;
        }

        // Set created_at in client's timezone
        $original_timezone = date_default_timezone_get();
        date_default_timezone_set($client_timezone);
        $created_at = date('Y-m-d H:i:s');
        date_default_timezone_set($original_timezone);

        mysqli_begin_transaction($this->db_conn());
        try {
            if ($interval_hours !== null) {
                $sql = "INSERT INTO prescription_notifications (medication_id, patient_id, enabled, notification_time, interval_hours, created_at)
                        VALUES ('$medication_id', '$patient_id', 'Yes', '$notification_time', '$interval_hours', '$created_at')";
            } else {
                $sql = "INSERT INTO prescription_notifications (medication_id, patient_id, enabled, notification_time, created_at)
                        VALUES ('$medication_id', '$patient_id', 'Yes', '$notification_time', '$created_at')";
            }

            if (!$this->db_query($sql)) {
                throw new Exception("SQL Error: " . mysqli_error($this->db_conn()) . " (Code: " . mysqli_errno($this->db_conn()) . ") | Query: $sql");
            }

            mysqli_commit($this->db_conn());
            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->db_conn());
            error_log("Transaction failed in save_notification_time: " . $e->getMessage());
            return false;
        }
    }

    public function delete_notification_time($notification_id) {
        $notification_id = mysqli_real_escape_string($this->db_conn(), $notification_id);
        $sql = "DELETE FROM prescription_notifications WHERE notification_id = '$notification_id'";
        $result = $this->db_query($sql);
        if (!$result) {
            error_log("SQL Error in delete_notification_time: " . mysqli_error($this->db_conn()) . " (Code: " . mysqli_errno($this->db_conn()) . ") | Query: $sql");
        }
        return $result;
    }

    public function get_notification_settings($medication_id, $patient_id) {
        $medication_id = mysqli_real_escape_string($this->db_conn(), $medication_id);
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $sql = "SELECT notification_id, enabled, notification_time, interval_hours 
                FROM prescription_notifications 
                WHERE medication_id = '$medication_id' AND patient_id = '$patient_id'";
        return $this->db_fetch_all($sql);
    }

    public function get_patient_notification_times($patient_id) {
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $sql = "SELECT pn.notification_id, pn.medication_id, pn.patient_id, pn.notification_time, pn.interval_hours, pn.last_sent, pm.medication, pm.dosage
                FROM prescription_notifications pn
                JOIN prescription_medication_table pm ON pn.medication_id = pm.medication_id
                WHERE pn.patient_id = '$patient_id' AND pn.enabled = 'Yes'";
        $notifications = $this->db_fetch_all($sql);

        $filtered = [];
        $now = new DateTime();
        foreach ($notifications as $notification) {
            if ($notification['interval_hours'] !== null) {
                $filtered[] = $notification;
            } elseif ($notification['notification_time'] !== '00:00:00') {
                $filtered[] = $notification;
            }
        }
        return $filtered;
    }
}
?>