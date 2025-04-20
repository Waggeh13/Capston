function updateCurrentDate() {
    const now = new Date();
    const options = { weekday: 'long', month: 'long', day: 'numeric' };
    document.getElementById('real-time-date').textContent = now.toLocaleDateString('en-US', options);
}

function calculateTotal(card) {
    let total = 0;
    card.querySelectorAll('.price-input:not([disabled])').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    card.querySelector('.total-amount').textContent = 'GMD ' + total.toFixed(2);
    return total;
}

document.querySelectorAll('.price-input').forEach(input => {
    input.addEventListener('input', function() {
        const card = this.closest('.payment-card');
        calculateTotal(card);
    });
});

function viewDetails(patientId, prescriptionId) {
    fetch('../actions/get_pending_payments.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }

            // Group medications by patient_id and prescription_id
            const groupedPayments = {};
            data.forEach(payment => {
                const key = `${payment.patient.patient_id}_${payment.prescription_id}`;
                if (!groupedPayments[key]) {
                    groupedPayments[key] = {
                        patient: payment.patient,
                        prescription_id: payment.prescription_id,
                        medications: [],
                        consultations: payment.consultations,
                        lab_tests: payment.lab_tests,
                        dispensed_date: payment.dispensed_date
                    };
                }
                groupedPayments[key].medications.push(payment.medication);
            });

            const payment = groupedPayments[`${patientId}_${prescriptionId}`];
            if (!payment) {
                alert('Payment details not found.');
                return;
            }

            const patient = payment.patient;
            const initials = (patient.first_name[0] || '') + (patient.last_name[0] || '');
            document.getElementById('detailPatientInfo').innerHTML = `
                <div class="patient-photo">${initials}</div>
                <div>
                    <strong>${patient.first_name} ${patient.last_name}</strong><br>
                    <span>ID: ${patient.patient_id} | Date: ${new Date(payment.dispensed_date).toLocaleDateString()}</span>
                </div>
            `;

            // Consultation Details
            let consultationHtml = `
                <h3 style="color: #0054A6; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <i class="fas fa-stethoscope"></i> Consultation Details
                </h3>
            `;
            if (payment.consultations && payment.consultations.length > 0) {
                payment.consultations.forEach(consult => {
                    consultationHtml += `
                        <div style="background-color: #f5f9ff; padding: 15px; border-radius: 6px; margin-bottom: 10px;">
                            <p><strong>Doctor:</strong> Dr. ${consult.doctor_last_name}</p>
                            <p><strong>Date:</strong> ${consult.appointment_date}</p>
                            <p><strong>Time:</strong> ${consult.time_slot}</p>
                            <p><strong>Type:</strong> ${consult.appointment_type}</p>
                        </div>
                    `;
                });
            } else {
                consultationHtml += `<p>No consultation details available.</p>`;
            }
            document.getElementById('consultationDetails').innerHTML = consultationHtml;

            // Prescription Details
            let prescriptionHtml = `
                <h3 style="color: #0054A6; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <i class="fas fa-prescription-bottle-alt"></i> Prescriptions
                </h3>
            `;
            if (payment.medications && payment.medications.length > 0) {
                payment.medications.forEach(med => {
                    prescriptionHtml += `
                        <div class="prescription-item">
                            <div>
                                <strong>${med.medication} ${med.dosage}</strong><br>
                                <span>${med.instructions}</span><br>
                                <span>Quantity: ${med.quantity_dispensed}</span>
                            </div>
                        </div>
                    `;
                });
            } else {
                prescriptionHtml += `<p>No prescription details available.</p>`;
            }
            document.getElementById('prescriptionDetails').innerHTML = prescriptionHtml;

            // Lab Test Details
            let labTestHtml = `
                <h3 style="color: #0054A6; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <i class="fas fa-flask"></i> Lab Tests
                </h3>
            `;
            if (payment.lab_tests && payment.lab_tests.length > 0) {
                payment.lab_tests.forEach(test => {
                    labTestHtml += `
                        <div class="test-item">
                            <div>
                                <strong>${test.test_name}</strong><br>
                                <span>Result: ${test.result || 'N/A'}</span><br>
                                <span>Status: ${test.result_status}</span>
                            </div>
                        </div>
                    `;
                });
            } else {
                labTestHtml += `<p>No lab test details available.</p>`;
            }
            document.getElementById('labTestDetails').innerHTML = labTestHtml;

            document.getElementById('detailsModal').style.display = 'flex';
        })
        .catch(error => {
            alert('Failed to load payment details.');
        });
}

function viewReceipt(receiptId) {
    if (!receiptId) {
        alert('Error: No receipt ID provided.');
        return;
    }

    fetch(`../actions/get_receipt_details.php?receipt_id=${encodeURIComponent(receiptId)}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }

            document.getElementById('receiptNumber').textContent = `RC-2025-${data.receipt_id}`;
            document.getElementById('receiptPatient').textContent = `${data.patient.first_name} ${data.patient.last_name}`;
            document.getElementById('receiptPatientId').textContent = data.patient.patient_id;
            document.getElementById('receiptCashier').textContent = `${data.cashier.first_name} ${data.cashier.last_name}`;
            document.getElementById('receiptDate').textContent = new Date().toLocaleString('en-GB');
            
            let itemsHtml = '';
            // Medications
            if (data.medications && data.medications.length > 0) {
                data.medications.forEach(med => {
                    itemsHtml += `
                        <tr>
                            <td>${med.medication} ${med.dosage} (Qty: ${med.quantity_dispensed})</td>
                            <td>-</td>
                        </tr>
                    `;
                });
            }
            // Consultations
            if (data.consultations && data.consultations.length > 0) {
                data.consultations.forEach(consult => {
                    itemsHtml += `
                        <tr>
                            <td>Consultation with Dr. ${consult.doctor_last_name}</td>
                            <td>-</td>
                        </tr>
                    `;
                });
            }
            // Lab Tests
            if (data.lab_tests && data.lab_tests.length > 0) {
                data.lab_tests.forEach(test => {
                    itemsHtml += `
                        <tr>
                            <td>${test.test_name}</td>
                            <td>-</td>
                        </tr>
                    `;
                });
            }
            if (!itemsHtml) {
                itemsHtml = '<tr><td>No items recorded</td><td>-</td></tr>';
            }
            document.getElementById('receiptItems').innerHTML = itemsHtml;
            
            document.getElementById('receiptTotal').textContent = parseFloat(data.total).toFixed(2);
            document.getElementById('receiptModal').style.display = 'flex';
        })
        .catch(error => {
            alert('Failed to load receipt details.');
        });
}

function processPayment(button) {
    const card = button.closest('.payment-card');
    const dispensedIds = JSON.parse(card.dataset.dispensedIds);
    const patientId = card.dataset.patientId;
    const prescriptionId = card.dataset.prescriptionId;
    const total = calculateTotal(card);

    if (total <= 0) {
        alert('Please enter valid prices for the services.');
        return;
    }

    if (!confirm('Are you sure you want to process this payment?')) {
        return;
    }

    fetch('../actions/process_payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            dispensed_ids: dispensedIds,
            patient_id: patientId,
            prescription_id: prescriptionId,
            total: total
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Payment processed successfully!');
            window.location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        alert('Failed to process payment.');
    });
}

function closeModal() {
    document.getElementById('detailsModal').style.display = 'none';
}

function closeReceipt() {
    document.getElementById('receiptModal').style.display = 'none';
}

// Initialize
updateCurrentDate();
document.querySelectorAll('.payment-card').forEach(card => {
    calculateTotal(card);
});

document.getElementById('logoutBtn').addEventListener('click', function(e) {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = '../actions/logoutactions.php';
    }
});

// Attach event listeners to View Receipt buttons
document.querySelectorAll('[id^="view-receipt-"]').forEach(button => {
    const receiptId = button.id.replace('view-receipt-', '');
    button.addEventListener('click', () => viewReceipt(receiptId));
});