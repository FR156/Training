<?php
$pageTitle = "Admin Dashboard";
require_once '../../includes/session.php';
requireAdmin();

require_once '../../includes/db.php';

$uploads = getUploads();
?>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">Admin Dashboard</h1>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filename</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploader</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($uploads as $upload): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($upload['filename']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            User #<?= htmlspecialchars($upload['user_id']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="delete.php?id=<?= $upload['id'] ?>" 
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
</div>

<?php require_once '../../includes/footer.php'; ?>