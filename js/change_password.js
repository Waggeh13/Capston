function openPasswordModal() {
    const modal = document.getElementById('passwordModal');
    if (modal) {
        modal.style.display = 'block';
    } else {
        alert('Modal element not found');
    }
}

function closePasswordModal() {
    const modal = document.getElementById('passwordModal');
    if (modal) {
        modal.style.display = 'none';
        // Reset the form and error messages
        document.getElementById('PasswordForm').reset();
        document.getElementById('currentPasswordError').style.display = 'none';
        document.getElementById('newPasswordError').style.display = 'none';
        document.getElementById('confirmPasswordError').style.display = 'none';
        document.getElementById('passwordStrength').textContent = '';
        document.getElementById('passwordStrength').style.color = '';
    } else {
        alert('Modal element not found');
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('passwordModal');
    if (event.target === modal) {
        closePasswordModal();
    }
}

// Form Validation and Submission
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

    if (newPassword.length < 8) {
        newPasswordError.textContent = 'Password must be at least 8 characters long';
        newPasswordError.style.display = 'block';
        return false;
    }

    // Check password strength (already handled in real-time, but ensure it meets minimum criteria)
    const passwordStrength = calculatePasswordStrength(newPassword);
    if (passwordStrength === 'Weak') {
        newPasswordError.textContent = 'Password is too weak. Include numbers, special characters, and uppercase letters.';
        newPasswordError.style.display = 'block';
        return false;
    }

    // Validate confirm password
    if (newPassword !== confirmPassword) {
        confirmPasswordError.textContent = 'New passwords do not match';
        confirmPasswordError.style.display = 'block';
        return false;
    }

    // Submit the form via AJAX
    const formData = new FormData();
    formData.append('currentPassword', currentPassword);
    formData.append('newPassword', newPassword);

    fetch('../actions/change_password_action.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Password changed successfully!');
            closePasswordModal();
        } else {
            if (data.error === 'incorrect_current_password') {
                currentPasswordError.textContent = 'Current password is incorrect';
                currentPasswordError.style.display = 'block';
            } else {
                newPasswordError.textContent = data.error || 'An error occurred. Please try again.';
                newPasswordError.style.display = 'block';
            }
        }
    })
    .catch(error => {
        newPasswordError.textContent = 'An error occurred. Please try again.';
        newPasswordError.style.display = 'block';
    });

    return false;
}

// Real-time Password Strength Calculation
function calculatePasswordStrength(password) {
    let strength = 'Weak';
    let score = 0;

    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    if (score <= 2) {
        strength = 'Weak';
    } else if (score === 3) {
        strength = 'Medium';
    } else if (score >= 4) {
        strength = 'Strong';
    }

    return strength;
}

// Real-time Password Strength Feedback
function updatePasswordStrength() {
    const newPassword = document.getElementById('newPassword').value;
    const passwordStrengthElement = document.getElementById('passwordStrength');
    const strength = calculatePasswordStrength(newPassword);

    passwordStrengthElement.textContent = `Password Strength: ${strength}`;
    if (strength === 'Weak') {
        passwordStrengthElement.style.color = 'red';
    } else if (strength === 'Medium') {
        passwordStrengthElement.style.color = 'orange';
    } else if (strength === 'Strong') {
        passwordStrengthElement.style.color = 'green';
    }
}

// Attach event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Submit button listener
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', validatePasswordForm);
    } else {
        alert('Submit button not found');
    }

    // Real-time password strength listener
    const newPasswordInput = document.getElementById('newPassword');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', updatePasswordStrength);
    } else {
        alert('New password input not found');
    }
});