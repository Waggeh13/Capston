<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../images/bafrow_logo.png" type="image/png">
    <link rel="stylesheet" href="../css/btn_style.css">
    <link rel="stylesheet" href="../css/data.css">
    <link rel="stylesheet" href="../css/calender.css">
    <link rel="stylesheet" href="../css/patient_dashboard.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/sidebarx.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/patient_request_modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Patient Dashboard</title>
</head>
<style>
    .user {
            display: inline-block;
            white-space: nowrap;
            margin-left: 10px;
            position: absolute;
            right: 150px;
            overflow: visible;
        }
    .sidebar ul li a {
        width: 100%;
        text-decoration: none;
        color: #fff;
        height: 70px;
        display: flex;
        align-items: center;
    }
</style>
<?php
require_once('../classes/getPatientAppointments_class.php');
require_once('../classes/getPatientPrescriptions_class.php');
require_once('../classes/userName_class.php');
require_once('../controllers/request_controller.php');
require_once('../settings/core.php');

redirect_patient_if_not_logged_in();

$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

if (!$user_id) {
    die("Error: User not logged in or session expired.");
}

$db = new getPatientAppointments_class();
$appointments = $db->getPatientAppointments($user_id, 2);

$db_prescriptions = new getPatientPrescriptions_class();
$prescriptions = $db_prescriptions->getPatientPrescriptions($user_id, 2);

$userProfile = new userName_class();

if (!is_array($appointments)) {
    $appointments = [];
}

if (!is_array($prescriptions)) {
    $prescriptions = [];
}
?>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li>
                    <a href="#">
                        <i class="fas fa-clinic-medical"></i>
                        <div class="title">BafrowCare</div>
                    </a>
                </li>
                <li>
                    <a href="patient_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="patient_appointments.php">
                        <i class="fas fa-calendar-check"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="patient_prescriptions.php">
                        <i class="fas fa-prescription-bottle-alt"></i>
                        <div class="title">Prescriptions</div>
                    </a>
                </li>
                <li>
                    <a href="patient_telemedicine.php">
                        <i class="fas fa-video"></i>
                        <div class="title">Virtual consultation</div>
                    </a>
                </li>
                <li>
                    <a href="patient_message.php">
                        <i class="fas fa-envelope"></i>
                        <div class="title">Messages</div>
                    </a>
                </li>
                <li>
                    <a href="patient_setting.php">
                        <i class="fas fa-cog"></i>
                        <div class="title">Settings</div>
                    </a>
                </li>
                <li>
                    <a href="../actions/logoutactions.php">
                        <i class="fas fa-right-from-bracket"></i>
                        <div class="title">Logout</div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            <div class="top-bar">
                <div class="user">
                    <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <div class="action-card" onclick="location.href='patient_appointments.php'">
                    <i class="fas fa-calendar-plus"></i>
                    <h3>Book Appointment</h3>
                    <p>Schedule with your doctor</p>
                </div>
                <div class="action-card" onclick="location.href='patient_telemedicine.php'">
                    <i class="fas fa-video"></i>
                    <h3>Virtual Consultation</h3>
                    <p>Start a video call</p>
                </div>
                <div class="action-card" onclick="location.href='patient_prescriptions.php'">
                    <i class="fas fa-prescription-bottle-alt"></i>
                    <h3>View Prescriptions</h3>
                    <p>Your medication list</p>
                </div>
                <div class="action-card" id="requestMedicalReportBtn">
                    <i class="fas fa-file-medical"></i>
                    <h3>Request Medical Report</h3>
                    <p>Request a summary report</p>
                </div>
                <div class="action-card" onclick="location.href='patient_chatbot.php'">
                    <i class="fas fa-robot"></i>
                    <h3>Health Assistant</h3>
                    <p>Chat with our AI</p>
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Upcoming Appointments</h2>
                    <button class="btn" onclick="location.href='patient_appointments.php'">View All</button>
                </div>
                <ul class="appointment-list">
                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $apt): ?>
                            <li class="appointment-item">
                                <div>
                                    <strong><?= htmlspecialchars($apt['doctor_name'] ?? 'N/A') ?></strong>
                                    <p>
                                        <?= htmlspecialchars($apt['department_name'] ?? 'N/A') ?> - 
                                        <?= !empty($apt['appointment_date']) && !empty($apt['time_slot']) 
                                            ? date('F j, Y', strtotime($apt['appointment_date'])) . ' at ' . date('g:i A', strtotime($apt['time_slot']))
                                            : 'N/A' ?>
                                    </p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="appointment-item">
                            <div>
                                <p>No upcoming appointments found</p>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Recent Prescriptions -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Current Prescriptions</h2>
                    <button class="btn" onclick="location.href='patient_prescriptions.php'">View All</button>
                </div>
                <ul class="appointment-list">
                    <?php if (!empty($prescriptions)): ?>
                        <?php foreach ($prescriptions as $prescription): ?>
                            <li class="appointment-item">
                                <div>
                                    <strong><?php echo htmlspecialchars($prescription['medication'] . ' ' . $prescription['dosage']); ?></strong>
                                    <p><?php echo htmlspecialchars($prescription['doctor_name'] . ' - ' . $prescription['instructions']); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="appointment-item">
                            <div>
                                <p>No current prescriptions</p>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Chatbot Button -->
        <div class="chatbot-btn" class="action-card" onclick="location.href='patient_chatbot.php'">
            <i class="fas fa-robot"></i>
        </div>
    </div>

    <!-- Medical Report Request Modal -->
    <div class="modal" id="requestModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-file-medical"></i> Request Medical Report</h2>
                <button class="close-btn" id="requestCancelBtn">×</button>
            </div>
            <div class="modal-body">
                <form id="requestForm">
                    <div class="form-group">
                        <label for="doctorId">Select Doctor to Request From</label>
                        <select id="doctorId" name="doctorId" required>
                            <option value="">Select a doctor</option>
                            <?php
                            $doctors = get_doctors_ctr();
                            if (!empty($doctors)) {
                                foreach ($doctors as $doctor) {
                                    echo "<option value='{$doctor['staff_id']}'>{$doctor['first_name']} {$doctor['last_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="error-message" id="doctorIdError"></div>
                    </div>
                    <div class="form-group">
                        <label for="hospitalName">Hospital to Receive Report</label>
                        <input type="text" id="hospitalName" name="hospitalName" placeholder="Enter hospital name (e.g., Serrekunda General Hospital)" required>
                        <div class="error-message" id="hospitalNameError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="requestCancelBtnSecondary">Cancel</button>
                <button class="btn btn-primary" id="requestSubmitBtn">Send Request</button>
            </div>
        </div>
    </div>

    <script src="../js/toggle.js"></script>
    <script src="../js/patient_request_modal.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>