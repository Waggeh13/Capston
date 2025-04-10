<?php
include("../controllers/doc_schedule_controller.php");

session_start();

// Set header for JSON response
header('Content-Type: application/json');

$response = array("success" => false, "message" => "");

try {
    $staff_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    if (!$staff_id) {
        throw new Exception("User not authenticated.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        
        if ($action === 'save') {
            // Handle save action
            $appointment_date = isset($_POST['date']) ? sanitize_input($_POST['date']) : null;
            $time_slots = isset($_POST['times']) ? json_decode($_POST['times'], true) : [];
            
            if (!$appointment_date) {
                throw new Exception("Invalid date selected.");
            }
            
            if (empty($time_slots)) {
                throw new Exception("No time slots selected.");
            }
            
            $result = add_doctor_schedule_ctr($staff_id, $appointment_date, $time_slots);
            
            if ($result) {
                $response["success"] = true;
                $response["message"] = "Schedule saved successfully.";
            } else {
                throw new Exception("Failed to save schedule.");
            }
        } else {
            throw new Exception("Invalid action.");
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === 'get') {
        // Handle get action
        $date = isset($_GET['date']) ? sanitize_input($_GET['date']) : null;
        
        if (!$date) {
            throw new Exception("No date specified.");
        }
        
        $schedule = get_doctor_schedule_for_date_ctr($staff_id, $date);
        
        $response["success"] = true;
        $response["schedule"] = $schedule;
    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
exit();

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}
?>