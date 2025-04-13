// Update current date
function updateCurrentDate() {
    const now = new Date();
    const options = { weekday: 'long', month: 'long', day: 'numeric' };
    document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', options);
}

// Modal functions
function openRequestModal(requestId) {
    document.getElementById('requestModal').style.display = 'flex';
}

function openResultsModal(requestId) {
    document.getElementById('resultsModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('requestModal').style.display = 'none';
    document.getElementById('resultsModal').style.display = 'none';
}

function submitResults() {
    alert('Results sent to doctor successfully!');
    closeModal();
}

// Initialize
updateCurrentDate();