function escapeHtml(text) {
  const div = document.createElement('div');
  div.appendChild(document.createTextNode(text));
  return div.innerHTML;
}

function renderMessages(msgs) {
  const win = document.getElementById('chat-window');
  win.innerHTML = '';
  msgs.forEach(m => {
    const item = document.createElement('div');
    item.className = 'chat-message' + (m.username === window.currentUser ? ' own' : '');
    item.innerHTML = `<span class="sender">${escapeHtml(m.username)}</span> ` +
                     `<span class="time">${escapeHtml(m.created)}</span><br>` +
                     `<span class="text">${escapeHtml(m.message)}</span>`;
    win.appendChild(item);
  });
  win.scrollTop = win.scrollHeight;
}

function getChannel() {
  return document.getElementById('chat-channel').value;
}

function fetchMessages() {
  fetch('fetch_messages.php?channel=' + encodeURIComponent(getChannel()))
    .then(r => r.json())
    .then(renderMessages);
}

document.addEventListener('DOMContentLoaded', () => {
  window.currentUser = document.querySelector('.welcome')?.textContent.replace('Welcome, ','');
  const form = document.getElementById('chat-form');
  const channelSelect = document.getElementById('chat-channel');
  form.addEventListener('submit', e => {
    e.preventDefault();
    const input = document.getElementById('chat-input');
    const msg = input.value.trim();
    if (!msg) return;
    fetch('send_message.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'message=' + encodeURIComponent(msg) + '&channel=' + encodeURIComponent(getChannel())
    }).then(fetchMessages);
    input.value = '';
  });
  channelSelect.addEventListener('change', fetchMessages);
  fetchMessages();
  setInterval(fetchMessages, 3000);
});

