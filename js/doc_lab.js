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
    
    // Get form data
    const formData = new FormData(this);
    const testRequests = Array.from(document.querySelectorAll('input[name="testRequest[]"]:checked')).map(el => el.value);
    
    // Add test requests to form data
    testRequests.forEach(test => {
        formData.append('testRequest[]', test);
    });
    
    // Send AJAX request
    fetch('../actions/lab_form_action.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Lab request submitted successfully!');
            labModal.style.display = "none";
            // Refresh or update the UI as needed
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the lab request.');
    });
});