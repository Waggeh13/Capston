document.addEventListener('DOMContentLoaded', function() {
    const medicationsContainer = document.getElementById('medicationsContainer');
    const addMedicationBtn = document.getElementById('addMedicationBtn');
    const form = document.getElementById('prescriptionForm');
    
    // Add new medication entry
    addMedicationBtn.addEventListener('click', function() {
        const newEntry = document.createElement('div');
        newEntry.className = 'medication-entry';
        newEntry.innerHTML = `
            <div class="input-row">
                <div class="input-box">
                    <label>Medicine Name</label>
                    <input type="text" name="medicines[]" placeholder="Enter medication name" required>
                </div>
                <div class="input-box">
                    <label>Dosage</label>
                    <input type="text" name="dosages[]" placeholder="e.g., 500mg, 1 tablet" required>
                </div>
            </div>
            <div class="input-box">
                <label>Instructions</label>
                <textarea name="instructions[]" rows="3" placeholder="Enter instructions (frequency, duration, etc.)" required></textarea>
            </div>
            <button type="button" class="remove-btn">
                <i class="fas fa-trash"></i> Remove
            </button>
        `;
        
        medicationsContainer.appendChild(newEntry);
        
        // Add event listener to the new remove button
        newEntry.querySelector('.remove-btn').addEventListener('click', function() {
            medicationsContainer.removeChild(newEntry);
        });
    });
    
    // Form submission with AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        const formData = new FormData(form); // Collect all form data, including arrays
        const submitButton = form.querySelector('.request-btn');
        
        // Disable button to prevent multiple submissions
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        fetch('../actions/prescription_form_action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Parse JSON response from PHP
        .then(data => {
            if (data.success) {
                // Show success message
                alert(data.message); // Or use a custom UI element
                form.reset(); // Clear the form
                medicationsContainer.innerHTML = `
                    <div class="medication-entry">
                        <div class="input-row">
                            <div class="input-box">
                                <label>Medicine Name</label>
                                <input type="text" name="medicines[]" placeholder="Enter medication name" required>
                            </div>
                            <div class="input-box">
                                <label>Dosage</label>
                                <input type="text" name="dosages[]" placeholder="e.g., 500mg, 1 tablet" required>
                            </div>
                        </div>
                        <div class="input-box">
                            <label>Instructions</label>
                            <textarea name="instructions[]" rows="3" placeholder="Enter instructions (frequency, duration, etc.)" required></textarea>
                        </div>
                    </div>
                `; // Reset to one medication entry
            } else {
                // Show error message
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the prescription.');
        })
        .finally(() => {
            // Re-enable the submit button
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Prescription';
        });
    });
});