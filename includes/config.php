<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'upload_vuln_demo');

// Upload directory - intentionally world-writable for demonstration
define('UPLOAD_DIR', 'uploads/');

// Set to false to demonstrate security risks
define('SECURE_UPLOADS', false);
?>