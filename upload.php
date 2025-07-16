<?php 
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['uploaded_file'])) {
        $file = $_FILES['uploaded_file'];
        
        // VULNERABILITY: No validation of file type or size
        $uploadedFilename = uploadFile($file);
        
        if ($uploadedFilename) {
            $fileType = getFileExtension($uploadedFilename);
            addUpload($uploadedFilename, $fileType);
            $message = "File uploaded successfully!";
        } else {
            $message = "File upload failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files - Vulnerable Demo</title>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800">File Upload</h1>
            <p class="text-gray-600">Test the vulnerable upload functionality</p>
        </header>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Upload a File</h2>
            
            <?php if ($message): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    <?php echo htmlspecialchars($message); ?>
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
                
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4">
                    <p class="font-semibold">Vulnerability Note:</p>
                    <p>This form accepts any file type without validation, including executable files like .php, .exe, etc.</p>
                </div>
                
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload File</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Try These Exploits</h2>
            <ul class="list-disc pl-5 space-y-2">
                <li>Upload a PHP file and try to execute it</li>
                <li>Upload a very large file to test size limits</li>
                <li>Upload a file with a double extension (e.g., "image.jpg.php")</li>
                <li>Upload a file with malicious content</li>
            </ul>
        </div>
    </div>
</body>
</html>