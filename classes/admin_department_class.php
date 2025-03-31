<?php
require_once("../settings/db_class.php");

class admin_department_class extends db_connection {

    // Add department
    public function adddepartment($department_id, $departmentName) {
        $department_id = mysqli_real_escape_string($this->db_conn(), $department_id);
        $departmentName = mysqli_real_escape_string($this->db_conn(), $departmentName);
        $sql = "INSERT INTO department_table (department_id, department_name)
                VALUES ('$department_id', '$departmentName')";
        
        return $this->db_query($sql);
    }

    // Delete a department by id
    public function deletedepartment($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM department_table WHERE department_id = '$id'";
        return $this->db_query($sql);
    }

    // Get all department records
    public function getdepartments() {
        $sql = "SELECT * FROM department_table";
        return $this->db_fetch_all($sql);
    }

    // Get department information by id
    public function getdepartmentsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM department_table WHERE department_id = '$id'";
        return $this->db_fetch_all($sql);
    }

    // Update product
    public function updatedepartment($department_id, $departmentName) {
        // Sanitize inputs to prevent SQL injection
        $department_id = mysqli_real_escape_string($this->db_conn(), $department_id);
        $departmentName= mysqli_real_escape_string($this->db_conn(), $departmentName);
        
        // Create the SQL query to update the department record
        $sql = "UPDATE department_table
                SET department_name = '$departmentName'
                WHERE department_id = '$department_id'";
        
        // Execute the query
        return $this->db_query($sql);
    }

    public function department_ID_exists($department_id) {
        $department_id= mysqli_real_escape_string($this->db_conn(), $department_id);
        $sql = "SELECT department_id FROM department_table WHERE department_id = '$department_id'";
        return $this->db_fetch_all($sql);
    }
}
?>
