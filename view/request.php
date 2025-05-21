<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../images/bafrow_logo.png" type="image/png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/request.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Requests</title>
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
    .user {
            display: inline-block;
            white-space: nowrap;
            margin-left: 10px;
            position: absolute;
            right: 150px;
            overflow: visible;
        }
    .profile-text {
        color: black;
    }
    .request-meta span {
        display: block;
        color: #7f8c8d;
        font-size: 0.9rem;
        margin: 0.2rem 0;
    }
    .request-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-primary {
        background: #0054A6;
        color: white;
    }
    .btn-primary:hover {
        background: red;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
    }
    .modal-content h2 {
        margin-top: 0;
        color: #2c3e50;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #34495e;
        font-weight: bold;
    }
    .form-group input[type="file"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }
    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
    .btn-cancel {
        background: #e74c3c;
    }
    .btn-cancel:hover {
        background: #c0392b;
    }
</style>
<?php
require_once('../settings/core.php');
require_once('../classes/userName_class.php');
require_once('../controllers/request_controller.php');

redirect_doctor_if_not_logged_in();

$doctor_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

if (!$doctor_id) {
    die("Error: Doctor not logged in or session expired.");
}

$userProfile = new userName_class();

$requests = get_pending_requests_by_doctor_ctr($doctor_id);
$request_count = count($requests);
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
                <div class="user">
                    <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>
            <div class="requests-container">
                <div class="requests-header">
                    <h1 class="requests-title">Medical Summary Requests <span class="notification-dot"></span></h1>
                    <div class="request-count"><?php echo $request_count; ?> Pending Request<?php echo $request_count !== 1 ? 's' : ''; ?></div>
                </div>
                <div class="requests-list">
                    <?php if (!empty($requests)): ?>
                        <?php foreach ($requests as $request): ?>
                            <div class="request-item">
                                <div class="request-info">
                                    <div class="patient-name">
                                        <?php echo htmlspecialchars($request['patient_name']); ?>
                                        <span class="badge badge-new">New</span>
                                    </div>
                                    <div class="request-meta">
                                        <span>ID: <?php echo htmlspecialchars($request['patient_id']); ?></span>
                                        <span>Destination: <?php echo htmlspecialchars($request['hospital_name']); ?></span>
                                    </div>
                                </div>
                                <div class="request-actions">
                                    <button class="btn btn-primary" onclick="openSummaryModal('<?php echo $request['request_id']; ?>', '<?php echo $request['patient_id']; ?>', '<?php echo htmlspecialchars($request['patient_name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($request['hospital_name'], ENT_QUOTES); ?>')">
                                        <i class="fas fa-file-upload"></i> Upload Summary
                                    </button>
                                    <button class="btn btn-primary" onclick="downloadTemplate('<?php echo $request['patient_id']; ?>', '<?php echo htmlspecialchars($request['patient_name'], ENT_QUOTES); ?>')">
                                        <i class="fas fa-file-medical"></i> Download Template
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="request-item">
                            <div class="request-info">
                                <div class="patient-name">No pending requests</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="summaryModal" class="modal">
            <div class="modal-content">
                <h2>Upload Summary for <span id="modalPatientName"></span></h2>
                <div class="form-group">
                    <label for="summaryFile">Select Filled Summary (PDF)</label>
                    <input type="file" id="summaryFile" accept=".pdf" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeSummaryModal()">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="sendSummary()">Send</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/dark_mode.js"></script>
    <script src="../js/request.js"></script>
</body>
</html>