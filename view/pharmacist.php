<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../images/bafrow_logo.png" type="image/png">
    <title>Pharmacist Dashboard</title>
    <link rel="stylesheet" href="../css/pharmacist.css">
    <link rel="stylesheet" href="../css/pharmacist_header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<?php
require_once('../settings/core.php');
require_once('../classes/userName_class.php');
require_once('../controllers/pharmacist_controller.php');
redirect_pharmacist_if_not_logged_in();
$userProfile = new userName_class();
$prescriptions = viewPendingPrescriptionsController();
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
                <a href="../view/pharmacist_setting.php" class="settings-btn" id="settingsBtn" title="Settings">
                    <i class="fas fa-cog"></i>
                </a>
                <div class="header-date">
                    <i class="fas fa-calendar-alt"></i> 
                    <span id="real-time-date"></span>
                </div>
            </div>
        </div>
        
        <div class="view-mode" id="viewMode">
            <h2><i class="fas fa-prescription-bottle-alt"></i> Prescriptions to Fill</h2>
            
            <?php
            if (!empty($prescriptions)) {
                foreach ($prescriptions as $prescription) {
                    $patient = $prescription['patient'];
                    $medications = $prescription['medications'];
                    $staff = $prescription['staff'];
                    ?>

                    <div class="prescription-card">
                        <div class="patient-info">
                            <div class="patient-photo">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <strong><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></strong><br>
                                ID: <?php echo htmlspecialchars($patient['patient_id']); ?> | <?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?>
                            </div>
                        </div>
                        <div class="medication-list">
                            <?php foreach ($medications as $med) { ?>
                                <div class="med-item">
                                    <div class="medication-name"><?php echo htmlspecialchars($med['medication'] . ' ' . $med['dosage']); ?></div>
                                    <div class="instructions"><?php echo htmlspecialchars($med['instructions']); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="action-btns">
                            <button class="btn btn-secondary" onclick="cancelPrescription('<?php echo $prescription['prescription_id']; ?>')">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </button>
                            <button class="btn btn-primary" onclick="startDispensing('<?php echo $prescription['prescription_id']; ?>', '<?php echo $patient['patient_id']; ?>')">
                                <i class="fas fa-pills"></i> Fill Prescription
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No pending prescriptions to display.</p>';
            }
            ?>
        </div>
        
        <div class="dispense-mode hidden" id="dispenseMode">
            <h2><i class="fas fa-pills"></i> Dispense Medication</h2>
            <div class="patient-info" id="dispensePatientInfo">
            </div>
            
            <form class="dispense-form" id="dispenseForm">
                <table id="dispenseTable">
                    <thead>
                        <tr>
                            <th>Medication</th>
                            <th>Quantity to Dispense</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                
                <div class="action-btns">
                    <button type="button" class="btn btn-secondary" onclick="toggleMode()">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-cash-register"></i> Send to Cashier
                    </button>
                </div>
            </form>
        </div>
        
        <div class="footer">
            <a href="../actions/logoutactions.php" class="logout-btn" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <script src="../js/pharmacist.js?v=<?php echo time(); ?>"></script>
    <script src="../js/real_time_date.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>