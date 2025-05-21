<?php
require_once("../settings/db_class.php");

class getAvailableDoctors_class extends db_connection {  
    public function getAvailableDoctors($limit = 5) {
        $query = "SELECT 
                    CONCAT('Dr. ', s.last_name) AS doctor_name,
                    d.department_name,
                    t.time_slot
                  FROM staff_table s
                  INNER JOIN department_table d ON s.department_id = d.department_id
                  INNER JOIN appointment_table a ON s.staff_id = a.staff_id
                  INNER JOIN appointment_timeslots t ON a.appointment_id = t.appointment_id
                  WHERE a.appointment_date >= CURDATE()
                  AND t.status = 'Available'
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
            
            error_log("Fetched available doctors: " . print_r($data, true));
            
            return is_array($data) ? $data : [];

        } catch (Exception $e) {
            error_log("Available doctors fetch error: " . $e->getMessage());
            return [];
        }
    }
}
?>