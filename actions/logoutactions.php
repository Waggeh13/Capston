<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();


// Redirect the user to the home page or login page
header("Location: ../login.php");
exit();
?>
