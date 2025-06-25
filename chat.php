<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login.aspx');
    exit;
}
$title = 'Chat';
$currentPage = 'chat';
include __DIR__ . '/includes/header.php';
?>
<div class="panel chat-panel">
  <h2><img width="40" src="https://upload.wikimedia.org/wikipedia/en/b/bf/Windows_Live_Messenger_icon.png" alt="">Chatroom</h2>
  <div id="chat-window" class="chat-window"></div>
  <form id="chat-form" class="chat-form">
    <select id="chat-channel">
      <option value="general">General</option>
      <option value="tech">Tech</option>
      <option value="offtopic">Off-topic</option>
    </select>
    <input type="text" id="chat-input" maxlength="250" placeholder="Type a message" autocomplete="off">
    <button type="submit">Send</button>
  </form>
</div>
<script src="/js/chat.js"></script>
<?php include __DIR__ . '/includes/footer.php'; ?>

