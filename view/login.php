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
    <title>Log-In</title>

    <!-- External Icons & Styles -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/index_icon.css">
    <link rel="stylesheet" href="../css/reset_password.css">

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
    </style>
</head>

<body>
    <!-- Logo -->
    <div class="logo">
        <span class="bafrow">Bafrow</span><span class="care">Care</span>
    </div>

    <!-- Login Form Container -->
    <div class="container">
        <div class="form-box login">
            <form id="loginForm" method="POST">
                <h1>Login</h1>

                <!-- User ID Input -->
                <div class="input-box">
                    <input type="text" id="user_id" name="user_id" placeholder="User ID" required>
                    <i class='bx bxs-user'></i>
                    <div id="idError" class="error-message"></div><br>
                </div>

                <!-- Password Input -->
                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <i id="show-password" class='bx bxs-lock-alt'></i>
                    <div id="passwordError" class="error-message"></div><br>
                </div>

                <!-- Forgot Password Link -->
                <div class="forgot-link">
                    <a href="#" style="text-decoration: none;">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="submit" class="btn">Login</button>
            </form>
        </div>

        <!-- Info Panel -->
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Connecting Care, Simplifying Lives</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/login.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>
