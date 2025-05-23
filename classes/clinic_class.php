<?php
require_once("../settings/db_class.php");

class clinic_class extends db_connection {

    public function addclinic($clinic_id, $clinicName, $department_id) {
        $clinic_id = mysqli_real_escape_string($this->db_conn(), $clinic_id);
        $clinicName = mysqli_real_escape_string($this->db_conn(), $clinicName);
        $department_id = mysqli_real_escape_string($this->db_conn(), $department_id);
        $sql = "INSERT INTO clinic_table (clinic_id, clinic_name, department_id)
                VALUES ('$clinic_id', '$clinicName', '$department_id')";
        
        return $this->db_query($sql);
    }

    public function deleteclinic($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM clinic_table WHERE clinic_id = '$id'";
        return $this->db_query($sql);
    }

    public function getclinics() {
        $sql = "SELECT * FROM clinic_table";
        return $this->db_fetch_all($sql);
    }

    public function getclinicsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM clinic_table WHERE clinic_id = '$id'";
        return $this->db_fetch_all($sql);
    }

    public function updateclinic($clinic_id, $clinicName, $department_id) {
        $clinic_id = mysqli_real_escape_string($this->db_conn(), $clinic_id);
        $clinicName= mysqli_real_escape_string($this->db_conn(), $clinicName);
        
        $sql = "UPDATE clinic_table
                SET clinic_name = '$clinicName'
                WHERE clinic_id = '$clinic_id'";
        
        return $this->db_query($sql);
    }

    public function clinic_ID_exists($clinic_id) {
        $clinic_id= mysqli_real_escape_string($this->db_conn(), $clinic_id);
        $sql = "SELECT clinic_id FROM clinic_table WHERE clinic_id = '$clinic_id'";
        return $this->db_fetch_all($sql);
    }
}
?>
