<?php 
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// VULNERABILITY: SQL injection possible through filetype parameter
$fileType = isset($_GET['type']) ? $_GET['type'] : null;
$uploads = getUploads($fileType);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files - Vulnerable Demo</title>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800">Uploaded Files</h1>
            <p class="text-gray-600">View all uploaded files and their details</p>
        </header>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">All Uploads</h2>
                <div>
                    <label for="fileType" class="mr-2">Filter by type:</label>
                    <select id="fileType" class="border rounded px-3 py-1" onchange="filterByType(this.value)">
                        <option value="">All Types</option>
                        <option value="jpg" <?php echo $fileType === 'jpg' ? 'selected' : '' ?>>JPG</option>
                        <option value="png" <?php echo $fileType === 'png' ? 'selected' : '' ?>>PNG</option>
                        <option value="pdf" <?php echo $fileType === 'pdf' ? 'selected' : '' ?>>PDF</option>
                        <option value="php" <?php echo $fileType === 'php' ? 'selected' : '' ?>>PHP</option>
                        <option value="exe" <?php echo $fileType === 'exe' ? 'selected' : '' ?>>EXE</option>
                    </select>
                </div>
            </div>

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
                                        <a href="<?php echo UPLOAD_DIR . htmlspecialchars($upload['filename']); ?>" 
                                           class="text-blue-600 hover:underline" 
                                           target="_blank">
                                            <?php echo htmlspecialchars($upload['filename']); ?>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($upload['filetype']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($upload['upload_date']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php if (isAdmin()): ?>
                                            <a href="admin/delete.php?id=<?php echo $upload['id']; ?>" 
                                               class="text-red-600 hover:underline"
                                               onclick="return confirm('Are you sure you want to delete this file?')">
                                                Delete
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-400">Admin required</span>
                                        <?php endif; ?>
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
            <h2 class="text-xl font-semibold mb-4">Security Notes</h2>
            <ul class="list-disc pl-5 space-y-2">
                <li>Files are stored with their original names, making them potentially executable</li>
                <li>No authentication is required to view or access uploaded files</li>
                <li>The file type filter is vulnerable to SQL injection</li>
                <li>Admin functionality is simulated with a simple URL parameter</li>
            </ul>
        </div>
    </div>

    <script>
        function filterByType(type) {
            if (type) {
                window.location.href = 'results.php?type=' + encodeURIComponent(type);
            } else {
                window.location.href = 'results.php';
            }
        }
    </script>
</body>
</html>