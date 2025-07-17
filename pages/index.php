<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Vulnerabilities Demo</title>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-gray-100">
    <?php
        $pageTitle = "File Upload";
        require_once '../includes/header.php';
    ?>
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800">File Upload Vulnerabilities Demo</h1>
            <p class="text-gray-600">A safe environment to learn about security risks</p>
        </header>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">About This Demo</h2>
            <p class="mb-4">This website intentionally contains vulnerabilities related to file uploads for educational purposes. It demonstrates common security flaws that can be exploited if proper precautions aren't taken.</p>
            
            <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4">
                <p class="font-semibold">Warning:</p>
                <p>This website contains intentional security vulnerabilities. Do not deploy this in a production environment.</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">File Upload</h2>
                <p class="mb-4">Try uploading different file types to see how the system behaves without proper validation.</p>
                <a href="upload.php" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Go to Upload Page</a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">View Uploads</h2>
                <p class="mb-4">See all uploaded files and how they're stored and displayed.</p>
                <a href="results.php" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Uploaded Files</a>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Educational Resources</h2>
            <ul class="list-disc pl-5 space-y-2">
                <li><a href="#" class="text-blue-600 hover:underline">File Upload Security Best Practices</a></li>
                <li><a href="#" class="text-blue-600 hover:underline">Common Attack Vectors</a></li>
                <li><a href="#" class="text-blue-600 hover:underline">How to Secure Your Upload Forms</a></li>
            </ul>
        </div>
    </div>
</body>
</html>