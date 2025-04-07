<?php
require_once("../settings/db_class.php");

class prescription_class extends db_connection {

    // Add Patient
    public function prescription_form($doctor_fullname, $patient_fullname, $medication_date, $medicines, $dosages, $instructions) {
        $conn = $this->db_conn();
    
        // Check if connection failed
        if ($conn === false) {
            throw new Exception("Database connection failed.");
        }
    
        // Sanitize inputs
        $doctor_fullname = mysqli_real_escape_string($conn, $doctor_fullname);
        $patient_fullname = mysqli_real_escape_string($conn, $patient_fullname);
        $medication_date = mysqli_real_escape_string($conn, $medication_date);
        $status = 'Pending'; // Must match ENUM values
    
        // Get patient_id
        $patient_sql = "SELECT patient_id FROM patient_table WHERE CONCAT(first_name, ' ', last_name) = '$patient_fullname'";
        $patient_result = mysqli_query($conn, $patient_sql);
        if ($patient_result === false) {
            throw new Exception("Query failed: " . mysqli_error($conn));
        }
        $patient_row = mysqli_fetch_assoc($patient_result);
        $patient_id = $patient_row['patient_id'] ?? null;
    
        // Get doctor_id
        $doctor_sql = "SELECT staff_id FROM staff_table WHERE CONCAT(first_name, ' ', last_name) = '$doctor_fullname'";
        $doctor_result = mysqli_query($conn, $doctor_sql);
        if ($doctor_result === false) {
            throw new Exception("Query failed: " . mysqli_error($conn));
        }
        $doctor_row = mysqli_fetch_assoc($doctor_result);
        $staff_id = $doctor_row['staff_id'] ?? null;
    
        // Check if patient and doctor exist
        if (!$patient_id) {
            throw new Exception("Patient not found: $patient_fullname");
        }
        if (!$staff_id) {
            throw new Exception("Doctor not found: $doctor_fullname");
        }
    
        // Start transaction to ensure atomicity
        if (!mysqli_begin_transaction($conn)) {
            throw new Exception("Failed to start transaction: " . mysqli_error($conn));
        }
    
        try {
            // Insert into prescription_table
            $prescription_sql = "INSERT INTO prescription_table (patient_id, staff_id, medication_date, status) 
                                VALUES ('$patient_id', '$staff_id', '$medication_date', '$status')";
            if (!mysqli_query($conn, $prescription_sql)) {
                throw new Exception("Failed to insert prescription: " . mysqli_error($conn));
            }
            
            // Get the last inserted ID
            $prescription_id = mysqli_insert_id($conn);
            if ($prescription_id === 0) {
                throw new Exception("Failed to get prescription ID");
            }
    
            // Insert each medication into prescription_medication_table
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
    
            // Commit transaction
            if (!mysqli_commit($conn)) {
                throw new Exception("Failed to commit transaction: " . mysqli_error($conn));
            }
            return true;
        } catch (Exception $e) {
            // Rollback on error
            mysqli_rollback($conn);
            throw $e;
        } finally {
            // Close connection
            mysqli_close($conn);
        }
    }

    // Get all patient records
    public function gettests() {
        $sql = "SELECT * FROM patient_table";
        return $this->db_fetch_all($sql);
    }

    // Get patient information by id
    public function getPatientsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM patient_table WHERE patient_id = '$id'";
        return $this->db_fetch_all($sql);
    }
    

    public function patient_ID_exists($patient_id) {
        $patient_id= mysqli_real_escape_string($this->db_conn(), $patient_id);
        $sql = "SELECT patient_id FROM patient_table WHERE patient_id = '$patient_id'";
        return $this->db_fetch_all($sql);
    }

    public function addUser($patientId, $password, $userRole)
    {
        $patientId = mysqli_real_escape_string($this->db_conn(), $patientId);
        $password = mysqli_real_escape_string($this->db_conn(), $password);
        $userRole = mysqli_real_escape_string($this->db_conn(), $userRole);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_table(user_id, password, role)
                VALUES ('$patientId', '$hashed_password', '$userRole')";
        
        return $this->db_query($sql);
    }

}
?>
