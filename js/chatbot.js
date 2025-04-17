function sendMessage() {
    const input = document.getElementById('chatbotInput');
    const message = input.value.trim();
    if (!message) return;

    const messages = document.querySelector('.chatbot-messages');
    const sentMessage = document.createElement('div');
    sentMessage.className = 'message sent';
    sentMessage.innerHTML = `<div class="message-content">${message}</div>`;
    messages.appendChild(sentMessage);

    // Placeholder for chatbot response
    setTimeout(() => {
        const response = document.createElement('div');
        response.className = 'message received';
        response.innerHTML = `<div class="message-content">I'm processing your request: "${message}". Please provide more details or ask another question.</div>`;
        messages.appendChild(response);
        messages.scrollTop = messages.scrollHeight;
    }, 1000);

    input.value = '';
    messages.scrollTop = messages.scrollHeight;
}

// Handle Enter key
document.getElementById('chatbotInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') sendMessage();
});