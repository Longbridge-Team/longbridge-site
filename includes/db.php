<?php
$dbFile = __DIR__ . '/../data/users.db';
$init = !file_exists($dbFile);
try {
    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($init) {
        $db->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, username TEXT UNIQUE, password TEXT);");
        $hash = password_hash('longbridge', PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->execute(['admin', $hash]);
    }
} catch (Exception $e) {
    die('DB error: ' . $e->getMessage());
}
?>
