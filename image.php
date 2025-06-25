<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
$file = basename($_GET['f'] ?? '');
$path = __DIR__ . '/uploads/' . $file;
if (!preg_match('/^[a-f0-9]{16}\.(png|jpe?g|gif)$/i', $file) || !is_file($path)) {
    http_response_code(404);
    exit;
}
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$type = finfo_file($finfo, $path);
finfo_close($finfo);
header('Content-Type: ' . $type);
readfile($path);
