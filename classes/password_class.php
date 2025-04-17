<?php
require_once("../settings/db_class.php");

class password_class extends db_connection {
    public function password_form($user_id, $c_pass, $n_pass) {
        // Sanitize inputs to prevent SQL injection
        $user_id = mysqli_real_escape_string($this->db_conn(), $user_id);
        $c_pass = mysqli_real_escape_string($this->db_conn(), $c_pass);
        $n_pass = mysqli_real_escape_string($this->db_conn(), $n_pass);

        // Step 1: Fetch the current hashed password from the database
        $sql = "SELECT password FROM user_table WHERE user_id = '$user_id'";
        $result = $this->db_query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            // Step 2: Verify the current password
            if (!password_verify($c_pass, $stored_password)) {
                // Return false with an error message for incorrect current password
                return ['success' => false, 'message' => 'incorrect_current_password'];
            }

            // Step 3: Hash the new password
            $hashed_password = password_hash($n_pass, PASSWORD_DEFAULT);

            // Step 4: Update the password in the user_table
            $update_sql = "UPDATE user_table SET password = '$hashed_password' WHERE user_id = '$user_id'";
            $update_result = $this->db_query($update_sql);

            if ($update_result && mysqli_affected_rows($this->db_conn()) > 0) {
                return ['success' => true, 'message' => 'Password changed successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to update password'];
            }
        } else {
            return ['success' => false, 'message' => 'User not found'];
        }
    }
}