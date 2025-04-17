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

    private function fetchUserName($patient_id) {
        $query = "SELECT CONCAT(first_name, ' ', last_name) AS full_name 
                  FROM patient_table 
                  WHERE patient_id = ?";

        try {
            $conn = $this->db_conn();
            if (!$conn) {
                throw new Exception("Database connection failed");
            }

            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            // Bind patient_id as an integer
            $stmt->bind_param("i", $patient_id);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            // Set userName or default to 'Unknown User'
            $this->userName = $data && isset($data['full_name']) ? $data['full_name'] : 'Unknown User';

            // Debug output
            error_log("Fetched user name for patient_id $patient_id: " . $this->userName);

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