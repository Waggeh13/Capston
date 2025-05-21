<?php
session_start(); 

ob_start();

/**
 * Generic function to redirect if user is not logged in or lacks the specified role
 * @param string $required_role The role required for access (e.g., 'Doctor', 'Admin')
 */
function redirect_if_not_role($required_role)
{
    // Check if session variables exist
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
        header("Location: ../view/login.php");
        exit();
    }
    
    // Check if role matches (case-insensitive)
    if (strcasecmp(trim($_SESSION['user_role']), $required_role) !== 0) {
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
            // Only redirect if we're not already on the correct page
            $current_page = basename($_SERVER['PHP_SELF']);
            $target_page = '';
            
            switch ($_SESSION['user_role']) {
                case "SuperAdmin":
                    $target_page = 'super_admin_dashboard.php';
                    break;
                case "Admin":
                    $target_page = 'admin_dashboard.php';
                    break;
                case "Doctor":
                    $target_page = 'doctor_dashboard.php';
                    break;
                case "Lab Technician":
                    $target_page = 'lab_technician.php';
                    break;
                case "Pharmacist":
                    $target_page = 'pharmacist.php';
                    break;
                case "Cashier":
                    $target_page = 'cashier.php';
                    break;
                case "Patient":
                    $target_page = 'patient_dashboard.php';
                    break;
            }
            
            if ($target_page && $current_page !== $target_page) {
                header("Location: $target_page");
                exit();
            }
        }
    }
}

function redirect_if_not_logged_in()
{
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        header("Location: ../view/login.php");
        exit();
    }

}

?>