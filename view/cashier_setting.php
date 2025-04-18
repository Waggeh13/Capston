<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - BafrowCare</title>
    <link rel="stylesheet" href="../css/pharmacist_header.css">
    <link rel="stylesheet" href="../css/setting.css">
    <link rel="stylesheet" href="../css/change_password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
</style>
<?php
require_once('../classes/userName_class.php');

require_once('../settings/core.php');
redirect_cashier_if_not_logged_in();
$userProfile = new userName_class();
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
                <div class="header-date">
                    <i class="fas fa-calendar-alt"></i> 
                    <span id="real-time-date"></span>
                </div>
                <a href="cashier.php" class="settings-btn" id="dashboardBtn" title="Back to Dashboard">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a href="actions/logoutactions.php" class="logout-btn" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
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
            <!-- Change Password -->
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
    <script src="../js/settings.js"></script>
    <script src="../js/real_time_date.js"></script>
    <script src="../js/change_password.js"></script>
</body>
</html>