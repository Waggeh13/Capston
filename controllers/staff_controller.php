<?php
require("../classes/staff_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new staff
function addstaffController($staff_id, $first_name, $last_name, $gender,$position, $department, $contact, $email) {
    $staff= new staff_class();
    return $staff->addstaff($staff_id, $first_name, $last_name, $gender,$position, $department, $contact, $email);
}

// Function to delete staff
function deletestaffController($id) {
    $staff = new staff_class();
    return $staff->deletestaff($id);
}

// Function to view all staffs
function viewstaffsController() {
    $staffs = new staff_class();
    return $staffs->getstaffs();
}


// Function to view staffs by ID
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

?>
