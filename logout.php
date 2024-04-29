<?php

session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the login page after logging out
header("Location: login.php");
exit();
?>
