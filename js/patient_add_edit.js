// JavaScript for handling pop-up forms (generalized)
const addItemBtn = document.getElementById('addItemBtn');
const addItemForm = document.getElementById('addItemForm');
const editItemForm = document.getElementById('editItemForm');
const overlay = document.getElementById('overlay');
const cancelAddItem = document.getElementById('cancelAddItem');
const cancelEditItem = document.getElementById('cancelEditItem');
const editItemBtns = document.querySelectorAll('.editItemBtn');

// Show Add Item Form
addItemBtn.addEventListener('click', () => {
    addItemForm.classList.add('active');
    overlay.classList.add('active');
});

// Show Edit Item Form and fetch patient data
editItemBtns.forEach(btn => {
    btn.addEventListener('click', async () => {
        const patientId = btn.getAttribute('data-patient-id');
        
        try {
            // Fetch patient data
            const response = await fetch('../actions/admin_actions/admin_view_actions/admin_view_patient.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `patient_id=${patientId}`
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const patient = await response.json();
            
            // Populate form fields
            document.getElementById('editPatientId').value = patient.patient_id;
            document.getElementById('editFirstName').value = patient.first_name;
            document.getElementById('editLastName').value = patient.last_name;
            document.getElementById('editDob').value = patient.DOB;
            document.getElementById('editWeight').value = patient.weight;
            document.getElementById('editAddress').value = patient.address;
            document.getElementById('editContact').value = patient.contact;
            document.getElementById('editNextOfKin').value = patient.nextofkin;
            document.getElementById('editNextOfKinContact').value = patient.nextofkincontact;
            document.getElementById('editNextOfKinGender').value = patient.nextofkingender;
            document.getElementById('editNextOfKinRelationship').value = patient.nextofkinrelationship;
            
            // Show the form
            editItemForm.classList.add('active');
            overlay.classList.add('active');
            
        } catch (error) {
            console.error('Error fetching patient data:', error);
            alert('Error loading patient data. Please try again.');
        }
    });
});

// Close Forms
cancelAddItem.addEventListener('click', () => {
    addItemForm.classList.remove('active');
    overlay.classList.remove('active');
});

cancelEditItem.addEventListener('click', () => {
    editItemForm.classList.remove('active');
    overlay.classList.remove('active');
});

overlay.addEventListener('click', () => {
    addItemForm.classList.remove('active');
    editItemForm.classList.remove('active');
    overlay.classList.remove('active');
});

// Handle Add Item Form Submission
document.getElementById('addItem').addEventListener('submit', (e) => {
    e.preventDefault();

    var form = document.getElementById("addItem");
    var formData = new FormData(form);

    // Send the data to the server using fetch
    fetch("../actions/admin_actions/admin_add_patients.php", {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.includes("application/json")) {
            return response.json();
        } else {
            return response.text().then(text => { throw new Error(text); });
        }
    })
    .then((data) => {
        if (data.success) {
            // Redirect on success
            location.href = '../view/customerlogin.php';
        } else {
                // Log error and reload page on server-side failure
                alert("Registration error:", data.message);
                setTimeout(() => {
                    location.reload();
                }, 5000);
        }
    });

    alert('Item added successfully!');
    addItemForm.classList.remove('active');
    overlay.classList.remove('active');
});

// Handle Edit Item Form Submission
document.getElementById('editItem').addEventListener('submit', (e) => {
    e.preventDefault();

    var form = document.getElementById("editItem");
    var formData = new FormData(form);

    // Send the data to the server using fetch
    fetch("../actions/admin_actions/admin_update_patiens.php", {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.includes("application/json")) {
            return response.json();
        } else {
            return response.text().then(text => { throw new Error(text); });
        }
    })
    .then((data) => {
        if (data.success) {
            // Redirect on success
            location.href = '../view/customerlogin.php';
        } else {
                // Log error and reload page on server-side failure
                alert("Registration error:", data.message);
                setTimeout(() => {
                    location.reload();
                }, 5000);
        }
    });

    alert('Item updated successfully!');
    editItemForm.classList.remove('active');
    overlay.classList.remove('active');
});