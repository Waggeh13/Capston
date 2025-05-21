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
        const staffId = btn.getAttribute('data-staff-id');
        
        try {
            const response = await fetch('../actions/view_staff.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `staff_id=${staffId}`
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            let staffData = await response.json();
            
            const staff = staffData[0];
            
            document.getElementById('originalstaffId').value = staff.staff_id;
            document.getElementById('editStaffId').value = staff.staff_id;
            document.getElementById('editFirstName').value = staff.first_name;
            document.getElementById('editLastName').value = staff.last_name;
            document.getElementById('editGender').value = staff.Gender;
            document.getElementById('editPosition').value = staff.position;
            document.getElementById('editDepartment').value = staff.department_id;
            document.getElementById('editContact').value = staff.phone;
            document.getElementById('editEmail').value = staff.email;
            
            editItemForm.classList.add('active');
            overlay.classList.add('active');
            
        } catch (error) {
            alert('Error loading staff data. Please try again.');
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

    fetch("../actions/add_staff.php", {
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
        alert(error);
    });
});

document.getElementById('editItem').addEventListener('submit', (e) => {
    e.preventDefault();

    var form = document.getElementById("editItem");
    var formData = new FormData(form);

    fetch("../actions/update_staff.php", {
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
            location.reload();
        } else {
                alert("Registration error:", data.message);
                setTimeout(() => {
                    location.reload();
                }, 5000);
        }
    });

    alert('Staff updated successfully!');
    editItemForm.classList.remove('active');
    overlay.classList.remove('active');
});

document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('deleteItemBtn')) {
        const staffId = e.target.getAttribute('data-staff-id');

        if (confirm('Are you sure you want to delete this staff record?')) {
            try {
                const response = await fetch('../actions/delete_staff.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `staff_id=${staffId}`
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
                alert('Error deleting staff record. Please try again.');
            }
        }
    }
});