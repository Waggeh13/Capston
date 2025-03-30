<?php
require_once("../settings/db_class.php");

class admin_patient_class extends db_connection {

    // Add Patient
    public function addPatient($patient_id, $first_name, $last_name, $dob, $gender, $weight, $address, $contact,$nextOfKin,$nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship) {
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $first_name = mysqli_real_escape_string($this->db_conn(), $first_name);
        $last_name = mysqli_real_escape_string($this->db_conn(), $last_name);
        $dob = mysqli_real_escape_string($this->db_conn(), $dob);
        $gender = mysqli_real_escape_string($this->db_conn(), $gender);
        $weight = mysqli_real_escape_string($this->db_conn(), $weight);
        $address = mysqli_real_escape_string($this->db_conn(), $address);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);
        $nextOfKin = mysqli_real_escape_string($this->db_conn(), $nextOfKin);
        $nextOfKinContact = mysqli_real_escape_string($this->db_conn(), $nextOfKinContact);
        $nextOfKinGender = mysqli_real_escape_string($this->db_conn(), $nextOfKinGender);
        $nextOfKinRelationship = mysqli_real_escape_string($this->db_conn(), $nextOfKinRelationship);
        $sql = "INSERT INTO patient_table(patient_id, first_name, last_name, dob, gender, weight, address, contact, nextofkinname, nextofkinContact, nextofkingender, nextofkinrelationship)
                VALUES ('$patient_id', '$first_name', '$last_name', '$dob', '$gender', '$weight', '$address', '$contact', '$nextOfKin', '$nextOfKinContact', '$nextOfKinGender', '$nextOfKinRelationship')";
        
        return $this->db_query($sql);
    }

    // Delete a patient by id
    public function deletePatient($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM user_table WHERE user_id = '$id'";
        return $this->db_query($sql);
    }

    // Get all patient records
    public function getPatients() {
        $sql = "SELECT * FROM patient_table";
        return $this->db_fetch_all($sql);
    }

    // Get patient information by id
    public function getPatientsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM patient_table WHERE patient_id = '$id'";
        return $this->db_fetch_all($sql);
    }

    // Update product
    public function updatePatient($patient_id, $first_name, $last_name, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship) {
        $patient_id = mysqli_real_escape_string($this->db_conn(), $patient_id);
        $first_name = mysqli_real_escape_string($this->db_conn(), $first_name);
        $last_name = mysqli_real_escape_string($this->db_conn(), $last_name);
        $dob = mysqli_real_escape_string($this->db_conn(), $dob);
        $gender = mysqli_real_escape_string($this->db_conn(), $gender);
        $weight = mysqli_real_escape_string($this->db_conn(), $weight);
        $address = mysqli_real_escape_string($this->db_conn(), $address);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);
        $nextOfKin = mysqli_real_escape_string($this->db_conn(), $nextOfKin);
        $nextOfKinContact = mysqli_real_escape_string($this->db_conn(), $nextOfKinContact);
        $nextOfKinGender = mysqli_real_escape_string($this->db_conn(), $nextOfKinGender);
        $nextOfKinRelationship = mysqli_real_escape_string($this->db_conn(), $nextOfKinRelationship);
    
        // Update query
        $sql = "UPDATE patient_table 
                SET first_name = '$first_name', 
                    last_name = '$last_name', 
                    dob = '$dob', 
                    gender = '$gender', 
                    weight = '$weight', 
                    address = '$address', 
                    contact = '$contact', 
                    nextOfKin = '$nextOfKin', 
                    nextOfKinContact = '$nextOfKinContact', 
                    nextOfKinGender = '$nextOfKinGender', 
                    nextOfKinRelationship = '$nextOfKinRelationship' 
                WHERE patient_id = '$patient_id'";
    
        return $this->db_query($sql);
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
