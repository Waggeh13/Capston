<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/lab_container.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/setting.css">
    <link rel="stylesheet" href="../css/change_password.css">
    <link rel="stylesheet" href="../css/reset_password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Lab Test</title>
</head>
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
                    <a href="index.php">
                        <i class="fas fa-right-from-bracket"></i>
                        <div class="title">Logout</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="top-bar">
                <div class="search">
                    <input type="text" name="search" placeholder="search here">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
                <i class="fas fa-bell"></i>
                <div class="user">
                    <span class="profile-text">Profile</span>
                </div>
            </div>
            <div class="settings-container">
                <h1>Settings</h1>
                <!-- Light/Dark Mode Toggle -->
                <div class="settings-section">
                    <h2>Appearance</h2>
                    <div class="settings-option">
                        <div class="toggle-switch">
                            <input type="checkbox" id="dark-mode" name="dark-mode">
                            <label for="dark-mode">Dark Mode</label>
                        </div>
                    </div>
                </div>
                <!-- Change password -->
                <div class="settings-section">
                    <h2>Password</h2>
                    <div class="settings-option">
                        <button class="change-password-btn" onclick="openPasswordModal()">Change Password</button>
                    </div>
                </div>
                <!-- Language Selection -->
                <div class="settings-section">
                    <h2>Language</h2>
                    <div class="settings-option">
                        <label for="language">Select Language:</label>
                        <select id="language" name="language">
                            <option value="english">English</option>
                            <option value="wollof">Wollof</option>
                            <option value="mandinka">Mandinka</option>
                        </select>
                    </div>
                </div>

                <!-- Font Size Adjustment -->
                <div class="settings-section">
                    <h2>Font Size</h2>
                    <div class="settings-option">
                        <label for="font-size">Adjust Font Size:</label>
                        <input type="range" id="font-size" name="font-size" min="12" max="24" value="16">
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Reset Modal -->
        <div class="password-modal" id="passwordModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2><i class="fas fa-key"></i> Change Password</h2>
                </div>
                <div class="modal-body">
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
                    <button class="btn-modal btn-secondary" id="cancelBtn" onclick="closePasswordModal()">Cancel</button>
                    <button class="btn-modal btn-primary" id="submitBtn">Update Password</button>
                </div>
            </div>
        </div>
        <script src="../js/change_password.js"></script>

    </body>
</html>