function escapeHtml(text) {
  const div = document.createElement('div');
  div.appendChild(document.createTextNode(text));
  return div.innerHTML;
}

let lastMessageId = 0;
const MAX_VISIBLE_MESSAGES = 25;
let availableEmojis = new Set();

function formatMessage(text) {
  let escaped = escapeHtml(text);
  escaped = escaped.replace(/:([a-zA-Z0-9_]+):/g, (m, name) => {
    if (availableEmojis.has(name + '.png')) {
      return `<img src="/img/wlm/emoticons/${name}.png" alt="${name}" class="emoji">`;
    }
    if (availableEmojis.has(name + '.gif')) {
      return `<img src="/img/wlm/emoticons/${name}.gif" alt="${name}" class="emoji">`;
    }
    return m;
  });
  return escaped;
}

function renderMessages(msgs) {
  const win = document.getElementById('chat-window');
  win.innerHTML = '';
  let highest = lastMessageId;
  msgs.forEach(m => {
    if (m.id > highest) highest = m.id;
  });
  const toShow = msgs.slice(-MAX_VISIBLE_MESSAGES);
  toShow.forEach(m => {
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
    let text = formatMessage(m.message);
    if (window.currentUser) {
      const regex = new RegExp('@' + window.currentUser.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\b', 'gi');
      text = text.replace(regex, '<span class="mention">$&</span>');
    }
    item.innerHTML = `<span class="sender">${escapeHtml(m.username)}</span> ` +
                     `<span class="time">${escapeHtml(m.created)}</span><br>` +
                     `<span class="text">${text}</span>`;
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
  list.innerHTML = '<strong>Online:</strong> ' +
    users.map(u => `<span class="user">${escapeHtml(u)}</span>`).join(', ');
  list.querySelectorAll('.user').forEach(span => {
    span.addEventListener('click', () => {
      const input = document.getElementById('chat-input');
      input.value += '@' + span.textContent + ' ';
      input.focus();
    });
  });
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
  const audio = document.getElementById('nudge-sound');
  if (audio) {
    audio.currentTime = 0;
    audio.play().catch(() => {});
  }
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
  const emojiBtn = document.getElementById('emoji-btn');
  const callBtn = document.getElementById('call-btn');
  const emojiPanel = document.getElementById('emoji-panel');

  fetch('list_emoticons.php')
    .then(r => r.json())
    .then(files => {
      files.forEach(f => {
        const name = f.split('/').pop();
        availableEmojis.add(name);
        const img = document.createElement('img');
        img.src = f;
        img.alt = name.split('.')[0];
        img.addEventListener('click', () => {
          const input = document.getElementById('chat-input');
          input.value += `:${img.alt}:`;
          input.focus();
          emojiPanel.style.display = 'none';
        });
        emojiPanel.appendChild(img);
      });
    });
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
    emojiPanel.style.display = 'none';
  });
  channelSelect.addEventListener('change', () => {
    lastMessageId = 0;
    fetchMessages();
    emojiPanel.style.display = 'none';
  });
  emojiBtn.addEventListener('click', () => {
    emojiPanel.style.display = emojiPanel.style.display === 'block' ? 'none' : 'block';
  });
  nudgeBtn.addEventListener('click', () => {
    fetch('send_message.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'message=' + encodeURIComponent('/nudge') + '&channel=' + encodeURIComponent(getChannel())
    }).then(fetchMessages);
    emojiPanel.style.display = 'none';
  });
  callBtn.addEventListener('click', () => {
    window.open('https://meet.jit.si/' + encodeURIComponent(getChannel()), '_blank');
    emojiPanel.style.display = 'none';
  });
  fetchMessages();
  fetchUsers();
  setInterval(fetchMessages, 3000);
  setInterval(fetchUsers, 30000);
});

