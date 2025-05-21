document.addEventListener('DOMContentLoaded', function() {
    const medicationsContainer = document.getElementById('medicationsContainer');
    const addMedicationBtn = document.getElementById('addMedicationBtn');
    const form = document.getElementById('prescriptionForm');
    
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
        
        newEntry.querySelector('.remove-btn').addEventListener('click', function() {
            medicationsContainer.removeChild(newEntry);
        });
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitButton = form.querySelector('.request-btn');
        
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        fetch('../actions/prescription_form_action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                form.reset();
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
                `;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the prescription.');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Prescription';
        });
    });
});