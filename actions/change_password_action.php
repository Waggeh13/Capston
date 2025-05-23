<?php
session_start();
include("../controllers/password_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        if (!isset($_SESSION['user_id'])) {
            throw new Exception("User not authenticated. Please log in.");
        }
        $user_id = $_SESSION['user_id'];

        $c_pass = sanitize_input($_POST['currentPassword']);
        $n_pass = sanitize_input($_POST['newPassword']);


        $result = password_controller($user_id, $c_pass, $n_pass);

        if ($result['success']) {
            $response["success"] = true;
            $response["message"] = $result['message'];
        } else {
            $response["success"] = false;
            $response["message"] = $result['message'];

            if ($result['message'] === 'incorrect_current_password') {
                $response["error"] = 'incorrect_current_password';
            }
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