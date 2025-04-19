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
    <title>Patient Messages</title>
    <style>
        .sidebar ul li a {
        width: 100%;
        text-decoration: none;
        color: #fff;
        height: 70px;
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

redirect_patient_if_not_logged_in();

$patient_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;

error_log("patient_message.php user_id: " . ($patient_id ?? 'not set'));
error_log("patient_message.php user_role: " . ($user_role ?? 'not set'));

if (empty($user_role) || strcasecmp($user_role, 'Patient') !== 0) {
    error_log("patient_message.php: Invalid or missing user_role, redirecting to login");
    header("Location: ../view/patient_login.php");
    exit;
}

$userProfile = new userName_class();

$db = new Message_class();
if (!$db->db_conn()) {
    error_log("patient_message.php: Database connection failed");
    die("Error: Unable to connect to the database.");
}

$chats = $db->getChats($patient_id, $user_role) ?? [];

$selected_doctor_id = isset($_GET['doctor_id']) ? filter_var($_GET['doctor_id']) : null;

$messages = $selected_doctor_id ? $db->getMessages($patient_id, $selected_doctor_id) : [];
$selected_doctor_name = $selected_doctor_id ? $db->getContactName($selected_doctor_id) : 'Select a doctor';
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
                    <a href="patient_message.php">
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
                <span class="profile-text"><?php echo htmlspecialchars($userProfile->getUserName()); ?></span>
            </div>
        </div>
        <div class="message-container">
            <!-- Chat List (Left Side) -->
            <div class="chat-list">
                <div class="chat-list-header">Chats</div>
                <div class="search-bar">
                    <input type="text" id="patientSearch" placeholder="Search for a doctor...">
                    <div id="searchResults" class="search-results" style="display: none;"></div>
                </div>
                <?php foreach ($chats as $chat): ?>
                    <div class="chat-item" onclick="window.location.href='patient_message.php?doctor_id=<?php echo htmlspecialchars($chat['contact_id']); ?>'">
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
                <div class="chat-header"><?php echo htmlspecialchars($selected_doctor_name); ?></div>
                <div class="chat-messages">
                    <?php foreach ($messages as $message): ?>
                        <div class="message <?php echo $message['sender_id'] == $patient_id ? 'sent' : 'received'; ?>">
                            <div class="message-content">
                                <?php echo htmlspecialchars($message['message']); ?>
                                <div class="message-timestamp"><?php echo date('M j, H:i', strtotime($message['sent_at'])); ?></div>
                                <?php if ($message['sender_id'] == $patient_id): ?>
                                    <div class="message-status">
                                        <i class="fas <?php echo $message['read_at'] ? 'fa-check-double' : 'fa-check'; ?>"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($selected_doctor_id): ?>
                    <div class="chat-input">
                        <input type="text" id="messageInput" placeholder="Type a message...">
                        <button onclick="sendMessage('<?php echo htmlspecialchars($patient_id); ?>', '<?php echo htmlspecialchars($selected_doctor_id); ?>')">Send</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="../js/dark_mode.js"></script>
<script src="../js/messages.js"></script>
<script src="../js/patient_doctor_search.js"></script>
</body>
</html>