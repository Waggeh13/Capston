<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebarx.css">
    <link rel="stylesheet" href="../css/message.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Messages</title>
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
    margin-left: 10px;
    }
    .fas.fa-bell {
        margin-left: 1180px;
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
require_once('../classes/userName_class.php');
require_once('../settings/core.php');
redirect_if_not_logged_in();
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
                        <div class="chat-list-header">Your Chats</div>
                        <div class="chat-item">
                            <div class="chat-item-info">
                                <div class="chat-item-name">Dr. Sarr</div>
                                <div class="chat-item-last-message">Your test results are ready</div>
                            </div>
                        </div>
                        <div class="chat-item">
                            <div class="chat-item-info">
                                <div class="chat-item-name">Dr. Njie</div>
                                <div class="chat-item-last-message">About your prescription refill</div>
                            </div>
                        </div>
                        <div class="chat-item">
                            <div class="chat-item-info">
                                <div class="chat-item-name">Nurse Fatou</div>
                                <div class="chat-item-last-message">Reminder: Appointment tomorrow</div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Window (Right Side) -->
                    <div class="chat-window">
                        <div class="chat-header">Dr. Badjie</div>
                        <div class="chat-messages">
                            <div class="message received">
                                <div class="message-content">Hello, this is Dr. Badjie following up about your medication. How are you feeling after starting the treatment?</div>
                            </div>
                            <div class="message sent">
                                <div class="message-content">I'm feeling better, but still have some headaches in the afternoon.</div>
                            </div>
                            <div class="message received">
                                <div class="message-content">That's good progress. For the headaches, try drinking more water with the medication. Should we schedule a follow-up?</div>
                            </div>
                            <div class="message sent">
                                <div class="message-content">Yes please, would next Tuesday work?</div>
                            </div>
                        </div>
                        <div class="chat-input">
                            <input type="text" placeholder="Type your message...">
                            <button><i class="fas fa-paper-plane"></i> Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/dark_mode.js"></script>
    </body>
</html>