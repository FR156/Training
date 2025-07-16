<?php
require_once 'config.php';

// Vulnerable file upload function
function uploadFile($file) {
    $targetFile = UPLOAD_DIR . basename($file["name"]);
    
    // VULNERABILITY: No proper validation of file type, content, or size
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return basename($file["name"]);
    }
    return false;
}

// Helper function to get file extension
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

// Check if admin (simulated for demo)
function isAdmin() {
    require_once 'session.php';
    return \isAdmin();
}
?>