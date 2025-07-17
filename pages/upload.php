<?php 
$pageTitle = "File Upload";
require_once '../includes/header.php';
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['uploaded_file'])) {
        $file = $_FILES['uploaded_file'];
        $uploadedFilename = uploadFile($file);
        
        if ($uploadedFilename) {
            $fileType = getFileExtension($uploadedFilename);
            addUpload($uploadedFilename, $fileType, $_SESSION['user_id'] ?? 0);
            $message = "File uploaded successfully!";
        } else {
            $message = "File upload failed.";
        }
    }
}
?>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Upload a File</h2>
    
    <?php if ($message): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form action="upload.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label for="uploaded_file" class="block text-sm font-medium text-gray-700 mb-1">Choose file to upload:</label>
            <input type="file" name="uploaded_file" id="uploaded_file" class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100">
        </div>
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload File</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>