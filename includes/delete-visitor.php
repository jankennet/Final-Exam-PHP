<?php
include 'visitors.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $result = deleteVisitor((int)$_GET['id']);
    
    if ($result['success']) {
        header('Location: ../visitors.php');
        exit;
    } else {
        die('Error deleting visitor: ' . ($result['error'] ?? 'Unknown error'));
    }
} else {
    header('Location: ../visitors.php');
    exit;
}
?>
