const addItemBtn = document.getElementById('addItemBtn');
const addItemForm = document.getElementById('addItemForm');
const editItemForm = document.getElementById('editItemForm');
const overlay = document.getElementById('overlay');
const cancelAddItem = document.getElementById('cancelAddItem');
const cancelEditItem = document.getElementById('cancelEditItem');
const editItemBtn = document.querySelectorAll('.editItemBtn');
const deleteItemBtn = document.querySelector('.deleteItemBtn');

addItemBtn.addEventListener('click', () => {
    addItemForm.classList.add('active');
    overlay.classList.add('active');
});

editItemBtn.forEach(btn => {
    btn.addEventListener('click', async () => {
        const clinicId = btn.getAttribute('data-clinic-id');
        
        try {
            const response = await fetch('../actions/view_clinic.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `clinic_id=${clinicId}`
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            let clinicData = await response.json();
            
            const clinic = clinicData[0];
            
            document.getElementById('editclinicId').value = clinic.clinic_id;
            document.getElementById('editclinicName').value = clinic.clinic_name;
            document.getElementById('editDepartment').value = clinic.department_id;
            
            editItemForm.classList.add('active');
            overlay.classList.add('active');
            
        } catch (error) {
            alert('Error loading clinic data. Please try again.');
        }
    });
});


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

document.getElementById('addItem').addEventListener('submit', (e) => {
    e.preventDefault();

    var form = document.getElementById("addItem");
    var formData = new FormData(form);

    fetch("../actions/add_clinic.php", {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            alert(data.message);
            addItemForm.classList.remove('active');
            overlay.classList.remove('active');
            location.reload();
        } else {
            alert(data.message);
            form.reset();
        }
    })
    .catch((error) => {
        alert('An unexpected error occurred. Please try again.');
    });
});

document.getElementById('editItem').addEventListener('submit', (e) => {
    e.preventDefault();

    var form = document.getElementById("editItem");
    var formData = new FormData(form);

    fetch("../actions/update_clinic.php", {
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
            editItemForm.classList.remove('active');
            overlay.classList.remove('active');
            location.reload();
        } else {
                alert("Registration error:", data.message);
                setTimeout(() => {
                    location.reload();
                }, 5000);
        }
    });
    editItemForm.classList.remove('active');
    overlay.classList.remove('active');
});

document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('deleteItemBtn')) {
        const clinicId = e.target.getAttribute('data-clinic-id');
        
        if (confirm('Are you sure you want to delete this clinic record?')) {
            try {
                const response = await fetch('../actions/delete_clinic.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `clinic_id=${clinicId}`
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Error deleting clinic record. Please try again.');
            }
        }
    }
});