<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
require __DIR__ . '/includes/db.php';
$since = date('Y-m-d H:i:s', time() - 300); // last 5 minutes
$stmt = $db->prepare('SELECT DISTINCT username FROM messages WHERE created > ?');
$stmt->execute([$since]);
$users = $stmt->fetchAll(PDO::FETCH_COLUMN);
header('Content-Type: application/json');
header('Cache-Control: no-cache');
echo json_encode($users);
