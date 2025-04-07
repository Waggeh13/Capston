// Sample data for doctors by clinic
const doctorsByClinic = {
    cardiology: [
        { id: 1, name: "Dr. John Smith" },
        { id: 2, name: "Dr. Emily Wilson" }
    ],
    dermatology: [
        { id: 3, name: "Dr. Sarah Johnson" },
        { id: 4, name: "Dr. Robert Chen" }
    ],
    general: [
        { id: 5, name: "Dr. Michael Brown" },
        { id: 6, name: "Dr. Jessica Lee" }
    ],
    pediatrics: [
        { id: 7, name: "Dr. David Miller" },
        { id: 8, name: "Dr. Olivia Davis" }
    ]
};

// Current appointment being edited/cancelled
let currentAppointmentId = null;

// DOM elements
const appointmentModal = document.getElementById('appointmentModal');
const confirmModal = document.getElementById('confirmModal');
const appointmentForm = document.getElementById('appointmentForm');
const modalTitle = document.getElementById('modalTitle');
const confirmCancelBtn = document.getElementById('confirmCancelBtn');

// Open appointment modal for new appointment
function openAppointmentModal() {
    document.getElementById('appointmentId').value = '';
    document.getElementById('patientName').value = 'John Doe'; // Pre-fill with current user
    document.getElementById('clinic').value = '';
    document.getElementById('doctor').innerHTML = '<option value="">Select a doctor</option>';
    document.getElementById('appointmentDate').value = '';
    document.getElementById('appointmentTime').value = '';
    document.getElementById('appointmentType').value = '';
    document.getElementById('notes').value = '';
    modalTitle.textContent = 'New Appointment';
    appointmentModal.style.display = 'block';
}

// Open appointment modal for editing
function editAppointment(id) {
    currentAppointmentId = id;
    
    // In a real app, you would fetch the appointment data from your database
    // Here we're just simulating with sample data
    const appointment = {
        id: id,
        patientName: 'John Doe',
        clinic: id === 1 ? 'cardiology' : 'dermatology',
        doctor: id === 1 ? '1' : '3',
        date: id === 1 ? '2023-05-15' : '2023-05-18',
        time: id === 1 ? '10:00' : '14:30',
        type: id === 1 ? 'in-person' : 'virtual',
        notes: id === 1 ? 'Follow-up for heart condition' : 'Skin rash consultation'
    };
    
    document.getElementById('appointmentId').value = appointment.id;
    document.getElementById('patientName').value = appointment.patientName;
    document.getElementById('clinic').value = appointment.clinic;
    updateDoctors(); // Populate doctors for the selected clinic
    setTimeout(() => {
        document.getElementById('doctor').value = appointment.doctor;
    }, 100);
    document.getElementById('appointmentDate').value = appointment.date;
    document.getElementById('appointmentTime').value = appointment.time;
    document.getElementById('appointmentType').value = appointment.type;
    document.getElementById('notes').value = appointment.notes;
    
    modalTitle.textContent = 'Edit Appointment';
    appointmentModal.style.display = 'block';
}

// Update doctors dropdown based on selected clinic
function updateDoctors() {
    const clinicSelect = document.getElementById('clinic');
    const doctorSelect = document.getElementById('doctor');
    
    doctorSelect.innerHTML = '<option value="">Select a doctor</option>';
    
    if (clinicSelect.value) {
        const doctors = doctorsByClinic[clinicSelect.value];
        doctors.forEach(doctor => {
            const option = document.createElement('option');
            option.value = doctor.id;
            option.textContent = doctor.name;
            doctorSelect.appendChild(option);
        });
    }
}

// Close appointment modal
function closeAppointmentModal() {
    appointmentModal.style.display = 'none';
}

// Open confirmation modal for cancellation
function cancelAppointment(id) {
    currentAppointmentId = id;
    confirmModal.style.display = 'block';
}

// Close confirmation modal
function closeConfirmModal() {
    confirmModal.style.display = 'none';
}

// Handle form submission
appointmentForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // In a real app, you would save to a database here
    const appointmentData = {
        id: document.getElementById('appointmentId').value,
        patientName: document.getElementById('patientName').value,
        clinic: document.getElementById('clinic').value,
        doctor: document.getElementById('doctor').value,
        date: document.getElementById('appointmentDate').value,
        time: document.getElementById('appointmentTime').value,
        type: document.getElementById('appointmentType').value,
        notes: document.getElementById('notes').value
    };
    
    console.log('Appointment data:', appointmentData);
    
    // Close modal and refresh appointments (in a real app)
    closeAppointmentModal();
    alert('Appointment saved successfully!');
    // You would typically refresh the appointments list here
});

// Handle cancellation confirmation
confirmCancelBtn.addEventListener('click', function() {
    // In a real app, you would update the appointment status in your database
    console.log('Cancelling appointment:', currentAppointmentId);
    
    closeConfirmModal();
    alert('Appointment cancelled successfully!');
    // You would typically refresh the appointments list here
});

// Close modals when clicking outside
window.addEventListener('click', function(event) {
    if (event.target === appointmentModal) {
        closeAppointmentModal();
    }
    if (event.target === confirmModal) {
        closeConfirmModal();
    }
});