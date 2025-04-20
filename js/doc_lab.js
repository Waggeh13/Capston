// Modal functionality
const labModal = document.getElementById("labModal");
const resultsModal = document.getElementById("resultsModal");
const newRequestBtn = document.getElementById("newRequestBtn");
const closeButtons = document.querySelectorAll(".close");

// Open lab request modal
newRequestBtn.onclick = function() {
    labModal.style.display = "block";
}

// Close modals
closeButtons.forEach(button => {
    button.onclick = function() {
        labModal.style.display = "none";
        resultsModal.style.display = "none";
    }
});

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target == labModal) {
        labModal.style.display = "none";
    }
    if (event.target == resultsModal) {
        resultsModal.style.display = "none";
    }
}

// Load lab requests for the logged-in doctor
function loadLabRequests() {
    fetch('../actions/get_doctor_lab_requests.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('labRequestsTableBody');
            tableBody.innerHTML = '';
            if (data.success && data.requests && data.requests.length > 0) {
                data.requests.forEach(request => {
                    const row = document.createElement('tr');
                    row.className = 'result-item';
                    row.setAttribute('data-id', request.lab_id);
                    row.innerHTML = `
                        <td>${request.patient_id || 'N/A'}</td>
                        <td>${request.patient_name || 'Unknown'}</td>
                        <td>${request.tests || 'N/A'}</td>
                        <td>${request.request_date ? new Date(request.request_date).toLocaleDateString() : 'N/A'}</td>
                        <td><span class="status-badge status-${request.overall_status.toLowerCase()}">${request.overall_status}</span></td>
                    `;
                    tableBody.appendChild(row);
                });

                // Attach click event listeners to the new rows
                const resultItems = document.querySelectorAll(".result-item");
                resultItems.forEach(item => {
                    item.addEventListener("click", function() {
                        const labId = this.getAttribute("data-id");
                        openResultsModal(labId);
                    });
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="5">No lab requests found.</td></tr>';
            }
        })
        .catch(error => {
            document.getElementById('labRequestsTableBody').innerHTML = '<tr><td colspan="5">Error loading lab requests.</td></tr>';
        });
}

// Open results modal and fetch result details
function openResultsModal(labId) {
    fetch('../actions/get_doctor_lab_result_by_id.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `lab_id=${labId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const result = data.result;

            // Populate patient information
            document.getElementById('resultPatientId').textContent = result.patient_id || 'N/A';
            document.getElementById('resultPatientName').textContent = result.patient_name || 'N/A';
            document.getElementById('resultPatientGender').textContent = result.Gender || 'N/A';

            // Calculate age
            const dob = new Date(result.DOB);
            const ageDiff = Date.now() - dob.getTime();
            const ageDate = new Date(ageDiff);
            const age = Math.abs(ageDate.getUTCFullYear() - 1970);
            document.getElementById('resultPatientAge').textContent = age ? `${age} years` : 'N/A';

            // Populate doctor information
            document.getElementById('resultDoctorName').textContent = result.doctor_name || 'N/A';
            document.getElementById('resultDoctorSignature').textContent = result.signature || 'N/A';
            document.getElementById('resultDoctorExtension').textContent = result.extension || 'N/A';
            document.getElementById('resultRequestDate').textContent = result.request_date ? new Date(result.request_date).toLocaleDateString() : 'N/A';

            // Reset all test result fields to blank
            const testFields = [
                'resultHaemoglobin', 'resultFullBloodCount', 'resultBloodFilm', 'resultBloodGroup', 'resultRetics',
                'resultSickleTest', 'resultHbGenotype', 'resultPT', 'resultAPTT', 'resultINR'
            ];
            testFields.forEach(field => {
                document.getElementById(field).textContent = '';
            });

            // Populate test results that exist
            if (result.tests && result.tests.length > 0) {
                result.tests.forEach(test => {
                    switch (test.test_name) {
                        case 'Haemoglobin':
                            document.getElementById('resultHaemoglobin').textContent = test.result || 'N/A';
                            break;
                        case 'Full Blood Count & DIFF':
                            document.getElementById('resultFullBloodCount').textContent = test.result || 'N/A';
                            break;
                        case 'Blood Film':
                            document.getElementById('resultBloodFilm').textContent = test.result || 'N/A';
                            break;
                        case 'Blood group':
                            document.getElementById('resultBloodGroup').textContent = test.result || 'N/A';
                            break;
                        case 'Retics':
                            document.getElementById('resultRetics').textContent = test.result || 'N/A';
                            break;
                        case 'Sickle test':
                            document.getElementById('resultSickleTest').textContent = test.result || 'N/A';
                            break;
                        case 'Hb genotype':
                            document.getElementById('resultHbGenotype').textContent = test.result || 'N/A';
                            break;
                        case 'PT':
                            document.getElementById('resultPT').textContent = test.result || 'N/A';
                            break;
                        case 'aPTT':
                            document.getElementById('resultAPTT').textContent = test.result || 'N/A';
                            break;
                        case 'INR':
                            document.getElementById('resultINR').textContent = test.result || 'N/A';
                            break;
                    }
                });

                // Populate laboratory use section (using the first test's data, assuming consistency)
                const firstTest = result.tests[0];
                document.getElementById('resultSpecimenReceivedBy').textContent = firstTest.specimen_received_by || 'N/A';
                document.getElementById('resultSpecimenDate').textContent = firstTest.specimen_date ? new Date(firstTest.specimen_date).toLocaleDateString() : 'N/A';
                document.getElementById('resultSpecimenTime').textContent = firstTest.specimen_time || 'N/A';
                document.getElementById('resultSampleAccepted').textContent = firstTest.sample_accepted || 'N/A';
                document.getElementById('resultLabTechSignature').textContent = firstTest.lab_tech_signature && firstTest.lab_tech_date 
                    ? `${firstTest.lab_tech_signature} / ${new Date(firstTest.lab_tech_date).toLocaleDateString()}` 
                    : 'N/A';
                document.getElementById('resultSupervisorSignature').textContent = firstTest.supervisor_signature && firstTest.supervisor_date 
                    ? `${firstTest.supervisor_signature} / ${new Date(firstTest.supervisor_date).toLocaleDateString()}` 
                    : 'N/A';
            } else {
                // If no test results, leave all fields blank
                document.getElementById('resultSpecimenReceivedBy').textContent = 'N/A';
                document.getElementById('resultSpecimenDate').textContent = 'N/A';
                document.getElementById('resultSpecimenTime').textContent = 'N/A';
                document.getElementById('resultSampleAccepted').textContent = 'N/A';
                document.getElementById('resultLabTechSignature').textContent = 'N/A';
                document.getElementById('resultSupervisorSignature').textContent = 'N/A';
            }

            resultsModal.style.display = "block";
        } else {
            alert('Error fetching lab result: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        alert('Error fetching lab result');
    });
}

// Handle lab request form submission (unchanged)
document.getElementById('labRequestForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Prevent multiple submissions
    const submitButton = this.querySelector('button[type="submit"]');
    if (submitButton.disabled) return; // Exit if already submitting
    submitButton.disabled = true;

    // Get form data
    const formData = new FormData();

    // Manually append all fields except testRequest to avoid duplication
    formData.append('firstName', document.getElementById('firstName').value);
    formData.append('lastName', document.getElementById('lastName').value);
    formData.append('diagnosis', document.getElementById('diagnosis').value);
    formData.append('labCode', document.getElementById('labCode').value);
    formData.append('signature', document.getElementById('signature').value);
    formData.append('extension', document.getElementById('extension').value);
    formData.append('requestDate', document.getElementById('requestDate').value);

    // Get test requests (only once, deduplicated)
    const testRequests = [...new Set(
        Array.from(document.querySelectorAll('input[name="testRequest[]"]:checked')).map(el => el.value)
    )]; // Use Set to ensure uniqueness

    // Append test requests to form data
    testRequests.forEach(test => {
        formData.append('testRequest[]', test);
    });

    // Send AJAX request
    fetch('../actions/lab_form_action.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        return response.text().then(rawResponse => {
            try {
                return JSON.parse(rawResponse);
            } catch (e) {
                throw new Error('Invalid JSON response');
            }
        });
    })
    .then(data => {
        if (data.success) {
            alert('Lab request submitted successfully!');
            labModal.style.display = "none";
            this.reset();
            loadLabRequests(); // Reload the table after submitting a new request
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('An error occurred while submitting the lab request.');
    })
    .finally(() => {
        submitButton.disabled = false;
    });
});

// Initialize by loading lab requests
document.addEventListener('DOMContentLoaded', function() {
    loadLabRequests();
});