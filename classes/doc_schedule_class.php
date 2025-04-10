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

            // Check if appointment exists for this date and staff
            $appointment_date = mysqli_real_escape_string($conn, $appointment_date);
            $staff_id = mysqli_real_escape_string($conn, $staff_id);
            
            $check_sql = "SELECT appointment_id FROM appointment_table 
                         WHERE staff_id = '$staff_id' AND appointment_date = '$appointment_date'";
            $check_result = mysqli_query($conn, $check_sql);
            
            if (mysqli_num_rows($check_result) > 0) {
                $row = mysqli_fetch_assoc($check_result);
                $appointment_id = $row['appointment_id'];
            } else {
                // Insert new appointment
                $appointment_sql = "INSERT INTO appointment_table (staff_id, appointment_date) 
                                  VALUES ('$staff_id', '$appointment_date')";
                if (!mysqli_query($conn, $appointment_sql)) {
                    throw new Exception("Failed to create appointment: " . mysqli_error($conn));
                }
                $appointment_id = mysqli_insert_id($conn);
            }

            // Insert time slots
            foreach ($time_slots as $time) {
                $time = mysqli_real_escape_string($conn, $time);
                $timeslot_sql = "INSERT INTO appointment_timeslots (appointment_id, time_slot) 
                               VALUES ('$appointment_id', '$time')";
                if (!mysqli_query($conn, $timeslot_sql)) {
                    throw new Exception("Failed to add time slot: " . mysqli_error($conn));
                }
            }

            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            return false;
        } finally {
            mysqli_close($conn);
        }
    }

    // Get doctor's schedule
    public function get_doctor_schedule($staff_id) {
        $conn = $this->db_conn();
        $staff_id = mysqli_real_escape_string($conn, $staff_id);
        
        $sql = "SELECT a.appointment_id, a.appointment_date, 
                       GROUP_CONCAT(t.time_slot) as time_slots
                FROM appointment_table a
                LEFT JOIN appointment_timeslots t ON a.appointment_id = t.appointment_id
                WHERE a.staff_id = '$staff_id'
                GROUP BY a.appointment_id, a.appointment_date";
                
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }

}
?>