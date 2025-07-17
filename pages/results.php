<?php 
$pageTitle = "Uploaded Files";
require_once '../includes/header.php';
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$fileType = isset($_GET['type']) ? $_GET['type'] : null;
$uploads = getUploads($fileType);
?>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">All Uploads</h2>
        <div>
            <label for="fileType" class="mr-2">Filter by type:</label>
            <select id="fileType" class="border rounded px-3 py-1" onchange="filterByType(this.value)">
                <option value="">All Types</option>
                <option value="jpg" <?= $fileType === 'jpg' ? 'selected' : '' ?>>JPG</option>
                <option value="png" <?= $fileType === 'png' ? 'selected' : '' ?>>PNG</option>
                <option value="pdf" <?= $fileType === 'pdf' ? 'selected' : '' ?>>PDF</option>
                <option value="php" <?= $fileType === 'php' ? 'selected' : '' ?>>PHP</option>
            </select>
        </div>
    </div>

    <?php if (count($uploads) > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filename</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($uploads as $upload): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="../uploads/<?= htmlspecialchars($upload['filename']) ?>" 
                                   class="text-blue-600 hover:underline" 
                                   target="_blank">
                                    <?= htmlspecialchars($upload['filename']) ?>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= htmlspecialchars($upload['filetype']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= htmlspecialchars($upload['upload_date']) ?>
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

<script>
    function filterByType(type) {
        if (type) {
            window.location.href = 'results.php?type=' + encodeURIComponent(type);
        } else {
            window.location.href = 'results.php';
        }
    }
</script>

<?php require_once '../includes/footer.php'; ?>