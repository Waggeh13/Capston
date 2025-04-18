<?php
// Start session
session_start(); 

// For header redirection
ob_start();

/**
 * Generic function to redirect if user is not logged in or lacks the specified role
 * @param string $required_role The role required for access (e.g., 'Doctor', 'Admin')
 */
function redirect_if_not_role($required_role)
{
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    $user_role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : null;
    
    // Check if user_id is valid (positive integer) and role matches (case-insensitive)
    if (!$user_id || !$user_role || strcasecmp($user_role, $required_role) !== 0) {
        header("Location: ../view/login.php");
        exit();
    }
}

/**
 * Redirect if not logged in as Doctor
 */
function redirect_doctor_if_not_logged_in()
{
    redirect_if_not_role('Doctor');
}

/**
 * Redirect if not logged in as Admin
 */
function redirect_admin_if_not_logged_in()
{
    redirect_if_not_role('Admin');
}

/**
 * Redirect if not logged in as SuperAdmin
 */
function redirect_superadmin_if_not_logged_in()
{
    redirect_if_not_role('SuperAdmin');
}

/**
 * Redirect if not logged in as Lab Technician
 */
function redirect_lab_technician_if_not_logged_in()
{
    redirect_if_not_role('Lab Technician');
}

/**
 * Redirect if not logged in as Pharmacist
 */
function redirect_pharmacist_if_not_logged_in()
{
    redirect_if_not_role('Pharmacist');
}

/**
 * Redirect if not logged in as Cashier
 */
function redirect_cashier_if_not_logged_in()
{
    redirect_if_not_role('Cashier');
}

/**
 * Redirect if not logged in as Patient
 */
function redirect_patient_if_not_logged_in()
{
    redirect_if_not_role('Patient');
}


function redirect_if_logged_in() {
    if (isset($_SESSION['user_id'])) {
        if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] == "SuperAdmin") {
                header("Location: super_admin_dashboard.php");
                exit();
            } else if ($_SESSION['user_role'] == "Admin") {
                header("Location: admin_dashboard.php");
                exit();
            }else if ($_SESSION['user_role']=="Doctor")
            {
                header("Location: doctor_dashboard.php");
                exit();
            }
            else if ($_SESSION['user_role']=="Lab Technician")
            {
                header("Location: lab_technician.php");
                exit();
            }
            else if ($_SESSION['user_role']=="Pharmacist")
            {
                header("Location: pharmacist.php");
                exit();
            }
            else if ($_SESSION['user_role']=="Cashier")
            {
                header("Location: cashier.php");
                exit();
            }
            else if ($_SESSION['user_role']=="Patient")
            {
                header("Location: patient_dashboard.php");
                exit();
            }
        }
    }
}


?>
