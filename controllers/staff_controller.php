<?php
require("../classes/staff_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

function addstaffController($staff_id, $first_name, $last_name, $gender,$position, $department, $contact, $email) {
    $staff= new staff_class();
    return $staff->addstaff($staff_id, $first_name, $last_name, $gender,$position, $department, $contact, $email);
}

function deletestaffController($id) {
    $staff = new staff_class();
    return $staff->deletestaff($id);
}

function viewstaffsController() {
    $staffs = new staff_class();
    return $staffs->getstaffs();
}


function viewstaffsByIDController($staff_id) {
    $staff = new staff_class();
    return $staff->getstaffsbyID($staff_id);
}

function staff_exists_ctr($staff_id) {
    $staff = new staff_class();
    return $staff->staff_ID_exists($staff_id);
}
function addUserController($staffId, $password, $userRole)
    {
        $staff = new staff_class();
        return $staff->addUser($staffId, $password, $userRole);
    }

function updatestaffController($staff_id, $first_name, $last_name, $gender, $position, $department_id, $contact,$email) {
    $staff= new staff_class();
    return $staff->updatestaff($staff_id, $first_name, $last_name, $gender, $position, $department_id, $contact,$email);
}

function update_id($original_staff_id, $staffId)
{
    $staff = new staff_class();
    return $staff-> update_ID($original_staff_id, $staffId);
}
?>
