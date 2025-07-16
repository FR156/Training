<?php
require_once 'config.php';
require_once 'db.php';
require_once 'session.php';

// VULNERABLE: No password strength requirements
function registerUser($username, $password) {
    global $conn;
    
    // VULNERABILITY: Weak password hashing (md5 is insecure)
    $hashedPassword = md5($password);
    
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
    return $conn->query($sql);
}

// VULNERABLE: SQL injection possible
function authenticateUser($username, $password) {
    global $conn;
    
    // VULNERABILITY: SQL injection and weak password hashing
    $hashedPassword = md5($password);
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        loginUser($user['id'], $user['username'], $user['is_admin']);
        return true;
    }
    return false;
}
?>