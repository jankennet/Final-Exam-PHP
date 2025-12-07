<?php
session_start();
include 'auth.php';

// Logout user
logoutUser();

// Redirect to login page
header('Location: login.php?logged_out=true');
exit;
?>
