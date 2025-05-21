function toggleMode() {
    document.getElementById('viewMode').classList.toggle('hidden');
    document.getElementById('dispenseMode').classList.toggle('hidden');
}

function startDispensing(prescriptionId, patientId) {
    fetch('../actions/get_prescription_by_id.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ prescription_id: prescriptionId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
            return;
        }

        if (!data.patient || !data.patient.first_name || !data.patient.last_name || !data.medications) {
            alert('Error: Invalid prescription data received.');
            return;
        }

        const prescription = data;
        const patient = prescription.patient;
        const medications = prescription.medications;

        const initials = (patient.first_name[0] || '') + (patient.last_name[0] || '');

        const patientInfoDiv = document.getElementById('dispensePatientInfo');
        patientInfoDiv.innerHTML = `
            <div class="patient-photo">${initials}</div>
            <div>
                <strong>${patient.first_name} ${patient.last_name}</strong><br>
                ID: ${patient.patient_id} | ${prescription.staff.first_name} ${prescription.staff.last_name}
            </div>
        `;

        const tbody = document.querySelector('#dispenseTable tbody');
        tbody.innerHTML = '';

        medications.forEach(med => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${med.medication} ${med.dosage}</td>
                <td><input type="text" name="dispensedQty" data-medication-id="${med.medication_id}" placeholder="e.g., 30 tablets" required></td>
            `;
            tbody.appendChild(row);
        });

        document.getElementById('dispenseForm').dataset.prescriptionId = prescriptionId;
        document.getElementById('dispenseForm').dataset.patientId = patientId;

        toggleMode();
    })
    .catch(error => {
        console.error('Error fetching prescription:', error);
        alert('Failed to load prescription details.');
    });
}

function cancelPrescription(prescriptionId) {
    if (!confirm('Are you sure you want to cancel this prescription? This action cannot be undone.')) {
        return;
    }

    fetch('../actions/delete_prescription.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ prescription_id: prescriptionId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Prescription cancelled successfully.');
            window.location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error cancelling prescription:', error);
        alert('Failed to cancel prescription.');
    });
}

document.getElementById('dispenseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const prescriptionId = this.dataset.prescriptionId;
    const patientId = this.dataset.patientId;
    const dispensedQuantities = [];

    document.querySelectorAll('#dispenseTable tbody input[name="dispensedQty"]').forEach(input => {
        dispensedQuantities.push({
            medication_id: input.dataset.medicationId,
            quantity: input.value
        });
    });

    fetch('../actions/dispense_medication.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            prescription_id: prescriptionId,
            patient_id: patientId,
            medications: dispensedQuantities
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Dispensing record sent to cashier!');
            window.location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error submitting dispensed medications:', error);
        alert('Failed to submit dispensing record.');
    });
});

document.getElementById('logoutBtn').addEventListener('click', function(e) {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = '../actions/logoutactions.php';
    }
});