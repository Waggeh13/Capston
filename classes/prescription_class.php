<?php
require_once("../settings/db_class.php");

class prescription_class extends db_connection {

    public function prescription_form($staff_id, $patient_fullname, $medication_date, $medicines, $dosages, $instructions) {
        $conn = $this->db_conn();
    
        if ($conn === false) {
            throw new Exception("Database connection failed.");
        }
    
        $staff_id = mysqli_real_escape_string($conn, $staff_id);
        $patient_fullname = mysqli_real_escape_string($conn, $patient_fullname);
        $medication_date = mysqli_real_escape_string($conn, $medication_date);
        $status = 'Pending';
    
        $patient_sql = "SELECT patient_id FROM patient_table WHERE CONCAT(first_name, ' ', last_name) = '$patient_fullname'";
        $patient_result = mysqli_query($conn, $patient_sql);
        if ($patient_result === false) {
            throw new Exception("Query failed: " . mysqli_error($conn));
        }
        $patient_row = mysqli_fetch_assoc($patient_result);
        $patient_id = $patient_row['patient_id'] ?? null;
    
    
        if (!$patient_id) {
            throw new Exception("Patient not found: $patient_fullname");
        }
    
        if (!mysqli_begin_transaction($conn)) {
            throw new Exception("Failed to start transaction: " . mysqli_error($conn));
        }
    
        try {
            $prescription_sql = "INSERT INTO prescription_table (patient_id, staff_id, medication_date, status) 
                                VALUES ('$patient_id', '$staff_id', '$medication_date', '$status')";
            if (!mysqli_query($conn, $prescription_sql)) {
                throw new Exception("Failed to insert prescription: " . mysqli_error($conn));
            }
            
            $prescription_id = mysqli_insert_id($conn);
            if ($prescription_id === 0) {
                throw new Exception("Failed to get prescription ID");
            }
    
            for ($i = 0; $i < count($medicines); $i++) {
                $medicine = mysqli_real_escape_string($conn, $medicines[$i]);
                $dosage = mysqli_real_escape_string($conn, $dosages[$i]);
                $instruction = mysqli_real_escape_string($conn, $instructions[$i]);
    
                $medication_sql = "INSERT INTO prescription_medication_table (prescription_id, medication, dosage, instructions) 
                                VALUES ('$prescription_id', '$medicine', '$dosage', '$instruction')";
                if (!mysqli_query($conn, $medication_sql)) {
                    throw new Exception("Failed to insert medication: " . mysqli_error($conn));
                }
            }
    
            if (!mysqli_commit($conn)) {
                throw new Exception("Failed to commit transaction: " . mysqli_error($conn));
            }
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            throw $e;
        } finally {
            mysqli_close($conn);
        }
    }

    public function gettests() {
        $sql = "SELECT * FROM patient_table";
        return $this->db_fetch_all($sql);
    }

    public function getPatientsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM patient_table WHERE patient_id = '$id'";
        return $this->db_fetch_all($sql);
    }
    



}
?>
