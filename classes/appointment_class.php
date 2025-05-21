<?php
require_once("../settings/db_class.php");

class appointment_class extends db_connection {
    public function book_appointment($patientName, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in book_appointment");
            return false;
        }

        try {
            mysqli_begin_transaction($conn);

            $names = explode(' ', trim($patientName), 2);
            $firstName = mysqli_real_escape_string($conn, $names[0]);
            $lastName = isset($names[1]) ? mysqli_real_escape_string($conn, $names[1]) : '';
            
            $patient_sql = "SELECT patient_id FROM patient_table 
                          WHERE first_name = '$firstName' AND last_name = '$lastName'";
            $patient_result = mysqli_query($conn, $patient_sql);
            
            if (mysqli_num_rows($patient_result) == 0) {
                throw new Exception("Patient not found: $patientName");
            }
            $patient_row = mysqli_fetch_assoc($patient_result);
            $patient_id = $patient_row['patient_id'];

            $appointmentType = $appointmentType === 'inPerson' ? 'In-Person' : 'Virtual';
            $sql = "INSERT INTO booking_table (patient_id, timeslot_id, appointment_type, clinic_id, status) 
                    VALUES (?, ?, ?, ?, 'Scheduled')";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt === false) {
                throw new Exception("Failed to prepare statement: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($stmt, "sisi", $patient_id, $timeslot_id, $appointmentType, $clinic_id);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to book appointment: " . mysqli_error($conn));
            }

            $update_sql = "UPDATE appointment_timeslots SET status = 'Booked' WHERE timeslot_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            if ($update_stmt === false) {
                throw new Exception("Failed to prepare timeslot update: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($update_stmt, "i", $timeslot_id);
            
            if (!mysqli_stmt_execute($update_stmt)) {
                throw new Exception("Failed to update timeslot: " . mysqli_error($conn));
            }

            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage());
            return false;
        } finally {
            if (isset($stmt) && is_a($stmt, 'mysqli_stmt')) {
                mysqli_stmt_close($stmt);
            }
            if (isset($update_stmt) && is_a($update_stmt, 'mysqli_stmt')) {
                mysqli_stmt_close($update_stmt);
            }
            mysqli_close($conn);
        }
    }

    public function update_appointment($booking_id, $patientName, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in update_appointment");
            return false;
        }

        try {
            mysqli_begin_transaction($conn);

            $names = explode(' ', trim($patientName), 2);
            $firstName = mysqli_real_escape_string($conn, $names[0]);
            $lastName = isset($names[1]) ? mysqli_real_escape_string($conn, $names[1]) : '';
            
            $patient_sql = "SELECT patient_id FROM patient_table 
                          WHERE first_name = '$firstName' AND last_name = '$lastName'";
            $patient_result = mysqli_query($conn, $patient_sql);
            
            if (mysqli_num_rows($patient_result) == 0) {
                throw new Exception("Patient not found: $patientName");
            }
            $patient_row = mysqli_fetch_assoc($patient_result);
            $patient_id = $patient_row['patient_id'];

            $old_sql = "SELECT timeslot_id FROM booking_table WHERE booking_id = ?";
            $old_stmt = mysqli_prepare($conn, $old_sql);
            if ($old_stmt === false) {
                throw new Exception("Failed to prepare old timeslot query: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($old_stmt, "i", $booking_id);
            mysqli_stmt_execute($old_stmt);
            $old_result = mysqli_stmt_get_result($old_stmt);
            $old_timeslot_id = mysqli_fetch_assoc($old_result)['timeslot_id'] ?? null;

            if ($old_timeslot_id && $old_timeslot_id != $timeslot_id) {
                $avail_sql = "UPDATE appointment_timeslots SET status = 'Available' WHERE timeslot_id = ?";
                $avail_stmt = mysqli_prepare($conn, $avail_sql);
                if ($avail_stmt === false) {
                    throw new Exception("Failed to prepare timeslot availability update: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($avail_stmt, "i", $old_timeslot_id);
                mysqli_stmt_execute($avail_stmt);
                mysqli_stmt_close($avail_stmt);
            }

            $appointmentType = $appointmentType === 'inPerson' ? 'In-Person' : 'Virtual';
            $sql = "UPDATE booking_table 
                    SET patient_id = ?, timeslot_id = ?, appointment_type = ?, clinic_id = ?
                    WHERE booking_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt === false) {
                throw new Exception("Failed to prepare update statement: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "sisii", $patient_id, $timeslot_id, $appointmentType, $clinic_id, $booking_id);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update appointment: " . mysqli_error($conn));
            }

            $update_sql = "UPDATE appointment_timeslots SET status = 'Booked' WHERE timeslot_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            if ($update_stmt === false) {
                throw new Exception("Failed to prepare timeslot update: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($update_stmt, "i", $timeslot_id);
            
            if (!mysqli_stmt_execute($update_stmt)) {
                throw new Exception("Failed to update timeslot: " . mysqli_error($conn));
            }

            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage());
            return false;
        } finally {
            if (isset($stmt) && is_a($stmt, 'mysqli_stmt')) {
                mysqli_stmt_close($stmt);
            }
            if (isset($update_stmt) && is_a($update_stmt, 'mysqli_stmt')) {
                mysqli_stmt_close($update_stmt);
            }
            if (isset($old_stmt) && is_a($stmt, 'mysqli_stmt')) {
                mysqli_stmt_close($old_stmt);
            }
            mysqli_close($conn);
        }
    }

    public function delete_appointment($booking_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in delete_appointment");
            return false;
        }

        try {
            mysqli_begin_transaction($conn);
            $sql = "SELECT timeslot_id FROM booking_table WHERE booking_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt === false) {
                throw new Exception("Failed to prepare timeslot query: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "i", $booking_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $timeslot_id = mysqli_fetch_assoc($result)['timeslot_id'] ?? null;

            $delete_sql = "DELETE FROM booking_table WHERE booking_id = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_sql);
            if ($delete_stmt === false) {
                throw new Exception("Failed to prepare delete statement: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($delete_stmt, "i", $booking_id);
            
            if (!mysqli_stmt_execute($delete_stmt)) {
                throw new Exception("Failed to delete appointment: " . mysqli_error($conn));
            }

            if ($timeslot_id) {
                $update_sql = "UPDATE appointment_timeslots SET status = 'Available' WHERE timeslot_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                if ($update_stmt === false) {
                    throw new Exception("Failed to prepare timeslot update: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($update_stmt, "i", $timeslot_id);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            }

            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage());
            return false;
        } finally {
            if (isset($stmt) && is_a($stmt, 'mysqli_stmt')) {
                mysqli_stmt_close($stmt);
            }
            if (isset($delete_stmt) && is_a($delete_stmt, 'mysqli_stmt')) {
                mysqli_stmt_close($delete_stmt);
            }
            mysqli_close($conn);
        }
    }

    public function get_appointments() {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in get_appointments");
            return [];
        }

        $sql = "SELECT b.booking_id, b.timeslot_id, CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                       CONCAT(s.first_name, ' ', s.last_name) as doctor_name,
                       a.appointment_date as date, t.time_slot as time, b.appointment_type, c.clinic_name, b.status
                FROM booking_table b
                JOIN patient_table p ON b.patient_id = p.patient_id
                JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                JOIN appointment_table a ON t.appointment_id = a.appointment_id
                JOIN staff_table s ON a.staff_id = s.staff_id
                JOIN clinic_table c ON b.clinic_id = c.clinic_id
                ORDER BY a.appointment_date DESC, t.time_slot DESC";
                
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            error_log("Query failed in get_appointments: " . mysqli_error($conn) . " | Query: $sql");
            mysqli_close($conn);
            return [];
        }

        $appointments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
        
        mysqli_free_result($result);
        mysqli_close($conn);
        return $appointments;
    }

    public function get_appointment($booking_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in get_appointment");
            return false;
        }

        $booking_id = mysqli_real_escape_string($conn, $booking_id);
        
        $sql = "SELECT b.booking_id, b.timeslot_id, CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                       a.staff_id, CONCAT(s.first_name, ' ', s.last_name) as doctor_name,
                       a.appointment_date as date, t.time_slot as time, b.appointment_type, b.clinic_id, c.clinic_name, b.status
                FROM booking_table b
                JOIN patient_table p ON b.patient_id = p.patient_id
                JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                JOIN appointment_table a ON t.appointment_id = a.appointment_id
                JOIN staff_table s ON a.staff_id = s.staff_id
                JOIN clinic_table c ON b.clinic_id = c.clinic_id
                WHERE b.booking_id = ?";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in get_appointment: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result === false) {
            error_log("Query failed in get_appointment: " . mysqli_error($conn) . " | Query: $sql");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }

        $appointment = mysqli_fetch_assoc($result);
        
        if ($appointment) {
            $appointment['appointment_type'] = strtolower($appointment['appointment_type']) === 'in-person' ? 'inPerson' : 'virtual';
        }

        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $appointment;
    }

    public function update_appointment_status($booking_id, $status) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in update_appointment_status");
            return false;
        }

        $sql = "UPDATE booking_table SET status = ? WHERE booking_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in update_appointment_status: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "si", $status, $booking_id);
        
        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            error_log("Execute failed in update_appointment_status: " . mysqli_error($conn));
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }

    public function get_doctor_appointments($staff_id, $date) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in get_doctor_appointments");
            return false;
        }

        $staff_id = mysqli_real_escape_string($conn, $staff_id);
        $date = mysqli_real_escape_string($conn, $date);
        
        $sql = "SELECT b.booking_id, b.timeslot_id, p.patient_id, CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                       a.appointment_date as date, t.time_slot as time, b.appointment_type, c.clinic_name, b.status
                FROM booking_table b
                JOIN patient_table p ON b.patient_id = p.patient_id
                JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                JOIN appointment_table a ON t.appointment_id = a.appointment_id
                JOIN clinic_table c ON b.clinic_id = c.clinic_id
                WHERE a.staff_id = ? AND a.appointment_date = ?
                ORDER BY t.time_slot ASC";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in get_doctor_appointments: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "ss", $staff_id, $date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result === false) {
            error_log("Query failed in get_doctor_appointments: " . mysqli_error($conn) . " | Query: $sql");
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

    public function get_patient_appointments($patient_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in get_patient_appointments");
            return false;
        }

        $patient_id = mysqli_real_escape_string($conn, $patient_id);
        
        $sql = "SELECT b.booking_id, b.timeslot_id, CONCAT(s.first_name, ' ', s.last_name) as doctor_name,
                       a.appointment_date as date, t.time_slot as time, b.appointment_type, c.clinic_name, b.status
                FROM booking_table b
                JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                JOIN appointment_table a ON t.appointment_id = a.appointment_id
                JOIN staff_table s ON a.staff_id = s.staff_id
                JOIN clinic_table c ON b.clinic_id = c.clinic_id
                WHERE b.patient_id = ?
                ORDER BY a.appointment_date DESC, t.time_slot DESC";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in get_patient_appointments: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result === false) {
            error_log("Query failed in get_patient_appointments: " . mysqli_error($conn) . " | Query: $sql");
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
}
?>