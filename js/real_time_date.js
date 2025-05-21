function updateRealTimeDate() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        month: 'long', 
        day: 'numeric' 
    };
    document.getElementById('real-time-date').textContent = now.toLocaleDateString('en-US', options);
}


updateRealTimeDate();


setInterval(updateRealTimeDate, 60000);


function updateRealTimeClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: true 
    });
}
