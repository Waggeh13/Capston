<?php
require_once('../settings/core.php');
require_once('../classes/userName_class.php');
require_once('../classes/DoctorDashboard_class.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

redirect_doctor_if_not_logged_in();

$doctor_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;

error_log("doctor_dashboard.php user_id: " . ($doctor_id ?? 'not set'));
error_log("doctor_dashboard.php user_role: " . ($user_role ?? 'not set'));

$userProfile = new userName_class();
$dashboard = new DoctorDashboard_class($doctor_id);
$today_appointments = $dashboard->getTodayAppointmentsCount();
$patients_seen = $dashboard->getPatientsSeenCount();
$virtual_consultations = $dashboard->getVirtualConsultationsCount();
$appointments = $dashboard->getTodayAppointments();
$next_patient = $dashboard->getNextPatient();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/btn_style.css">
    <link rel="stylesheet" href="../css/calender.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/datas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Doctor Dashboard</title>
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
        }
        .fas.fa-bell {
            margin-left: 1180px;
        }
        .profile-text {
            color: black;
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
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php echo htmlspecialchars($today_appointments); ?></div>
                        <div class="card-name">Today's Appointments</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">1</div>
                        <div class="card-name">Medical Report Request</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-file-medical"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php echo htmlspecialchars($patients_seen); ?></div>
                        <div class="card-name">Patients Seen</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php echo htmlspecialchars($virtual_consultations); ?></div>
                        <div class="card-name">Virtual Consultations</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-video"></i>
                    </div>
                </div>
            </div>
            <div class="data">
                <div class="todays-appointments">
                    <div class="heading">
                        <h2><i class="fas fa-calendar-day"></i> Today's Appointments</h2>
                    </div>
                    <div class="table-container">
                        <table class="appointments">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Clinic</th>
                                    <th>Appointment Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appt): ?>
                                    <tr>
                                        <td>
                                            <div class="patient-info">
                                                <div class="avatar"><i class="fas fa-user"></i></div>
                                                <div>
                                                    <div class="name"><?php echo htmlspecialchars($appt['first_name'] . ' ' . $appt['last_name']); ?></div>
                                                    <div class="meta"><?php echo htmlspecialchars($appt['Gender'] . ' • ' . $appt['age'] . 'yrs'); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="clinic-badge <?php echo htmlspecialchars(strtolower(str_replace(' ', '-', $appt['clinic']))); ?>">
                                                <?php echo htmlspecialchars($appt['clinic']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="time-slot">
                                                <i class="far fa-clock"></i>
                                                <?php echo htmlspecialchars($appt['time_slot']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status <?php echo htmlspecialchars(strtolower($appt['status'])); ?>">
                                                <?php echo htmlspecialchars($appt['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($appointments)): ?>
                                    <tr><td colspan="4">No appointments today</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="next-patient-card">
                    <div class="heading">
                        <h2><i class="fas fa-user-injured"></i> Next Patient</h2>
                        <div class="urgency-badge">Next Up</div>
                    </div>
                    <?php if ($next_patient): ?>
                        <div class="patient-profile">
                            <div class="patient-avatar"><i class="fas fa-user"></i></div>
                            <div class="patient-info">
                                <h3><?php echo htmlspecialchars($next_patient['first_name'] . ' ' . $next_patient['last_name']); ?></h3>
                                <div class="patient-meta">
                                    <span><i class="fas fa-venus-mars"></i> <?php echo htmlspecialchars($next_patient['Gender']); ?></span>
                                    <span><i class="fas fa-birthday-cake"></i> <?php echo htmlspecialchars($next_patient['age']); ?> yrs</span>
                                    <span><i class="fas fa-weight"></i> <?php echo htmlspecialchars($next_patient['weight']); ?> kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="patient-details">
                            <div class="detail-row">
                                <div class="detail">
                                    <i class="fas fa-id-card"></i>
                                    <div>
                                        <label>Patient ID</label>
                                        <div class="value"><?php echo htmlspecialchars($next_patient['patient_id']); ?></div>
                                    </div>
                                </div>
                                <div class="detail">
                                    <i class="fas fa-calendar-check"></i>
                                    <div>
                                        <label>Appointment Type</label>
                                        <div class="value"><?php echo htmlspecialchars($next_patient['appointment_type']); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail">
                                    <i class="fas fa-birthday-cake"></i>
                                    <div>
                                        <label>Date of Birth</label>
                                        <div class="value"><?php echo htmlspecialchars($next_patient['dob_formatted']); ?></div>
                                    </div>
                                </div>
                                <div class="detail">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <label>Address</label>
                                        <div class="value"><?php echo htmlspecialchars($next_patient['address'] ?: 'N/A'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>No upcoming patients today</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/dark_mode.js"></script>
</body>
</html>