<?php
require_once 'includes/config.php';

$content = '';
$url = $_GET['url'] ?? '';

if ($url) {
    // VULNERABLE: SSRF - No validation of user-supplied URL
    $content = file_get_contents($url);
    if ($content === false) {
        $content = "Failed to fetch URL: $url";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>URL Fetcher - Vulnerable Demo</title>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">URL Fetcher</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">URL to fetch:</label>
                    <input type="text" name="url" value="<?= htmlspecialchars($url) ?>" 
                           class="border p-2 rounded w-full" 
                           placeholder="http://example.com">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Fetch URL</button>
            </form>
        </div>

        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6">
            <p class="font-semibold">Vulnerability Note:</p>
            <p>This URL fetcher is vulnerable to SSRF attacks. Try fetching internal URLs like:</p>
            <ul class="list-disc pl-5 mt-2">
                <li><code>file:///etc/passwd</code></li>
                <li><code>http://localhost/admin</code></li>
                <li><code>http://169.254.169.254/latest/meta-data/</code> (AWS metadata)</li>
            </ul>
        </div>

        <?php if ($url): ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Content from <?= htmlspecialchars($url) ?></h2>
                <pre class="bg-gray-200 p-4 rounded overflow-x-auto"><?= htmlspecialchars($content) ?></pre>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>