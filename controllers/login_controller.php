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

        // Determine the success message based on the user's role
        switch ($user['role']) {
            case 1:
                $role_message = "Super Admin login successful.";
                break;
            case 2:
                $role_message = "Admin login successful.";
                break;
            case 3:
                $role_message = "Doctor login successful.";
                break;
            case 4:
                $role_message = "Lab Tech Login successful";
                break;
            case 5:
                $role_message = "Pharmacist login successful";
                break;
            case 6:
                $role_message = "Cashier login successful";
                break;
            default:
                $role_message = "Patient login successful";
                break;
        }

        return [
            'error' => false,
            'user_role' => $user['role'],
            'user_id' => $user['user_id'],
            'message' => $role_message
        ];
    } else {
        return ['error' => true, 'message' => 'Incorrect userID or password.'];
    }
}
?>