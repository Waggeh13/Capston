 // Password Modal Functions
 function openPasswordModal() {
    document.getElementById('passwordModal').style.display = 'block';
}

function closePasswordModal() {
    document.getElementById('passwordModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('passwordModal');
    if (event.target === modal) {
        closePasswordModal();
    }
}

// Form Validation
function validatePasswordForm(event) {
    event.preventDefault();
    
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (newPassword !== confirmPassword) {
        alert('New passwords do not match!');
        return false;
    }

    if (newPassword.length < 8) {
        alert('Password must be at least 8 characters long!');
        return false;
    }

    // Here you would typically add your password change logic
    // For example, make an API call to update the password
    alert('Password changed successfully!');
    closePasswordModal();
    return false;
}