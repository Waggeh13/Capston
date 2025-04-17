<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Consultation</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/data.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/telemedicine.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    .sidebar ul li a {
    width: 100%;
    text-decoration: none;
    color: #fff;
    height: 60px;
    display: flex;
    align-items: center;
    }
    .user {
    display: inline-block;
    white-space: nowrap;
    margin-left: 10px;
    }
    .fas.fa-bell {
    margin-left: 1180px;
    }
    .profile-text{
    color: black;
    }
</style>
<?php
session_start();
require_once('../classes/userName_class.php');

// Get patient_id from session
$user_id = $_SESSION['user_id'] ?? null;
$userProfile = new userName_class();
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
                    <a href="doctor_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="doc_appointment.php">
                        <i class="fas fa-stethoscope"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="doc_schedule.php">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="title">Schedule</div>
                    </a>
                </li>
                <li>
                    <a href="doc_lab.php">
                        <i class="fas fa-vial"></i>
                        <div class="title">Lab Test</div>
                    </a>
                </li>
                <li>
                    <a href="doc_prescription.php">
                        <i class="fas fa-prescription-bottle-alt"></i>
                        <div class="title">Prescription</div>
                    </a>
                </li>
                <li>
                    <a href="doc_telemedicine.php" class="active">
                        <i class="fas fa-video"></i>
                        <div class="title">Virtual Consultation</div>
                    </a>
                </li>
                <li>
                    <a href="doc_message.php">
                        <i class="fas fa-envelope"></i>
                        <div class="title">Messages</div>
                    </a>
                </li>
                <li>
                    <a href="request.php">
                        <i class="fas fa-file-medical"></i>
                        <div class="title">Report Request</div>
                    </a>
                </li>
                <li>
                    <a href="doc_setting.php">
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

        <!-- Main Content Area -->
        <div class="main">
            <!-- Top Navigation Bar -->
            <div class="top-bar">
                <div class="top-bar">
                    <i class="fas fa-bell"></i>
                    <div class="user">
                        <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                    </div>
                </div>
            </div>

            <!-- Virtual Consultation Content -->
            <div class="telemedicine-container">
                <div class="consultation-header">
                    <h1><i class="fas fa-video"></i> Virtual Consultation</h1>
                    <p>Connect with your patients through secure video consultations</p>
                </div>

                <!-- Upcoming Consultations -->
                <div class="upcoming-consultations">
                    <h2>Upcoming Consultations</h2>
                    <div class="consultation-list">
                        <!-- Consultation Item 1 -->
                        <div class="consultation-card">
                            <div class="patient-info">
                                <div class="patient-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h3>John Doe</h3>
                                    <p>ID: PT12345 | Today, 10:30 AM</p>
                                </div>
                            </div>
                            <div class="consultation-actions">
                                <button class="btn start-consultation" data-meeting-id="123456789">
                                    <i class="fas fa-video"></i> Start Consultation
                                </button>
                                <button class="btn btn-outline">
                                    <i class="fas fa-calendar-alt"></i> Reschedule
                                </button>
                            </div>
                        </div>

                        <!-- Consultation Item 2 -->
                        <div class="consultation-card">
                            <div class="patient-info">
                                <div class="patient-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h3>Amina Ceesay</h3>
                                    <p>ID: PT12346 | Tomorrow, 02:15 PM</p>
                                </div>
                            </div>
                            <div class="consultation-actions">
                                <button class="btn" disabled>
                                    <i class="fas fa-video"></i> Start Consultation
                                </button>
                                <button class="btn btn-outline">
                                    <i class="fas fa-calendar-alt"></i> Reschedule
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Consultation Area (shown when consultation starts) -->
                <div class="consultation-area" id="consultationArea" style="display: none;">
                    <div class="video-container">
                        <div class="video-placeholder" id="zoomEmbed">
                            <!-- Zoom meeting will be embedded here -->
                            <div class="zoom-placeholder">
                                <i class="fas fa-video"></i>
                                <p>Consultation session will begin shortly...</p>
                            </div>
                        </div>
                        <div class="consultation-controls">
                            <button class="control-btn" id="muteBtn"><i class="fas fa-microphone"></i></button>
                            <button class="control-btn" id="videoBtn"><i class="fas fa-video"></i></button>
                            <button class="control-btn" id="screenShareBtn"><i class="fas fa-desktop"></i></button>
                            <button class="control-btn end-call" id="endCallBtn"><i class="fas fa-phone-slash"></i> End Call</button>
                        </div>
                    </div>
                    <div class="consultation-notes">
                        <h3>Consultation Notes</h3>
                        <textarea placeholder="Enter consultation notes here..."></textarea>
                        <button class="btn save-notes"><i class="fas fa-save"></i> Save Notes</button>
                    </div>
                </div>

                <!-- Schedule New Consultation -->
                <div class="schedule-consultation">
                    <h2>Schedule New Consultation</h2>
                    <form class="consultation-form">
                        <div class="form-group">
                            <label for="patientSelect">Select Patient</label>
                            <select id="patientSelect" name="patientSelect" required>
                                <option value="">-- Select Patient --</option>
                                <option value="PT12345">John Doe (PT12345)</option>
                                <option value="PT12346">Amina Ceesay (PT12346)</option>
                                <option value="PT12347">Michael Brown (PT12347)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="consultDate">Date</label>
                            <input type="date" id="consultDate" name="consultDate" required>
                        </div>
                        <div class="form-group">
                            <label for="consultTime">Time</label>
                            <input type="time" id="consultTime" name="consultTime" required>
                        </div>
                        <div class="form-group">
                            <label for="consultReason">Reason</label>
                            <textarea id="consultReason" name="consultReason" placeholder="Brief reason for consultation"></textarea>
                        </div>
                        <button type="submit" class="btn schedule-btn">
                            <i class="fas fa-calendar-plus"></i> Schedule Consultation
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>