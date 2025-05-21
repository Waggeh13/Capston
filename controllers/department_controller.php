<?php
require("../classes/department_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

function adddepartmentController($department_id, $departmentName) {
    $department= new department_class();
    return $department->adddepartment($department_id, $departmentName);
}

function deletedepartmentController($id) {
    $department = new department_class();
    return $department->deletedepartment($id);
}

function viewdepartmentsController() {
    $departments = new department_class();
    return $departments->getdepartments();
}


function viewdepartmentsByIDController($department_id) {
    $department = new department_class();
    return $department->getdepartmentsbyID($department_id);
}

function department_exists_ctr($department_id) {
    $department = new department_class();
    return $department->department_ID_exists($department_id);
}

function updatedepartmentController($department_id, $departmentName) {
    $department= new department_class();
    return $department->updatedepartment($department_id, $departmentName);
}

?>
