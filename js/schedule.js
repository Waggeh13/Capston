document.addEventListener('DOMContentLoaded', function () {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const monthYear = document.getElementById('monthYear');
    const datesContainer = document.getElementById('dates');
    const selectedDateElement = document.getElementById('selectedDate');
    const timeSlots = document.querySelectorAll('.time-slot');
    const saveScheduleBtn = document.getElementById('save-schedule');

    let currentDate = new Date();
    let selectedDate = null;

    // Render the calendar
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Set month and year in the header
        monthYear.textContent = `${new Intl.DateTimeFormat('en-US', { month: 'long' }).format(currentDate)} ${year}`;

        // Clear previous dates
        datesContainer.innerHTML = '';

        // Get the first day of the month and the number of days in the month
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Add empty divs for days before the first day of the month
        for (let i = 0; i < firstDay; i++) {
            datesContainer.innerHTML += `<div class="date empty"></div>`;
        }

        // Add dates
        for (let i = 1; i <= daysInMonth; i++) {
            const date = new Date(year, month, i);
            const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();
            datesContainer.innerHTML += `
                <div class="date ${isSelected ? 'selected' : ''}" data-date="${date.toDateString()}">${i}</div>
            `;
        }

        // Add event listeners to dates
        const dateElements = document.querySelectorAll('.date:not(.empty)');
        dateElements.forEach(dateElement => {
            dateElement.addEventListener('click', function () {
                // Set the selected date
                selectedDate = new Date(this.getAttribute('data-date'));
                selectedDateElement.textContent = selectedDate.toDateString();

                // Highlight the selected date
                dateElements.forEach(el => el.classList.remove('selected'));
                this.classList.add('selected');

                // Enable time slots
                timeSlots.forEach(slot => slot.disabled = false);
            });
        });
    }

    // Previous month button
    prevBtn.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    // Next month button
    nextBtn.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // Time Slot Selection
    timeSlots.forEach(slot => {
        slot.addEventListener('click', function () {
            this.classList.toggle('selected');
        });
    });

    // Save Schedule
    saveScheduleBtn.addEventListener('click', function () {
        if (!selectedDate) {
            alert('Please select a date first.');
            return;
        }

        const selectedTimes = Array.from(document.querySelectorAll('.time-slot.selected'))
            .map(slot => slot.getAttribute('data-time'));

        if (selectedTimes.length > 0) {
            alert(`Selected Date: ${selectedDate.toDateString()}\nSelected Times: ${selectedTimes.join(', ')}`);
        } else {
            alert('No times selected!');
        }
    });

    // Disable time slots initially
    timeSlots.forEach(slot => slot.disabled = true);

    // Render the calendar on page load
    renderCalendar();
});