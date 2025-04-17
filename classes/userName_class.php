<?php
require_once("../settings/db_class.php");

class userName_class extends db_connection {
    private $userName;

    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../view/login.php');
            exit;
        }

        // Fetch user name
        $this->fetchUserName($_SESSION['user_id']);
    }

    private function fetchUserName($user_id) {
        // Query to fetch name from patient_table
        $patient_query = "SELECT CONCAT(first_name, ' ', last_name) AS full_name 
                         FROM patient_table 
                         WHERE patient_id = ?";

        // Query to fetch name from staff_table
        $staff_query = "SELECT CONCAT(first_name, ' ', last_name) AS full_name 
                        FROM staff_table 
                        WHERE staff_id = ?";

        try {
            $conn = $this->db_conn();
            if (!$conn) {
                throw new Exception("Database connection failed");
            }

            // First, try fetching from patient_table
            $stmt = $conn->prepare($patient_query);
            if (!$stmt) {
                throw new Exception("Prepare failed (patient): " . $conn->error);
            }

            // Bind user_id as an integer
            $stmt->bind_param("i", $user_id);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed (patient): " . $stmt->error);
            }

            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            if ($data && isset($data['full_name'])) {
                // Name found in patient_table
                $this->userName = $data['full_name'];
            } else {
                // If not found in patient_table, try staff_table
                $stmt = $conn->prepare($staff_query);
                if (!$stmt) {
                    throw new Exception("Prepare failed (staff): " . $conn->error);
                }

                // Bind user_id as an integer
                $stmt->bind_param("i", $user_id);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed (staff): " . $stmt->error);
                }

                $result = $stmt->get_result();
                $data = $result->fetch_assoc();

                // Set userName or default to 'Unknown User'
                $this->userName = $data && isset($data['full_name']) ? $data['full_name'] : 'Unknown User';
            }

            // Debug output
            error_log("Fetched user name for user_id $user_id: " . $this->userName);

        } catch (Exception $e) {
            error_log("User profile fetch error: " . $e->getMessage());
            $this->userName = 'Unknown User';
        }
    }

    public function getUserName() {
        return htmlspecialchars($this->userName);
    }
}
?>