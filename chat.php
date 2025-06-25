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
  <div id="online-users" class="online-users"></div>
  <form id="chat-form" class="chat-form">
    <select id="chat-channel">
      <option value="general">General</option>
      <option value="tech">Tech</option>
      <option value="offtopic">Off-topic</option>
    </select>
    <input type="text" id="chat-input" maxlength="250" placeholder="Type a message" autocomplete="off">
    <button type="button" id="emoji-btn" class="aerobutton" aria-label="Emoji"></button>
    <button type="button" id="nudge-btn" class="aerobutton" aria-label="Nudge"></button>
    <button type="button" id="call-btn" class="aerobutton" aria-label="Call"></button>
    <div id="emoji-panel" class="emoji-panel"></div>
  </form>
  <audio id="nudge-sound" src="/img/nudge.mp3" preload="auto"></audio>
</div>
<script src="/js/chat.js"></script>
<?php include __DIR__ . '/includes/footer.php'; ?>

