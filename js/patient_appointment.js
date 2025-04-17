document.addEventListener('DOMContentLoaded', function() {
    const addAppointmentModal = document.getElementById('addAppointmentModal');
    const editAppointmentModal = document.getElementById('editAppointmentModal');
    const confirmModal = document.getElementById('confirmModal');
    const addAppointmentForm = document.getElementById('addAppointmentForm');
    const editAppointmentForm = document.getElementById('editAppointmentForm');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');
    const addAppointmentCancelBtn = document.getElementById('addAppointmentCancelBtn');
    const editAppointmentCancelBtn = document.getElementById('editAppointmentCancelBtn');
    const confirmCancelNoBtn = document.getElementById('confirmCancelNoBtn');
    const appointmentsBody = document.getElementById('appointmentsBody');
    const addAppointmentBtn = document.getElementById('addAppointmentBtn');
    const addDoctorSelect = document.getElementById('addDoctorName');
    const addDateSelect = document.getElementById('addAppointmentDate');
    const addTimeSelect = document.getElementById('addAppointmentTime');
    const editDoctorSelect = document.getElementById('editDoctorName');
    const editDateSelect = document.getElementById('editAppointmentDate');
    const editTimeSelect = document.getElementById('editAppointmentTime');
    let currentAppointmentId = null;

    if (!addAppointmentModal || !editAppointmentModal || !confirmModal || !addAppointmentForm || 
        !editAppointmentForm || !appointmentsBody || !addAppointmentBtn || 
        !addDoctorSelect || !addDateSelect || !addTimeSelect || 
        !editDoctorSelect || !editDateSelect || !editTimeSelect ||
        !addAppointmentCancelBtn || !editAppointmentCancelBtn || !confirmCancelBtn || !confirmCancelNoBtn) {
        return;
    }

    // Bind click events for modal buttons
    addAppointmentBtn.addEventListener('click', openAddAppointmentModal);
    addAppointmentCancelBtn.addEventListener('click', closeAddAppointmentModal);
    editAppointmentCancelBtn.addEventListener('click', closeEditAppointmentModal);
    confirmCancelNoBtn.addEventListener('click', closeConfirmModal);
    confirmCancelBtn.addEventListener('click', confirmCancelAppointment);

    // Load appointments on page load
    loadAppointments();

    // Fetch available dates for a doctor
    async function populateDates(selectElement, staffId) {
        if (!selectElement || !staffId) return;
        try {
            const response = await fetch('../actions/get_doctor_dates.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `staff_id=${encodeURIComponent(staffId)}`
            });
            const data = await response.json();
            selectElement.innerHTML = '<option value="">Select a date</option>';
            if (data.success && data.dates) {
                data.dates.forEach(date => {
                    const option = document.createElement('option');
                    option.value = date;
                    option.textContent = new Date(date).toLocaleDateString();
                    selectElement.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error populating dates:', error);
        }
    }

    // Fetch available times for a doctor and date
    async function populateTimes(doctorSelect, dateSelect, timeSelect) {
        if (!doctorSelect || !dateSelect || !timeSelect) return;
        const staffId = doctorSelect.value;
        const date = dateSelect.value;
        if (staffId && date) {
            try {
                const response = await fetch('../actions/get_doctor_times.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `staff_id=${encodeURIComponent(staffId)}&date=${encodeURIComponent(date)}`
                });
                const data = await response.json();
                timeSelect.innerHTML = '<option value="">Select a time</option>';
                if (data.success && data.times) {
                    data.times.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time.timeslot_id;
                        option.textContent = time.time_slot.slice(0, 5);
                        timeSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error populating times:', error);
            }
        } else {
            timeSelect.innerHTML = '<option value="">Select a time</option>';
        }
    }

    // Load patient appointments
    async function loadAppointments() {
        try {
            const response = await fetch('../actions/patient_get_appointments.php');
            const data = await response.json();
            appointmentsBody.innerHTML = '';
            if (data.success && Array.isArray(data.appointments) && data.appointments.length > 0) {
                const currentDateTime = new Date(); // For logging purposes
                data.appointments.forEach(apt => {
                    // Normalize data
                    const dateTime = apt.date && apt.time ? `${new Date(apt.date).toLocaleDateString()} - ${apt.time.slice(0, 5)}` : 'N/A';
                    const appointmentDateTime = new Date(`${apt.date} ${apt.time}`);
                    const clinicName = apt.clinic_name || 'Unknown';
                    const doctorName = apt.doctor_name || 'Unknown';
                    const appointmentType = apt.appointment_type === 'in-person' ? 'In-person' : apt.appointment_type || 'Unknown';
                    const status = apt.status || 'Pending';
                    const bookingId = apt.booking_id || '';

                    // Log status for debugging
                    console.log(`Appointment ID: ${bookingId}, Date: ${dateTime}, Status: ${status}, Is Past: ${appointmentDateTime < currentDateTime}`);

                    const statusClass = {
                        'Scheduled': 'badge-confirmed',
                        'Completed': 'badge-completed',
                        'Cancelled': 'badge-cancelled'
                    }[status] || 'badge-pending';
                    const statusColor = {
                        'Scheduled': 'blue',
                        'Completed': 'green',
                        'Cancelled': 'red'
                    }[status] || 'black';
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${dateTime}</td>
                        <td>${clinicName}</td>
                        <td>${doctorName}</td>
                        <td>${appointmentType}</td>
                        <td><span class="badge ${statusClass}" style="color: ${statusColor}">${status}</span></td>
                        <td>
                            <button class="action-btn edit-btn" data-id="${bookingId}" title="Edit" ${status === 'Cancelled' ? 'disabled' : ''}>
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn cancel-btn" data-id="${bookingId}" title="Cancel" ${status === 'Cancelled' ? 'disabled' : ''}>
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    `;
                    appointmentsBody.appendChild(row);
                });
                // Bind events after rows are added
                bindActionButtons();
            } else {
                appointmentsBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            ${data.success ? 'No appointments found' : 'No appointments available'}
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

    // Bind edit and cancel button events
    function bindActionButtons() {
        const editButtons = document.querySelectorAll('.edit-btn');
        const cancelButtons = document.querySelectorAll('.cancel-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (id) editAppointment(id);
            });
        });
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (id) cancelAppointment(id);
            });
        });
    }

    // Open add appointment modal
    function openAddAppointmentModal() {
        addAppointmentForm.reset();
        addDateSelect.innerHTML = '<option value="">Select a date</option>';
        addTimeSelect.innerHTML = '<option value="">Select a time</option>';
        addAppointmentModal.style.display = 'block';
    }

    // Open edit appointment modal
    async function editAppointment(id) {
        currentAppointmentId = id;
        try {
            const response = await fetch('../actions/patient_get_appointment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `booking_id=${id}`
            });
            const data = await response.json();
            if (data.success && data.appointment) {
                const apt = data.appointment;
                document.getElementById('editBookingId').value = apt.booking_id || '';
                editDoctorSelect.value = apt.staff_id || '';

                await populateDates(editDateSelect, apt.staff_id);
                editDateSelect.value = apt.date || '';

                await populateTimes(editDoctorSelect, editDateSelect, editTimeSelect);

                const timeOptions = Array.from(editTimeSelect.options).map(opt => opt.value);
                editTimeSelect.value = timeOptions.includes(apt.timeslot_id) ? apt.timeslot_id : '';
                
                const appointmentType = apt.appointment_type === 'in-person' ? 'inPerson' : apt.appointment_type || '';
                document.getElementById('editAppointmentType').value = appointmentType;
                document.getElementById('editClinic').value = apt.clinic_id || '';
                editAppointmentModal.style.display = 'block';
            } else {
                alert('Error fetching appointment details: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error fetching appointment details:', error);
            alert('Error fetching appointment details');
        }
    }

    // Open confirmation modal for cancellation
    function cancelAppointment(id) {
        currentAppointmentId = id;
        confirmModal.style.display = 'block';
    }

    // Close modals
    function closeAddAppointmentModal() {
        addAppointmentModal.style.display = 'none';
    }

    function closeEditAppointmentModal() {
        editAppointmentModal.style.display = 'none';
    }

    function closeConfirmModal() {
        confirmModal.style.display = 'none';
    }

    // Handle add appointment form submission
    addAppointmentForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(addAppointmentForm);
        const timeslotId = addTimeSelect.value;
        formData.append('timeslot_id', timeslotId);
        try {
            const response = await fetch('../actions/patient_book_appointment.php', {
                method: 'POST',
                body: formData
            });
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = JSON.parse(await response.text());
            if (data.success) {
                alert(data.message);
                closeAddAppointmentModal();
                await loadAppointments();
            } else if (data.redirect) {
                alert(data.message);
                window.location.href = data.redirect; // Redirect to Zoom OAuth
            } else {
                alert(data.message || 'Failed to book appointment: Unknown error');
            }
        } catch (error) {
            console.error('Error booking appointment:', error);
            alert(`Error booking appointment: ${error.message}`);
        }
    });

    // Handle edit appointment form submission
    editAppointmentForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(editAppointmentForm);
        const timeslotId = editTimeSelect.value;
        formData.append('timeslot_id', timeslotId);
        try {
            const response = await fetch('../actions/patient_update_appointment.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                alert(data.message);
                closeEditAppointmentModal();
                await loadAppointments();
            } else {
                alert(data.message || 'Failed to update appointment');
            }
        } catch (error) {
            console.error('Error updating appointment:', error);
            alert('Error updating appointment');
        }
    });

    // Handle cancellation confirmation
    async function confirmCancelAppointment() {
        try {
            const response = await fetch('../actions/patient_delete_appointment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `booking_id=${currentAppointmentId}`
            });
            const data = await response.json();
            if (data.success) {
                alert(data.message);
                closeConfirmModal();
                await loadAppointments();
            } else {
                alert(data.message || 'Failed to cancel appointment');
            }
        } catch (error) {
            console.error('Error cancelling appointment:', error);
            alert('Error cancelling appointment');
        }
    }

    // Populate dates when doctor changes
    addDoctorSelect.addEventListener('change', function() {
        addDateSelect.innerHTML = '<option value="">Select a date</option>';
        addTimeSelect.innerHTML = '<option value="">Select a time</option>';
        if (this.value) {
            populateDates(addDateSelect, this.value);
        }
    });

    editDoctorSelect.addEventListener('change', function() {
        editDateSelect.innerHTML = '<option value="">Select a date</option>';
        editTimeSelect.innerHTML = '<option value="">Select a time</option>';
        if (this.value) {
            populateDates(editDateSelect, this.value);
        }
    });

    // Populate times when date changes
    addDateSelect.addEventListener('change', function() {
        populateTimes(addDoctorSelect, addDateSelect, addTimeSelect);
    });

    editDateSelect.addEventListener('change', function() {
        populateTimes(editDoctorSelect, editDateSelect, editTimeSelect);
    });

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === addAppointmentModal) {
            closeAddAppointmentModal();
        }
        if (event.target === editAppointmentModal) {
            closeEditAppointmentModal();
        }
        if (event.target === confirmModal) {
            closeConfirmModal();
        }
    });
});