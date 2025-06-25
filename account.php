<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login.aspx');
    exit;
}
require __DIR__ . '/includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['method'] ?? 'url';
    $pic = null;
    if ($method === 'upload' && isset($_FILES['profile_file']) && $_FILES['profile_file']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['profile_file']['size'] > 500000) {
            $error = 'File too large';
        } else {
            $info = getimagesize($_FILES['profile_file']['tmp_name']);
            if ($info && ($info[2] === IMAGETYPE_PNG || $info[2] === IMAGETYPE_JPEG)) {
                $ext = $info[2] === IMAGETYPE_PNG ? '.png' : '.jpg';
                $name = bin2hex(random_bytes(8)) . $ext;
                $dest = __DIR__ . '/../uploads/' . $name;
                if (move_uploaded_file($_FILES['profile_file']['tmp_name'], $dest)) {
                    $pic = '/uploads/' . $name;
                } else {
                    $error = 'Upload failed';
                }
            } else {
                $error = 'Invalid image';
            }
        }
    } else {
        $pic = trim($_POST['profile_pic'] ?? '');
        if ($pic !== '' && !preg_match('/^https?:\/\//i', $pic)) {
            $error = 'Profile picture must be a valid URL';
        }
    }
    if ($error === '') {
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
  <form method="post" action="account.aspx" enctype="multipart/form-data">
    <p>
      <label><input type="radio" name="method" value="url" checked> Use image URL</label>
      <br>
      <input type="text" name="profile_pic" value="<?php echo htmlspecialchars($_SESSION['profile_pic'] ?? ''); ?>" size="50">
    </p>
    <p>
      <label><input type="radio" name="method" value="upload"> Upload image</label>
      <br>
      <input type="file" name="profile_file" accept="image/png,image/jpeg">
    </p>
    <button type="submit">Save</button>
  </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
