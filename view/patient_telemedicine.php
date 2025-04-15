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
</head>
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
            <!-- Top Navigation Bar -->
            <div class="top-bar">
                <div class="search">
                    <input type="text" name="search" placeholder="Search here">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
                <i class="fas fa-bell"></i>
                <div class="user">
                    <span class="profile-text">Profile</span>
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
                <div class="consultation-area" id="consultationArea" style="display: none;">
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