<?php

// Redirects to login if user is not authenticated

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'auth.php';

// Check if session expired
if (isSessionExpired()) {
    header('Location: includes/login.php?session=expired');
    exit;
}

// Check if user is logged in
if (!isUserLoggedIn()) {
    header('Location: includes/login.php');
    exit;
}

$current_user = getCurrentUser();

?>
