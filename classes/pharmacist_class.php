<?php
require_once("../settings/db_class.php");

class Prescription_class extends db_connection {

    // Get all pending prescriptions with patient, staff, and medication details
    public function getPendingPrescriptions() {
        $sql = "
            SELECT 
                pt.prescription_id,
                pt.patient_id,
                pt.staff_id,
                pt.medication_date,
                pt.status,
                p.first_name AS patient_first_name,
                p.last_name AS patient_last_name,
                s.first_name AS staff_first_name,
                s.last_name AS staff_last_name
            FROM prescription_table pt
            JOIN patient_table p ON pt.patient_id = p.patient_id
            JOIN staff_table s ON pt.staff_id = s.staff_id
            WHERE pt.status = 'Pending'
        ";
        $prescriptions = $this->db_fetch_all($sql);

        $result = [];
        foreach ($prescriptions as $pres) {
            $medications = $this->getPrescriptionMedications($pres['prescription_id']);
            $result[] = [
                'prescription_id' => $pres['prescription_id'],
                'patient' => [
                    'patient_id' => $pres['patient_id'],
                    'first_name' => $pres['patient_first_name'],
                    'last_name' => $pres['patient_last_name']
                ],
                'staff' => [
                    'first_name' => $pres['staff_first_name'],
                    'last_name' => $pres['staff_last_name']
                ],
                'medications' => $medications,
                'medication_date' => $pres['medication_date'],
                'status' => $pres['status']
            ];
        }
        return $result;
    }

    // Get prescription by ID with patient, staff, and medication details
    public function getPrescriptionById($prescription_id) {
        $prescription_id = mysqli_real_escape_string($this->db_conn(), $prescription_id);
        $sql = "
            SELECT 
                pt.prescription_id,
                pt.patient_id,
                pt.staff_id,
                pt.medication_date,
                pt.status,
                p.first_name AS patient_first_name,
                p.last_name AS patient_last_name,
                s.first_name AS staff_first_name,
                s.last_name AS staff_last_name
            FROM prescription_table pt
            JOIN patient_table p ON pt.patient_id = p.patient_id
            JOIN staff_table s ON pt.staff_id = s.staff_id
            WHERE pt.prescription_id = '$prescription_id' AND pt.status = 'Pending'
        ";
        $prescription = $this->db_fetch_one($sql);

        if (!$prescription) {
            return false;
        }

        $medications = $this->getPrescriptionMedications($prescription['prescription_id']);
        return [
            'prescription_id' => $prescription['prescription_id'],
            'patient' => [
                'patient_id' => $prescription['patient_id'],
                'first_name' => $prescription['patient_first_name'],
                'last_name' => $prescription['patient_last_name']
            ],
            'staff' => [
                'first_name' => $prescription['staff_first_name'],
                'last_name' => $prescription['staff_last_name']
            ],
            'medications' => $medications,
            'medication_date' => $prescription['medication_date'],
            'status' => $prescription['status']
        ];
    }

    // Helper function to get medications for a prescription
    private function getPrescriptionMedications($prescription_id) {
        $prescription_id = mysqli_real_escape_string($this->db_conn(), $prescription_id);
        $sql = "
            SELECT 
                medication_id,
                medication,
                dosage,
                instructions
            FROM prescription_medication_table
            WHERE prescription_id = '$prescription_id'
        ";
        return $this->db_fetch_all($sql);
    }

    // Dispense medications and update prescription status
    public function dispenseMedication($prescription_id, $patient_id, $medications, $pharmacist_id) {
        $prescription_id = mysqli_real_escape_string($this->db_conn(), $prescription_id);
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $pharmacist_id = mysqli_real_escape_string($this->db_conn(), $pharmacist_id);

        // Start transaction
        $this->db_query("START TRANSACTION");

        try {
            // Insert dispensed medications
            foreach ($medications as $med) {
                $medication_id = mysqli_real_escape_string($this->db_conn(), $med['medication_id']);
                $quantity = mysqli_real_escape_string($this->db_conn(), $med['quantity']);
                $status =mysqli_real_escape_string($this->db_conn(), 'Pending');
                $sql = "
                    INSERT INTO dispensed_medication_table (
                        medication_id,
                        prescription_id,
                        patient_id,
                        quantity_dispensed,
                        status,
                        pharmacist_id

                    ) VALUES (
                        '$medication_id',
                        '$prescription_id',
                        '$patient_id',
                        '$quantity',
                        '$status',
                        '$pharmacist_id'
                    )
                ";
                if (!$this->db_query($sql)) {
                    throw new Exception("Failed to insert dispensed medication.");
                }
            }

            // Update prescription status to Dispensed
            $sql = "
                UPDATE prescription_table
                SET status = 'Dispensed'
                WHERE prescription_id = '$prescription_id' AND patient_id = '$patient_id'
            ";
            if (!$this->db_query($sql)) {
                throw new Exception("Failed to update prescription status.");
            }

            // Commit transaction
            $this->db_query("COMMIT");
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db_query("ROLLBACK");
            throw $e;
        }
    }

    // Delete a prescription
    public function deletePrescription($prescription_id) {
        $prescription_id = mysqli_real_escape_string($this->db_conn(), $prescription_id);
        $sql = "DELETE FROM prescription_table WHERE prescription_id = '$prescription_id'";
        return $this->db_query($sql);
    }
}
?>