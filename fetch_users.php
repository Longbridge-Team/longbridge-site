<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
require __DIR__ . '/includes/db.php';
$since = date('Y-m-d H:i:s', time() - 300); // last 5 minutes
$stmt = $db->prepare('SELECT DISTINCT username FROM messages WHERE created > ? ORDER BY username');
$stmt->execute([$since]);
$users = $stmt->fetchAll(PDO::FETCH_COLUMN);
$page = max(1, (int)($_GET['page'] ?? 1));
$per = max(1, min(50, (int)($_GET['per_page'] ?? 10)));
$total = count($users);
$totalPages = max(1, (int)ceil($total / $per));
$start = ($page - 1) * $per;
$paginated = array_slice($users, $start, $per);
header('Content-Type: application/json');
header('Cache-Control: no-cache');
echo json_encode(['users' => $paginated, 'page' => $page, 'totalPages' => $totalPages]);
