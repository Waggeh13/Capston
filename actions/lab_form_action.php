<?php
include("../controllers/lab_form_controller.php");

header('Content-Type: application/json');
$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $firstName = sanitize_input($_POST['firstName']);
        $lastName = sanitize_input($_POST['lastName']);
        $diagnosis = sanitize_input($_POST['diagnosis']);
        $labCode = sanitize_input($_POST['labCode'] ?? '');
        $dFullName = sanitize_input($_POST['dFullName']);
        $signature = sanitize_input($_POST['signature']);
        $extension = sanitize_input($_POST['extension'] ?? '');
        $requestDate = sanitize_input($_POST['requestDate']);
        $testRequests = array_unique($_POST['testRequest'] ?? []); // Deduplicate test requests

        if (empty($testRequests)) {
            throw new Exception("Please select at least one test.");
        }

        // Process the lab request
        $result = addrequestcontroller(
            $dFullName,
            $firstName . ' ' . $lastName,
            $testRequests,
            $diagnosis,
            $signature,
            $extension,
            $requestDate
        );

        if ($result) {
            $response["success"] = true;
            $response["message"] = "Lab requested successfully.";
        } else {
            $response["message"] = "Error: Unable to request lab tests. Please try again.";
        }
    } catch (Exception $e) {
        $response["message"] = $e->getMessage();
    }
} else {
    $response["message"] = "Invalid request method.";
}

echo json_encode($response);
exit();
?>