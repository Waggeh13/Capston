<?php
session_start();
include("../controllers/prescription_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("Doctor not authenticated. Please log in.");
        }
        $staff_id = $_SESSION['user_id'];
        
        $patient_fullname = sanitize_input($_POST['pFullName']);
        $medication_date = sanitize_input($_POST['date']);
        $medicines = $_POST['medicines'] ?? [];
        $dosages = $_POST['dosages'] ?? [];
        $instructions = $_POST['instructions'] ?? [];

        if (count($medicines) !== count($dosages) || count($dosages) !== count($instructions)) {
            throw new Exception("Mismatch in medication, dosage, or instructions count.");
        }

        if (empty($medicines)) {
            throw new Exception("At least one medication is required.");
        }

        $result = prescription_controller($staff_id, $patient_fullname, $medication_date, $medicines, $dosages, $instructions);

        if ($result) {
            $response["success"] = true;
            $response["message"] = "Prescription submitted successfully.";
        } else {
            $response["success"] = false;
            $response["message"] = "Error: Unable to submit prescription. Please try again.";
        }
    } catch (Exception $e) {
        $response["success"] = false;
        $response["message"] = $e->getMessage();
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>