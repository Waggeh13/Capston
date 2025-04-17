document.addEventListener('DOMContentLoaded', function() {
    // Update current date
    function updateCurrentDate() {
        const now = new Date();
        const options = { weekday: 'long', month: 'long', day: 'numeric' };
        document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', options);
    }

    // Modal functions
    function openRequestModal(labId) {
        fetch('../actions/get_lab_request_by_id.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `lab_id=${labId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const request = data.request;
                // Populate patient information
                document.getElementById('patientName').textContent = request.patient_name || 'N/A';
                document.getElementById('patientId').textContent = request.patient_id || 'N/A';
                document.getElementById('patientDOB').textContent = request.DOB ? new Date(request.DOB).toLocaleDateString() : 'N/A';
                
                // Calculate age
                const dob = new Date(request.DOB);
                const ageDiff = Date.now() - dob.getTime();
                const ageDate = new Date(ageDiff);
                const age = Math.abs(ageDate.getUTCFullYear() - 1970);
                document.getElementById('patientAge').textContent = age ? `${age} years` : 'N/A';
                
                document.getElementById('patientGender').textContent = request.Gender || 'N/A';

                // Populate doctor information
                document.getElementById('doctorName').textContent = request.doctor_name || 'N/A';
                document.getElementById('doctorSignature').textContent = request.signature || 'N/A';
                document.getElementById('requestDate').textContent = request.request_date ? new Date(request.request_date).toLocaleDateString() : 'N/A';

                // Populate test checkboxes with the updated list of 10 tests
                const testCheckboxes = document.getElementById('testCheckboxes');
                testCheckboxes.innerHTML = '';
                const allTests = [
                    { id: 'haemoglobin', name: 'Haemoglobin' },
                    { id: 'fbc', name: 'Full Blood Count & DIFF' },
                    { id: 'blood-film', name: 'Blood Film' },
                    { id: 'blood-group', name: 'Blood group' },
                    { id: 'retics', name: 'Retics' },
                    { id: 'sickle-test', name: 'Sickle test' },
                    { id: 'hb-genotype', name: 'Hb genotype' },
                    { id: 'pt', name: 'PT' },
                    { id: 'aptt', name: 'aPTT' },
                    { id: 'inr', name: 'INR' }
                ];

                allTests.forEach(test => {
                    const isChecked = request.tests.some(t => t.test_name === test.name);
                    const div = document.createElement('div');
                    div.className = 'checkbox-item';
                    div.innerHTML = `
                        <input type="checkbox" id="${test.id}" ${isChecked ? 'checked' : ''} disabled>
                        <label for="${test.id}">${test.name}</label>
                    `;
                    testCheckboxes.appendChild(div);
                });

                document.getElementById('requestModal').style.display = 'flex';
            } else {
                alert('Error fetching lab request: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error fetching lab request:', error);
            alert('Error fetching lab request');
        });
    }

    function openResultsModal(labId) {
        document.getElementById('labId').value = labId;

        // Fetch the lab request to get the requested tests
        fetch('../actions/get_lab_request_by_id.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `lab_id=${labId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const request = data.request;
                const dynamicTestResults = document.getElementById('dynamicTestResults');
                dynamicTestResults.innerHTML = '';

                // Only include tests that were requested
                if (request.tests && request.tests.length > 0) {
                    request.tests.forEach(test => {
                        const testTypeId = test.test_type_id;
                        const testName = test.test_name;
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${testName}</td>
                            <td><input type="text" name="test_${testTypeId}" data-test-id="${testTypeId}"></td>
                        `;
                        dynamicTestResults.appendChild(row);
                    });
                } else {
                    dynamicTestResults.innerHTML = '<tr><td colspan="2">No tests requested.</td></tr>';
                }

                document.getElementById('resultsModal').style.display = 'flex';
            } else {
                alert('Error fetching lab request: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error fetching lab request for results modal:', error);
            alert('Error fetching lab request');
        });
    }

    function closeModal() {
        document.getElementById('requestModal').style.display = 'none';
        document.getElementById('resultsModal').style.display = 'none';
    }

    // Load lab requests
    function loadLabRequests() {
        fetch('../actions/get_lab_requests.php')
        .then(response => response.json())
        .then(data => {
            const requestCards = document.getElementById('requestCards');
            requestCards.innerHTML = '';
            if (data.success && data.requests && data.requests.length > 0) {
                data.requests.forEach(request => {
                    const card = document.createElement('div');
                    card.className = 'request-card';
                    card.setAttribute('data-lab-id', request.lab_id);
                    card.innerHTML = `
                        <div class="patient-info">
                            <div class="patient-photo">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <strong>${request.patient_name || 'Unknown'}</strong><br>
                                ${request.doctor_name || 'Unknown'}<br>
                                <small>${request.request_date ? new Date(request.request_date).toLocaleDateString() : 'N/A'}</small>
                            </div>
                        </div>
                        <div class="request-actions">
                            <button class="btn btn-secondary view-request-btn">
                                <i class="fas fa-eye"></i> View Request
                            </button>
                            <button class="btn btn-primary enter-results-btn">
                                <i class="fas fa-flask"></i> Enter Results
                            </button>
                        </div>
                    `;
                    requestCards.appendChild(card);
                });
            } else {
                requestCards.innerHTML = '<p>No pending lab requests found.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading lab requests:', error);
            document.getElementById('requestCards').innerHTML = '<p>Error loading lab requests.</p>';
        });
    }

    // Search lab requests
    function searchRequests() {
        const searchTerm = document.getElementById('searchBar').value.toLowerCase();
        const cards = document.querySelectorAll('.request-card');
        cards.forEach(card => {
            const patientName = card.querySelector('.patient-info div strong').textContent.toLowerCase();
            if (patientName.includes(searchTerm)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Handle form submission
    const resultsForm = document.getElementById('resultsForm');
    if (resultsForm) {
        resultsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('../actions/lab_action.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeModal();
                    loadLabRequests(); // Reload requests to reflect changes
                } else {
                    alert('Error submitting results: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error submitting results:', error);
                alert('Error submitting results');
            });
        });
    }

    // Event delegation for dynamically generated buttons
    document.getElementById('requestCards').addEventListener('click', function(e) {
        const target = e.target.closest('button');
        if (!target) return;

        const card = target.closest('.request-card');
        const labId = card ? card.getAttribute('data-lab-id') : null;

        if (!labId) return;

        if (target.classList.contains('view-request-btn')) {
            openRequestModal(labId);
        } else if (target.classList.contains('enter-results-btn')) {
            openResultsModal(labId);
        }
    });

    // Event listeners for static buttons
    document.getElementById('logoutBtn').addEventListener('click', function() {
        window.location.href = 'index.php';
    });

    document.getElementById('closeRequestModal').addEventListener('click', closeModal);
    document.getElementById('closeRequestModalBtn').addEventListener('click', closeModal);
    document.getElementById('closeResultsModal').addEventListener('click', closeModal);
    document.getElementById('cancelResultsModalBtn').addEventListener('click', closeModal);

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('requestModal')) {
            closeModal();
        }
        if (event.target === document.getElementById('resultsModal')) {
            closeModal();
        }
    });

    // Attach search event listener
    document.getElementById('searchBar').addEventListener('keyup', searchRequests);

    // Initialize
    updateCurrentDate();
    loadLabRequests();
});