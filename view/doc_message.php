<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/message.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Messages</title>
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
    .chat-input button {
        background-color: #0054A6;
    }
    .message.sent .message-content {
    background-color: #0054A6;
    color: white;
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
    .message-container {
        display: flex;
        height: calc(97vh - 60px); 
        margin-top: 80px; 
        background-color: #f5f5f5;
    }
    .chat-input button {
        background-color: #0054A6;
    }
    .message.sent .message-content {
    background-color: #0054A6;
    color: white;
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
                    <i class="fas fa-bell"></i>
                    <div class="user">
                        <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                    </div>
                </div>
                <div class="message-container">
                    <!-- Chat List (Left Side) -->
                    <div class="chat-list">
                        <div class="chat-list-header">Chats</div>
                        <div class="chat-item">
                            <div class="chat-item-info">
                                <div class="chat-item-name">Fatou Touray</div>
                                <div class="chat-item-last-message">Hello, how are you?</div>
                            </div>
                        </div>
                        <div class="chat-item">
                            <div class="chat-item-info">
                                <div class="chat-item-name">Lamin Jallow</div>
                                <div class="chat-item-last-message">Can we reschedule?</div>
                            </div>
                        </div>
                        <div class="chat-item">
                            <div class="chat-item-info">
                                <div class="chat-item-name">Ousman Sowe</div>
                                <div class="chat-item-last-message">Thank you!</div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-window">
                        <div class="chat-header">Alieu Faye</div>
                        <div class="chat-messages">
                            <div class="message received">
                                <div class="message-content">Hello, how are you?</div>
                            </div>
                            <div class="message sent">
                                <div class="message-content">I'm good, thank you!</div>
                            </div>
                            <div class="message received">
                                <div class="message-content">Can we reschedule the appointment?</div>
                            </div>
                        </div>
                        <div class="chat-input">
                            <input type="text" placeholder="Type a message...">
                            <button>Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>