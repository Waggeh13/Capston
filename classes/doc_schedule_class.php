<?php
require_once("../settings/db_class.php");

class schedule_class extends db_connection {
    // Add doctor's schedule
    public function add_doctor_schedule($staff_id, $appointment_date, $time_slots) {
        $conn = $this->db_conn();
        
        if ($conn === false) {
            return false;
        }

        try {
            // Start transaction
            mysqli_begin_transaction($conn);

            // First, delete any existing schedule for this date
            $delete_sql = "DELETE FROM appointment_table 
                          WHERE staff_id = ? AND appointment_date = ?";
            $stmt = mysqli_prepare($conn, $delete_sql);
            mysqli_stmt_bind_param($stmt, "is", $staff_id, $appointment_date);
            mysqli_stmt_execute($stmt);
            
            // Insert new appointment
            $appointment_sql = "INSERT INTO appointment_table (staff_id, appointment_date) 
                              VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $appointment_sql);
            mysqli_stmt_bind_param($stmt, "is", $staff_id, $appointment_date);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to create appointment: " . mysqli_error($conn));
            }
            
            $appointment_id = mysqli_insert_id($conn);

            // Insert time slots
            foreach ($time_slots as $time) {
                $timeslot_sql = "INSERT INTO appointment_timeslots (appointment_id, time_slot) 
                               VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $timeslot_sql);
                mysqli_stmt_bind_param($stmt, "is", $appointment_id, $time);
                
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Failed to add time slot: " . mysqli_error($conn));
                }
            }

            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
            mysqli_close($conn);
        }
    }

    // Get doctor's schedule for a specific date
    public function get_doctor_schedule_for_date($staff_id, $date) {
        $conn = $this->db_conn();
        
        $sql = "SELECT t.time_slot
                FROM appointment_table a
                JOIN appointment_timeslots t ON a.appointment_id = t.appointment_id
                WHERE a.staff_id = ? AND a.appointment_date = ?";
                
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $staff_id, $date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $time_slots = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $time_slots[] = $row['time_slot'];
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $time_slots;
    }

    // Get all doctor's schedules
    public function get_doctor_schedule($staff_id) {
        $conn = $this->db_conn();
        
        $sql = "SELECT a.appointment_id, a.appointment_date, 
                       GROUP_CONCAT(t.time_slot) as time_slots
                FROM appointment_table a
                LEFT JOIN appointment_timeslots t ON a.appointment_id = t.appointment_id
                WHERE a.staff_id = ?
                GROUP BY a.appointment_id, a.appointment_date";
                
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $staff_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $rows;
    }
}
?>