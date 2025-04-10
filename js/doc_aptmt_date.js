document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const currentDateElement = document.getElementById('currentDate');
    const prevDayButton = document.getElementById('prevDay');
    const nextDayButton = document.getElementById('nextDay');
    
    // Initialize with current date
    let currentDate = new Date();
    
    // Function to update the displayed date
    function updateDateDisplay() {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        currentDateElement.textContent = currentDate.toLocaleDateString(undefined, options);
        
        // Update the time every minute (optional)
        updateTime();
    }
    
    // Function to update time (optional)
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        document.querySelector('.header div').innerHTML = `<i class="fas fa-calendar-alt"></i> ${currentDateElement.textContent} | ${timeString}`;
    }
    
    // Event listeners for navigation
    prevDayButton.addEventListener('click', function() {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDateDisplay();
    });
    
    nextDayButton.addEventListener('click', function() {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDateDisplay();
    });
    
    // Initialize display
    updateDateDisplay();
    
    // Update time every minute (optional)
    setInterval(updateTime, 60000);
    
    // Also update the header time immediately
    updateTime();
});