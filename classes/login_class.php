<?php
require("../settings/db_class.php");

class customerlogin_class extends db_connection
{
    public function get_user_by_id($user_id)
    {
        $sql = "SELECT user_id, role, password FROM user_table WHERE user_id = ?";
        $stmt = $this->db_conn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $role, $password);
                $stmt->fetch();
                return [
                    'user_id' => $user_id,
                    'role' => $role,
                    'password' => $password
                ];
            } else {
                return null;
            }
        } else {
            return false;
        }
    }

    public function verify_password($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}
?>