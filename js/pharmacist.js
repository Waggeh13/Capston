// Prescription data
const prescriptions = {
    'JD': {
        name: 'John Doe',
        id: 'PT-1024',
        doctor: 'Dr. Smith',
        initials: 'JD',
        medications: [
            { name: 'Amoxicillin 500mg', instructions: 'Take 1 tablet every 8 hours for 7 days' },
            { name: 'Ibuprofen 200mg', instructions: 'Take as needed for pain (max 3/day)' }
        ]
    },
    'MS': {
        name: 'Mary Smith',
        id: 'PT-2048',
        doctor: 'Dr. Johnson',
        initials: 'MS',
        medications: [
            { name: 'Lisinopril 10mg', instructions: 'Take 1 tablet daily in the morning' },
            { name: 'Metformin 500mg', instructions: 'Take 1 tablet twice daily with meals' },
            { name: 'Atorvastatin 20mg', instructions: 'Take 1 tablet at bedtime' }
        ]
    }
};

function toggleMode() {
    document.getElementById('viewMode').classList.toggle('hidden');
    document.getElementById('dispenseMode').classList.toggle('hidden');
}

function startDispensing(patientId) {
    const patient = prescriptions[patientId];
    
    // Update patient info in dispense mode
    const patientInfoDiv = document.getElementById('dispensePatientInfo');
    patientInfoDiv.innerHTML = `
        <div class="patient-photo">${patient.initials}</div>
        <div>
            <strong>${patient.name}</strong><br>
            ID: ${patient.id} | ${patient.doctor}
        </div>
    `;
    
    // Update medications table
    const tbody = document.querySelector('#dispenseTable tbody');
    tbody.innerHTML = '';
    
    patient.medications.forEach(med => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${med.name}</td>
            <td><input type="text" name="dispensedQty" placeholder="e.g., 1 bottle, 30 tablets" required></td>
        `;
        tbody.appendChild(row);
    });
    
    toggleMode();
}

document.getElementById('dispenseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Dispensing record sent to cashier!');
    // In real implementation: Submit to server and reset form
    toggleMode();
});

document.getElementById('logoutBtn').addEventListener('click', function(e) {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = '../actions/logoutactions.php';
    }
});