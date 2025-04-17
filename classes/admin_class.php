<?php
require_once("../settings/db_class.php");

class admin_class extends db_connection {

    // Add admin
    public function addadmin($admin_id, $first_name, $last_name, $contact, $position) {
        $admin_id = mysqli_real_escape_string($this->db_conn(), $admin_id);
        $first_name = mysqli_real_escape_string($this->db_conn(), $first_name);
        $last_name = mysqli_real_escape_string($this->db_conn(), $last_name);
        $position = mysqli_real_escape_string($this->db_conn(), $position);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);
        $sql = "INSERT INTO admin (admin_id, first_name, last_name, contact, role)
                VALUES ('$admin_id', '$first_name', '$last_name', '$contact','$position')";
        
        return $this->db_query($sql);
    }

    // Delete a admin by id
    public function deleteadmin($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM user_table WHERE user_id = '$id'";
        return $this->db_query($sql);
    }

    // Get all admin records
    public function getadmins() {
        $sql = "SELECT * FROM admin";
        return $this->db_fetch_all($sql);
    }

    // Get admin information by id
    public function getadminsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM admin WHERE admin_id = '$id'";
        return $this->db_fetch_all($sql);
    }

    // Update  admin
    public function updateadmin($adminId, $firstName, $lastName,$contact, $position) {
        // Sanitize inputs to prevent SQL injection
        $admin_id = mysqli_real_escape_string($this->db_conn(), $adminId);
        $first_name = mysqli_real_escape_string($this->db_conn(), $firstName);
        $last_name = mysqli_real_escape_string($this->db_conn(), $lastName);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);
        $position = mysqli_real_escape_string($this-> db_conn(), $position);
        
        // Create the SQL query to update the admin record
        $sql = "UPDATE admin
                SET first_name = '$first_name',
                    last_name = '$last_name',
                    role = '$position',
                    contact = '$contact',
                WHERE admin_id = '$admin_id'";
        
        // Execute the query
        return $this->db_query($sql);
    }
    

    public function addUser($admin_id, $password, $userRole)
    {
        $admin_id= mysqli_real_escape_string($this->db_conn(), $admin_id);
        $password = mysqli_real_escape_string($this->db_conn(), $password);
        $userRole = mysqli_real_escape_string($this->db_conn(), $userRole);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_table(user_id, password, role)
                VALUES ('$admin_id', '$hashed_password', '$userRole')";
        
        return $this->db_query($sql);
    }

    public function admin_ID_exists($admin_id) {
        $admin_id= mysqli_real_escape_string($this->db_conn(), $admin_id);
        $sql = "SELECT user_id FROM user_table WHERE user_id = '$admin_id'";
        return $this->db_fetch_all($sql);
    }
}
?>
