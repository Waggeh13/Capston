document.addEventListener('DOMContentLoaded', () => {
    const addItemBtn = document.getElementById('addItemBtn');
    const addItemForm = document.getElementById('addItemForm');
    const editItemForm = document.getElementById('editItemForm');
    const overlay = document.getElementById('overlay');
    const cancelAddItem = document.getElementById('cancelAddItem');
    const cancelEditItem = document.getElementById('cancelEditItem');
    const doctorSelect = document.getElementById('doctorName');
    const dateSelect = document.getElementById('appointmentDate');
    const timeSelect = document.getElementById('appointmentTime');
    const editDoctorSelect = document.getElementById('editdoctorName');
    const editDateSelect = document.getElementById('editappointmentDate');
    const editTimeSelect = document.getElementById('editappointmentTime');

    if (!addItemBtn || !addItemForm || !editItemForm || !overlay || !cancelAddItem || !cancelEditItem) {
        return;
    }
    if (!doctorSelect || !dateSelect || !timeSelect || !editDoctorSelect || !editDateSelect || !editTimeSelect) {
        return;
    }

    async function loadAppointments() {
        try {
            const response = await fetch('../actions/get_appointments.php');
            const data = JSON.parse(await response.text());
            const tbody = document.querySelector('.available tbody');
            if (!tbody) {
                return;
            }
            tbody.innerHTML = '';
            if (data.success && data.appointments) {
                data.appointments.forEach(apt => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${apt.patient_name}</td>
                        <td>${apt.doctor_name}</td>
                        <td>${new Date(apt.date).toLocaleDateString()}</td>
                        <td>${apt.time.slice(0, 5)}</td>
                        <td>${apt.appointment_type}</td>
                        <td>${apt.clinic_name}</td>
                        <td>
                            <select class="status-dropdown" data-booking-id="${apt.booking_id}">
                                <option value="Scheduled" ${apt.status === 'Scheduled' ? 'selected' : ''}>Scheduled</option>
                                <option value="Completed" ${apt.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                <option value="Cancelled" ${apt.status === 'Cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </td>
                        <td>
                            <i class="far fa-edit editItemBtn" data-booking-id="${apt.booking_id}"></i>
                            <i class="far fa-trash-alt deleteItemBtn" data-booking-id="${apt.booking_id}"></i>
                        </td>
                    `;
                    tbody.appendChild(row);
                });

                document.querySelectorAll('.status-dropdown').forEach(select => {
                    select.addEventListener('change', async function() {
                        const bookingId = this.getAttribute('data-booking-id');
                        const status = this.value;
                        try {
                            const response = await fetch('../actions/update_appointment_status.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: `booking_id=${bookingId}&status=${status}`
                            });
                            await response.text();
                            updateColor(this);
                        } catch (error) {}
                    });
                    updateColor(select);
                });
            }
        } catch (error) {}
    }

    function updateColor(dropdown) {
        let color = {
            "Scheduled": "blue",
            "Completed": "green",
            "Cancelled": "red"
        }[dropdown.value] || "black";
        dropdown.style.color = color;
    }

    addItemBtn.addEventListener('click', () => {
        addItemForm.classList.add('active');
        overlay.classList.add('active');
    });

    async function populateDates(selectElement, staffId) {
        if (!selectElement) {
            return;
        }
        try {
            const response = await fetch('../actions/get_doctor_dates.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `staff_id=${staffId}`
            });
            const data = JSON.parse(await response.text());
            selectElement.innerHTML = '<option value="">Select a date</option>';
            if (data.success && data.dates) {
                data.dates.forEach(date => {
                    const option = document.createElement('option');
                    option.value = date;
                    option.textContent = new Date(date).toLocaleDateString();
                    selectElement.appendChild(option);
                });
            }
        } catch (error) {}
    }

    async function populateTimes(doctorSelect, dateSelect, timeSelect) {
        if (!doctorSelect || !dateSelect || !timeSelect) {
            return;
        }
        const staffId = doctorSelect.value;
        const date = dateSelect.value;
        if (staffId && date) {
            try {
                const response = await fetch('../actions/get_doctor_times.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `staff_id=${staffId}&date=${date}`
                });
                const data = JSON.parse(await response.text());
                timeSelect.innerHTML = '<option value="">Select a time</option>';
                if (data.success && data.times) {
                    data.times.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time.time_slot;
                        option.textContent = time.time_slot.slice(0, 5);
                        option.dataset.timeslotId = time.timeslot_id;
                        timeSelect.appendChild(option);
                    });
                }
            } catch (error) {}
        } else {
            timeSelect.innerHTML = '<option value="">Select a time</option>';
        }
    }

    doctorSelect.addEventListener('change', () => {
        dateSelect.innerHTML = '<option value="">Select a date</option>';
        timeSelect.innerHTML = '<option value="">Select a time</option>';
        if (doctorSelect.value) {
            populateDates(dateSelect, doctorSelect.value);
        }
    });

    editDoctorSelect.addEventListener('change', () => {
        editDateSelect.innerHTML = '<option value="">Select a date</option>';
        editTimeSelect.innerHTML = '<option value="">Select a time</option>';
        if (editDoctorSelect.value) {
            populateDates(editDateSelect, editDoctorSelect.value);
        }
    });

    dateSelect.addEventListener('change', () => populateTimes(doctorSelect, dateSelect, timeSelect));
    editDateSelect.addEventListener('change', () => populateTimes(editDoctorSelect, editDateSelect, editTimeSelect));

    document.addEventListener('click', async (e) => {
        if (e.target.classList.contains('editItemBtn')) {
            const bookingId = e.target.getAttribute('data-booking-id');
            try {
                const response = await fetch('../actions/get_appointment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `booking_id=${bookingId}`
                });
                const data = JSON.parse(await response.text());
                if (data.success && data.appointment) {
                    const apt = data.appointment;
                    document.getElementById('editBookingId').value = apt.booking_id;
                    document.getElementById('editpatientName').value = apt.patient_name;
                    editDoctorSelect.value = apt.staff_id;

                    await populateDates(editDateSelect, apt.staff_id);
                    editDateSelect.value = apt.date;

                    await populateTimes(editDoctorSelect, editDateSelect, editTimeSelect);

                    const timeOptions = Array.from(editTimeSelect.options).map(opt => opt.value);
                    if (timeOptions.includes(apt.time)) {
                        editTimeSelect.value = apt.time;
                    } else {
                        editTimeSelect.value = '';
                    }

                    const appointmentType = apt.appointment_type.toLowerCase() === 'in-person' ? 'inPerson' : 'virtual';
                    const radio = document.querySelector(`input[name="appointmentType"][value="${appointmentType}"]`);
                    if (radio) {
                        radio.checked = true;
                    }

                    document.getElementById('editclinic').value = apt.clinic_id;
                    editItemForm.classList.add('active');
                    overlay.classList.add('active');
                } else {
                    alert('Error loading appointment data: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                alert('Error loading appointment data: ' + error.message);
            }
        }
    });

    document.addEventListener('click', async (e) => {
        if (e.target.classList.contains('deleteItemBtn')) {
            const bookingId = e.target.getAttribute('data-booking-id');
            if (confirm('Are you sure you want to delete this appointment?')) {
                try {
                    const response = await fetch('../actions/delete_appointment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `booking_id=${bookingId}`
                    });
                    const data = JSON.parse(await response.text());
                    if (data.success) {
                        alert(data.message);
                        loadAppointments();
                    } else {
                        alert(data.message);
                    }
                } catch (error) {
                    alert('Error deleting appointment: ' + error.message);
                }
            }
        }
    });

    cancelAddItem.addEventListener('click', () => {
        addItemForm.classList.remove('active');
        overlay.classList.remove('active');
    });

    cancelEditItem.addEventListener('click', () => {
        editItemForm.classList.remove('active');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        addItemForm.classList.remove('active');
        editItemForm.classList.remove('active');
        overlay.classList.remove('active');
    });

    document.getElementById('addItem').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = document.getElementById('addItem');
        const formData = new FormData(form);
        if (timeSelect.selectedIndex > 0) {
            formData.append('timeslot_id', timeSelect.options[timeSelect.selectedIndex].dataset.timeslotId);
        }
        try {
            const response = await fetch('../actions/add_appointment.php', {
                method: 'POST',
                body: formData
            });
            const data = JSON.parse(await response.text());
            if (data.success) {
                alert(data.message);
                form.reset();
                addItemForm.classList.remove('active');
                overlay.classList.remove('active');
                loadAppointments();
            } else {
                alert(data.message);
            }
        } catch (error) {
            alert('Error adding appointment: ' + error.message);
        }
    });

    document.getElementById('editItem').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = document.getElementById('editItem');
        const formData = new FormData(form);
        if (editTimeSelect.selectedIndex > 0) {
            formData.append('timeslot_id', editTimeSelect.options[editTimeSelect.selectedIndex].dataset.timeslotId);
        }
        try {
            const response = await fetch('../actions/update_appointment.php', {
                method: 'POST',
                body: formData
            });
            const data = JSON.parse(await response.text());
            if (data.success) {
                alert(data.message);
                editItemForm.classList.remove('active');
                overlay.classList.remove('active');
                loadAppointments();
            } else {
                alert(data.message);
            }
        } catch (error) {
            alert('Error updating appointment: ' + error.message);
        }
    });

    loadAppointments();
});