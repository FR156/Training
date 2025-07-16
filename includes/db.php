<?php
require_once 'config.php';

// Create database connection with vulnerable error reporting
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection - error details exposed intentionally for demonstration
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get all uploads - vulnerable to SQL injection
function getUploads($fileType = null) {
    global $conn;
    
    $sql = "SELECT * FROM uploads";
    if ($fileType) {
        // VULNERABILITY: No parameterization, direct concatenation
        $sql .= " WHERE filetype = '$fileType'";
    }
    $sql .= " ORDER BY upload_date DESC";
    
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add an upload - vulnerable to SQL injection
function addUpload($filename, $filetype, $userId = 0) {
    global $conn;
    
    // VULNERABILITY: No parameterization, direct concatenation
    $sql = "INSERT INTO uploads (filename, filetype, user_id) 
            VALUES ('$filename', '$filetype', $userId)";
            
    return $conn->query($sql);
}

// Function to delete an upload - vulnerable to SQL injection
function deleteUpload($id) {
    global $conn;
    
    // VULNERABILITY: No parameterization, direct concatenation
    $sql = "DELETE FROM uploads WHERE id = $id";
    return $conn->query($sql);
}
?>