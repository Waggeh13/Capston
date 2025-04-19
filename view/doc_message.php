<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/message.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/enhanced_messaging.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Messages</title>
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
                    <i class="fas fa-bell"></i>
                    <div class="user">
                        <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                    </div>
                </div>
                <div class="message-container">
                    <!-- Chat List (Left Side) -->
                    <div class="chat-list">
                        <div class="chat-list-header">Chats</div>
                        <div class="search-bar">
                            <input type="text" id="patientSearch" placeholder="Search for a patient...">
                            <div id="searchResults" style="display: none;"></div>
                        </div>
                        <?php foreach ($chats as $chat): ?>
                            <div class="chat-item" onclick="window.location.href='doc_message.php?patient_id=<?php echo $chat['patient_id']; ?>'">
                                <div class="chat-item-info">
                                    <div class="chat-item-name"><?php echo htmlspecialchars($chat['patient_name']); ?></div>
                                    <div class="chat-item-last-message"><?php echo htmlspecialchars($chat['last_message'] ?: 'No messages yet'); ?></div>
                                </div>
                                <span class="message-count"><?php echo $chat['message_count']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Chat Window (Right Side) -->
                    <div class="chat-window">
                        <div class="chat-header"><?php echo htmlspecialchars($selected_patient_name); ?></div>
                        <div class="chat-messages">
                            <?php foreach ($messages as $message): ?>
                                <div class="message <?php echo $message['sender_id'] == $doctor_id ? 'sent' : 'received'; ?>">
                                    <div class="message-content">
                                        <?php echo htmlspecialchars($message['message']); ?>
                                        <div class="message-timestamp"><?php echo date('M j, H:i', strtotime($message['sent_at'])); ?></div>
                                        <?php if ($message['sender_id'] == $doctor_id): ?>
                                            <div class="message-status">
                                                <i class="fas <?php echo $message['read_at'] ? 'fa-check-double' : 'fa-check'; ?>"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($selected_patient_id): ?>
                            <div class="chat-input">
                                <input type="text" id="messageInput" placeholder="Type a message...">
                                <button onclick="sendMessage(<?php echo $doctor_id; ?>, <?php echo $selected_patient_id; ?>)">Send</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/dark_mode.js"></script>
    </body>
</html>