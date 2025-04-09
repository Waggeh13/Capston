const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentDate = new Date();
const today = new Date();
today.setHours(0, 0, 0, 0); // Normalize today for comparison

const updateCalender = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = (firstDay.getDay() + 6) % 7; // Monday as 0
    const lastDayIndex = (lastDay.getDay() + 6) % 7;

    // Set month and year
    const monthYearString = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';

    // Previous month's trailing days
    for (let i = firstDayIndex; i > 0; i--) {
        const prevDate = new Date(currentYear, currentMonth, 0 - i + 1);
        datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
    }

    // Current month's days
    for (let i = 1; i <= totalDays; i++) {
        const date = new Date(currentYear, currentMonth, i);
        const isToday = date.toDateString() === today.toDateString();
        const isPast = date < today;
        const activeClass = isToday ? 'today' : '';
        const disabledClass = isPast ? 'disabled' : '';
        datesHTML += `<div class="date ${activeClass} ${disabledClass}">${i}</div>`;
    }

    // Next month's leading days
    for (let i = 1; i <= 6 - lastDayIndex; i++) {
        const nextDate = new Date(currentYear, currentMonth + 1, i);
        datesHTML += `<div class="date inactive">${nextDate.getDate()}</div>`;
    }

    datesElement.innerHTML = datesHTML;
};

// Navigation buttons
prevBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalender();
});

nextBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalender();
});

// Initialize the calendar
updateCalender();