<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// VULNERABLE: Raw user input in SQL query
$searchTerm = $_GET['q'] ?? '';
$results = [];

if ($searchTerm) {
    // Extremely vulnerable query
    $sql = "SELECT * FROM uploads WHERE filename LIKE '%$searchTerm%' OR filetype LIKE '%$searchTerm%'";
    $result = $conn->query($sql);
    if ($result) {
        $results = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search - Vulnerable Demo</title>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">Search Files</h1>
        
        <form action="search.php" method="GET" class="mb-6">
            <input type="text" name="q" value="<?= htmlspecialchars($searchTerm) ?>" 
                   class="border p-2 rounded w-full md:w-1/2" 
                   placeholder="Search files...">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Search</button>
        </form>

        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6">
            <p class="font-semibold">Vulnerability Note:</p>
            <p>This search is vulnerable to SQL injection. Try inputs like: <code>' OR '1'='1</code> or <code>'; DROP TABLE uploads;--</code></p>
        </div>

        <?php if ($searchTerm): ?>
            <h2 class="text-xl font-semibold mb-4">Results for "<?= htmlspecialchars($searchTerm) ?>"</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <?php if ($results): ?>
                    <ul class="space-y-2">
                        <?php foreach ($results as $file): ?>
                            <li class="border-b pb-2">
                                <a href="uploads/<?= htmlspecialchars($file['filename']) ?>" 
                                   class="text-blue-600 hover:underline">
                                    <?= htmlspecialchars($file['filename']) ?>
                                </a>
                                (<?= htmlspecialchars($file['filetype']) ?>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No results found.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>