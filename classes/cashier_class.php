<?php
require_once("../settings/db_class.php");

class Cashier_class extends db_connection {

    public function getPendingPayments() {
        $sql = "
            SELECT 
                dmt.dispensed_id,
                dmt.prescription_id,
                dmt.patient_id,
                dmt.quantity_dispensed,
                dmt.dispensed_date,
                dmt.status AS payment_status,
                pmt.medication,
                pmt.dosage,
                pmt.instructions,
                pt.first_name AS patient_first_name,
                pt.last_name AS patient_last_name,
                st.first_name AS staff_first_name,
                st.last_name AS staff_last_name
            FROM dispensed_medication_table dmt
            JOIN prescription_medication_table pmt ON dmt.medication_id = pmt.medication_id
            JOIN patient_table pt ON dmt.patient_id = pt.patient_id
            JOIN prescription_table prt ON dmt.prescription_id = prt.prescription_id
            JOIN staff_table st ON prt.staff_id = st.staff_id
            WHERE dmt.status = 'Pending'
        ";
        $payments = $this->db_fetch_all($sql);

        $grouped = [];
        foreach ($payments as $payment) {
            $key = $payment['patient_id'] . '_' . $payment['prescription_id'];
            if (!isset($grouped[$key])) {
                $consultations = $this->getConsultationDetails($payment['patient_id']);
                $lab_tests = $this->getLabTestDetails($payment['patient_id']);
                $grouped[$key] = [
                    'dispensed_ids' => [],
                    'prescription_id' => $payment['prescription_id'],
                    'patient' => [
                        'patient_id' => $payment['patient_id'],
                        'first_name' => $payment['patient_first_name'],
                        'last_name' => $payment['patient_last_name']
                    ],
                    'staff' => [
                        'first_name' => $payment['staff_first_name'],
                        'last_name' => $payment['staff_last_name']
                    ],
                    'medications' => [],
                    'consultations' => $consultations,
                    'lab_tests' => $lab_tests,
                    'dispensed_date' => $payment['dispensed_date'],
                    'payment_status' => $payment['payment_status']
                ];
            }
            $grouped[$key]['dispensed_ids'][] = $payment['dispensed_id'];
            $grouped[$key]['medications'][] = [
                'medication' => $payment['medication'],
                'dosage' => $payment['dosage'],
                'instructions' => $payment['instructions'],
                'quantity_dispensed' => $payment['quantity_dispensed']
            ];
        }
        return array_values($grouped);
    }

    private function getConsultationDetails($patient_id) {
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $sql = "
            SELECT 
                bt.booking_id,
                bt.appointment_type,
                bt.status AS booking_status,
                st.first_name AS doctor_first_name,
                st.last_name AS doctor_last_name,
                at.appointment_date,
                ats.time_slot
            FROM booking_table bt
            JOIN appointment_timeslots ats ON bt.timeslot_id = ats.timeslot_id
            JOIN appointment_table at ON ats.appointment_id = at.appointment_id
            JOIN staff_table st ON at.staff_id = st.staff_id
            WHERE bt.patient_id = '$patient_id' AND bt.status = 'Completed'
        ";
        return $this->db_fetch_all($sql);
    }

    private function getLabTestDetails($patient_id) {
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $sql = "
            SELECT 
                ltt.lab_test_id,
                ltt.result,
                ltt.result_status,
                ttt.test_name,
                ttt.description,
                lt.request_date
            FROM lab_test_table ltt
            JOIN lab_table lt ON ltt.lab_id = lt.lab_id
            JOIN test_type_table ttt ON ltt.test_type_id = ttt.test_type_id
            WHERE lt.patient_id = '$patient_id' AND ltt.result_status = 'Completed'
        ";
        return $this->db_fetch_all($sql);
    }

    public function processPayment($dispensed_ids, $patient_id, $prescription_id, $total, $cashier_id) {
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $prescription_id = mysqli_real_escape_string($this->db_conn(), $prescription_id);
        $total = mysqli_real_escape_string($this->db_conn(), $total);
        $cashier_id = mysqli_real_escape_string($this->db_conn(), $cashier_id);

        $this->db_query("START TRANSACTION");

        try {
            foreach ($dispensed_ids as $dispensed_id) {
                $dispensed_id = mysqli_real_escape_string($this->db_conn(), $dispensed_id);
                $sql = "
                    UPDATE dispensed_medication_table
                    SET status = 'Paid'
                    WHERE dispensed_id = '$dispensed_id' AND patient_id = '$patient_id' AND status = 'Pending'
                ";
                if (!$this->db_query($sql)) {
                    throw new Exception("Failed to update dispensed medication status.");
                }
            }

            $sql = "
                INSERT INTO receipt_table (
                    patient_id,
                    prescription_id,
                    total,
                    status,
                    cashier_id
                ) VALUES (
                    '$patient_id',
                    '$prescription_id',
                    '$total',
                    'Paid',
                    '$cashier_id'
                )
            ";
            if (!$this->db_query($sql)) {
                throw new Exception("Failed to create receipt.");
            }

            $this->db_query("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->db_query("ROLLBACK");
            error_log('Process payment error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getRecentPayments() {
        $sql = "
            SELECT 
                rt.receipt_id,
                rt.patient_id,
                rt.prescription_id,
                rt.total,
                rt.status AS receipt_status,
                pt.first_name AS patient_first_name,
                pt.last_name AS patient_last_name
            FROM receipt_table rt
            JOIN patient_table pt ON rt.patient_id = pt.patient_id
            WHERE rt.status = 'Paid'
            ORDER BY rt.receipt_id DESC
        ";
        return $this->db_fetch_all($sql);
    }

    public function getReceiptDetails($receipt_id) {
        $receipt_id = mysqli_real_escape_string($this->db_conn(), $receipt_id);
        $sql = "
            SELECT 
                rt.receipt_id,
                rt.patient_id,
                rt.prescription_id,
                rt.total,
                rt.status AS receipt_status,
                rt.cashier_id,
                pt.first_name AS patient_first_name,
                pt.last_name AS patient_last_name,
                st.first_name AS cashier_first_name,
                st.last_name AS cashier_last_name
            FROM receipt_table rt
            JOIN patient_table pt ON rt.patient_id = pt.patient_id
            JOIN staff_table st ON rt.cashier_id = st.staff_id
            WHERE rt.receipt_id = '$receipt_id'
        ";
        $receipt = $this->db_fetch_one($sql);

        if (!$receipt) {
            error_log('getReceiptDetails: No receipt found for receipt_id: ' . $receipt_id); // Debug
            return null;
        }

        $sql = "
            SELECT 
                pmt.medication,
                pmt.dosage,
                pmt.instructions,
                dmt.quantity_dispensed
            FROM dispensed_medication_table dmt
            JOIN prescription_medication_table pmt ON dmt.medication_id = pmt.medication_id
            WHERE dmt.prescription_id = '{$receipt['prescription_id']}' AND dmt.patient_id = '{$receipt['patient_id']}' AND dmt.status = 'Paid'
        ";
        $medications = $this->db_fetch_all($sql);

        // Get consultations
        $consultations = $this->getConsultationDetails($receipt['patient_id']);

        // Get lab tests
        $lab_tests = $this->getLabTestDetails($receipt['patient_id']);

        return [
            'receipt_id' => $receipt['receipt_id'],
            'patient' => [
                'patient_id' => $receipt['patient_id'],
                'first_name' => $receipt['patient_first_name'],
                'last_name' => $receipt['patient_last_name']
            ],
            'cashier' => [
                'first_name' => $receipt['cashier_first_name'],
                'last_name' => $receipt['cashier_last_name']
            ],
            'total' => $receipt['total'],
            'medications' => $medications,
            'consultations' => $consultations,
            'lab_tests' => $lab_tests
        ];
    }
}
?>