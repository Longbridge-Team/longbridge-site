<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($title)) {
    $title = 'Windows Longbridge';
}
if (!isset($currentPage)) {
    $currentPage = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo htmlspecialchars($title); ?></title>
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/css/xp.css">
</head>
<body>
<div class="top-banner">Build 2 of <strong>Windows Longbridge</strong> is out!</div>
<header>
  <nav>
    <ul>
      <li><a <?php if($currentPage=='home') echo 'class="active"'; ?> href="/index.aspx"><img height="40" width="40" src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.rw-designer.com%2Ficon-image%2F18837-256x256x4.png&f=1&nofb=1&ipt=f7d794f16772d7f4e0c9a6e94728373825d3c62652593016b99b5592e6f2ea32" alt="Home">Home</a></li>
      <li><a <?php if($currentPage=='features') echo 'class="active"'; ?> href="/features.aspx"><img height="40" width="40" src="https://images.freeimages.com/fic/images/icons/679/nx10/256/windows_update.png" alt="Features">Features</a></li>
      <li><a href="https://uploadnow.io/f/77m5F4p"><img height="40" width="40" src="http://www.jidesoft.com/icon/vista/vista.png" alt="Download">Download</a></li>
      <li><a href="https://discord.gg/zP9fAPxtNj"><img height="40" width="40" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.redd.it%2Flne7g32kas2c1.png&f=1&nofb=1&ipt=1d67f20a42f2bc0901f6d1c4e7cedbe700edbbff8f4cf0c716d53327873b7d8c" alt="Community">Community</a></li>
      <li><a <?php if($currentPage=='about') echo 'class="active"'; ?> href="/about.aspx"><img height="40" width="40" src="https://www.iconshock.com/image/Vista/General/file" alt="About">About</a></li>
      <?php if(isset($_SESSION['user'])): ?>
      <li><a <?php if($currentPage=='chat') echo 'class="active"'; ?> href="/chat.aspx"><img height="40" width="40" src="https://upload.wikimedia.org/wikipedia/en/b/bf/Windows_Live_Messenger_icon.png" alt="Chat">Chat</a></li>
      <li><a <?php if($currentPage=='account') echo 'class="active"'; ?> href="/account.aspx"><img height="40" width="40" src="https://www.iconshock.com/image/Windows7/General/user" alt="Account">Account</a></li>
      <li class="welcome">
        <?php if(!empty($_SESSION['profile_pic'])): ?>
          <img class="avatar-small" src="<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" alt="avatar">
        <?php endif; ?>
        Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>
      </li>
      <li><a href="/logout.aspx"><img height="20" width="20" src="https://www.iconshock.com/image/Windows7/General/cross" alt="Logout">Logout</a></li>
      <?php else: ?>
      <li><a <?php if($currentPage=='login') echo 'class="active"'; ?> href="/login.aspx"><img height="40" width="40" src="https://www.iconshock.com/image/Vista/General/lock" alt="Login">Login</a></li>
      <li><a <?php if($currentPage=='register') echo 'class="active"'; ?> href="/register.aspx"><img height="40" width="40" src="https://www.iconshock.com/image/Vista/Education/attendance_list" alt="Register">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
<div class="container">
