<?php
// Authentication Functions

include_once 'connect.php';


// Authenticate user with username and password

function authenticateUser($username, $password) {
    $query = "SELECT user_id, username, password, full_name FROM users WHERE username = ?";
    $cn = ConnectDB();
    $stmt = $cn->prepare($query);
    
    if (!$stmt) {
        return ['success' => false, 'error' => 'Database error'];
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return ['success' => false, 'error' => 'Invalid username or password'];
    }
    
    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        return [
            'success' => true,
            'user_id' => $user['user_id'],
            'username' => $user['username'],
            'full_name' => $user['full_name']
        ];
    } else {
        return ['success' => false, 'error' => 'Invalid username or password'];
    }
}


// Start user session
function startUserSession($user_id, $username, $full_name) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['full_name'] = $full_name;
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();
}


function isUserLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}


function getCurrentUser() {
    if (isUserLoggedIn()) {
        return [
            'user_id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'full_name' => $_SESSION['full_name']
        ];
    }
    return null;
}


function logoutUser() {
    session_destroy();
}


function isSessionExpired($timeout = 3600) {
    if (!isUserLoggedIn()) {
        return true;
    }
    
    if (time() - $_SESSION['login_time'] > $timeout) {
        logoutUser();
        return true;
    }
    
    // Update login time to extend session
    $_SESSION['login_time'] = time();
    return false;
}

?>
