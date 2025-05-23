async function sendMessage() {
    const input = document.getElementById('chatbotInput');
    const message = input.value.trim();
    if (!message) return;

    const messages = document.querySelector('.chatbot-messages');

    const sentMessage = document.createElement('div');
    sentMessage.className = 'message sent';
    sentMessage.innerHTML = `<div class="message-content">${message}</div>`;
    messages.appendChild(sentMessage);
    input.value = '';
    messages.scrollTop = messages.scrollHeight;

    try {
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

        const responseDiv = document.createElement('div');
        responseDiv.className = 'message received';
        responseDiv.innerHTML = `<div class="message-content">${botMessage}</div>`;
        messages.appendChild(responseDiv);
        messages.scrollTop = messages.scrollHeight;

    } catch (error) {
        const errorMessage = document.createElement('div');
        errorMessage.className = 'message received';
        errorMessage.innerHTML = `<div class="message-content">Sorry, something went wrong. Please try again later.</div>`;
        messages.appendChild(errorMessage);
        messages.scrollTop = messages.scrollHeight;
    }
}

document.getElementById('chatbotInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') sendMessage();
});