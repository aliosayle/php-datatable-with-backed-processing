<?php
// Set the session name to match the login session
session_name("bon_session");

// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: auth-login.php");
exit;
?>
