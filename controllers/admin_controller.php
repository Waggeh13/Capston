<?php
require("../classes/admin_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

function addadminController($admin_id, $first_name, $last_name, $contact, $position) {
    $admin = new admin_class();
    return $admin->addadmin($admin_id, $first_name, $last_name, $contact, $position);
}

function deleteadminController($id) {
    $admin = new admin_class();
    return $admin->deleteadmin($id);
}

function viewadminsController() {
    $admins = new admin_class();
    return $admins->getadmins();
}

function viewadminsByIDController($admin_id) {
    $admin = new admin_class();
    return $admin->getadminsbyID($admin_id);
}

function admin_exists_ctr($admin_id) {
    $admin = new admin_class();
    return $admin->admin_ID_exists($admin_id);
}

function addUserController($adminId, $password, $userRole) {
    $admin = new admin_class();
    return $admin->addUser($adminId, $password, $userRole);
}

function updateadminController($original_admin_id, $new_admin_id, $first_name, $last_name, $contact) {
    $admin = new admin_class();
    if ($original_admin_id === $new_admin_id) {
        return $admin->updateadmin($new_admin_id, $first_name, $last_name, $contact);
    } else {
        return $admin->updateAdminWithId($original_admin_id, $new_admin_id, $first_name, $last_name, $contact);
    }
}
?>