document.addEventListener('DOMContentLoaded', function() {
    const requestModal = document.getElementById('requestModal');
    const requestForm = document.getElementById('requestForm');
    const requestMedicalReportBtn = document.getElementById('requestMedicalReportBtn');
    const requestCancelBtn = document.getElementById('requestCancelBtn');
    const requestCancelBtnSecondary = document.getElementById('requestCancelBtnSecondary');
    const requestSubmitBtn = document.getElementById('requestSubmitBtn');
    const doctorIdSelect = document.getElementById('doctorId');
    const hospitalNameInput = document.getElementById('hospitalName');
    const doctorIdError = document.getElementById('doctorIdError');
    const hospitalNameError = document.getElementById('hospitalNameError');

    if (!requestModal || !requestForm || !requestMedicalReportBtn || !requestCancelBtn || 
        !requestCancelBtnSecondary || !requestSubmitBtn || !doctorIdSelect || 
        !hospitalNameInput || !doctorIdError || !hospitalNameError) {
        console.error('One or more required elements are missing.');
        return;
    }

    requestMedicalReportBtn.addEventListener('click', openRequestModal);
    requestCancelBtn.addEventListener('click', closeRequestModal);
    requestCancelBtnSecondary.addEventListener('click', closeRequestModal);
    requestSubmitBtn.addEventListener('click', handleFormSubmission);

    function openRequestModal() {
        requestForm.reset();
        doctorIdError.textContent = '';
        hospitalNameError.textContent = '';
        requestModal.style.display = 'block';
    }

    function closeRequestModal() {
        requestModal.style.display = 'none';
        requestForm.reset();
        doctorIdError.textContent = '';
        hospitalNameError.textContent = '';
    }

    function validateForm() {
        let isValid = true;
        doctorIdError.textContent = '';
        hospitalNameError.textContent = '';

        if (!doctorIdSelect.value) {
            doctorIdError.textContent = 'Please select a doctor.';
            isValid = false;
        }

        if (!hospitalNameInput.value.trim()) {
            hospitalNameError.textContent = 'Please enter a hospital name.';
            isValid = false;
        } else if (hospitalNameInput.value.trim().length < 3) {
            hospitalNameError.textContent = 'Hospital name must be at least 3 characters long.';
            isValid = false;
        }

        return isValid;
    }

    async function handleFormSubmission(e) {
        e.preventDefault();
        if (!validateForm()) {
            return;
        }

        const formData = new FormData(requestForm);
        try {
            const response = await fetch('../actions/request_action.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            if (data.success) {
                alert(data.message);
                closeRequestModal();
            } else {
                alert(data.message || 'Failed to submit request: Unknown error');
            }
        } catch (error) {
            console.error('Error submitting request:', error);
            alert(`Error submitting request: ${error.message}`);
        }
    }

    window.addEventListener('click', function(event) {
        if (event.target === requestModal) {
            closeRequestModal();
        }
    });
});