<?php
session_start();
require __DIR__ . '/includes/ratelimit.php';
rateLimit('captcha', 20, 60);
$code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5);
$_SESSION['captcha_text'] = $code;
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
echo json_encode(['code' => $code]);
exit;
?>