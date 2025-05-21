<?php
require_once("../settings/db_class.php");

class admin_class extends db_connection {

    public function addadmin($admin_id, $first_name, $last_name, $contact, $position) {
        $admin_id = mysqli_real_escape_string($this->db_conn(), $admin_id);
        $first_name = mysqli_real_escape_string($this->db_conn(), $first_name);
        $last_name = mysqli_real_escape_string($this->db_conn(), $last_name);
        $position = mysqli_real_escape_string($this->db_conn(), $position);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);
        $sql = "INSERT INTO admin (admin_id, first_name, last_name, contact, role)
                VALUES ('$admin_id', '$first_name', '$last_name', '$contact', '$position')";
        
        return $this->db_query($sql);
    }

    public function deleteadmin($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM user_table WHERE user_id = '$id'";
        return $this->db_query($sql);
    }

    public function getadmins() {
        $sql = "SELECT * FROM admin";
        return $this->db_fetch_all($sql);
    }

    public function getadminsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM admin WHERE admin_id = '$id'";
        return $this->db_fetch_all($sql);
    }

    public function updateadmin($adminId, $firstName, $lastName, $contact) {
        $admin_id = mysqli_real_escape_string($this->db_conn(), $adminId);
        $first_name = mysqli_real_escape_string($this->db_conn(), $firstName);
        $last_name = mysqli_real_escape_string($this->db_conn(), $lastName);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);
        
        $sql = "UPDATE admin
                SET first_name = '$first_name',
                    last_name = '$last_name',
                    contact = '$contact'
                WHERE admin_id = '$admin_id'";
        
        return $this->db_query($sql);
    }

    public function updateAdminWithId($original_admin_id, $new_admin_id, $first_name, $last_name, $contact) {
        $original_admin_id = mysqli_real_escape_string($this->db_conn(), $original_admin_id);
        $new_admin_id = mysqli_real_escape_string($this->db_conn(), $new_admin_id);
        $first_name = mysqli_real_escape_string($this->db_conn(), $first_name);
        $last_name = mysqli_real_escape_string($this->db_conn(), $last_name);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);

        mysqli_begin_transaction($this->db_conn());

        try {
            $sql_user = "UPDATE user_table SET user_id = ? WHERE user_id = ?";
            $stmt_user = mysqli_prepare($this->db_conn(), $sql_user);
            mysqli_stmt_bind_param($stmt_user, "ss", $new_admin_id, $original_admin_id);
            $user_result = mysqli_stmt_execute($stmt_user);
            mysqli_stmt_close($stmt_user);

            $sql_admin = "UPDATE admin SET first_name = ?, last_name = ?, contact = ? WHERE admin_id = ?";
            $stmt_admin = mysqli_prepare($this->db_conn(), $sql_admin);
            mysqli_stmt_bind_param($stmt_admin, "ssss", $first_name, $last_name, $contact, $new_admin_id);
            $admin_result = mysqli_stmt_execute($stmt_admin);
            mysqli_stmt_close($stmt_admin);


            mysqli_commit($this->db_conn());
            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->db_conn());
            error_log("UpdateAdminWithId Error: " . $e->getMessage());
            return false;
        }
    }

    public function addUser($admin_id, $password, $userRole) {
        $admin_id = mysqli_real_escape_string($this->db_conn(), $admin_id);
        $password = mysqli_real_escape_string($this->db_conn(), $password);
        $userRole = mysqli_real_escape_string($this->db_conn(), $userRole);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_table (user_id, password, role)
                VALUES ('$admin_id', '$hashed_password', '$userRole')";
        
        return $this->db_query($sql);
    }

    public function admin_ID_exists($admin_id) {
        $admin_id = mysqli_real_escape_string($this->db_conn(), $admin_id);
        $sql = "SELECT user_id FROM user_table WHERE user_id = '$admin_id'";
        return $this->db_fetch_all($sql);
    }
}
?>