<?php
require_once('../settings/core.php');
redirect_if_logged_in();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../images/bafrow_logo.png" type="image/png">
    <title>Log-In</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/index_icon.css">
    <link rel="stylesheet" href="../css/reset_password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 35px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .bafrow {
            color: rgb(34, 34, 249);
        }
        .care {
            color: red;
        }
        .error-message {
            color: red;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        input {
            margin-bottom: 10px;
        }
        .input-box i {
            cursor: pointer;
        }
        .password-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-header h2 {
            margin: 0;
            font-size: 24px;
        }
        .modal-header i {
            margin-right: 10px;
        }
        .modal-body {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .password-strength {
            font-size: 12px;
            margin-top: 5px;
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .btn-modal {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="logo">
        <span class="bafrow">Bafrow</span><span class="care">Care</span>
    </div>

    <div class="container">
        <div class="form-box login">
            <form id="loginForm" method="POST">
                <h1>Login</h1>

                <div class="input-box">
                    <input type="text" id="user_id" name="user_id" placeholder="User ID" required>
                    <i class='bx bxs-user'></i>
                    <div id="idError" class="error-message"></div><br>
                </div>

                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <i id="show-password" class='bx bxs-lock-alt'></i>
                    <div id="passwordError" class="error-message"></div><br>
                </div>


                <button type="submit" name="submit" class="btn">Login</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Connecting Care, Simplifying Lives</p>
            </div>
        </div>
    </div>

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
                    <div class="password-strength" id="passwordStrength">Must be at least 8 characters with numbers and special characters</div>
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

    <script src="../js/login.js"></script>
    <script src="../js/reset_password.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>