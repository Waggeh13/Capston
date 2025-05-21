<?php
require_once("../settings/db_class.php");

class patient_class extends db_connection {
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
    public function deletePatient($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM user_table WHERE user_id = '$id'";
        return $this->db_query($sql);
    }

    public function getPatients() {
        $sql = "SELECT * FROM patient_table";
        return $this->db_fetch_all($sql);
    }

    public function getPatientsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM patient_table WHERE patient_id = '$id'";
        return $this->db_fetch_all($sql);
    }

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
    
        $sql = "UPDATE patient_table 
                SET first_name = '$first_name', 
                    last_name = '$last_name', 
                    dob = '$dob', 
                    gender = '$gender', 
                    weight = '$weight', 
                    address = '$address', 
                    contact = '$contact', 
                    nextofkinname = '$nextOfKin', 
                    nextofkincontact = '$nextOfKinContact', 
                    nextofkingender = '$nextOfKinGender', 
                    nextofkinrelationship = '$nextOfKinRelationship' 
                WHERE patient_id = '$patient_id'";
    
        return $this->db_query($sql);
    }
    

    public function patient_ID_exists($patient_id) {
        $patient_id= mysqli_real_escape_string($this->db_conn(), $patient_id);
        $sql = "SELECT user_id FROM user_table WHERE user_id = '$patient_id'";
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

    public function update_ID($original_patient_id, $patientId)
{
    $patient_id = mysqli_real_escape_string($this->db_conn(), $patientId);
    $original_patientid = mysqli_real_escape_string($this->db_conn(), $original_patient_id);

    $sql = "UPDATE user_table
    SET user_id = '$patient_id'
    WHERE user_id = '$original_patientid'";

return $this->db_query($sql);

}

}
?>
