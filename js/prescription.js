document.addEventListener('DOMContentLoaded', function() {
    const medicationsContainer = document.getElementById('medicationsContainer');
    const addMedicationBtn = document.getElementById('addMedicationBtn');
    
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
    
    // Form submission
    document.getElementById('prescriptionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Handle form submission here
        alert('Prescription submitted successfully!');
    });
});