<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    exit;
}
if ($_FILES['file']['size'] > 2 * 1024 * 1024) {
    http_response_code(400);
    exit;
}
$info = getimagesize($_FILES['file']['tmp_name']);
if (!$info || !in_array($info[2], [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF])) {
    http_response_code(400);
    exit;
}
$ext = $info[2] === IMAGETYPE_GIF ? '.gif' : ($info[2] === IMAGETYPE_PNG ? '.png' : '.jpg');
$name = bin2hex(random_bytes(8)) . $ext;
$dest = __DIR__ . '/uploads/' . $name;
if (!move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
    http_response_code(500);
    exit;
}
header('Content-Type: application/json');
echo json_encode(['url' => '/image.php?f=' . $name]);
