// Password Modal Functions
function openPasswordModal() {
    const modal = document.getElementById('passwordModal');
    if (modal) {
        modal.style.display = 'block';
        console.log('Modal opened via openPasswordModal()');
    } else {
        console.error('Modal element not found');
    }
}

function closePasswordModal() {
    const modal = document.getElementById('passwordModal');
    if (modal) {
        modal.style.display = 'none';
        console.log('Modal closed');
    } else {
        console.error('Modal element not found');
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('passwordModal');
    if (event.target === modal) {
        closePasswordModal();
        console.log('Modal closed by clicking outside');
    }
}

// Form Validation
function validatePasswordForm(event) {
    event.preventDefault();
    
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    const currentPasswordError = document.getElementById('currentPasswordError');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    // Reset error messages
    currentPasswordError.style.display = 'none';
    newPasswordError.style.display = 'none';
    confirmPasswordError.style.display = 'none';

    // Validate current password
    if (currentPassword.trim() === '') {
        currentPasswordError.textContent = 'Current password is required';
        currentPasswordError.style.display = 'block';
        return false;
    }

    // Validate new password
    if (newPassword.trim() === '') {
        newPasswordError.textContent = 'New password is required';
        newPasswordError.style.display = 'block';
        return false;
    }

    if (newPassword !== confirmPassword) {
        confirmPasswordError.textContent = 'New passwords do not match!';
        confirmPasswordError.style.display = 'block';
        return false;
    }

    if (newPassword.length < 8) {
        newPasswordError.textContent = 'Password must be at least 8 characters long!';
        newPasswordError.style.display = 'block';
        return false;
    }

    // Here you would typically add your password change logic
    // For example, make an API call to update the password
    alert('Password changed successfully!');
    closePasswordModal();
    return false;
}

// Attach submit button listener
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', validatePasswordForm);
        console.log('Submit button event listener attached');
    } else {
        console.error('Submit button not found');
    }
    
    // Debug: Log initial modal state
    console.log('Password modal script loaded. Modal display:', document.getElementById('passwordModal')?.style.display || 'not found');
});