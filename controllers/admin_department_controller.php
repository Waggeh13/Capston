<?php
require("../classes/admin_department_class.php");

// Function to add new department
function adddepartmentController($department_id, $departmentName) {
    $department= new admin_department_class();
    return $department->adddepartment($department_id, $departmentName);
}

// Function to delete product
function deletedepartmentController($id) {
    $department = new admin_department_class();
    return $department->deletedepartment($id);
}

// Function to view all products
function viewdepartmentsController() {
    $departments = new admin_department_class();
    return $departments->getdepartments();
}


// Function to view departments by ID
function viewdepartmentsByIDController($department_id) {
    $department = new admin_department_class();
    return $department->getdepartmentsbyID($department_id);
}

function department_exists_ctr($department_id) {
    $department = new admin_department_class();
    return $department->department_ID_exists($department_id);
}

function updatedepartmentController($department_id, $departmentName) {
    $department= new admin_department_class();
    return $department->updatedepartment($department_id, $departmentName);
}

?>
