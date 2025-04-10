<?php
require("../classes/admin_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new admin
function addadminController($admin_id, $first_name, $last_name, $contact) {
    $admin= new admin_class();
    return $admin->addadmin($admin_id, $first_name, $last_name,  $contact);
}

// Function to delete product
function deleteadminController($id) {
    $admin = new admin_class();
    return $admin->deleteadmin($id);
}

// Function to view all products
function viewadminsController() {
    $admins = new admin_class();
    return $admins->getadmins();
}


// Function to view admins by ID
function viewadminsByIDController($admin_id) {
    $admin = new admin_class();
    return $admin->getadminsbyID($admin_id);
}

function admin_exists_ctr($admin_id) {
    $admin = new admin_class();
    return $admin->admin_ID_exists($admin_id);
}
function addUserController($adminId, $password, $userRole)
    {
        $admin = new admin_class();
        return $admin->addUser($adminId, $password, $userRole);
    }

function updateadminController($admin_id, $first_name, $last_name, $gender, $position, $department_id, $contact,$email) {
    $admin= new admin_class();
    return $admin->updateadmin($admin_id, $first_name, $last_name, $gender, $position, $department_id, $contact,$email);
}

?>
