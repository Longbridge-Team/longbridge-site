<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
$channel = $_GET['channel'] ?? 'general';
require __DIR__ . '/includes/db.php';
$limit = 50;
$stmt = $db->prepare('SELECT id, username, message, created FROM messages WHERE channel = ? ORDER BY id DESC LIMIT ?');
$stmt->bindValue(1, $channel, PDO::PARAM_STR);
$stmt->bindValue(2, $limit, PDO::PARAM_INT);
$stmt->execute();
$messages = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
header('Content-Type: application/json');
header('Cache-Control: no-cache');
echo json_encode($messages);


