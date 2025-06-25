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

function fetchMessages() {
  fetch('fetch_messages.php')
    .then(r => r.json())
    .then(renderMessages);
}

document.addEventListener('DOMContentLoaded', () => {
  window.currentUser = document.querySelector('.welcome')?.textContent.replace('Welcome, ','');
  const form = document.getElementById('chat-form');
  form.addEventListener('submit', e => {
    e.preventDefault();
    const input = document.getElementById('chat-input');
    const msg = input.value.trim();
    if (!msg) return;
    fetch('send_message.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'message=' + encodeURIComponent(msg)
    }).then(fetchMessages);
    input.value = '';
  });
  fetchMessages();
  setInterval(fetchMessages, 3000);
});

