<?php
require("../settings/db_class.php");

class customerlogin_class extends db_connection
{
    //--SELECT USER--//
    public function get_user_by_id($user_id)
    {
        $sql = "SELECT user_role, user_password FROM user_table WHERE user_id = ?";
        $stmt = $this->db_conn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_role, $hashedPassword,);
                $stmt->fetch();
                return ['hashedPassword' => $hashedPassword, 'user_role' => $user_role, 'user_id' => $user_id];
            } else {
                return null;
            }
        } else {
            return false;
        }
    }

    // Function to verify password
    public function verify_password($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}
?>
