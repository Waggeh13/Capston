/**
 * Handles medical summary upload and template download functionality.
 */

/**
 * Opens the modal to upload a filled summary for a patient.
 * @param {string} requestId - The unique ID of the request.
 * @param {string} patientId - The unique ID of the patient.
 * @param {string} patientName - The name of the patient.
 * @param {string} destination - The destination hospital.
 */
function openSummaryModal(requestId, patientId, patientName, destination) {
    document.getElementById('modalPatientName').textContent = patientName;
    document.getElementById('summaryFile').value = ''; // Clear file input
    document.getElementById('summaryModal').dataset.requestId = requestId;
    document.getElementById('summaryModal').dataset.patientId = patientId;
    document.getElementById('summaryModal').dataset.destination = destination;
    document.getElementById('summaryModal').style.display = 'flex';
}

/**
 * Closes the summary upload modal.
 */
function closeSummaryModal() {
    document.getElementById('summaryModal').style.display = 'none';
}

/**
 * Sends the uploaded summary PDF to the destination hospital.
 */
async function sendSummary() {
    const requestId = document.getElementById('summaryModal').dataset.requestId;
    const patientId = document.getElementById('summaryModal').dataset.patientId;
    const patientName = document.getElementById('modalPatientName').textContent;
    const destination = document.getElementById('summaryModal').dataset.destination;
    const fileInput = document.getElementById('summaryFile');
    const file = fileInput.files[0];

    if (!file) {
        alert("Please select a PDF file to upload.");
        return;
    }

    if (!file.type.includes("pdf")) {
        alert("Please upload a PDF file.");
        return;
    }

    // Create FormData for file upload
    const uploadFormData = new FormData();
    uploadFormData.append('file', file, `summary_${requestId}_${patientId}_doctor.pdf`);

    try {
        // Send file to the upload endpoint
        const uploadResponse = await fetch('http://165.22.117.96/upload.php', {
            method: 'POST',
            body: uploadFormData
        });

        const uploadData = await uploadResponse.json();

        if (!uploadResponse.ok) {
            throw new Error(`Upload failed with status: ${uploadResponse.status}`);
        }

        if (!uploadData.url) {
            throw new Error('Upload response missing URL field');
        }

        const fileUrl = uploadData.url;

        // Send metadata to send_summary_action.php
        const apiFormData = new FormData();
        apiFormData.append('request_id', requestId);
        apiFormData.append('patient_id', patientId);
        apiFormData.append('file_url', fileUrl);

        const apiResponse = await fetch('../actions/send_summary_action.php', {
            method: 'POST',
            body: apiFormData
        });

        const apiData = await apiResponse.json();

        if (!apiResponse.ok) {
            throw new Error(`API request failed with status: ${apiResponse.status}`);
        }

        if (apiData.success) {
            alert(`Summary for ${patientName} sent to ${destination} successfully!`);
            closeSummaryModal();
            window.location.reload();
        } else {
            alert(apiData.message || 'Error sending summary: Unknown error');
        }
    } catch (error) {
        alert('Error sending summary: ' + error.message);
    }
}

/**
 * Downloads the medical summary template as a Word document.
 * @param {string} patientId - The unique ID of the patient.
 * @param {string} patientName - The name of the patient.
 */
function downloadTemplate(patientId, patientName) {
    const link = document.createElement('a');
    link.href = '../summary/Summary_template.docx';
    link.download = `Summary_template.docx`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}