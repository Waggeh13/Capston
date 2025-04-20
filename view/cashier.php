<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard</title>
    <link rel="stylesheet" href="../css/cashier.css">
    <link rel="stylesheet" href="../css/pharmacist_header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    .settings-btn, .logout-btn {
        text-decoration: none;
    }
</style>

<?php
require_once('../settings/core.php');
require_once('../classes/userName_class.php');
require_once('../controllers/cashier_controller.php');
redirect_cashier_if_not_logged_in();

$userProfile = new userName_class();
$pending_payments = viewPendingPaymentsController();
$recent_payments = viewRecentPaymentsController();
?>

<body>
    <div class="dashboard">
        <div class="header">
            <div class="header-left">
                <div class="username-section">
                    <i class="fas fa-user-circle"></i>
                    <span id="username"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>
            <div class="header-right">
                <div class="header-date">
                    <i class="fas fa-calendar-alt"></i> 
                    <span id="real-time-date"></span>
                </div>
                <a href="../view/cashier_setting.php" class="settings-btn" id="settingsBtn" title="Settings">
                    <i class="fas fa-cog"></i>
                </a>
                <a href="../actions/logoutactions.php" class="logout-btn" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <h2>Pending Payments</h2>
        <div class="payment-cards">
            <?php
            if (!empty($pending_payments)) {
                $grouped_payments = [];
                foreach ($pending_payments as $payment) {
                    $key = $payment['patient']['patient_id'] . '_' . $payment['prescription_id'];
                    if (!isset($grouped_payments[$key])) {
                        $grouped_payments[$key] = [
                            'patient' => $payment['patient'],
                            'prescription_id' => $payment['prescription_id'],
                            'medications' => [],
                            'consultations' => $payment['consultations'],
                            'lab_tests' => $payment['lab_tests'],
                            'dispensed_ids' => []
                        ];
                    }
                    $grouped_payments[$key]['medications'][] = $payment['medication'];
                    $grouped_payments[$key]['dispensed_ids'][] = $payment['dispensed_id'];
                }

                foreach ($grouped_payments as $key => $payment) {
                    $patient = $payment['patient'];
                    $initials = strtoupper(substr($patient['first_name'], 0, 1) . substr($patient['last_name'], 0, 1));
                    ?>
                    <div class="payment-card" data-dispensed-ids='<?php echo json_encode($payment['dispensed_ids']); ?>' 
                         data-patient-id="<?php echo htmlspecialchars($patient['patient_id']); ?>" 
                         data-prescription-id="<?php echo htmlspecialchars($payment['prescription_id']); ?>">
                        <div class="patient-info">
                            <div class="patient-photo"><?php echo $initials; ?></div>
                            <div>
                                <strong><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></strong><br>
                                <span class="status-badge status-pending">Pending Payment</span>
                            </div>
                        </div>
                        
                        <!-- Consultation Details -->
                        <div class="service-section">
                            <div class="service-title">
                                <span><i class="fas fa-stethoscope"></i> Consultation</span>
                            </div>
                            <?php
                            if (!empty($payment['consultations'])) {
                                foreach ($payment['consultations'] as $consult) {
                                    ?>
                                    <div class="service-item">
                                        <span>Consultation with Dr. <?php echo htmlspecialchars($consult['doctor_last_name']); ?></span>
                                        <input type="number" class="price-input" value="500.00" min="0" step="0.01" data-type="consultation" data-id="<?php echo $consult['booking_id']; ?>">
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="service-item">
                                    <span>No consultation recorded</span>
                                    <input type="number" class="price-input" value="0.00" min="0" step="0.01" data-type="consultation" data-id="0" disabled>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        
                        <!-- Prescriptions -->
                        <div class="service-section">
                            <div class="service-title">
                                <span><i class="fas fa-prescription-bottle-alt"></i> Prescriptions</span>
                            </div>
                            <?php
                            foreach ($payment['medications'] as $med) {
                                ?>
                                <div class="service-item">
                                    <span><?php echo htmlspecialchars($med['medication'] . ' ' . $med['dosage'] . ' (' . $med['quantity_dispensed'] . ')'); ?></span>
                                    <input type="number" class="price-input" value="0.00" min="0" step="0.01" data-type="medication">
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        
                        <!-- Lab Tests -->
                        <div class="service-section">
                            <div class="service-title">
                                <span><i class="fas fa-flask"></i> Lab Tests</span>
                            </div>
                            <?php
                            if (!empty($payment['lab_tests'])) {
                                foreach ($payment['lab_tests'] as $test) {
                                    ?>
                                    <div class="service-item">
                                        <span><?php echo htmlspecialchars($test['test_name']); ?></span>
                                        <input type="number" class="price-input" value="0.00" min="0" step="0.01" data-type="lab_test" data-id="<?php echo $test['lab_test_id']; ?>">
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="service-item">
                                    <span>No lab tests recorded</span>
                                    <input type="number" class="price-input" value="0.00" min="0" step="0.01" data-type="lab_test" data-id="0" disabled>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        
                        <div class="payment-total">
                            <span>Total:</span>
                            <span class="total-amount">GMD 0.00</span>
                        </div>
                        
                        <div class="payment-actions">
                            <button class="btn btn-secondary" onclick="viewDetails('<?php echo $patient['patient_id']; ?>', '<?php echo $payment['prescription_id']; ?>')">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                            <button class="btn btn-primary" onclick="processPayment(this)">
                                <i class="fas fa-money-bill-wave"></i> Process Payment
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No pending payments to display.</p>';
            }
            ?>
        </div>
        
        <h2>Recent Payments</h2>
        <div class="payment-cards">
            <?php
            if (!empty($recent_payments)) {
                foreach ($recent_payments as $payment) {
                    $initials = strtoupper(substr($payment['patient_first_name'], 0, 1) . substr($payment['patient_last_name'], 0, 1));
                    ?>
                    <div class="payment-card">
                        <div class="patient-info">
                            <div class="patient-photo"><?php echo $initials; ?></div>
                            <div>
                                <strong><?php echo htmlspecialchars($payment['patient_first_name'] . ' ' . $payment['patient_last_name']); ?></strong><br>
                                <span class="status-badge status-paid">Paid</span>
                            </div>
                        </div>
                        
                        <div class="payment-total">
                            <span>Total Paid:</span>
                            <span>GMD <?php echo number_format($payment['total'], 2); ?></span>
                        </div>
                        
                        <div class="payment-actions">
                            <button class="btn btn-secondary" onclick="viewReceipt('<?php echo $payment['receipt_id']; ?>')">
                                <i class="fas fa-receipt"></i> View Receipt
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No recent payments to display.</p>';
            }
            ?>
        </div>
    </div>
    
    <!-- Details Modal -->
    <div class="modal" id="detailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Service Details</h2>
                <button class="close-btn" onclick="closeModal()">×</button>
            </div>
            
            <div class="patient-info" style="margin-bottom: 20px;" id="detailPatientInfo">
                <!-- Filled by JavaScript -->
            </div>
            
            <div id="consultationDetails" style="margin-bottom: 25px;">
                <!-- Filled by JavaScript -->
            </div>
            
            <div id="prescriptionDetails" style="margin-bottom: 25px;">
                <!-- Filled by JavaScript -->
            </div>
            
            <div id="labTestDetails" style="margin-bottom: 25px;">
                <!-- Filled by JavaScript -->
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
                    <p>Receipt #: <span id="receiptNumber"></span></p>
                    <p>Date: <span id="receiptDate"></span></p>
                </div>
                
                <div class="receipt-details">
                    <p><strong>Patient:</strong> <span id="receiptPatient"></span></p>
                    <p><strong>Patient ID:</strong> <span id="receiptPatientId"></span></p>
                    <p><strong>Cashier:</strong> <span id="receiptCashier"></span></p>
                </div>
                
                <table class="receipt-items">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount (GMD)</th>
                        </tr>
                    </thead>
                    <tbody id="receiptItems">
                        <!-- Filled by JavaScript -->
                    </tbody>
                </table>
                
                <div class="receipt-total">
                    <p>Total: <span id="receiptTotal"></span> GMD</p>
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
    
    <script src="../js/dark_mode.js"></script>
    <script src="../js/cashier.js?v=<?php echo time(); ?>"></script>
    <script src="../js/real_time_date.js"></script>
</body>
</html>