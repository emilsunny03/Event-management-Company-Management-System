<?php
// logout.php
session_start();
// Destroy all session data
session_unset();
session_destroy();

// Redirect the user to the homepage or login page after logout
header("Location: login.php");
exit();  // Stop further script execution
?>
