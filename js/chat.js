function escapeHtml(text) {
  const div = document.createElement('div');
  div.appendChild(document.createTextNode(text));
  return div.innerHTML;
}

let lastMessageId = 0;

function renderMessages(msgs) {
  const win = document.getElementById('chat-window');
  win.innerHTML = '';
  let highest = lastMessageId;
  msgs.forEach(m => {
    if (m.id > highest) highest = m.id;
    if (m.message === '::nudge::') {
      if (m.id > lastMessageId) {
        nudge();
      }
      const item = document.createElement('div');
      item.className = 'chat-message system';
      item.textContent = m.username + ' sent a nudge!';
      win.appendChild(item);
      return;
    }
    const item = document.createElement('div');
    item.className = 'chat-message' + (m.username === window.currentUser ? ' own' : '');
    item.innerHTML = `<span class="sender">${escapeHtml(m.username)}</span> ` +
                     `<span class="time">${escapeHtml(m.created)}</span><br>` +
                     `<span class="text">${escapeHtml(m.message)}</span>`;
    win.appendChild(item);
  });
  lastMessageId = highest;
  win.scrollTop = win.scrollHeight;
}

function getChannel() {
  return document.getElementById('chat-channel').value;
}

function renderUsers(users) {
  const list = document.getElementById('online-users');
  list.innerHTML = '<strong>Online:</strong> ' + users.map(escapeHtml).join(', ');
}

function fetchUsers() {
  fetch('fetch_users.php')
    .then(r => r.json())
    .then(renderUsers);
}

function nudge() {
  const panel = document.querySelector('.chat-panel');
  if (!panel) return;
  panel.classList.add('nudge');
  setTimeout(() => panel.classList.remove('nudge'), 500);
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
  const nudgeBtn = document.getElementById('nudge-btn');
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
  channelSelect.addEventListener('change', () => {
    lastMessageId = 0;
    fetchMessages();
  });
  nudgeBtn.addEventListener('click', () => {
    fetch('send_message.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'message=' + encodeURIComponent('/nudge') + '&channel=' + encodeURIComponent(getChannel())
    }).then(fetchMessages);
  });
  fetchMessages();
  fetchUsers();
  setInterval(fetchMessages, 3000);
  setInterval(fetchUsers, 30000);
});

