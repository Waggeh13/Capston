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
                    <a href="admin_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="admin_appointment.php">
                        <i class="fas fa-stethoscope"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="admin_staff.php">
                        <i class="fas fa-users"></i>
                        <div class="title">Staff</div>
                    </a>
                </li>
                <li>
                    <a href="admin_patient.php">
                        <i class="fas fa-user"></i>
                        <div class="title">Patients</div>
                    </a>
                </li>
                <li>
                    <a href="admin_department.php">
                        <i class="fas fa-puzzle-piece"></i>
                        <div class="title">Departments</div>
                    </a>
                </li>
                <li>
                    <a href="admin_clinic.php">
                        <i class="fas fa-briefcase-medical"></i>
                        <div class="title">Clinics</div>
                    </a>
                </li>
                <li>
                    <a href="admin_setting.php">
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
        <!-- Password Change Modal -->
        <div id="passwordModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closePasswordModal()">&times;</span>
                <h2>Change Password</h2>
                <form class="password-form" onsubmit="return validatePasswordForm(event)">
                    <label for="current-password">Current Password</label>
                    <input type="password" id="current-password" required>

                    <label for="new-password">New Password</label>
                    <input type="password" id="new-password" required>

                    <label for="confirm-password">Confirm New Password</label>
                    <input type="password" id="confirm-password" required>

                    <button type="submit">Change Password</button>
                    <button type="button" onclick="closePasswordModal()">Cancel</button>
                </form>
            </div>
        </div>
        <script src="../js/change_password.js"></script>
    </body>
</html>