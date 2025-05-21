<?php
require_once("../settings/db_class.php");

class userName_class extends db_connection {
    private $userName;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../view/login.php');
            exit;
        }

        $this->fetchUserName($_SESSION['user_id']);
    }

    private function fetchUserName($user_id) {
        $patient_query = "SELECT CONCAT(first_name, ' ', last_name) AS full_name 
                         FROM patient_table 
                         WHERE patient_id = ?";

        $staff_query = "SELECT CONCAT(first_name, ' ', last_name) AS full_name 
                        FROM staff_table 
                        WHERE staff_id = ?";

        $admin_query = "SELECT CONCAT(first_name, ' ', last_name) AS full_name 
                        FROM admin 
                        WHERE admin_id = ?";

        $role_query = "SELECT role FROM user_table WHERE user_id = ?";

        try {
            $conn = $this->db_conn();
            if (!$conn) {
                throw new Exception("Database connection failed");
            }

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

            $this->userName = 'Unknown User';

            if (strcasecmp($role, 'Patient') === 0) {
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