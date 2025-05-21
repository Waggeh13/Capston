<?php
require_once("../settings/db_class.php");

class getPatientAppointments_class extends db_connection {  
    public function getPatientAppointments($patient_id, $limit = 2) {
        $query = "SELECT 
                    CONCAT('Dr. ', s.last_name) AS doctor_name,
                    d.department_name,
                    a.appointment_date,
                    t.time_slot
                  FROM booking_table b
                  INNER JOIN patient_table p ON b.patient_id = p.patient_id
                  INNER JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                  INNER JOIN appointment_table a ON t.appointment_id = a.appointment_id
                  INNER JOIN staff_table s ON a.staff_id = s.staff_id
                  INNER JOIN department_table d ON s.department_id = d.department_id
                  WHERE b.patient_id = ?
                  AND b.status = 'Scheduled'
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

            $stmt->bind_param("ii", $patient_id, $limit);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            
            error_log("Fetched patient appointments for patient_id $patient_id: " . print_r($data, true));
            
            return is_array($data) ? $data : [];

        } catch (Exception $e) {
            error_log("Patient appointments fetch error: " . $e->getMessage());
            return [];
        }
    }
}
?>