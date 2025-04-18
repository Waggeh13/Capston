<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/btn_style.css">
    <link rel="stylesheet" href="../css/data.css">
    <link rel="stylesheet" href="../css/calender.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Doctor Dashboard</title>
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
    }
    .fas.fa-bell {
    margin-left: 1180px;
    }
    .profile-text{
    color: black;
    }
</style>
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
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number">15</div>
                        <div class="card-name">Today's Apointments</div>
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
                        <div class="number">12</div>
                        <div class="card-name">Patient Seen</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">2</div>
                        <div class="card-name">Virtual Consulations</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-video"></i>
                    </div>
                </div>
            </div>
                <div class="data">
                    <div class="todays-appointments">
                        <div class="heading">
                            <h2>Today's Appointments</h2>
                        </div>
                        <table class="appointments">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Clinic</th>
                                    <th>Appointment Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Awa Jallow</td>
                                    <td>Gynaecology</td>
                                    <td>09:30 AM</td>
                                </tr>
                                <tr>
                                    <td>Omar Touray</td>
                                    <td>Paediatrics</td>
                                    <td>11:00 AM</td>
                                </tr>
                                <tr>
                                    <td>Fatou Ceesay</td>
                                    <td>Cardiology</td>
                                    <td>02:00 PM</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                
                    <div class="next-patient-card">
                        <div class="heading">
                            <h2>Next Patient</h2>
                        </div>
                        <div class="patient-details">
                            <div class="detail"><strong>Name:</strong> Awa Jallow</div>
                            <div class="detail"><strong>ID:</strong> P-10023</div>
                            <div class="detail"><strong>Type of Appointment:</strong> General Checkup</div>
                            <div class="detail"><strong>DOB:</strong> 12 March 1988</div>
                            <div class="detail"><strong>Age:</strong> 36</div>
                            <div class="detail"><strong>Weight:</strong> 68 kg</div>
                            <div class="detail"><strong>Address:</strong> Serrekunda, The Gambia</div>
                        </div>
                    </div>

                </div>
                <div class="container-request">
                    <div class="calender">
                        <div class="header">
                            <button id="prevBtn">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <div class="monthYear" id="monthYear"></div>
                            <button id="nextBtn">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                        <div class="days">
                            <div class="day">Mon</div>
                            <div class="day">Tue</div>
                            <div class="day">Wed</div>
                            <div class="day">Thu</div>
                            <div class="day">Fri</div>
                            <div class="day">Sat</div>
                            <div class="day">Sun</div>
                        </div>
                        <div class="dates" id="dates"></div>
                    </div>
                    <div class="appointment-requests-card">
                        <h2>Appointment Requests</h2>
                        <div class="requests-list">
                            <div class="request">
                                <div class="request-details">
                                    <p><strong>Name:</strong> Awa Jallow</p>
                                    <p><strong>Clinic:</strong> Gynaecology</p>
                                </div>
                                <div class="actions">
                                    <button class="accept">Accept</button>
                                    <button class="reject">Reject</button>
                                </div>
                            </div>
                    
                            <div class="request">
                                <div class="request-details">
                                    <p><strong>Name:</strong> Musa Ceesay</p>
                                    <p><strong>Clinic:</strong> Pediatrics</p>
                                </div>
                                <div class="actions">
                                    <button class="accept">Accept</button>
                                    <button class="reject">Reject</button>
                                </div>
                            </div>
                    
                            <div class="request">
                                <div class="request-details">
                                    <p><strong>Name:</strong> Fatou Sowe</p>
                                    <p><strong>Clinic:</strong> Cardiology</p>
                                </div>
                                <div class="actions">
                                    <button class="accept">Accept</button>
                                    <button class="reject">Reject</button>
                                </div>
                            </div>

                            <div class="request">
                                <div class="request-details">
                                    <p><strong>Name:</strong> Fatou Sowe</p>
                                    <p><strong>Clinic:</strong> Cardiology</p>
                                </div>
                                <div class="actions">
                                    <button class="accept">Accept</button>
                                    <button class="reject">Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <script src= "../js/calender.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>