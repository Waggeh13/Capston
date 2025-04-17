<?php
require("../classes/password_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to handle password change
function password_controller($user_id, $c_pass, $n_pass) {
    $password = new password_class();
    return $password->password_form($user_id, $c_pass, $n_pass);
}