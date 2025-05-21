<?php
require_once("../settings/db_class.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class password_class extends db_connection {
    public function password_form($user_id, $c_pass, $n_pass) {
        $conn = $this->db_conn();
        if (!$conn) {
            return ['success' => false, 'message' => 'Database connection failed'];
        }

        $sql = "SELECT password FROM user_table WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $conn->error);
            return ['success' => false, 'message' => 'Query preparation failed'];
        }

        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            if (!password_verify($c_pass, $stored_password)) {
                $stmt->close();
                return ['success' => false, 'message' => 'incorrect_current_password'];
            }

            $hashed_password = password_hash($n_pass, PASSWORD_DEFAULT);
            if (!$hashed_password) {
                $stmt->close();
                return ['success' => false, 'message' => 'Failed to hash new password'];
            }

            $update_sql = "UPDATE user_table SET password = ? WHERE user_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            if (!$update_stmt) {
                error_log('Update prepare failed: ' . $conn->error);
                $stmt->close();
                return ['success' => false, 'message' => 'Update query preparation failed'];
            }

            $update_stmt->bind_param("ss", $hashed_password, $user_id);
            $update_success = $update_stmt->execute();

            if ($update_success && $update_stmt->affected_rows > 0) {
                $update_stmt->close();
                $stmt->close();
                return ['success' => true, 'message' => 'Password changed successfully'];
            } else {
                error_log('Update failed: ' . $update_stmt->error);
                $update_stmt->close();
                $stmt->close();
                return ['success' => false, 'message' => 'Failed to update password'];
            }
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'User not found'];
        }
    }
}
?>