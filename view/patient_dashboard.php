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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebarx.css">
    <link rel="stylesheet" href="../css/reset_password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Patient Dashboard</title>
</head>
<?php
session_start();
require_once('../classes/getPatientAppointments_class.php');

// Get patient_id from session (assumed)
$patient_id = $_SESSION['patient_id'] ?? null;

// Fetch patient appointments
$db = new getPatientAppointments_class();
$appointments = $patient_id ? $db->getPatientAppointments($patient_id, 5) : [];

// Ensure appointments is an array
if (!is_array($appointments)) {
    $appointments = [];
}
?>
<body>
    <!-- Password Reset Modal -->
    <div class="password-modal" id="passwordModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-key"></i> Change Password</h2>
            </div>
            <div class="modal-body">
                <p style="margin-bottom: 20px;">For security reasons, please change your default password.</p>
                
                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" id="currentPassword" name="currentPassword" placeholder="Enter your current password">
                    <div class="error-message" id="currentPasswordError"></div>
                </div>
                
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" name="newPassword" placeholder="Enter your new password">
                    <div class="password-strength">Must be at least 8 characters with numbers and special characters</div>
                    <div class="error-message" id="newPasswordError"></div>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword">Confirm New Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password">
                    <div class="error-message" id="confirmPasswordError"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal btn-secondary" id="cancelBtn">Cancel</button>
                <button class="btn-modal btn-primary" id="submitBtn">Update Password</button>
            </div>
        </div>
    </div>

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
                    <a href="index.php">
                        <i class="fas fa-right-from-bracket"></i>
                        <div class="title">Logout</div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            <div class="top-bar">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="search">
                    <input type="text" name="search" placeholder="search here">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
                <i class="fas fa-bell"></i>
                <div class="user">
                    <span class="profile-text">Profile</span>
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
                <div class="action-card" onclick="openChatbot()">
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
                    <h2 class="card-title">Recent Prescriptions</h2>
                    <button class="btn" onclick="location.href='patient_prescriptions.php'">View All</button>
                </div>
                <ul class="appointment-list">
                    <li class="appointment-item">
                        <div>
                            <strong>Amoxicillin 500mg</strong>
                            <p>Dr. John Smith - Take twice daily for 7 days</p>
                        </div>
                    </li>
                    <li class="appointment-item">
                        <div>
                            <strong>Lisinopril 10mg</strong>
                            <p>Dr. Sarah Johnson - Take once daily</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Chatbot Button -->
        <div class="chatbot-btn" onclick="openChatbot()">
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
    <script src="../js/reset_password.js"></script>
</body>
</html>