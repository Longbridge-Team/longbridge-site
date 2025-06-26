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
  <div id="call-info" class="call-info"></div>
  <div id="online-users" class="online-users"></div>
  <div class="users-pagination">
    <button type="button" id="users-prev" class="aerobutton">Prev</button>
    <span id="users-page">1</span>
    <button type="button" id="users-next" class="aerobutton">Next</button>
  </div>
  <form id="chat-form" class="chat-form">
    <select id="chat-channel">
      <option value="general" selected>General</option>
      <option value="tech">Tech</option>
      <option value="offtopic">Off-topic</option>
    </select>
    <input type="text" id="chat-input" maxlength="250" placeholder="Type a message" autocomplete="off">
    <input type="file" id="image-input" accept="image/png,image/jpeg,image/gif" style="display:none">
    <div class="btn-row">
      <button type="button" id="emoji-btn" class="aerobutton" aria-label="Emoji"></button>
      <button type="button" id="nudge-btn" class="aerobutton" aria-label="Nudge"></button>
      <button type="button" id="call-btn" class="aerobutton" aria-label="Call"></button>
    </div>
    <div class="btn-row">
      <button type="button" id="upload-btn" class="aerobutton" aria-label="Upload"></button>
      <button type="button" id="gif-btn" class="aerobutton" aria-label="GIF"></button>
      <button type="button" id="draw-btn" class="aerobutton" aria-label="Draw"></button>
    </div>
    <div id="emoji-panel" class="emoji-panel"></div>
    <div id="gif-panel" class="gif-panel">
      <input type="text" id="gif-search" placeholder="Search GIFs">
      <div id="gif-results"></div>
    </div>
  </form>
  <audio id="nudge-sound" src="/img/nudge.mp3" preload="auto"></audio>
  <div id="call-modal" class="call-modal">
    <div class="call-window">
      <button type="button" id="call-close" class="aerobutton">X</button>
      <div id="jitsi-container" class="jitsi-container"></div>
    </div>
  </div>
  <div id="draw-modal" class="draw-modal">
    <div class="draw-window">
      <canvas id="draw-canvas" width="400" height="300"></canvas>
      <div class="draw-actions">
        <button type="button" id="draw-send" class="aerobutton">Send</button>
        <button type="button" id="draw-clear" class="aerobutton">Clear</button>
        <button type="button" id="draw-close" class="aerobutton">X</button>
      </div>
    </div>
  </div>
</div>
<script src="/js/chat.js"></script>
<?php include __DIR__ . '/includes/footer.php'; ?>

