<?php
require_once("../settings/db_class.php");

class getPatientPrescriptions_class extends db_connection {
    public function getPatientPrescriptions($patient_id, $limit = 2) {
        $query = "SELECT 
                    pm.medication,
                    pm.dosage,
                    pm.instructions,
                    CONCAT('Dr. ', s.last_name) AS doctor_name
                FROM prescription_table p
                INNER JOIN prescription_medication_table pm ON p.prescription_id = pm.prescription_id
                INNER JOIN staff_table s ON p.staff_id = s.staff_id
                WHERE p.patient_id = ?
                AND p.status = 'Dispensed'
                ORDER BY p.medication_date DESC
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
            
            error_log("Fetched patient prescriptions for patient_id $patient_id: " . print_r($data, true));
            
            return is_array($data) ? $data : [];

        } catch (Exception $e) {
            error_log("Patient prescriptions fetch error: " . $e->getMessage());
            return [];
        }
    }
}
?>
