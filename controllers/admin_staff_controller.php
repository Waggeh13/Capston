<?php
require("../classes/admin_staff__class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new staff
function addstaffController($product_title, $brand, $category, $price, $description, $image, $keywords) {
    $staff= new admin_staff_class();
    return $staff->addstaff($product_title, $brand, $category, $price, $description, $image, $keywords);
}

// Function to delete product
function deletestaffController($id) {
    $staff = new admin_staff_class();
    return $staff->deletestaff($id);
}

// Function to view all products
function viewstaffsController() {
    $staffs = new admin_staff_class();
    return $staffs->getstaffs();
}


// Function to view staffs by ID
function viewstaffsByIDController($staff_id) {
    $staff = new admin_staff_class();
    return $staff->getstaffsbyID($staff_id);
}
?>
