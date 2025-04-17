document.addEventListener('DOMContentLoaded', function() {
    // Open modal
    window.openRequestModal = function() {
        document.getElementById('requestModal').classList.add('active');
    };

    // Close modal
    window.closeRequestModal = function() {
        document.getElementById('requestModal').classList.remove('active');
        // Clear form
        document.getElementById('requestForm').reset();
        document.getElementById('hospitalNameError').textContent = '';
        document.getElementById('doctorIdError').textContent = '';
    };

    // Submit form
    window.submitRequestForm = function() {
        const form = document.getElementById('requestForm');
        const hospitalName = document.getElementById('hospitalName').value.trim();
        const doctorId = document.getElementById('doctorId').value;

        // Reset error messages
        document.getElementById('hospitalNameError').textContent = '';
        document.getElementById('doctorIdError').textContent = '';

        let valid = true;

        // Validation
        if (!hospitalName) {
            document.getElementById('hospitalNameError').textContent = 'Hospital name is required';
            valid = false;
        }
        if (!doctorId) {
            document.getElementById('doctorIdError').textContent = 'Please select a doctor';
            valid = false;
        }

        if (valid) {
            form.submit(); // Submit the form to the server
        }
    };
});