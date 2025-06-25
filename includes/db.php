<?php
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'longbridge';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255) UNIQUE, password VARCHAR(255))");
    $db->exec("CREATE TABLE IF NOT EXISTS messages (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255), message TEXT, created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    $check = $db->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
    $check->execute(['admin']);
    if (!$check->fetchColumn()) {
        $hash = password_hash('longbridge', PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->execute(['admin', $hash]);
    }
} catch (Exception $e) {
    die('DB error: ' . $e->getMessage());
}
?>
