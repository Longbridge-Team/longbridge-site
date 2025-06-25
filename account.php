<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login.aspx');
    exit;
}
require __DIR__ . '/includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pic = trim($_POST['profile_pic'] ?? '');
    if ($pic !== '' && !preg_match('/^https?:\/\//i', $pic)) {
        $error = 'Profile picture must be a valid URL';
    } else {
        $stmt = $db->prepare('UPDATE users SET profile_pic = ? WHERE username = ?');
        $stmt->execute([$pic ?: null, $_SESSION['user']]);
        $_SESSION['profile_pic'] = $pic ?: null;
        header('Location: /account.aspx?updated=1');
        exit;
    }
}

$title = 'Account Settings';
$currentPage = 'account';
include __DIR__ . '/includes/header.php';
?>
<div class="panel">
  <h2>Account Settings</h2>
  <?php if (isset($_GET['updated'])): ?>
  <p style="color:green;"><strong>Profile updated.</strong></p>
  <?php endif; ?>
  <?php if ($error): ?>
  <p style="color:red;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
  <?php endif; ?>
  <form method="post" action="account.aspx">
    <p>
      <label>Profile picture URL:<br>
        <input type="text" name="profile_pic" value="<?php echo htmlspecialchars($_SESSION['profile_pic'] ?? ''); ?>" size="50">
      </label>
    </p>
    <button type="submit">Save</button>
  </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
