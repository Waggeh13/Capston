<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/btn_style.css">
    <link rel="stylesheet" href="../css/data.css">
    <link rel="stylesheet" href="../css/calender.css">
    <link rel="stylesheet" href="../css/patient_dashboard.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/sidebarx.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Patient Dashboard</title>
</head>
<style>
    .user {
    display: inline-block;
    white-space: nowrap;
    margin-left: 10px; /* Reduced from 65px to 10px */
    }
    .fas.fa-bell {
        margin-left: 1180px;
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
session_start();
require_once('../classes/getPatientAppointments_class.php');
require_once('../classes/getPatientPrescriptions_class.php');
require_once('../classes/userName_class.php');

// Get patient_id from session (assumed)
$patient_id = $_SESSION['user_id'] ?? null;

// Fetch patient appointments
$db = new getPatientAppointments_class();
$appointments = $patient_id ? $db->getPatientAppointments($patient_id, 2) : [];

// Fetch patient prescriptions
$db = new getPatientPrescriptions_class();
$prescriptions = $patient_id ? $db->getPatientPrescriptions($patient_id, 2) : [];

$userProfile = new userName_class();

// Ensure appointments is an array
if (!is_array($appointments)) {
    $appointments = [];
}

// Ensure prescriptions is an array
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
                    <a href="patient_messages.php">
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
                <i class="fas fa-bell"></i>
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

    <script>
        function openChatbot() {
            // Implement chatbot functionality here
            alert("Health Assistant chatbot will open here");
            // This could open a modal or redirect to a chat interface
        }

    </script>
    <script src="../js/toggle.js"></script>
</body>
</html>