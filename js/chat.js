function escapeHtml(text) {
  const div = document.createElement('div');
  div.appendChild(document.createTextNode(text));
  return div.innerHTML;
}

let lastMessageId = 0;
const MAX_VISIBLE_MESSAGES = 25;
let availableEmojis = new Set();
let usersPage = 1;
const USERS_PER_PAGE = 10;
let jitsiApi = null;
let callUsers = new Set();

function formatMessage(text) {
  let escaped = escapeHtml(text);
  escaped = escaped.replace(/\[img:([^\]\s]+)\]/g, (m, url) => {
    const safe = url.replace(/"/g, '');
    return `<img src="${safe}" class="chat-img">`;
  });
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
    if (m.id > lastMessageId && window.currentUser) {
      const mentionRegex = new RegExp('@' + window.currentUser.replace(/[.*+?^${}()|[\\]\\]/g, '\\$&') + '\\b', 'i');
      if (mentionRegex.test(m.message)) {
        nudge();
        const note = document.createElement('div');
        note.className = 'chat-message system';
        if (m.username === window.currentUser) {
          note.textContent = 'You have mentioned yourself';
        } else {
          note.textContent = m.username + ' mentioned ' + window.currentUser;
        }
        win.appendChild(note);
      }
    }
  });
  lastMessageId = highest;
  win.scrollTop = win.scrollHeight;
}

function getChannel() {
  return document.getElementById('chat-channel').value;
}

function renderUsers(data) {
  const list = document.getElementById('online-users');
  list.innerHTML = '<strong>Online:</strong> ' +
    data.users.map(u => `<span class="user">${escapeHtml(u)}</span>`).join(', ');
  list.querySelectorAll('.user').forEach(span => {
    span.addEventListener('click', () => {
      const input = document.getElementById('chat-input');
      input.value += '@' + span.textContent + ' ';
      input.focus();
    });
  });
  document.getElementById('users-page').textContent = data.page + '/' + data.totalPages;
  document.getElementById('users-prev').disabled = data.page <= 1;
  document.getElementById('users-next').disabled = data.page >= data.totalPages;
}

function fetchUsers() {
  fetch(`fetch_users.php?page=${usersPage}&per_page=${USERS_PER_PAGE}`)
    .then(r => r.json())
    .then(renderUsers);
}

function loadGifs(query = '') {
  const url = query
    ? `https://g.tenor.com/v1/search?q=${encodeURIComponent(query)}&key=LIVDSRZULELA&limit=10`
    : 'https://g.tenor.com/v1/trending?key=LIVDSRZULELA&limit=10';
  fetch(url)
    .then(r => r.json())
    .then(d => {
      if (!window.gifResults) return;
      gifResults.innerHTML = '';
      d.results.forEach(g => {
        const img = document.createElement('img');
        img.src = g.media[0].tinygif.url;
        img.addEventListener('click', () => {
          gifPanel.style.display = 'none';
          fetch('send_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'message=' + encodeURIComponent('[img:' + g.media[0].tinygif.url + ']') + '&channel=' + encodeURIComponent(getChannel())
          }).then(fetchMessages);
        });
        gifResults.appendChild(img);
      });
    });
}

function nudge() {
  const panel = document.querySelector('.chat-panel');
  if (!panel) return;
  panel.classList.remove('nudge');
  void panel.offsetWidth;
  panel.classList.add('nudge');
  const audio = document.getElementById('nudge-sound');
  if (audio) {
    audio.currentTime = 0;
    audio.play().catch(() => {});
  }
  setTimeout(() => panel.classList.remove('nudge'), 500);
}

function showCallInfo() {
  const info = document.getElementById('call-info');
  if (!info) return;
  if (callUsers.size === 0) {
    info.textContent = '';
    return;
  }
  info.textContent = 'In call: ' + Array.from(callUsers).join(', ') +
    ' (' + callUsers.size + ')';
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
  const callModal = document.getElementById('call-modal');
  const callClose = document.getElementById('call-close');
  const usersPrev = document.getElementById('users-prev');
  const usersNext = document.getElementById('users-next');
  const emojiPanel = document.getElementById('emoji-panel');
  const uploadBtn = document.getElementById('upload-btn');
  const imageInput = document.getElementById('image-input');
  const gifBtn = document.getElementById('gif-btn');
  const gifPanel = document.getElementById('gif-panel');
  const gifSearch = document.getElementById('gif-search');
  const gifResults = document.getElementById('gif-results');
  const drawBtn = document.getElementById('draw-btn');
  const drawModal = document.getElementById('draw-modal');
  const drawCanvas = document.getElementById('draw-canvas');
  const drawSend = document.getElementById('draw-send');
  const drawClear = document.getElementById('draw-clear');
  const drawClose = document.getElementById('draw-close');
  const callInfo = document.getElementById('call-info');
  window.gifResults = gifResults;

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
    const hasFile = imageInput.files.length > 0;
    const sendText = () => {
      if (!msg) return Promise.resolve();
      return fetch('send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'message=' + encodeURIComponent(msg) + '&channel=' + encodeURIComponent(getChannel())
      });
    };
    const sendImg = () => {
      if (!hasFile) return Promise.resolve();
      const fd = new FormData();
      fd.append('file', imageInput.files[0]);
      return fetch('upload_image.php', { method: 'POST', body: fd })
        .then(r => r.ok ? r.json() : Promise.reject())
        .then(d => fetch('send_message.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'message=' + encodeURIComponent('[img:' + d.url + ']') + '&channel=' + encodeURIComponent(getChannel())
        }));
    };
    Promise.all([sendText(), sendImg()]).then(fetchMessages);
    input.value = '';
    imageInput.value = '';
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
  uploadBtn.addEventListener('click', () => imageInput.click());
  gifBtn.addEventListener('click', () => {
    gifPanel.style.display = gifPanel.style.display === 'block' ? 'none' : 'block';
    if (!gifPanel.dataset.loaded) {
      loadGifs();
      gifPanel.dataset.loaded = '1';
    }
  });
  gifSearch.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      loadGifs(gifSearch.value.trim());
    }
  });
  nudgeBtn.addEventListener('click', () => {
    fetch('send_message.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'message=' + encodeURIComponent('/nudge') + '&channel=' + encodeURIComponent(getChannel())
    }).then(fetchMessages);
    emojiPanel.style.display = 'none';
  });
  drawBtn.addEventListener('click', () => {
    drawModal.classList.add('active');
  });
  drawClose.addEventListener('click', () => {
    drawModal.classList.remove('active');
  });
  drawClear.addEventListener('click', () => {
    const ctx = drawCanvas.getContext('2d');
    ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
  });
  let drawing = false;
  const ctx = drawCanvas.getContext('2d');
  ctx.lineWidth = 2;
  ctx.strokeStyle = '#000';
  drawCanvas.addEventListener('mousedown', e => {
    drawing = true;
    ctx.beginPath();
    ctx.moveTo(e.offsetX, e.offsetY);
  });
  drawCanvas.addEventListener('mousemove', e => {
    if (!drawing) return;
    ctx.lineTo(e.offsetX, e.offsetY);
    ctx.stroke();
  });
  document.addEventListener('mouseup', () => { drawing = false; });
  drawSend.addEventListener('click', () => {
    drawCanvas.toBlob(blob => {
      const fd = new FormData();
      fd.append('file', blob, 'drawing.png');
      fetch('upload_image.php', { method: 'POST', body: fd })
        .then(r => r.ok ? r.json() : Promise.reject())
        .then(d => fetch('send_message.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'message=' + encodeURIComponent('[img:' + d.url + ']') + '&channel=' + encodeURIComponent(getChannel())
        }))
        .then(() => {
          drawModal.classList.remove('active');
          ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
          fetchMessages();
        });
    });
  });
  callBtn.addEventListener('click', () => {
    emojiPanel.style.display = 'none';
    callModal.classList.add('active');
    const start = () => {
      const room = 'Longbridge_' + encodeURIComponent(getChannel());
      jitsiApi = new JitsiMeetExternalAPI('meet.jit.si', {
        roomName: room,
        parentNode: document.getElementById('jitsi-container'),
        userInfo: { displayName: window.currentUser }
      });
      callUsers.clear();
      callUsers.add(window.currentUser);
      showCallInfo();
      jitsiApi.addEventListener('participantJoined', p => {
        if (p.displayName) callUsers.add(p.displayName);
        showCallInfo();
      });
      jitsiApi.addEventListener('participantLeft', p => {
        if (p.displayName) callUsers.delete(p.displayName);
        showCallInfo();
      });
    };
    if (window.JitsiMeetExternalAPI) {
      start();
    } else {
      const s = document.createElement('script');
      s.src = 'https://meet.jit.si/external_api.js';
      s.onload = start;
      document.body.appendChild(s);
    }
  });
  callClose.addEventListener('click', () => {
    if (jitsiApi) {
      jitsiApi.dispose();
      jitsiApi = null;
    }
    callUsers.clear();
    showCallInfo();
    callModal.classList.remove('active');
  });
  usersPrev.addEventListener('click', () => {
    if (usersPage > 1) {
      usersPage--;
      fetchUsers();
    }
  });
  usersNext.addEventListener('click', () => {
    usersPage++;
    fetchUsers();
  });
  fetchMessages();
  fetchUsers();
  setInterval(fetchMessages, 3000);
  setInterval(fetchUsers, 30000);
});

