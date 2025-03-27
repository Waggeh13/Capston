<?php
// Start session
session_start(); 

// For header redirection
ob_start();

// Function to check for active session and redirect based on role
function redirect_if_logged_in() {
    if (isset($_SESSION['pid'])) {
        if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] == 1) {
                header("Location: ./view/viewproduct.php");
                exit();
            } else if ($_SESSION['user_role'] == 2) {
                header("Location: ./view/userDash.php"); // User dashboard
                exit();
            } else if ($_SESSION['user_role'] == 3) {
                header("Location: ./view/admindashboard.php"); // Admin dashboard
                exit();
            }
    
        }
    }
}

function redirect_when_logged_in() {
    if (isset($_SESSION['pid'])) {
        if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] == 1) {
                header("Location: viewproduct.php");
                exit();
            } else if ($_SESSION['user_role'] == 2) {
                header("Location: userDash.php"); // User dashboard
                exit();
            }else if ($_SESSION['user_role']==3)
            {
                header("Location: admindashboard.php"); // Admin dashboard
                exit();
            }
        }
    }
}

// Function to check for login
function check_login() {
    if (!isset($_SESSION['pid'])) {
        header("Location: ../view/customerlogin.php");
        exit();
    }
}

// Function to get user ID
function get_user_id() {
    return isset($_SESSION['pid']) ? $_SESSION['pid'] : false;
}

// Function to check for role (admin, customer, etc.)
function check_user_role() {
    if (isset($_SESSION['user_role'])) {
        return $_SESSION['user_role'] == 1 ? "admin" : "customer";
    } else {
        return false;
    }
}
?>
