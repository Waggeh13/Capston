<?php
include("../classes/login_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

function login_user($user_id, $password)
{
    $customerlogin = new customerlogin_class();
    $default_password = "Bafrrow@2025";

    $user = $customerlogin->get_user_by_id($user_id);
    if ($user === null) {
        return ['error' => true, 'message' => 'User not registered or incorrect userID.'];
    }

    if ($customerlogin->verify_password($password, $user['password'])) {
        $is_default_password = password_verify($default_password, $user['password']);
        
        if (!$is_default_password) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['role'];
        }

        return [
            'error' => false,
            'user_role' => $user['role'],
            'user_id' => $user['user_id'],
            'is_default_password' => $is_default_password
        ];
    } else {
        return ['error' => true, 'message' => 'Incorrect userID or password.'];
    }
}
?>