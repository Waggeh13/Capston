<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../images/bafrow_logo.png" type="image/png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/btn_style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/edit_add.css">
    <link rel="stylesheet" href="../css/reset_password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Admin Dashboard</title>
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
            position: absolute;
            right: 150px;
            overflow: visible;
        }
    .profile-text{
    color: black;
    }
</style>
<?php
require_once('../classes/getUpcomingAppointments_class.php');
require_once('../classes/getAvailableDoctors_class.php');
require_once('../settings/core.php');
redirect_superadmin_if_not_logged_in();


$db = new getUpcomingAppointments_class();
$appointments = $db->getUpcomingAppointments(5);
$appointment_count = $db->countScheduledAppointments();
$patient_count = $db->countPatients();
$staff_count = $db->countStaff();
$department_count = $db->countDepartments();


$doctors_db = new getAvailableDoctors_class();
$available_doctors = $doctors_db->getAvailableDoctors(5);


if (!is_array($appointments)) {
    $appointments = [];
}

if (!is_array($available_doctors)) {
    $available_doctors = [];
}
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
                    <a href="super_admin_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_appointment.php">
                        <i class="fas fa-stethoscope"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="admin.php">
                        <i class="fas fa-users"></i>
                        <div class="title">Admins</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_staff.php">
                        <i class="fas fa-users"></i>
                        <div class="title">Staff</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_patient.php">
                        <i class="fas fa-user"></i>
                        <div class="title">Patients</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_department.php">
                        <i class="fas fa-puzzle-piece"></i>
                        <div class="title">Departments</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_clinic.php">
                        <i class="fas fa-briefcase-medical"></i>
                        <div class="title">Clinics</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_setting.php">
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
                    <span class="profile-text">Fatou Waggeh</span>
                </div>
            </div>
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= htmlspecialchars($appointment_count) ?></div>
                        <div class="card-name">Appointments</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= htmlspecialchars($patient_count) ?></div>
                        <div class="card-name">Patients</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= htmlspecialchars($staff_count) ?></div>
                        <div class="card-name">Staff</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= htmlspecialchars($department_count) ?></div>
                        <div class="card-name">Departments</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
                
            </div>
            <div class="tables">
                <div class="last-appointments">
                    <div class="heading">
                        <h2>Last Appointments</h2>
                        <a href="super_admin_appointment.php" class="btn">View All</a>
                    </div>
                    <table class="appointments">
                        <thead>
                            <td>Patient Name</td>
                            <td>Doctor</td>
                            <td>Clinic</td>
                            <td>Time</td>
                        </thead>
                        <?php if (!empty($appointments)): ?>
                            <?php foreach ($appointments as $apt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($apt['patient_full_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($apt['doctor_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($apt['clinic_name'] ?? 'N/A') ?></td>
                                    <td>
                                        <?= !empty($apt['time_slot']) ? date('g:i A', strtotime($apt['time_slot'])) : 'N/A' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">
                                    No upcoming appointments found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <div class="doctor-available">
                    <div class="heading">
                        <h2>Doctors Available</h2>
                        <a href="super_admin_staff.php" class="btn">View All</a>
                    </div>
                    <table class="available">
                        <thead>
                            <td>Name</td>
                            <td>Deparatment</td>
                            <td>Available Time</td>
                        </thead>
                        <tbody>
                        <?php if (!empty($available_doctors)): ?>
                                <?php foreach ($available_doctors as $doc): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($doc['doctor_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($doc['department_name'] ?? 'N/A') ?></td>
                                        <td>
                                            <?= !empty($doc['time_slot']) ? date('g:i A', strtotime($doc['time_slot'])) . ' - ' . date('g:i A', strtotime($doc['time_slot'] . ' +5 hours')) : 'N/A' ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="text-align: center;">
                                        No available doctors found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/dark_mode.js"></script>
</body>
</html>