document.addEventListener('DOMContentLoaded', function() {
    const currentDateElement = document.getElementById('currentDate');
    const prevDayButton = document.getElementById('prevDay');
    const nextDayButton = document.getElementById('nextDay');
    const appointmentsBody = document.getElementById('appointmentsBody');
    
    if (!currentDateElement || !prevDayButton || !nextDayButton || !appointmentsBody) {
        console.error('Required DOM elements not found');
        return;
    }
    
    let currentDate = new Date();
    
    function updateDateDisplay() {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        currentDateElement.textContent = currentDate.toLocaleDateString(undefined, options);
        loadAppointments();
    }
    
    async function loadAppointments() {
        try {
            const dateStr = currentDate.toISOString().split('T')[0];
            console.log('Fetching appointments for date:', dateStr);
            
            const response = await fetch('../actions/get_doctor_appointments.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `date=${encodeURIComponent(dateStr)}`
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Response data:', data);
            
            appointmentsBody.innerHTML = '';
            
            if (data.success && data.appointments && data.appointments.length > 0) {
                data.appointments.forEach(apt => {
                    console.log('Processing appointment:', apt);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${apt.time.slice(0, 5)}</td>
                        <td>
                            <div class="patient-info">
                                <div class="patient-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div>${apt.patient_name}</div>
                                    <div style="font-size: 0.8rem; color: #718096;">ID: ${apt.patient_id}</div>
                                </div>
                            </div>
                        </td>
                        <td>${new Date(apt.date).toLocaleDateString()}</td>
                        <td>${apt.appointment_type}</td>
                        <td>${apt.clinic_name}</td>
                        <td>
                            <select class="status-dropdown" data-booking-id="${apt.booking_id}">
                                <option value="Scheduled" ${apt.status === 'Scheduled' ? 'selected' : ''}>Scheduled</option>
                                <option value="Completed" ${apt.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                <option value="Cancelled" ${apt.status === 'Cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </td>
                    `;
                    appointmentsBody.appendChild(row);
                });
                
                document.querySelectorAll('.status-dropdown').forEach(select => {
                    function updateColor(dropdown) {
                        let color = {
                            "Scheduled": "blue",
                            "Completed": "green",
                            "Cancelled": "red"
                        }[dropdown.value] || "black";
                        dropdown.style.color = color;
                    }
                    updateColor(select);
                    select.addEventListener('change', function() {
                        updateColor(this);
                        const bookingId = this.getAttribute('data-booking-id');
                        const status = this.value;
                        console.log('Updating status:', { bookingId, status });
                        fetch('../actions/update_appointment_status.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `booking_id=${bookingId}&status=${status}`
                        }).then(res => res.text()).then(text => {
                            console.log('Status update response:', text);
                        }).catch(err => {
                            console.error('Status update error:', err);
                        });
                    });
                });
            } else {
                console.log('No appointments found for date:', dateStr);
                appointmentsBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            No appointments scheduled
                        </td>
                    </tr>
                `;
            }
        } catch (error) {
            console.error('Error loading appointments:', error);
            appointmentsBody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">
                    Error loading appointments
                </td>
                </tr>
            `;
        }
    }
    
    prevDayButton.addEventListener('click', function() {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDateDisplay();
    });
    
    nextDayButton.addEventListener('click', function() {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDateDisplay();
    });
    
    updateDateDisplay();
});