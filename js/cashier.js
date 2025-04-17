 // Update current date
 function updateCurrentDate() {
    const now = new Date();
    const options = { weekday: 'long', month: 'long', day: 'numeric' };
    document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', options);
}

// Calculate totals when prices change
document.querySelectorAll('.price-input').forEach(input => {
    input.addEventListener('input', calculateTotal);
});

function calculateTotal() {
    const card = this.closest('.payment-card');
    let total = 0;
    
    card.querySelectorAll('.price-input').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    
    card.querySelector('.payment-total span:last-child').textContent = 'GMD ' + total.toFixed(2);
}

// View details modal
function viewDetails(paymentId) {
    if (paymentId === 3) { // This is the paid receipt
        // Set receipt data
        document.getElementById('receiptNumber').textContent = 'RC-2023-' + (1000 + paymentId);
        document.getElementById('receiptPatient').textContent = 'Thomas Brown';
        document.getElementById('receiptPatientId').textContent = 'PT-3096';
        document.getElementById('receiptCashier').textContent = 'Fatou Jallow';
        
        // Set receipt date to current date/time
        const now = new Date();
        const dateStr = now.toLocaleDateString('en-GB') + ' ' + 
                       now.toLocaleTimeString('en-GB', {hour: '2-digit', minute: '2-digit'});
        document.getElementById('receiptDate').textContent = dateStr;
        
        // Set receipt items (in a real app this would come from the payment data)
        const items = [
            { description: 'Consultation with Dr. Williams', amount: '500.00' },
            { description: 'Lisinopril 10mg (30 tablets)', amount: '1200.00' }
        ];
        
        const itemsContainer = document.getElementById('receiptItems');
        itemsContainer.innerHTML = '';
        items.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.description}</td>
                <td>${item.amount}</td>
            `;
            itemsContainer.appendChild(row);
        });
        
        // Calculate and set total
        const total = items.reduce((sum, item) => sum + parseFloat(item.amount), 0);
        document.getElementById('receiptTotal').textContent = total.toFixed(2);
        
        document.getElementById('receiptModal').style.display = 'flex';
    } else {
        // Show regular details modal for pending payments
        document.getElementById('detailPatientPhoto').textContent = paymentId === 1 ? 'JD' : 'MS';
        document.getElementById('detailPatientName').textContent = 
            paymentId === 1 ? 'John Doe' : 'Mary Smith';
        
        document.getElementById('detailsModal').style.display = 'flex';
    }
}

function processPayment(paymentId) {
    alert('Payment for patient #' + paymentId + ' processed successfully!');
    // In real app, would submit to server and update UI
}

function closeModal() {
    document.getElementById('detailsModal').style.display = 'none';
}

function closeReceipt() {
    document.getElementById('receiptModal').style.display = 'none';
}

// Initialize
updateCurrentDate();

// Calculate all totals on page load
document.querySelectorAll('.payment-card').forEach(card => {
    let total = 0;
    card.querySelectorAll('.price-input').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    if (total > 0) {
        card.querySelector('.payment-total span:last-child').textContent = 'GMD ' + total.toFixed(2);
    }
});

document.getElementById('logoutBtn').addEventListener('click', function(e) {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = '../actions/logoutactions.php';
    }
});