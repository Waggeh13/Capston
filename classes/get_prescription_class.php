<?php
require_once("../settings/db_class.php");

class prescription_class extends db_connection {
    public function get_patient_prescriptions($patient_id) {
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $sql = "SELECT p.prescription_id, p.medication_date, s.first_name, s.last_name, 
                       pm.medication_id, pm.medication, pm.dosage, pm.instructions
                FROM prescription_table p
                JOIN staff_table s ON p.staff_id = s.staff_id
                JOIN prescription_medication_table pm ON p.prescription_id = pm.prescription_id
                WHERE p.patient_id = '$patient_id' AND p.status = 'Pending'";
        return $this->db_fetch_all($sql);
    }
}
?>