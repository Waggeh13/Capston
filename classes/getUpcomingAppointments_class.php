<?php
require_once("../settings/db_class.php");

class getUpcomingAppointments_class extends db_connection {  
    public function getUpcomingAppointments($limit = 5) {
        $query = "SELECT 
                    CONCAT(p.first_name, ' ', p.last_name) AS patient_full_name,
                    c.clinic_name,
                    t.time_slot,
                    CONCAT('Dr. ', s.last_name) AS doctor_name,
                    b.booking_id,
                    b.appointment_type,
                    b.status
                  FROM booking_table b
                  INNER JOIN patient_table p ON b.patient_id = p.patient_id
                  INNER JOIN clinic_table c ON b.clinic_id = c.clinic_id
                  INNER JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                  INNER JOIN appointment_table a ON t.appointment_id = a.appointment_id
                  INNER JOIN staff_table s ON a.staff_id = s.staff_id
                  WHERE b.status = 'Scheduled' 
                  AND a.appointment_date >= CURDATE()
                  ORDER BY a.appointment_date ASC, t.time_slot ASC
                  LIMIT ?";
    
        try {
            $conn = $this->db_conn();
            if (!$conn) {
                throw new Exception("Database connection failed");
            }

            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("i", $limit);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            
            // Debug output
            error_log("Fetched appointments: " . print_r($data, true));
            
            return is_array($data) ? $data : [];

        } catch (Exception $e) {
            error_log("Appointment fetch error: " . $e->getMessage());
            return [];
        }
    }
}
?>