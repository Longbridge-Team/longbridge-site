<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/ratelimit.php';
rateLimit('chat', 10, 10);
$input = trim($_POST['message'] ?? '');
if ($input === '') {
    exit;
}
if (mb_strlen($input) > 250) {
    $input = mb_substr($input, 0, 250);
}
$stmt = $db->prepare('INSERT INTO messages (username, message) VALUES (?, ?)');
$stmt->execute([$_SESSION['user'], $input]);
?>

