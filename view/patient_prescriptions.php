<?php
require_once('../classes/userName_class.php');
require_once('../settings/core.php');
require_once('../controllers/get_prescription_controller.php');
require_once('../controllers/prescription_notification_controller.php');
redirect_patient_if_not_logged_in();

$userProfile = new userName_class();
$patient_id = $_SESSION['user_id'];

// Fetch prescriptions for the patient
$prescriptions = get_patient_prescriptions_ctr($patient_id);

// Get client timezone from session or default to server timezone
$client_timezone = isset($_SESSION['client_timezone']) ? $_SESSION['client_timezone'] : 'UTC';
date_default_timezone_set($client_timezone);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/patient_prescription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Prescription</title>
    <script>
        // Register service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('../sw.js')
                .then(reg => console.log('Service Worker registered'))
                .catch(err => console.error('Service Worker registration failed:', err));
        }
        // Send client timezone to server
        document.addEventListener('DOMContentLoaded', () => {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            fetch('../actions/set_timezone.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `timezone=${encodeURIComponent(timezone)}`
            });
        });
    </script>
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
        .medication-card {
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        #notification-form input[type="time"], #notification-form select {
            margin: 10px 0;
            display: block;
        }
        #add-time, #notification-form button[type="submit"] {
            margin: 10px 0;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        #add-time:hover, #notification-form button[type="submit"]:hover {
            background-color: #0056b3;
        }
        #existing-times div {
            margin: 5px 0;
        }
        .delete-time {
            margin-left: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
        .delete-time:hover {
            background-color: #c82333;
        }
    </style>
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
                    <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>
            <div class="prescription-container">
                <div class="prescription-header">
                    <h2><i class="fas fa-prescription-bottle-alt"></i> My Prescription</h2>
                    <div class="prescription-meta">
                        <div class="meta-item">
                            <span class="meta-label">Date:</span>
                            <span class="meta-value"><?php echo $prescriptions ? htmlspecialchars($prescriptions[0]['medication_date']) : 'N/A'; ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Prescribed by:</span>
                            <span class="meta-value"><?php echo $prescriptions ? htmlspecialchars($prescriptions[0]['first_name'] . ' ' . $prescriptions[0]['last_name']) : 'N/A'; ?></span>
                        </div>
                    </div>
                </div>
                <div class="medication-list">
                    <?php if ($prescriptions): ?>
                        <?php foreach ($prescriptions as $prescription): ?>
                            <?php
                            $notification_settings = get_notification_settings_ctr($prescription['medication_id'], $patient_id);
                            $enabled = false;
                            $notification_times = [];
                            $interval = null;
                            if ($notification_settings) {
                                foreach ($notification_settings as $setting) {
                                    if ($setting['enabled'] === 'Yes') {
                                        $enabled = true;
                                    }
                                    if ($setting['interval_hours'] !== null) {
                                        $interval = $setting['interval_hours'] . ' hours';
                                    } elseif ($setting['notification_time'] !== '00:00:00') {
                                        // Store all times without filtering
                                        $notification_times[] = $setting['notification_time'];
                                    }
                                }
                            }
                            ?>
                            <div class="medication-card">
                                <div class="medication-header">
                                    <h3><?php echo htmlspecialchars($prescription['medication']); ?></h3>
                                    <span class="medication-status active">Active</span>
                                </div>
                                <div class="medication-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Dosage:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($prescription['dosage']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Schedule:</span>
                                        <span class="detail-value">
                                            <?php
                                            if ($interval) {
                                                echo 'Every ' . htmlspecialchars($interval);
                                            } elseif ($notification_times) {
                                                foreach ($notification_times as $time) {
                                                    // Convert to 12-hour format with AM/PM
                                                    $date = new DateTime($time);
                                                    $formatted_time = $date->format('h:i A');
                                                    echo '<span class="dosage-time">' . htmlspecialchars($formatted_time) . '</span>';
                                                }
                                            } else {
                                                echo 'Not set';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Duration:</span>
                                        <span class="detail-value">7 days</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Instructions:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($prescription['instructions']); ?></span>
                                    </div>
                                </div>
                                <div class="alert-section">
                                    <div class="alert-toggle">
                                        <input type="checkbox" 
                                               id="alert-<?php echo $prescription['medication_id']; ?>" 
                                               data-medication-id="<?php echo $prescription['medication_id']; ?>" 
                                               data-patient-id="<?php echo $patient_id; ?>" 
                                               <?php echo $enabled ? 'checked' : ''; ?>>
                                        <label for="alert-<?php echo $prescription['medication_id']; ?>">Enable medication reminders</label>
                                    </div>
                                    <?php if ($enabled && ($notification_times || $interval)): ?>
                                        <div class="next-dose">
                                            Next dose: <strong>
                                            <?php
                                            if ($interval) {
                                                echo htmlspecialchars($interval);
                                            } else {
                                                // Find the next upcoming time
                                                $now = new DateTime();
                                                $next_time = null;
                                                foreach ($notification_times as $time) {
                                                    $notification_datetime = new DateTime($now->format('Y-m-d') . ' ' . $time);
                                                    if ($notification_datetime < $now) {
                                                        $notification_datetime->modify('+1 day');
                                                    }
                                                    if (!$next_time || $notification_datetime < $next_time) {
                                                        $next_time = $notification_datetime;
                                                    }
                                                }
                                                echo $next_time ? htmlspecialchars($next_time->format('h:i A')) : 'Not set';
                                            }
                                            ?>
                                            </strong>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No active prescriptions found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/prescription_notifications.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>
?>