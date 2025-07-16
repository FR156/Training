<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// VULNERABLE: Stored XSS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $sql = "INSERT INTO comments (content, created_at) VALUES ('$comment', NOW())";
    $conn->query($sql);
}

// Create comments table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT,
    created_at DATETIME
)");

$comments = $conn->query("SELECT * FROM comments ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comments - Vulnerable Demo</title>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">Comments Section</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Leave a Comment</h2>
            <form method="POST">
                <textarea name="comment" class="border p-2 rounded w-full" rows="4" 
                          placeholder="Your comment..."></textarea>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Submit</button>
            </form>
        </div>

        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6">
            <p class="font-semibold">Vulnerability Note:</p>
            <p>This comments section is vulnerable to stored XSS. Try submitting: <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code></p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Comments</h2>
            <?php if ($comments): ?>
                <div class="space-y-4">
                    <?php foreach ($comments as $comment): ?>
                        <div class="border-b pb-4">
                            <!-- VULNERABLE: No output encoding -->
                            <div class="comment-content"><?= $comment['content'] ?></div>
                            <div class="text-sm text-gray-500 mt-1">
                                <?= htmlspecialchars($comment['created_at']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No comments yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>