<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Create users table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    email VARCHAR(100),
    is_admin BOOLEAN DEFAULT false
)");

// Add some demo users if empty
if ($conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0] == 0) {
    $conn->query("INSERT INTO users (username, email, is_admin) VALUES 
        ('admin', 'admin@example.com', true),
        ('user1', 'user1@example.com', false),
        ('user2', 'user2@example.com', false)");
}

// VULNERABLE: IDOR - No authorization check
$userId = $_GET['id'] ?? 1;
$user = $conn->query("SELECT * FROM users WHERE id = $userId")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile - Vulnerable Demo</title>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-gray-100">
    <?php
        $pageTitle = "File Upload";
        require_once '../includes/header.php';
    ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">User Profile</h1>
        
        <?php if ($user): ?>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
                <div class="space-y-2">
                    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Role:</strong> <?= $user['is_admin'] ? 'Admin' : 'Regular User' ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>

        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6">
            <p class="font-semibold">Vulnerability Note:</p>
            <p>This profile page is vulnerable to Insecure Direct Object Reference (IDOR). Try changing the <code>id</code> parameter in the URL to access other users' data.</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Try These Exploits</h2>
            <ul class="list-disc pl-5 space-y-2">
                <li>Change the <code>?id=</code> parameter to view other users' profiles</li>
                <li>Try SQL injection in the ID parameter: <code>?id=1 OR 1=1--</code></li>
                <li>Attempt to access non-existent IDs to test error handling</li>
            </ul>
        </div>
    </div>
</body>
</html>