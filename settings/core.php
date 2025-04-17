<?php
// Start session
session_start(); 

// For header redirection
ob_start();

function redirect_if_not_logged_in()
{
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        header("Location: ../view/login.php");
        exit();
    }

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
