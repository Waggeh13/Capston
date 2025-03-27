<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();


echo "
<script>
    sessionStorage.removeItem('cid');
</script>
";

// Redirect the user to the home page or login page
header("Location: ../index.php");
exit();
?>
