<?php
session_start();

// Clear conversation history
if (isset($_SESSION['chat_history'])) {
    unset($_SESSION['chat_history']);
}
$_SESSION = array(); // Clear session variables
session_destroy();
session_regenerate_id(true); // Prevent session fixation attacks

header("Location: ../view/login.php");
exit();
?>