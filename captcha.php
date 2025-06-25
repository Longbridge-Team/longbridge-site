<?php
session_start();
$code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5);
$_SESSION['captcha_text'] = $code;
header('Content-Type: image/png');
header('Cache-Control: no-cache, must-revalidate');
$img = imagecreatetruecolor(100, 30);
$bg = imagecolorallocate($img, 224, 236, 244);
$fg = imagecolorallocate($img, 0, 0, 0);
imagefilledrectangle($img, 0, 0, 100, 30, $bg);
imagestring($img, 5, 15, 8, $code, $fg);
imagepng($img);
imagedestroy($img);
exit;
?>
