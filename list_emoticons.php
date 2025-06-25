<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
$files = glob(__DIR__ . '/img/wlm/emoticons/*.{png,gif}', GLOB_BRACE);
$files = array_map(function($f) {
    return '/img/wlm/emoticons/' . basename($f);
}, $files);
header('Content-Type: application/json');
header('Cache-Control: no-cache');
echo json_encode($files);

