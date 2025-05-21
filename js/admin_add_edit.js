const addItemBtn = document.getElementById('addItemBtn');
const addItemForm = document.getElementById('addItemForm');
const editItemForm = document.getElementById('editItemForm');
const overlay = document.getElementById('overlay');
const cancelAddItem = document.getElementById('cancelAddItem');
const cancelEditItem = document.getElementById('cancelEditItem');
const editItemBtn = document.querySelectorAll('.editItemBtn');

addItemBtn.addEventListener('click', () => {
    addItemForm.classList.add('active');
    overlay.classList.add('active');
});

editItemBtn.forEach(btn => {
    btn.addEventListener('click', async () => {
        const adminId = btn.getAttribute('data-admin-id');
        
        try {
            const response = await fetch('../actions/view_admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `admin_id=${adminId}`
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            let adminData = await response.json();
            
            const admin = adminData[0];
            
            document.getElementById('originalAdminId').value = admin.admin_id;
            document.getElementById('editadminId').value = admin.admin_id;
            document.getElementById('editFirstName').value = admin.first_name;
            document.getElementById('editLastName').value = admin.last_name;
            document.getElementById('editContact').value = admin.contact;
            
            editItemForm.classList.add('active');
            overlay.classList.add('active');
            
        } catch (error) {
            alert('Error loading admin data. Please try again.');
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

document.getElementById('addItem').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = document.getElementById("addItem");
    const formData = new FormData(form);

    try {
        const response = await fetch("../actions/add_admin.php", {
            method: "POST",
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            addItemForm.classList.remove('active');
            overlay.classList.remove('active');
            location.reload();
        } else {
            alert(data.message);
            form.reset();
        }
    } catch (error) {
        alert('An unexpected error occurred. Please try again.');
    }
});


document.getElementById('editItem').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = document.getElementById("editItem");
    const formData = new FormData(form);

    try {
        const response = await fetch("../actions/update_admin.php", {
            method: "POST",
            body: formData,
        });

        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            throw new Error('Invalid response: ' + text);
        }

        const data = await response.json();

        if (data.success) {
            alert('Admin updated successfully!');
            location.href = '../view/admin.php';
        } else {
            alert("Update error: " + data.message);
            setTimeout(() => {
                location.reload();
            }, 5000);
        }
    } catch (error) {
        alert('An unexpected error occurred: ' + error.message);
    }
});

document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('deleteItemBtn')) {
        const adminId = e.target.getAttribute('data-admin-id');
        
        if (confirm('Are you sure you want to delete this admin record?')) {
            try {
                const response = await fetch('../actions/delete_admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `admin_id=${adminId}`
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
                alert('Error deleting admin record. Please try again.');
            }
        }
    }
});