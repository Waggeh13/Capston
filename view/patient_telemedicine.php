<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Consultation</title>
    <link rel="stylesheet" href="../css/data.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/telemedicine.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebarx.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://source.zoom.us/3.12.0/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.12.0/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.12.0/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.12.0/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.12.0/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-3.12.0.min.js"></script>
    <script src="../js/telemedicine.js"></script>
    <style>
        /* Ensure consultation-area is a flex container with two equal columns */
        .consultation-area {
            display: none; /* Initially hidden */
            flex-direction: row;
            width: 100%;
            gap: 20px;
            padding: 20px;
            box-sizing: border-box;
        }

        .video-container, .consultation-notes {
            flex: 1; /* Each takes 50% of the width */
            min-width: 0; /* Prevents overflow */
        }

        .video-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #zoomMeeting {
            width: 100%;
            height: 400px; /* Fixed height for the Zoom meeting */
            background-color: #000; /* Fallback background */
        }

        .consultation-controls {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .consultation-notes {
            display: flex;
            flex-direction: column;
        }

        .consultation-notes textarea {
            width: 100%;
            height: 300px;
            resize: vertical;
            padding: 10px;
            box-sizing: border-box;
        }

        .consultation-notes .save-notes {
            margin-top: 10px;
            align-self: flex-start;
        }
    </style>
</head>
<style>
    .sidebar ul li a {
    width: 100%;
    text-decoration: none;
    color: #fff;
    height: 70px;
    display: flex;
    align-items: center;
    }
    .user {
    display: inline-block;
    white-space: nowrap;
    margin-left: 10px; /* Reduced from 65px to 10px */
    }
    .fas.fa-bell {
        margin-left: 1180px;
    }
</style>
<?php
session_start();
require_once('../classes/userName_class.php');

// Get patient_id from session
$patient_id = $_SESSION['user_id'] ?? null;
$userProfile = new userName_class();
?>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
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

        <!-- Main Content Area -->
        <div class="main">
            <div class="top-bar">
                <i class="fas fa-bell"></i>
                <div class="user">
                    <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>

            <!-- Virtual Consultation Content -->
            <div class="telemedicine-container">
                <div class="consultation-header">
                    <h1><i class="fas fa-video"></i> Virtual Consultation</h1>
                    <p>Connect with your doctor through secure video consultations</p>
                </div>

                <!-- Upcoming Consultations -->
                <div class="upcoming-consultations">
                    <h2>Upcoming Consultations</h2>
                    <div class="consultation-list" id="consultationList">
                        <!-- Consultation cards will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Consultation Area -->
                <div class="consultation-area" id="consultationArea">
                    <div class="video-container">
                        <div id="zoomMeeting"></div>
                        <div class="consultation-controls">
                            <button class="control-btn" id="muteBtn"><i class="fas fa-microphone"></i></button>
                            <button class="control-btn" id="videoBtn"><i class="fas fa-video"></i></button>
                            <button class="control-btn" id="screenShareBtn"><i class="fas fa-desktop"></i></button>
                            <button class="control-btn end-call" id="endCallBtn"><i class="fas fa-phone-slash"></i> End Call</button>
                        </div>
                    </div>
                    <div class="consultation-notes">
                        <h3>Consultation Notes</h3>
                        <textarea id="consultationNotes" placeholder="Enter consultation notes here..."></textarea>
                        <button class="btn save-notes" id="saveNotesBtn"><i class="fas fa-save"></i> Save Notes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>