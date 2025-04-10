// Password Modal Script
document.addEventListener('DOMContentLoaded', function() {
    // Show modal (in a real app, this would trigger after login with default credentials)
    const passwordModal = document.getElementById('passwordModal');
    passwordModal.style.display = 'flex';
    
    // Modal elements
    const currentPassword = document.getElementById('currentPassword');
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const cancelBtn = document.getElementById('cancelBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Error elements
    const currentPasswordError = document.getElementById('currentPasswordError');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    
    // Close modal when clicking cancel
    cancelBtn.addEventListener('click', function() {
        passwordModal.style.display = 'none';
    });
    
    // Close modal when clicking outside
    passwordModal.addEventListener('click', function(e) {
        if (e.target === passwordModal) {
            passwordModal.style.display = 'none';
        }
    });
    
    // Validate password on submit
    submitBtn.addEventListener('click', function() {
        let isValid = true;
        
        // Reset error messages
        currentPasswordError.style.display = 'none';
        newPasswordError.style.display = 'none';
        confirmPasswordError.style.display = 'none';
        
        // Validate current password
        if (currentPassword.value.trim() === '') {
            currentPasswordError.textContent = 'Current password is required';
            currentPasswordError.style.display = 'block';
            isValid = false;
        }
        
        // Validate new password
        if (newPassword.value.trim() === '') {
            newPasswordError.textContent = 'New password is required';
            newPasswordError.style.display = 'block';
            isValid = false;
        } else if (!isStrongPassword(newPassword.value)) {
            newPasswordError.textContent = 'Password must be at least 8 characters with numbers and special characters';
            newPasswordError.style.display = 'block';
            isValid = false;
        }
        
        // Validate confirm password
        if (confirmPassword.value.trim() === '') {
            confirmPasswordError.textContent = 'Please confirm your new password';
            confirmPasswordError.style.display = 'block';
            isValid = false;
        } else if (confirmPassword.value !== newPassword.value) {
            confirmPasswordError.textContent = 'Passwords do not match';
            confirmPasswordError.style.display = 'block';
            isValid = false;
        }
        
        if (isValid) {
            // In a real app, you would send this to your backend
            alert('Password changed successfully!');
            passwordModal.style.display = 'none';
            
            // Here you would typically make an AJAX call to your server
            // to update the password in the database
        }
    });
    
    // Password strength checker
    function isStrongPassword(password) {
        const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
        return regex.test(password);
    }
});