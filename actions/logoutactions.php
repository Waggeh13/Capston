<?php
session_start();

if (isset($_SESSION['chat_history'])) {
    unset($_SESSION['chat_history']);
}
$_SESSION = array();
session_destroy();
session_regenerate_id(true);

header("Location: ../view/login.php");
exit();
?>