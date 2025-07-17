<?php
$pageTitle = "Login";
require_once '../includes/header.php';
require_once '../includes/auth.php';
require_once '../includes/session.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (authenticateUser($username, $password)) {
        header('Location: ../index.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}

if (isLoggedIn()) {
    header('Location: ../index.php');
    exit;
}
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-center text-blue-800 mb-6">Login</h1>
    
    <?php if ($error): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Username:</label>
            <input type="text" name="username" required class="border p-2 rounded w-full">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Password:</label>
            <input type="password" name="password" required class="border p-2 rounded w-full">
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Login
        </button>
    </form>
    
    <div class="mt-6 text-center">
        <p class="text-gray-600">Don't have an account? <a href="register.php" class="text-blue-600 hover:underline">Register</a></p>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>