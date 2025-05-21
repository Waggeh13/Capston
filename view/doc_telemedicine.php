<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../images/bafrow_logo.png" type="image/png">
    <title>Virtual Consultation</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/data.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/telemedicine.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            position: absolute;
            right: 150px;
            overflow: visible;
        }
        .profile-text {
            color: black;
        }
        .consultation-area {
            display: none;
            flex-direction: row;
            width: 100%;
            gap: 20px;
            padding: 20px;
            box-sizing: border-box;
        }
        .video-container, .consultation-notes {
            flex: 1;
            min-width: 0;
        }
        .video-container {
            display: flex;
            flex-direction: column;
            align-items: center;
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
        .end-meeting-area {
            text-align: center;
            margin-top: 20px;
        }
        .end-meeting-area .btn {
            padding: 10px 20px;
            background: #ff4444;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .browser-warning {
            color: red;
            text-align: center;
            margin: 10px 0;
            display: none;
        }
        .telemedicine-container {
            padding-top: 80px;
        }
    </style>
</head>
<?php
require_once('../settings/core.php');
require_once('../classes/userName_class.php');
redirect_doctor_if_not_logged_in();
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
                    <a href="doc_telemedicine.php">
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

        <div class="main">
            <div class="top-bar">
                <div class="user">
                    <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>

            <div class="telemedicine-container">
                <div class="consultation-header">
                    <h1><i class="fas fa-video"></i> Virtual Consultation</h1>
                    <p>Connect with your patients through secure video consultations</p>
                </div>

                <div class="browser-warning" id="browserWarning">
                    Your browser may not support Zoom's audio and video features. Please use a modern browser like Chrome, Firefox, or Edge for the best experience.
                </div>

                <div class="upcoming-consultations" id="upcomingConsultations">
                    <h2>Upcoming Consultations</h2>
                    <div class="consultation-list" id="consultationList">
                    </div>
                </div>

                <div class="consultation-area" id="consultationArea">
                    <div class="consultation-notes">
                        <h3>Consultation Notes</h3>
                        <textarea id="consultationNotes" placeholder="Enter consultation notes here..."></textarea>
                        <button class="btn save-notes" id="saveNotesBtn"><i class="fas fa-save"></i> Save Notes</button>
                    </div>
                </div>

                <div class="end-meeting-area" id="endMeetingArea" style="display: none;">
                    <button class="btn" id="endMeetingBtn"><i class="fas fa-phone-slash"></i> End Meeting</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/doc_telemedicine.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>