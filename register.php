<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/session.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } else {
        if (registerUser($username, $password)) {
            $success = 'Registration successful! Please login.';
        } else {
            $error = 'Registration failed. Username may already exist.';
        }
    }
}

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Vulnerable Training</title>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-center text-blue-800 mb-6">Register</h1>
            
            <?php if ($error): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Username:</label>
                    <input type="text" name="username" required
                           class="border p-2 rounded w-full">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Password:</label>
                    <input type="password" name="password" required
                           class="border p-2 rounded w-full">
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Confirm Password:</label>
                    <input type="password" name="confirm_password" required
                           class="border p-2 rounded w-full">
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Register
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600">Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>