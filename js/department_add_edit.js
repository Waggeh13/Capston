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
        const departmentId = btn.getAttribute('data-department-id');
        
        try {
            const response = await fetch('../actions/view_department.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `department_id=${departmentId}`
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            let departmentData = await response.json();
            
            const department = departmentData[0];
            
            document.getElementById('editDepartmentId').value = department.department_id;
            document.getElementById('editDepartmentName').value = department.department_name;
            
            editItemForm.classList.add('active');
            overlay.classList.add('active');
            
        } catch (error) {
            alert('Error loading department data. Please try again.');
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

    fetch("../actions/add_department.php", {
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

    fetch("../actions/update_department.php", {
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
        const departmentId = e.target.getAttribute('data-department-id');
        
        if (confirm('Are you sure you want to delete this department record?')) {
            try {
                const response = await fetch('../actions/delete_department.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `department_id=${departmentId}`
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
                alert('Error deleting department record. Please try again.');
            }
        }
    }
});