document.addEventListener('DOMContentLoaded', function () {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const monthYear = document.getElementById('monthYear');
    const datesContainer = document.getElementById('dates');
    const selectedDateElement = document.getElementById('selected-date');
    const timeSlots = document.querySelectorAll('.time-slot');
    const saveScheduleBtn = document.getElementById('save-schedule');
    const scheduleList = document.getElementById('schedule-list');

    let currentDate = new Date();
    let selectedDate = null;
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        monthYear.textContent = `${new Intl.DateTimeFormat('en-US', { month: 'long' }).format(currentDate)} ${year}`;
        datesContainer.innerHTML = '';

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDayAdjusted = (firstDay + 6) % 7;

        for (let i = 0; i < firstDayAdjusted; i++) {
            datesContainer.innerHTML += `<div class="date empty"></div>`;
        }

        for (let i = 1; i <= daysInMonth; i++) {
            const date = new Date(year, month, i);
            const isToday = date.toDateString() === today.toDateString();
            const isPast = date < today;
            const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();
            datesContainer.innerHTML += `
                <div class="date ${isToday ? 'today' : ''} ${isPast ? 'disabled' : ''} ${isSelected ? 'selected' : ''}" 
                     data-date="${date.toDateString()}">${i}</div>
            `;
        }

        const dateElements = document.querySelectorAll('.date:not(.empty):not(.disabled)');
        dateElements.forEach(dateElement => {
            dateElement.addEventListener('click', function () {
                selectedDate = new Date(this.getAttribute('data-date'));
                selectedDateElement.textContent = selectedDate.toDateString();
                document.querySelectorAll('.date').forEach(el => el.classList.remove('selected'));
                this.classList.add('selected');
                timeSlots.forEach(slot => slot.disabled = false);
                timeSlots.forEach(slot => slot.classList.remove('selected'));
                
                // Load existing schedule for selected date
                loadExistingSchedule(selectedDate);
            });
        });

        if (currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear()) {
            const todayElement = document.querySelector('.date.today');
            if (todayElement && !selectedDate) {
                todayElement.click();
            }
        }
    }

    function loadExistingSchedule(date) {
        const formattedDate = date.toISOString().split('T')[0];
        
        fetch('actions/doc_schedule_action.php?action=get&date=' + formattedDate)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.schedule) {
                    // Clear all selected time slots
                    timeSlots.forEach(slot => slot.classList.remove('selected'));
                    
                    // Mark the existing time slots as selected
                    data.schedule.forEach(time => {
                        const timeSlot = document.querySelector(`.time-slot[data-time="${time}"]`);
                        if (timeSlot) {
                            timeSlot.classList.add('selected');
                        }
                    });
                    
                    updateScheduleList(date, data.schedule);
                }
            })
            .catch(error => {
                console.error('Error loading schedule:', error);
            });
    }

    function updateScheduleList(date, times) {
        if (times && times.length > 0) {
            scheduleList.innerHTML = `<li>${date.toDateString()}: ${times.join(', ')}</li>`;
        } else {
            scheduleList.innerHTML = '';
        }
    }

    prevBtn.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextBtn.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    timeSlots.forEach(slot => {
        slot.addEventListener('click', function () {
            if (!this.disabled) {
                this.classList.toggle('selected');
            }
        });
    });

    saveScheduleBtn.addEventListener('click', function () {
        if (!selectedDate) {
            alert('Please select a date first.');
            return;
        }

        const selectedTimes = Array.from(document.querySelectorAll('.time-slot.selected'))
            .map(slot => slot.getAttribute('data-time'));

        // Format date for database (YYYY-MM-DD)
        const formattedDate = selectedDate.toISOString().split('T')[0];
        
        // Create FormData object to send data
        const formData = new FormData();
        formData.append('action', 'save');
        formData.append('date', formattedDate);
        formData.append('times', JSON.stringify(selectedTimes));

        // Send to backend
        fetch('../actions/doc_schedule_action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateScheduleList(selectedDate, selectedTimes);
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the schedule.');
        });
    });

    timeSlots.forEach(slot => slot.disabled = true);
    renderCalendar();
});