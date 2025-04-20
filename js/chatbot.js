async function sendMessage() {
    const input = document.getElementById('chatbotInput');
    const message = input.value.trim();
    if (!message) return;

    const messages = document.querySelector('.chatbot-messages');

    // Append user's message
    const sentMessage = document.createElement('div');
    sentMessage.className = 'message sent';
    sentMessage.innerHTML = `<div class="message-content">${message}</div>`;
    messages.appendChild(sentMessage);
    input.value = '';
    messages.scrollTop = messages.scrollHeight;

    try {
        // Send request to PHP proxy
        const response = await fetch('../actions/openai_proxy.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        if (data.error) {
            throw new Error(data.error);
        }

        const botMessage = data.reply;

        // Append bot's response
        const responseDiv = document.createElement('div');
        responseDiv.className = 'message received';
        responseDiv.innerHTML = `<div class="message-content">${botMessage}</div>`;
        messages.appendChild(responseDiv);
        messages.scrollTop = messages.scrollHeight;

    } catch (error) {
        console.error('Error:', error.message);
        const errorMessage = document.createElement('div');
        errorMessage.className = 'message received';
        errorMessage.innerHTML = `<div class="message-content">Sorry, something went wrong. Please try again later.</div>`;
        messages.appendChild(errorMessage);
        messages.scrollTop = messages.scrollHeight;
    }
}

// Handle Enter key
document.getElementById('chatbotInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') sendMessage();
});