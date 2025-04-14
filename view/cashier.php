<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard</title>
    <link rel="stylesheet" href="../css/cashier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="dashboard">
        <div class="header">
            <input type="text" class="search-bar" placeholder="Search patient name/ID...">
            <div class="header-actions">
                <div><i class="fas fa-calendar-alt"></i> <span id="current-date">Tuesday, May 14</span></div>
                <button class="logout-btn" onclick="window.location.href='logout.php'">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>
        
        <h2>Pending Payments</h2>
        <div class="payment-cards">
            <!-- Payment Card 1 -->
            <div class="payment-card">
                <div class="patient-info">
                    <div class="patient-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>John Doe</strong><br>
                        <span class="status-badge status-pending">Pending Payment</span>
                    </div>
                </div>
                
                <!-- Consultation Details -->
                <div class="service-section">
                    <div class="service-title">
                        <span><i class="fas fa-stethoscope"></i> Consultation</span>
                    </div>
                    <div class="service-item">
                        <span>Consultation with Dr. Smith</span>
                        <input type="number" class="price-input" value="500.00" min="0" step="0.01">
                    </div>
                </div>
                
                <!-- Prescriptions -->
                <div class="service-section">
                    <div class="service-title">
                        <span><i class="fas fa-prescription-bottle-alt"></i> Prescriptions</span>
                    </div>
                    <div class="service-item">
                        <span>Amoxicillin 500mg (30 tablets)</span>
                        <input type="number" class="price-input" value="350.00" min="0" step="0.01">
                    </div>
                    <div class="service-item">
                        <span>Ibuprofen 200mg (20 tablets)</span>
                        <input type="number" class="price-input" value="150.00" min="0" step="0.01">
                    </div>
                    <div class="service-item">
                        <span>Paracetamol 500mg (30 tablets)</span>
                        <input type="number" class="price-input" value="250.00" min="0" step="0.01">
                    </div>
                </div>
                
                <!-- Lab Tests -->
                <div class="service-section">
                    <div class="service-title">
                        <span><i class="fas fa-flask"></i> Lab Tests</span>
                    </div>
                    <div class="service-item">
                        <span>Complete Blood Count (CBC)</span>
                        <input type="number" class="price-input" value="800.00" min="0" step="0.01">
                    </div>
                    <div class="service-item">
                        <span>Malaria Test</span>
                        <input type="number" class="price-input" value="400.00" min="0" step="0.01">
                    </div>
                </div>
                
                <div class="payment-total">
                    <span>Total:</span>
                    <span id="totalAmount">GMD 2450.00</span>
                </div>
                
                <div class="payment-actions">
                    <button class="btn btn-secondary" onclick="viewDetails(1)">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                    <button class="btn btn-primary" onclick="processPayment(1)">
                        <i class="fas fa-money-bill-wave"></i> Process Payment
                    </button>
                </div>
            </div>
            
            <!-- Payment Card 2 -->
            <div class="payment-card">
                <div class="patient-info">
                    <div class="patient-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>Mary Smith</strong><br>
                        <span class="status-badge status-pending">Pending Payment</span>
                    </div>
                </div>
                
                <!-- Consultation Details -->
                <div class="service-section">
                    <div class="service-title">
                        <span><i class="fas fa-stethoscope"></i> Consultation</span>
                    </div>
                    <div class="service-item">
                        <span>Consultation with Dr. Johnson</span>
                        <input type="number" class="price-input" value="500.00" min="0" step="0.01">
                    </div>
                </div>
                
                <!-- Lab Tests -->
                <div class="service-section">
                    <div class="service-title">
                        <span><i class="fas fa-flask"></i> Lab Tests</span>
                    </div>
                    <div class="service-item">
                        <span>Urinalysis</span>
                        <input type="number" class="price-input" value="600.00" min="0" step="0.01">
                    </div>
                    <div class="service-item">
                        <span>Pregnancy Test</span>
                        <input type="number" class="price-input" value="250.00" min="0" step="0.01">
                    </div>
                </div>
                
                <div class="payment-total">
                    <span>Total:</span>
                    <span id="totalAmount">GMD 1350.00</span>
                </div>
                
                <div class="payment-actions">
                    <button class="btn btn-secondary" onclick="viewDetails(2)">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                    <button class="btn btn-primary" onclick="processPayment(2)">
                        <i class="fas fa-money-bill-wave"></i> Process Payment
                    </button>
                </div>
            </div>
        </div>
        
        <h2>Recent Payments</h2>
        <div class="payment-cards">
            <!-- Completed Payment Card -->
            <div class="payment-card">
                <div class="patient-info">
                    <div class="patient-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>Thomas Brown</strong><br>
                        <span class="status-badge status-paid">Paid - 15/11/2023</span>
                    </div>
                </div>
                
                <div class="service-section">
                    <div class="service-title">
                        <span><i class="fas fa-stethoscope"></i> Consultation</span>
                    </div>
                    <div class="service-item">
                        <span>Consultation with Dr. Williams</span>
                        <span>GMD 500.00</span>
                    </div>
                </div>
                
                <div class="service-section">
                    <div class="service-title">
                        <span><i class="fas fa-prescription-bottle-alt"></i> Prescriptions</span>
                    </div>
                    <div class="service-item">
                        <span>Lisinopril 10mg (30 tablets)</span>
                        <span>GMD 1200.00</span>
                    </div>
                </div>
                
                <div class="payment-total">
                    <span>Total Paid:</span>
                    <span>GMD 1700.00</span>
                </div>
                
                <div class="payment-actions">
                    <button class="btn btn-secondary" onclick="viewDetails(3)">
                        <i class="fas fa-receipt"></i> View Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Details Modal -->
    <div class="modal" id="detailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Service Details</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            
            <div class="patient-info" style="margin-bottom: 20px;">
                <div class="patient-photo" id="detailPatientPhoto">JD</div>
                <div>
                    <strong id="detailPatientName">John Doe</strong><br>
                    <span id="detailPatientInfo">ID: PT-1024 | 15/11/2023</span>
                </div>
            </div>
            
            <!-- Consultation Details -->
            <div style="margin-bottom: 25px;">
                <h3 style="color: #0054A6; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <i class="fas fa-stethoscope"></i> Consultation Details
                </h3>
                <div style="background-color: #f5f9ff; padding: 15px; border-radius: 6px;">
                    <p><strong>Doctor:</strong> Dr. Smith</p>
                    <p><strong>Date:</strong> 15/11/2023</p>
                    <p><strong>Diagnosis:</strong> Upper respiratory infection</p>
                    <p><strong>Notes:</strong> Patient presented with fever and cough for 3 days</p>
                </div>
            </div>
            
            <!-- Prescriptions -->
            <div style="margin-bottom: 25px;">
                <h3 style="color: #0054A6; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <i class="fas fa-prescription-bottle-alt"></i> Prescriptions
                </h3>
                <div class="prescription-item">
                    <div>
                        <strong>Amoxicillin 500mg</strong><br>
                        <span>Take 1 tablet every 8 hours for 7 days</span>
                    </div>
                    <div>
                        <strong>GMD 350.00</strong>
                    </div>
                </div>
                <div class="prescription-item">
                    <div>
                        <strong>Ibuprofen 200mg</strong><br>
                        <span>Take as needed for pain (max 3/day)</span>
                    </div>
                    <div>
                        <strong>GMD 150.00</strong>
                    </div>
                </div>
            </div>
            
            <!-- Lab Tests -->
            <div style="margin-bottom: 25px;">
                <h3 style="color: #0054A6; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <i class="fas fa-flask"></i> Lab Tests
                </h3>
                <div class="test-item">
                    <div>
                        <strong>Complete Blood Count (CBC)</strong><br>
                        <span>Results: WBC 6.5, RBC 4.8, HGB 14.2</span>
                    </div>
                    <div>
                        <strong>GMD 800.00</strong>
                    </div>
                </div>
                <div class="test-item">
                    <div>
                        <strong>Malaria Test</strong><br>
                        <span>Results: Negative</span>
                    </div>
                    <div>
                        <strong>GMD 400.00</strong>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end;">
                <button class="btn btn-secondary" onclick="closeModal()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
    
    <!-- Receipt Modal -->
    <div class="receipt-modal" id="receiptModal">
        <div class="receipt-content">
            <div class="receipt-print">
                <div class="receipt-logo">
                    <h2 style="color: #0054A6;">BAFROW MEDICAL CENTER</h2>
                    <p>123 Health Street, Serrekunda</p>
                    <p>Tel: +220 123 4567 | Email: info@bafrow.org</p>
                </div>
                
                <div class="receipt-header">
                    <h3>PAYMENT RECEIPT</h3>
                    <p>Receipt #: <span id="receiptNumber">RC-2023-001</span></p>
                    <p>Date: <span id="receiptDate">15/11/2023 10:30 AM</span></p>
                </div>
                
                <div class="receipt-details">
                    <p><strong>Patient:</strong> <span id="receiptPatient">Thomas Brown</span></p>
                    <p><strong>Patient ID:</strong> <span id="receiptPatientId">PT-3096</span></p>
                    <p><strong>Cashier:</strong> <span id="receiptCashier">Fatou Jallow</span></p>
                </div>
                
                <table class="receipt-items">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount (GMD)</th>
                        </tr>
                    </thead>
                    <tbody id="receiptItems">
                        <tr>
                            <td>Consultation with Dr. Williams</td>
                            <td>500.00</td>
                        </tr>
                        <tr>
                            <td>Lisinopril 10mg (30 tablets)</td>
                            <td>1200.00</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="receipt-total">
                    <p>Total: <span id="receiptTotal">1700.00</span> GMD</p>
                    <p>Payment Method: <span id="receiptMethod">Cash</span></p>
                </div>
                
                <div class="receipt-footer">
                    <p>Thank you for choosing Bafrow Medical Center</p>
                    <p>This is an official receipt</p>
                </div>
            </div>
            
            <div class="no-print" style="display: flex; justify-content: center; gap: 15px; margin-top: 25px;">
                <button class="btn btn-secondary" onclick="closeReceipt()">
                    <i class="fas fa-times"></i> Close
                </button>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>

    <script src="../js/cashier.js"></script>
</body>
</html>