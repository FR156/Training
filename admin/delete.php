<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';
requireAdmin(); // This will redirect non-admins

// Simulated admin check - VULNERABILITY: No real authentication
if (!isAdmin()) {
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get filename before deleting
    $result = $conn->query("SELECT filename FROM uploads WHERE id = $id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filename = $row['filename'];
        
        // Delete from database
        deleteUpload($id);
        
        // Delete file - VULNERABILITY: No validation that the file belongs to the upload record
        $filepath = UPLOAD_DIR . $filename;
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }
}

header('Location: dashboard.php');
exit;
?>