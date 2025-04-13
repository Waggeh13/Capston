// Function to update the date display
function updateRealTimeDate() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        month: 'long', 
        day: 'numeric' 
    };
    document.getElementById('real-time-date').textContent = now.toLocaleDateString('en-US', options);
}

// Update immediately when page loads
updateRealTimeDate();

// Update every minute (to handle day changes at midnight)
setInterval(updateRealTimeDate, 60000);

// Optional: Add real-time clock if desired
function updateRealTimeClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: true 
    });
    // Uncomment if you want to add time to your display:
    // document.getElementById('real-time-date').textContent += ` | ${timeString}`;
}

// Uncomment these if you want the time displayed:
// updateRealTimeClock();
// setInterval(updateRealTimeClock, 60000);