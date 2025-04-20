<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/message.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/enhanced_message.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Messages</title>
    <style>
        .sidebar ul li a {
        width: 100%;
        text-decoration: none;
        color: #fff;
        height: 60px;
        display: flex;
        align-items: center;
        }
        .message-container {
            display: flex;
            height: calc(97vh - 60px);
            margin-top: 80px;
            background-color: #f5f5f5;
        }
        .search-results {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
        }
        .message-count:empty, .message-count[data-count="0"] {
            display: none;
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
        .chat-list {
        width: 20%;
        border-right: 1px solid #ddd;
        overflow-y: auto;
        }
        #messages {
        max-height: 400px;
        overflow-y: auto;
        scroll-behavior: smooth;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        }
    </style>
</head>
<body>
<?php
require_once('../settings/core.php');
require_once('../classes/userName_class.php');
require_once('../classes/message_class.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

redirect_doctor_if_not_logged_in();

// Set doctor_id and user_role
$doctor_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;

// Log session variables
error_log("doc_message.php user_id: " . ($doctor_id ?? 'not set'));
error_log("doc_message.php user_role: " . ($user_role ?? 'not set'));

$userProfile = new userName_class();

// Initialize message class
$db = new Message_class();
if (!$db->db_conn()) {
    error_log("doc_message.php: Database connection failed");
    die("Error: Unable to connect to the database.");
}

// Get chats
$chats = $db->getChats($doctor_id, $user_role) ?? [];

// Get selected patient ID (sanitize input)
$selected_patient_id = isset($_GET['patient_id']) ? filter_var($_GET['patient_id']) : null;

// Get messages and patient name
$messages = $selected_patient_id ? $db->getMessages($doctor_id, $selected_patient_id) : [];
$selected_patient_name = $selected_patient_id ? $db->getContactName($selected_patient_id) : 'Select a patient';
?>

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
                <span class="profile-text"><?php echo htmlspecialchars($userProfile->getUserName()); ?></span>
            </div>
        </div>
        <div class="message-container">
            <!-- Chat List (Left Side) -->
            <div class="chat-list">
                <div class="chat-list-header">Chats</div>
                <div class="search-bar">
                    <input type="text" id="patientSearch" placeholder="Search for a patient...">
                    <div id="searchResults" class="search-results" style="display: none;"></div>
                </div>
                <?php foreach ($chats as $chat): ?>
                    <div class="chat-item" onclick="window.location.href='doc_message.php?patient_id=<?php echo htmlspecialchars($chat['contact_id']); ?>'">
                        <div class="chat-item-info">
                            <div class="chat-item-name"><?php echo htmlspecialchars($chat['contact_name']); ?></div>
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
                        <button onclick="sendMessage('<?php echo htmlspecialchars($doctor_id); ?>', '<?php echo htmlspecialchars($selected_patient_id); ?>')">Send</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="../js/dark_mode.js"></script>
<script src="../js/messages.js"></script>
</body>
</html>