<?php
require_once("../settings/db_class.php");

class department_class extends db_connection {

    public function adddepartment($department_id, $departmentName) {
        $department_id = mysqli_real_escape_string($this->db_conn(), $department_id);
        $departmentName = mysqli_real_escape_string($this->db_conn(), $departmentName);
        $sql = "INSERT INTO department_table (department_id, department_name)
                VALUES ('$department_id', '$departmentName')";
        
        return $this->db_query($sql);
    }

    public function deletedepartment($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM department_table WHERE department_id = '$id'";
        return $this->db_query($sql);
    }

    public function getdepartments() {
        $sql = "SELECT * FROM department_table";
        return $this->db_fetch_all($sql);
    }

    public function getdepartmentsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM department_table WHERE department_id = '$id'";
        return $this->db_fetch_all($sql);
    }

    public function updatedepartment($department_id, $departmentName) {
        $department_id = mysqli_real_escape_string($this->db_conn(), $department_id);
        $departmentName= mysqli_real_escape_string($this->db_conn(), $departmentName);
        
        $sql = "UPDATE department_table
                SET department_name = '$departmentName'
                WHERE department_id = '$department_id'";
        
        return $this->db_query($sql);
    }

    public function department_ID_exists($department_id) {
        $department_id= mysqli_real_escape_string($this->db_conn(), $department_id);
        $sql = "SELECT department_id FROM department_table WHERE department_id = '$department_id'";
        return $this->db_fetch_all($sql);
    }
}
?>
