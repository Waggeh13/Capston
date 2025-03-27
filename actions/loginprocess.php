<?php
session_start();

// Include the controller for user login processing
include("../controllers/login_controller.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input values
    $email = $_POST['customer_email'];
    $password = $_POST['customer_pass'];

    // Validate email and password (basic checks to prevent empty fields)
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please enter both email and password.';
        header("Location: ../view/login.php");
        exit();
    }

    // Call the login function from the controller
    $login = select_user_ctr($email, $password); 

    if ($login !== false) {
        // Check if the necessary fields are returned by the login function
        if (isset($login['user_role']) && isset($login['customer_id'])) {
            
            // Set the session variables based on the login response
            $_SESSION['customer_id'] = $login['customer_id'];
            $_SESSION['user_role'] = $login['user_role']; 
            $_SESSION['customer_name'] = $login['customer_name']; // Assuming the 'customer_name' is returned from the database
            $_SESSION['customer_email'] = $login['customer_email']; // Assuming 'customer_email' is also part of the returned data

            // Redirect based on user role
            if ($_SESSION['user_role'] == 1) {
                header("Location: ../view/adminDashboard.php");
                exit();
            } elseif ($_SESSION['user_role'] == 2) {
                header("Location: ../view/home.php"); 
                exit();
            } else {
                // Invalid user role
                $_SESSION['error'] = 'Invalid role assigned.';
                header("Location: ../view/login.php");
                exit();
            }
        } else {
            // User role or ID is missing from the login data
            $_SESSION['error'] = 'User role or ID not found.';
            header("Location: ../view/login.php"); 
            exit();
        }
    } else {
        // Invalid credentials (email or password)
        $_SESSION['error'] = 'Invalid email, password, or role.';
        header("Location: ../view/login.php"); 
        exit();
    }
}
?>
