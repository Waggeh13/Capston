<?php
require_once("../settings/db_class.php");

class message_class extends db_connection {
    private function validateUserId($conn, $user_id, $expected_role = null) {
        $sql = "SELECT role FROM user_table WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        if (!$row) {
            error_log("Invalid user_id: $user_id");
            return false;
        }
        if ($expected_role && strcasecmp($row['role'], $expected_role) !== 0) {
            error_log("User_id $user_id has role {$row['role']}, expected $expected_role");
            return false;
        }
        return true;
    }

    public function getChats($user_id, $user_role) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in getChats");
            return [];
        }

        if (!$this->validateUserId($conn, $user_id, $user_role)) {
            error_log("Invalid user_id or role in getChats: user_id=$user_id, role=$user_role");
            mysqli_close($conn);
            return [];
        }

        $other_role = strcasecmp($user_role, 'Doctor') === 0 ? 'Patient' : 'Doctor';
        $other_table = strcasecmp($user_role, 'Doctor') === 0 ? 'patient_table' : 'staff_table';
        $other_id = strcasecmp($user_role, 'Doctor') === 0 ? 'patient_id' : 'staff_id';
        
        $sql = "SELECT u.$other_id AS contact_id, 
                       CONCAT(u.first_name, ' ', u.last_name) AS contact_name,
                       m.message AS last_message, 
                       (SELECT COUNT(*) FROM messages_table m2 
                        WHERE m2.receiver_id = ? AND m2.sender_id = u.$other_id 
                        AND m2.read_at IS NULL) AS message_count
                FROM $other_table u
                JOIN user_table ut ON u.$other_id = ut.user_id
                LEFT JOIN messages_table m ON m.id = (
                    SELECT MAX(id) FROM messages_table m3 
                    WHERE (m3.sender_id = u.$other_id AND m3.receiver_id = ?) 
                       OR (m3.sender_id = ? AND m3.receiver_id = u.$other_id)
                )
                WHERE ut.role = ? AND EXISTS (
                    SELECT 1 FROM messages_table m4 
                    WHERE (m4.sender_id = u.$other_id AND m4.receiver_id = ?) 
                       OR (m4.sender_id = ? AND m4.receiver_id = u.$other_id)
                )
                ORDER BY m.sent_at DESC";
                
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssisss", $user_id, $user_id, $user_id, $other_role, $user_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $chats = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $chats[] = $row;
        }
        
        if (empty($chats)) {
            error_log("No chats found for user_id: $user_id, role: $user_role");
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $chats;
    }

    public function getMessages($user_id, $contact_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in getMessages");
            return [];
        }

        if (!$this->validateUserId($conn, $user_id) || !$this->validateUserId($conn, $contact_id)) {
            error_log("Invalid user_id or contact_id in getMessages: user_id=$user_id, contact_id=$contact_id");
            mysqli_close($conn);
            return [];
        }

        $sql = "SELECT id, sender_id, receiver_id, message, sent_at, read_at
                FROM messages_table
                WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
                ORDER BY sent_at ASC";
                
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $user_id, $contact_id, $contact_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $messages = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
        
        $update_sql = "UPDATE messages_table SET read_at = NOW() 
                       WHERE receiver_id = ? AND sender_id = ? AND read_at IS NULL";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ss", $user_id, $contact_id);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);
        
        if (empty($messages)) {
            error_log("No messages found for user_id: $user_id, contact_id: $contact_id");
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $messages;
    }

    public function sendMessage($sender_id, $receiver_id, $message) {
        $conn = $this->db_conn();
        if ($conn === false) {
            return ['success' => false, 'message' => 'Database connection failed'];
        }

        if (!$this->validateUserId($conn, $sender_id) || !$this->validateUserId($conn, $receiver_id)) {
            error_log("Invalid sender_id or receiver_id in sendMessage: sender_id=$sender_id, receiver_id=$receiver_id");
            mysqli_close($conn);
            return ['success' => false, 'message' => 'Invalid user IDs'];
        }

        $sql = "INSERT INTO messages_table (sender_id, receiver_id, message, sent_at)
                VALUES (?, ?, ?, NOW())";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Failed to prepare statement in sendMessage");
            mysqli_close($conn);
            return ['success' => false, 'message' => 'Failed to prepare statement'];
        }

        $message = mysqli_real_escape_string($conn, $message);
        mysqli_stmt_bind_param($stmt, "sss", $sender_id, $receiver_id, $message);
        
        $result = mysqli_stmt_execute($stmt);
        $error = mysqli_stmt_error($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        if ($result) {
            error_log("Message sent successfully from $sender_id to $receiver_id");
            return ['success' => true, 'message' => 'Message sent'];
        } else {
            error_log("Failed to send message: $error");
            return ['success' => false, 'message' => 'Failed to send message: ' . $error];
        }
    }

    public function getContactName($contact_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in getContactName");
            return "Unknown";
        }

        $sql = "SELECT ut.role, 
                       CASE 
                           WHEN ut.role = 'Patient' THEN CONCAT(p.first_name, ' ', p.last_name)
                           WHEN ut.role = 'Doctor' THEN CONCAT(s.first_name, ' ', s.last_name)
                           ELSE 'Unknown'
                       END AS name
                FROM user_table ut
                LEFT JOIN patient_table p ON ut.user_id = p.patient_id
                LEFT JOIN staff_table s ON ut.user_id = s.staff_id
                WHERE ut.user_id = ?";
                
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $contact_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'] ?? "Unknown";
        
        if ($name === "Unknown") {
            error_log("No name found for contact_id: $contact_id");
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $name;
    }

    public function searchUsers($query, $user_role) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in searchUsers");
            return ['success' => false, 'users' => [], 'error' => 'Database connection failed'];
        }

        error_log("searchUsers: Connected to database " . mysqli_get_host_info($conn));
        
        if (strcasecmp($user_role, 'Doctor') !== 0 && strcasecmp($user_role, 'Patient') !== 0) {
            error_log("searchUsers: Invalid user_role: $user_role");
            mysqli_close($conn);
            return ['success' => false, 'users' => [], 'error' => 'Invalid user role'];
        }

        $target_role = strcasecmp($user_role, 'Doctor') === 0 ? 'Patient' : 'Doctor';
        $table = strcasecmp($user_role, 'Doctor') === 0 ? 'patient_table' : 'staff_table';
        $id_column = strcasecmp($user_role, 'Doctor') === 0 ? 'patient_id' : 'staff_id';
        
        $query = '%' . mysqli_real_escape_string($conn, $query) . '%';
        $sql = "SELECT u.$id_column AS id, CONCAT(u.first_name, ' ', u.last_name) AS name, ut.role
                FROM $table u
                LEFT JOIN user_table ut ON u.$id_column = ut.user_id
                WHERE ut.role = ? AND 
                      (LOWER(u.first_name) LIKE LOWER(?) OR 
                       LOWER(u.last_name) LIKE LOWER(?) OR 
                       LOWER(CONCAT(u.first_name, ' ', u.last_name)) LIKE LOWER(?))
                ORDER BY u.first_name ASC";
                
        error_log("searchUsers: Executing SQL: $sql with params: role=$target_role, query=$query");
        
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            error_log("searchUsers: Failed to prepare statement: " . mysqli_error($conn));
            mysqli_close($conn);
            return ['success' => false, 'users' => [], 'error' => 'Failed to prepare statement'];
        }
        
        mysqli_stmt_bind_param($stmt, "ssss", $target_role, $query, $query, $query);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("searchUsers: Failed to execute statement: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return ['success' => false, 'users' => [], 'error' => 'Failed to execute query'];
        }
        
        $result = mysqli_stmt_get_result($stmt);
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['role'] === null) {
                error_log("searchUsers: User ID {$row['id']} found in $table but missing role in user_table");
            }
            $users[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }
        
        error_log("searchUsers query: $query, role: $target_role, results: " . count($users));
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ['success' => true, 'users' => $users];
    }
}
?>