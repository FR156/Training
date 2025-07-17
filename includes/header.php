<?php
require_once 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Vulnerable Training') ?></title>
    <link rel="stylesheet" href="../assets/css/output.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="../index.php" class="text-xl font-bold">Vulnerable Training</a>
                <?php if (isLoggedIn()): ?>
                    <a href="upload.php" class="hover:bg-blue-700 px-3 py-2 rounded">Upload</a>
                    <a href="results.php" class="hover:bg-blue-700 px-3 py-2 rounded">Files</a>
                    <a href="profile.php?id=<?= $_SESSION['user_id'] ?? 1 ?>" class="hover:bg-blue-700 px-3 py-2 rounded">Profile</a>
                <?php endif; ?>
            </div>
            
            <div class="flex items-center space-x-4">
                <?php if (isLoggedIn()): ?>
                    <span class="hidden md:inline">Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                    <?php if (isAdmin()): ?>
                        <a href="../admin/dashboard.php" class="bg-yellow-600 hover:bg-yellow-700 px-3 py-2 rounded">Admin</a>
                    <?php endif; ?>
                    <a href="logout.php" class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="hover:bg-blue-700 px-3 py-2 rounded">Login</a>
                    <a href="register.php" class="bg-green-600 hover:bg-green-700 px-3 py-2 rounded">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">