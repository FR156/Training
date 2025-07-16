<?php 
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Simulated admin check - VULNERABILITY: No real authentication
if (!isAdmin()) {
    header('Location: ../index.php');
    exit;
}

$uploads = getUploads();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Vulnerable Demo</title>
    <link rel="stylesheet" href="../assets/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800">Admin Dashboard</h1>
            <p class="text-gray-600">Manage all uploaded files</p>
        </header>

        <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-6">
            <p class="font-semibold">Security Warning:</p>
            <p>This admin panel has no real authentication. Access is controlled by a simple URL parameter.</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">All Uploads</h2>

            <?php if (count($uploads) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filename</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($uploads as $upload): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($upload['id']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="../<?php echo UPLOAD_DIR . htmlspecialchars($upload['filename']); ?>" 
                                           class="text-blue-600 hover:underline" 
                                           target="_blank">
                                            <?php echo htmlspecialchars($upload['filename']); ?>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($upload['filetype']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($upload['upload_date']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="delete.php?id=<?php echo $upload['id']; ?>" 
                                           class="text-red-600 hover:underline"
                                           onclick="return confirm('Are you sure you want to delete this file?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-500">No files have been uploaded yet.</p>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Admin Functions</h2>
            <ul class="list-disc pl-5 space-y-2">
                <li>View all uploaded files</li>
                <li>Delete malicious or unwanted files</li>
                <li>Monitor upload activity</li>
            </ul>
        </div>
    </div>
</body>
</html>