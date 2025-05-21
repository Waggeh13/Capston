const userRole = document.body.dataset.userRole || 'Doctor';

function sendMessage(senderId, receiverId) {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    if (!message) return;

    console.log('Sending message:', { senderId, receiverId, message, userRole });
    fetch('../actions/send_message_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ sender_id: senderId, receiver_id: receiverId, message: message })
    })
    .then(response => {
        console.log('Send message response status:', response.status);
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Send message response:', data);
        if (data.success) {
            input.value = '';
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Send message error:', error);
        alert('Error sending message: ' + error);
    });
}

document.getElementById('patientSearch').addEventListener('input', function() {
    const query = this.value.trim();
    console.log('Search query:', query);
    const resultsDiv = document.getElementById('searchResults');
    if (query.length < 2) {
        resultsDiv.style.display = 'none';
        resultsDiv.innerHTML = '';
        return;
    }

    const searchUrl = '../actions/search_user_action.php';
    console.log('Sending search request:', { query, user_role: userRole, url: searchUrl });
    fetch(searchUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: query, user_role: userRole })
    })
    .then(response => {
        console.log('Search response status:', response.status);
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Search response:', data);
        resultsDiv.innerHTML = '';
        if (data.success && data.users && Array.isArray(data.users) && data.users.length > 0) {
            data.users.forEach(user => {
                const div = document.createElement('div');
                div.className = 'chat-item';
                div.innerHTML = `<div class="chat-item-info">
                    <div class="chat-item-name">${user.name || 'Unknown'}</div>
                    <div class="chat-item-last-message">Start new chat</div>
                </div>`;
                div.onclick = () => window.location.href = userRole === 'Patient' ? 
                    `patient_message.php?doctor_id=${user.id}` : 
                    `doc_message.php?patient_id=${user.id}`;
                resultsDiv.appendChild(div);
            });
            resultsDiv.style.display = 'block';
        } else {
            resultsDiv.innerHTML = `<div class="chat-item">${data.error || 'No results found'}</div>`;
            resultsDiv.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Search error:', error);
        resultsDiv.innerHTML = `<div class="chat-item">Error searching users: ${error.message}</div>`;
        resultsDiv.style.display = 'block';
    });
});