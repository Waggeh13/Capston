<?php
session_start();
$_SESSION = array(); // Clear session variables
session_destroy();
session_regenerate_id(true); // Prevent session fixation attacks

header("Location: ../view/login.php");
exit();
?>