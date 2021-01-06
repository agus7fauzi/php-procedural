<?php

// When we use session we must starting first on first line
session_start();

// Set $_SESSION to empety
$_SESSION = [];

// Unset $_SESSION
session_unset();

// Destroy $_SESSION
session_destroy();

// Remove Cookie
setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);

// Redirect to Login Page
header("Location: login.php");
exit;

?>
