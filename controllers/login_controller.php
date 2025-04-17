<?php
include("../classes/login_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to log the user in
function login_user($user_id, $password)
{
    $customerlogin = new customerlogin_class();

    // Get user details by id
    $user = $customerlogin->get_user_by_id($user_id);
    if ($user === null) {
        return ['error' => true, 'message' => 'User not registered or incorrect userID.'];
    }

    // Verify the password
    if ($customerlogin->verify_password($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_role'] = $user['role'];

        return [
            'error' => false,
            'user_role' => $user['role'],
            'user_id' => $user['user_id']
        ];
    } else {
        return ['error' => true, 'message' => 'Incorrect userID or password.'];
    }
}
?>