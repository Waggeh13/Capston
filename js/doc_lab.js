// Modal functionality
const labModal = document.getElementById("labModal");
const resultsModal = document.getElementById("resultsModal");
const newRequestBtn = document.getElementById("newRequestBtn");
const resultItems = document.querySelectorAll(".result-item");
const closeButtons = document.querySelectorAll(".close");

// Open lab request modal
newRequestBtn.onclick = function() {
    labModal.style.display = "block";
}

// Open results modal when clicking on a result item
resultItems.forEach(item => {
    item.addEventListener("click", function() {
        resultsModal.style.display = "block";
    });
});

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

// Handle lab request form submission
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
    formData.append('dFullName', document.getElementById('dFullName').value);
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
            console.log('Raw response:', rawResponse);
            try {
                return JSON.parse(rawResponse);
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                throw new Error('Invalid JSON response');
            }
        });
    })
    .then(data => {
        if (data.success) {
            alert('Lab request submitted successfully!');
            labModal.style.display = "none";
            this.reset(); // Reset form after success
            // Refresh or update the UI as needed
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the lab request.');
    })
    .finally(() => {
        submitButton.disabled = false; // Re-enable submit button
    });
});