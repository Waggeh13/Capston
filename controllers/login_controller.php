<?php
include("../classes/login_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to log the user in
function login_user($user_id, $password)
{
    $customerlogin = new customerlogin_class();

    // Get user details by email
    $user = $customerlogin->get_user_by_id($user_id);
    if ($user === null) {
        return ['error' => true, 'message' => 'User not registered or incorrect userID.'];
    }

    // Verify the password
    if ($customerlogin->verify_password($password, $user['hashedPassword'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_role'] = $user['user_role'];

        // Determine the success message based on the user's role
        switch ($user['user_role']) {
            case 1:
                $role_message = "Vendor login successful.";
                break;
            case 2:
                $role_message = "Customer login successful.";
                break;
            case 3:
                $role_message = "Admin login successful.";
                break;
            default:
                $role_message = "Unknown role login successful.";
                break;
        }

        return [
            'error' => false,
            'user_role' => $user['user_role'],
            'user_id' => $user['user_pid'],
            'message' => $role_message
        ];
    } else {
        return ['error' => true, 'message' => 'Incorrect userID or password.'];
    }
}
?>
