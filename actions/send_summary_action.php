<?php
require_once('../settings/core.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../controllers/request_controller.php');

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
    if (empty($doctor_id)) {
        error_log("Session error: user_id not found in session.");
        $response["message"] = "Doctor not authenticated. Please log in again.";
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    $request_id = isset($_POST['request_id']) ? sanitize_input($_POST['request_id']) : '';
    $patient_id = isset($_POST['patient_id']) ? sanitize_input($_POST['patient_id']) : '';
    $file_url = isset($_POST['file_url']) ? filter_var($_POST['file_url'], FILTER_SANITIZE_URL) : '';

    if (empty($request_id) || empty($patient_id) || empty($file_url)) {
        error_log("Missing required fields: request_id=$request_id, patient_id=$patient_id, file_url=$file_url");
        $response["message"] = "Missing required fields.";
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if (!filter_var($file_url, FILTER_VALIDATE_URL)) {
        error_log("Invalid file URL: $file_url");
        $response["message"] = "Invalid file URL.";
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    $api_data = [
        'doctor_id' => $doctor_id,
        'patient_id' => $patient_id,
        'file_url' => $file_url
    ];

    error_log("Sending data to medical summaries API: " . json_encode($api_data));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://165.22.117.96/actions/medical_summaries.php');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($api_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_STDERR, $verbose = fopen('php://temp', 'w+'));
    $api_response = curl_exec($ch);
    $api_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    rewind($verbose);
    $verbose_log = stream_get_contents($verbose);
    error_log("cURL verbose output: " . $verbose_log);

    if ($curl_error) {
        error_log("cURL error: " . $curl_error);
        $response["message"] = "Error: cURL failed to communicate with the summary API: $curl_error";
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    error_log("Medical summaries API response: HTTP $api_http_code, Response: " . ($api_response ?: 'Empty response'));

    if ($api_http_code === 200 && $api_response) {
        $api_result = json_decode($api_response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON decode error: " . json_last_error_msg());
            $response["message"] = "Error: Invalid response from summary API.";
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        if (isset($api_result['success']) && $api_result['success']) {
            $result = update_request_status_ctr($request_id, 'Completed');
            if ($result) {
                $response["success"] = true;
                $response["message"] = "Summary uploaded and request marked as completed.";
            } else {
                error_log("Failed to update request status for request_id: $request_id");
                $response["message"] = "Error: Unable to update request status.";
            }
        } else {
            $message = $api_result['message'] ?? 'Unknown error';
            error_log("API error: $message");
            $response["message"] = "Error: Unable to save summary data: $message";
        }
    } else {
        error_log("API request failed with HTTP code: $api_http_code, response: " . ($api_response ?: 'Empty response'));
        $response["message"] = "Error: Unable to communicate with the summary API. HTTP code: $api_http_code";
    }
} else {
    error_log("Invalid request method: " . $_SERVER["REQUEST_METHOD"]);
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>