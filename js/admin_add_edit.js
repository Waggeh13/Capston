// JavaScript for handling pop-up forms (generalized)
const addItemBtn = document.getElementById('addItemBtn');
const addItemForm = document.getElementById('addItemForm');
const editItemForm = document.getElementById('editItemForm');
const overlay = document.getElementById('overlay');
const cancelAddItem = document.getElementById('cancelAddItem');
const cancelEditItem = document.getElementById('cancelEditItem');
const editItemBtn = document.querySelectorAll('.editItemBtn');
const deleteItemBtn = document.querySelector('.deleteItemBtn');

// Show Add Item Form
addItemBtn.addEventListener('click', () => {
    addItemForm.classList.add('active');
    overlay.classList.add('active');
});

// Show Edit Item Form and fetch admin data
editItemBtn.forEach(btn => {
    btn.addEventListener('click', async () => {
        const adminId = btn.getAttribute('data-admin-id');
        
        try {
            // Fetch admin data
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
            
            // Since the response is an array, get the first item
            const admin = adminData[0];
            
            // Populate form fields
            document.getElementById('editadminId').value = admin.admin_id;
            document.getElementById('editFirstName').value = admin.first_name;
            document.getElementById('editLastName').value = admin.last_name;
            document.getElementById('editContact').value = admin.contact;
            
            // Show the form
            editItemForm.classList.add('active');
            overlay.classList.add('active');
            
        } catch (error) {
            alert('Error loading admin data. Please try again.');
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

    fetch("../actions/add_admin.php", {
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

// Handle Edit Item Form Submission
document.getElementById('editItem').addEventListener('submit', (e) => {
    e.preventDefault();

    var form = document.getElementById("editItem");
    var formData = new FormData(form);

    // Send the data to the server using fetch
    fetch("../actions/update_admin.php", {
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
            location.href = '../view/admin.php';
        } else {
                // Log error and reload page on server-side failure
                alert("Registration error:", data.message);
                setTimeout(() => {
                    location.reload();
                }, 5000);
        }
    });

    alert('Admin updated successfully!');
    editItemForm.classList.remove('active');
    overlay.classList.remove('active');
});

// Handle Delete Item
document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('deleteItemBtn')) {
        const adminId = e.target.getAttribute('data-admin-id');
        
        // Confirm before deleting
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