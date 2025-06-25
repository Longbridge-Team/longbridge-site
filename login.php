<?php
session_start();
require __DIR__ . '/includes/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    $captcha = $_POST['captcha'] ?? '';
    if (strcasecmp($captcha, $_SESSION['captcha_text'] ?? '') !== 0) {
        $error = 'Captcha incorrect';
    } else {
        $stmt = $db->prepare('SELECT password FROM users WHERE username = ?');
        $stmt->execute([$user]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($pass, $row['password'])) {
            $_SESSION['user'] = $user;
            header('Location: /');
            exit;
        } else {
            $error = 'Invalid credentials';
        }
    }
}
$title = 'Login';
$currentPage = 'login';
include __DIR__ . '/includes/header.php';
?>
<div class="panel">
  <h2>Login</h2>
  <?php if ($error): ?>
  <p style="color:red;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
  <?php endif; ?>
  <form method="post" action="login.php">
    <p>
      <label>Username: <input type="text" name="username"></label>
    </p>
    <p>
      <label>Password: <input type="password" name="password"></label>
    </p>
    <p>
      <img src="captcha.php" alt="captcha"><br>
      <label>Enter text: <input type="text" name="captcha"></label>
    </p>
    <button type="submit">Login</button>
  </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>