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

// Show Edit Item Form
editItemBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        editItemForm.classList.add('active');
        overlay.classList.add('active');
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

    // Get values from the form
    const itemName = document.getElementById('itemName').value;
    const itemDescription = document.getElementById('itemDescription').value;
    const itemCategory = document.getElementById('itemCategory').value;

    // Log or process the values
    console.log('Item Name:', itemName);
    console.log('Item Description:', itemDescription);
    console.log('Item Category:', itemCategory);

    alert('Item added successfully!');
    addItemForm.classList.remove('active');
    overlay.classList.remove('active');
});

// Handle Edit Item Form Submission
document.getElementById('editItem').addEventListener('submit', (e) => {
    e.preventDefault();

    // Get values from the form
    const editItemName = document.getElementById('editItemName').value;
    const editItemDescription = document.getElementById('editItemDescription').value;
    const editItemCategory = document.getElementById('editItemCategory').value;

    // Log or process the values
    console.log('Edit Item Name:', editItemName);
    console.log('Edit Item Description:', editItemDescription);
    console.log('Edit Item Category:', editItemCategory);

    alert('Item updated successfully!');
    editItemForm.classList.remove('active');
    overlay.classList.remove('active');
});