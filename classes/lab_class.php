<?php
require_once("../settings/db_class.php");

class lab_class extends db_connection {

    // Add Patient
    public function requestform($doctor_fullname, $patient_fullname, $lab_test, $susdiag, $signature, $ext, $request_date) {
        // Sanitize input
        $doctor_fullname = mysqli_real_escape_string($this->db_conn(), $doctor_fullname);
        $patient_fullname = mysqli_real_escape_string($this->db_conn(), $patient_fullname);
        $lab_test = mysqli_real_escape_string($this->db_conn(), $lab_test);
        $susdiag = mysqli_real_escape_string($this->db_conn(), $susdiag);
        $signature = mysqli_real_escape_string($this->db_conn(), $signature);
        $ext = mysqli_real_escape_string($this->db_conn(), $ext);
        $request_date = mysqli_real_escape_string($this->db_conn(), $request_date);
    
        // Get patient_id
        $patient_sql = "SELECT patient_id 
                        FROM patient_table 
                        WHERE CONCAT(first_name, ' ', last_name) = '$patient_fullname'";
        $patient_result = $this->db_query($patient_sql);
        $patient_row = mysqli_fetch_assoc($patient_result);
        $patient_id = $patient_row['patient_id'] ?? null;
    
        // Get doctor_id
        $doctor_sql = "SELECT doctor_id 
                       FROM doctor_table 
                       WHERE CONCAT(first_name, ' ', last_name) = '$doctor_fullname'";
        $doctor_result = $this->db_query($doctor_sql);
        $doctor_row = mysqli_fetch_assoc($doctor_result);
        $doctor_id = $doctor_row['doctor_id'] ?? null;
    
        // Check if patient and doctor exist
        if (!$patient_id) {
            throw new Exception("Patient not found: $patient_fullname");
        }
        if (!$doctor_id) {
            throw new Exception("Doctor not found: $doctor_fullname");
        }
    
        // Insert into lab table
        $lab_sql = "INSERT INTO lab_table (
                        patient_id, 
                        doctor_id, 
                        lab_test, 
                        suspected_diagnosis, 
                        signature, 
                        extension, 
                        request_date
                    ) VALUES (
                        '$patient_id',
                        '$doctor_id',
                        '$lab_test',
                        '$susdiag',
                        '$signature',
                        '$ext',
                        '$request_date'
                    )";
        
        return $this->db_query($lab_sql);
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
