<?php
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'longbridge';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255) UNIQUE, password VARCHAR(255), profile_pic VARCHAR(255) NULL)");
    $db->exec("CREATE TABLE IF NOT EXISTS messages (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255), message TEXT, channel VARCHAR(100) DEFAULT 'general', created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    // ensure new columns exist when updating from older installations
    $cols = $db->query("SHOW COLUMNS FROM users LIKE 'profile_pic'")->fetchAll();
    if (!$cols) {
        $db->exec("ALTER TABLE users ADD COLUMN profile_pic VARCHAR(255) NULL");
    }
    $cols = $db->query("SHOW COLUMNS FROM messages LIKE 'channel'")->fetchAll();
    if (!$cols) {
        $db->exec("ALTER TABLE messages ADD COLUMN channel VARCHAR(100) DEFAULT 'general'");
    }
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
