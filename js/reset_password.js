function openPasswordModal() {
    const modal = document.getElementById('passwordModal');
    if (modal) {
        modal.style.display = 'block';
    } else {
        console.error('Modal element not found');
    }
}

function closePasswordModal() {
    const modal = document.getElementById('passwordModal');
    if (modal) {
        modal.style.display = 'none';
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
        document.getElementById('currentPasswordError').textContent = '';
        document.getElementById('newPasswordError').textContent = '';
        document.getElementById('confirmPasswordError').textContent = '';
        document.getElementById('passwordStrength').textContent = 'Must be at least 8 characters with numbers and special characters';
        document.getElementById('passwordStrength').style.color = '';
    } else {
        console.error('Modal element not found');
    }
}

window.onclick = function(event) {
    const modal = document.getElementById('passwordModal');
    if (event.target === modal) {
        closePasswordModal();
    }
}

function validatePasswordForm(event) {
    event.preventDefault();

    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    const currentPasswordError = document.getElementById('currentPasswordError');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    currentPasswordError.textContent = '';
    newPasswordError.textContent = '';
    confirmPasswordError.textContent = '';

    if (currentPassword.trim() === '') {
        currentPasswordError.textContent = 'Current password is required';
        return false;
    }

    if (newPassword.trim() === '') {
        newPasswordError.textContent = 'New password is required';
        return false;
    }

    if (newPassword.length < 8) {
        newPasswordError.textContent = 'Password must be at least 8 characters long';
        return false;
    }

    const passwordStrength = calculatePasswordStrength(newPassword);
    if (passwordStrength === 'Weak') {
        newPasswordError.textContent = 'Password is too weak. Include numbers, special characters, and uppercase letters.';
        return false;
    }

    if (newPassword !== confirmPassword) {
        confirmPasswordError.textContent = 'New passwords do not match';
        return false;
    }

    const user_id = sessionStorage.getItem('temp_user_id');
    if (!user_id) {
        newPasswordError.textContent = 'User ID not found. Please log in again.';
        return false;
    }

    const formData = new FormData();
    formData.append('user_id', user_id);
    formData.append('currentPassword', currentPassword);
    formData.append('newPassword', newPassword);

    fetch('../actions/reset_password_action.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response Status:', response.status);
        return response.text().then(text => {
            console.log('Raw Response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('Failed to parse response as JSON: ' + text);
            }
        });
    })
    .then(data => {
        if (data.success) {
            alert('Password changed successfully! Please log in again with your new password.');
            closePasswordModal();
            sessionStorage.removeItem('temp_user_id');
            window.location.reload();
        } else {
            if (data.error === 'incorrect_current_password') {
                currentPasswordError.textContent = 'Current password is incorrect';
            } else {
                newPasswordError.textContent = data.message || 'An error occurred. Please try again.';
            }
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        newPasswordError.textContent = 'An error occurred: ' + error.message;
    });

    return false;
}

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

document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', validatePasswordForm);
    } else {
        console.error('Submit button not found');
    }

    const cancelBtn = document.getElementById('cancelBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closePasswordModal);
    } else {
        console.error('Cancel button not found');
    }

    const newPasswordInput = document.getElementById('newPassword');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', updatePasswordStrength);
    } else {
        console.error('New password input not found');
    }
});