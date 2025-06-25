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
$channel = $_POST['channel'] ?? 'general';
if ($input === '') {
    exit;
}
if (mb_strlen($input) > 250) {
    $input = mb_substr($input, 0, 250);
}
$check = $db->prepare('SELECT message, created FROM messages WHERE username = ? ORDER BY id DESC LIMIT 1');
$check->execute([$_SESSION['user']]);
$last = $check->fetch(PDO::FETCH_ASSOC);
if ($last && $last['message'] === $input && strtotime($last['created']) > time() - 30) {
    exit; // ignore spammy duplicate
}
$msg = $input === '/nudge' ? '::nudge::' : $input;
$stmt = $db->prepare('INSERT INTO messages (username, message, channel) VALUES (?, ?, ?)');
$stmt->execute([$_SESSION['user'], $msg, $channel]);
?>

