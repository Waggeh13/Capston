<?php
session_start();
include("../controllers/login_controller.php");

$response = ['error' => false, 'message' => '', 'User_role' => '', 'user_id' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $user_id = sanitize_input($_POST['user_id']);
    $password = sanitize_input($_POST['password']);

    $response = login_user($user_id, $password);
} else {
    $response['error'] = true;
    $response['message'] = "Wrong request method. Please try again.";
}

echo json_encode($response);
?>
