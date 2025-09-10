document.addEventListener('DOMContentLoaded', () => {
  const textarea   = document.getElementById('chat-textarea');
  const sendBtn    = document.getElementById('send-btn');
  const messagesEl = document.getElementById('chat-messages');

  function escapeHTML(str) {
    return String(str || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;')
      .replace(/\n/g, '<br>');
  }

  function appendMessage(text, type) {
    const div = document.createElement('div');
    div.className = `message ${type}`;
    div.innerHTML = escapeHTML(text);
    messagesEl.appendChild(div);
    messagesEl.scrollTop = messagesEl.scrollHeight;
  }

  async function sendMessage() {
    const raw = textarea.value;
    const message = raw.trim();
    if (!message) return;

    appendMessage(raw, 'user');
    textarea.value = '';
    sendBtn.disabled = true;

    try {
      const res = await fetch('chat_bot.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message })
      });
      const data = await res.json();
      appendMessage(data.reply || 'No reply', 'bot');
    } catch (err) {
      appendMessage('Simulated reply for: ' + message, 'bot');
    } finally {
      sendBtn.disabled = false;
    }
  }

  sendBtn.addEventListener('click', sendMessage);
  textarea.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });
});
