<?php
session_start();
require __DIR__ . '/includes/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    $captcha = $_POST['captcha'] ?? '';
    if (strcasecmp($captcha, $_SESSION['captcha_text'] ?? '') !== 0) {
        $error = 'Captcha incorrect';
    } elseif ($user === '' || $pass === '') {
        $error = 'Please fill all fields';
    } else {
        $stmt = $db->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$user]);
        if ($stmt->fetch()) {
            $error = 'Username already taken';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $insert = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $insert->execute([$user, $hash]);
            $_SESSION['user'] = $user;
            header('Location: /');
            exit;
        }
    }
}
$title = 'Register';
$currentPage = 'register';
include __DIR__ . '/includes/header.php';
?>
<div class="panel">
  <h2>Register</h2>
  <?php if ($error): ?>
  <p style="color:red;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
  <?php endif; ?>
  <form method="post" action="register.aspx">
    <p>
      <label>Username: <input type="text" name="username"></label>
    </p>
    <p>
      <label>Password: <input type="password" name="password"></label>
    </p>
    <p>
      <img class="captcha-img" alt="captcha"><br>
      <label>Enter text: <input type="text" name="captcha"></label>
    </p>
    <button type="submit">Register</button>
  </form>
</div>
<script src="/js/captcha.js"></script>
<?php include __DIR__ . '/includes/footer.php'; ?>
