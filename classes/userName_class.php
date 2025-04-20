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

        // Query to fetch name from admin_table
        $admin_query = "SELECT CONCAT(first_name, ' ', last_name) AS full_name 
                        FROM admin 
                        WHERE admin_id = ?";

        // Query to fetch role from user_table
        $role_query = "SELECT role FROM user_table WHERE user_id = ?";

        try {
            $conn = $this->db_conn();
            if (!$conn) {
                throw new Exception("Database connection failed");
            }

            // Get user role to prioritize query
            $stmt = $conn->prepare($role_query);
            if (!$stmt) {
                throw new Exception("Prepare failed (role): " . $conn->error);
            }

            $stmt->bind_param("s", $user_id);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed (role): " . $stmt->error);
            }

            $result = $stmt->get_result();
            $role_data = $result->fetch_assoc();
            $role = $role_data['role'] ?? null;
            $stmt->close();

            // Initialize userName
            $this->userName = 'Unknown User';

            // Query based on role
            if (strcasecmp($role, 'Patient') === 0) {
                // Try patient_table
                $stmt = $conn->prepare($patient_query);
                if (!$stmt) {
                    throw new Exception("Prepare failed (patient): " . $conn->error);
                }

                $stmt->bind_param("s", $user_id);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed (patient): " . $stmt->error);
                }

                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                if ($data && isset($data['full_name'])) {
                    $this->userName = $data['full_name'];
                }
                $stmt->close();
            } elseif (strcasecmp($role, 'Doctor') === 0) {
                // Try staff_table
                $stmt = $conn->prepare($staff_query);
                if (!$stmt) {
                    throw new Exception("Prepare failed (staff): " . $conn->error);
                }

                $stmt->bind_param("s", $user_id);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed (staff): " . $stmt->error);
                }

                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                if ($data && isset($data['full_name'])) {
                    $this->userName = $data['full_name'];
                }
                $stmt->close();
            } elseif (strcasecmp($role, 'Admin') === 0) {
                // Try admin_table
                $stmt = $conn->prepare($admin_query);
                if (!$stmt) {
                    throw new Exception("Prepare failed (admin): " . $conn->error);
                }

                $stmt->bind_param("s", $user_id);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed (admin): " . $stmt->error);
                }

                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                if ($data && isset($data['full_name'])) {
                    $this->userName = $data['full_name'];
                }
                $stmt->close();
            } else {
                // No valid role, try all tables
                // Try patient_table
                $stmt = $conn->prepare($patient_query);
                if (!$stmt) {
                    throw new Exception("Prepare failed (patient): " . $conn->error);
                }

                $stmt->bind_param("s", $user_id);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed (patient): " . $stmt->error);
                }

                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                if ($data && isset($data['full_name'])) {
                    $this->userName = $data['full_name'];
                    $stmt->close();
                } else {
                    $stmt->close();
                    // Try staff_table
                    $stmt = $conn->prepare($staff_query);
                    if (!$stmt) {
                        throw new Exception("Prepare failed (staff): " . $conn->error);
                    }

                    $stmt->bind_param("s", $user_id);
                    if (!$stmt->execute()) {
                        throw new Exception("Execute failed (staff): " . $stmt->error);
                    }

                    $result = $stmt->get_result();
                    $data = $result->fetch_assoc();
                    if ($data && isset($data['full_name'])) {
                        $this->userName = $data['full_name'];
                        $stmt->close();
                    } else {
                        $stmt->close();
                        // Try admin_table
                        $stmt = $conn->prepare($admin_query);
                        if (!$stmt) {
                            throw new Exception("Prepare failed (admin): " . $conn->error);
                        }

                        $stmt->bind_param("s", $user_id);
                        if (!$stmt->execute()) {
                            throw new Exception("Execute failed (admin): " . $stmt->error);
                        }

                        $result = $stmt->get_result();
                        $data = $result->fetch_assoc();
                        if ($data && isset($data['full_name'])) {
                            $this->userName = $data['full_name'];
                        }
                        $stmt->close();
                    }
                }
            }

            // Debug output
            error_log("Fetched user name for user_id $user_id (role: " . ($role ?? 'unknown') . "): " . $this->userName);

        } catch (Exception $e) {
            error_log("User profile fetch error: " . $e->getMessage());
            $this->userName = 'Unknown User';
        } finally {
            if (isset($conn) && $conn) {
                $conn->close();
            }
        }
    }

    public function getUserName() {
        return htmlspecialchars($this->userName);
    }
}
?>