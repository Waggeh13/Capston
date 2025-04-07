<?php
include("../controllers/lab_form_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $doctor_fullname = sanitize_input($_POST['product-title']);
        $patient_fullname = sanitize_input($_POST['productprice']);
        $lab_test = sanitize_input($_POST['labtest']);
        $susdiag = sanitize_input($_POST['diag']);
        $signature = sanitize_input($_POST['sign']);
        $ext = sanitize_input($_POST['ext']);
        $request_date = sanitize_input($_POST['date']);

        $result = addrequestcontroller($doctor_fullname, $patient_fullname, $lab_test, $susdiag, $signature, $ext, $request_date);

        if ($result) {
            $response["success"] = true;
            $response["message"] = "Lab requested successfully.";
        } else {
            $response["success"] = false;
            $response["message"] = "Error: Unable to request for lab. Please try again.";
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