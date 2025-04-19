function sendMessage(senderId, receiverId) {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    if (!message) return;

    fetch('../actions/send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ sender_id: senderId, receiver_id: receiverId, message: message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => alert('Error sending message: ' + error));
}

document.getElementById('doctorSearch').addEventListener('input', function() {
    const query = this.value.trim();
    if (query.length < 2) {
        document.getElementById('searchResults').style.display = 'none';
        return;
    }

    fetch('../actions/search_users.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: query, user_role: 'Patient' })
    })
    .then(response => response.json())
    .then(data => {
        const resultsDiv = document.getElementById('searchResults');
        resultsDiv.innerHTML = '';
        if (data.success && data.users.length > 0) {
            data.users.forEach(user => {
                const div = document.createElement('div');
                div.className = 'chat-item';
                div.innerHTML = `<div class="chat-item-info">
                    <div class="chat-item-name">${user.name}</div>
                    <div class="chat-item-last-message">Start new chat</div>
                </div>`;
                div.onclick = () => window.location.href = `patient_messages.php?doctor_id=${user.id}`;
                resultsDiv.appendChild(div);
            });
            resultsDiv.style.display = 'block';
        } else {
            resultsDiv.style.display = 'none';
        }
    })
    .catch(error => console.error('Error searching doctors:', error));
});