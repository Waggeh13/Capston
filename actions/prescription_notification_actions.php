<?php
ob_start();
include("../controllers/prescription_notification_controller.php");

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/php_errors.log');

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? sanitize_input($_POST['action']) : '';

    if ($action === 'save_preference') {
        $medication_id = sanitize_input($_POST['medication_id'] ?? '');
        $patient_id = sanitize_input($_POST['patient_id'] ?? '');
        $enabled = sanitize_input($_POST['enabled'] ?? '');

        if (empty($medication_id) || empty($patient_id) || empty($enabled)) {
            $response["message"] = "Missing required parameters for preference.";
        } elseif (save_notification_preference_ctr($medication_id, $patient_id, $enabled)) {
            $response["success"] = true;
            $response["message"] = "Notification preference saved.";
        } else {
            $response["message"] = "Failed to save notification preference.";
        }
    } elseif ($action === 'save_times') {
        $medication_id = sanitize_input($_POST['medication_id'] ?? '');
        $patient_id = sanitize_input($_POST['patient_id'] ?? '');
        $data = isset($_POST['data']) ? json_decode($_POST['data'], true) : null;

        if (empty($medication_id) || empty($patient_id) || !$data) {
            $response["message"] = "Missing or invalid parameters: medication_id=$medication_id, patient_id=$patient_id, data=" . json_encode($data);
        } elseif (!isset($data['type']) || !in_array($data['type'], ['times', 'interval'])) {
            $response["message"] = "Invalid notification type: " . ($data['type'] ?? 'none');
        } else {
            $success = true;
            $errors = [];
            $client_timezone = isset($data['timezone']) && in_array($data['timezone'], timezone_identifiers_list()) ? $data['timezone'] : 'UTC';
            if ($data['type'] === 'times') {
                if (!isset($data['times']) || !is_array($data['times']) || empty($data['times'])) {
                    $response["message"] = "No times provided.";
                    ob_end_clean();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit();
                }
                foreach ($data['times'] as $time) {
                    $time = sanitize_input($time);
                    if (preg_match('/^\d{2}:\d{2}$/', $time)) {
                        $time .= ':00';
                    }
                    if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
                        $errors[] = "Invalid time format: $time";
                        $success = false;
                        continue;
                    }
                    $parts = explode(':', $time);
                    $hours = (int)$parts[0];
                    $minutes = (int)$parts[1];
                    $seconds = (int)$parts[2];
                    if ($hours > 23 || $minutes > 59 || $seconds > 59) {
                        $errors[] = "Invalid time value: $time";
                        $success = false;
                        continue;
                    }
                    $result = save_notification_time_ctr($medication_id, $patient_id, $time, null, $client_timezone);
                    if (!$result) {
                        $errors[] = "Failed to save time: $time (check server logs)";
                        $success = false;
                    }
                }
            } else {
                $interval = isset($data['interval_hours']) ? (int)sanitize_input($data['interval_hours']) : 0;
                if ($interval < 1 || $interval > 24) {
                    $errors[] = "Invalid interval: $interval hours";
                    $success = false;
                } elseif (!save_notification_time_ctr($medication_id, $patient_id, '00:00:00', $interval, $client_timezone)) {
                    $errors[] = "Failed to save interval: $interval hours (check server logs)";
                    $success = false;
                }
            }
            if ($success) {
                $response["success"] = true;
                $response["message"] = "Notification settings saved.";
            } else {
                $response["message"] = "Failed to save some settings: " . implode('; ', $errors);
            }
        }
    } elseif ($action === 'delete_time') {
        $notification_id = sanitize_input($_POST['notification_id'] ?? '');

        if (empty($notification_id)) {
            $response["message"] = "Missing notification ID.";
        } elseif (delete_notification_time_ctr($notification_id)) {
            $response["success"] = true;
            $response["message"] = "Notification time deleted.";
        } else {
            $response["message"] = "Failed to delete notification time.";
        }
    } elseif ($action === 'get_settings') {
        $medication_id = sanitize_input($_POST['medication_id'] ?? '');
        $patient_id = sanitize_input($_POST['patient_id'] ?? '');

        if (empty($medication_id) || empty($patient_id)) {
            $response["message"] = "Missing required parameters.";
        } else {
            $settings = get_notification_settings_ctr($medication_id, $patient_id);
            if ($settings !== false) {
                $response["success"] = true;
                $response["settings"] = $settings;
            } else {
                $response["message"] = "Failed to retrieve notification settings.";
            }
        }
    } else {
        $response["message"] = "Invalid action.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

ob_end_clean();
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>