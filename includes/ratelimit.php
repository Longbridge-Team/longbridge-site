<?php
function rateLimit(string $action, int $limit = 10, int $window = 60): void {
    $file = __DIR__ . '/../data/ratelimit.json';
    if (!file_exists($file)) {
        file_put_contents($file, '{}');
    }
    $fp = fopen($file, 'c+');
    if (!$fp) {
        return; // fail open: skip limiting
    }
    flock($fp, LOCK_EX);
    $contents = stream_get_contents($fp);
    $data = json_decode($contents ?: '{}', true);
    if (!is_array($data)) {
        $data = [];
    }
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $key = $ip . ':' . $action;
    $now = time();
    foreach ($data as $k => $v) {
        if (($v['expires'] ?? 0) < $now) {
            unset($data[$k]);
        }
    }
    if (isset($data[$key])) {
        $entry = $data[$key];
        if ($entry['expires'] > $now) {
            $entry['count']++;
        } else {
            $entry = ['count' => 1, 'expires' => $now + $window];
        }
    } else {
        $entry = ['count' => 1, 'expires' => $now + $window];
    }
    $data[$key] = $entry;
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($data));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    if ($entry['count'] > $limit) {
        header('HTTP/1.1 429 Too Many Requests');
        echo 'Too many requests. Please slow down.';
        exit;
    }
}
?>
