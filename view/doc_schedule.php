<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../images/bafrow_logo.png" type="image/png">
    <title>Doctor Schedule</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/calender.css">
    <link rel="stylesheet" href="../css/schedule.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css">
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
                    <a href="doc_schedule.php" class="active">
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
    
            <div class="schedule-container">
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
                
                <div class="timeslots-section">
                    <div class="timeslots-header">
                        <h3>Available Time Slots</h3>
                        <p>Select your available times for <span id="selected-date">Please select a date</span></p>
                    </div>
                    
                    <div class="time-options">
                        <button class="time-slot" data-time="07:00">07:00 AM</button>
                        <button class="time-slot" data-time="08:00">08:00 AM</button>
                        <button class="time-slot" data-time="09:00">09:00 AM</button>
                        <button class="time-slot" data-time="10:00">10:00 AM</button>
                        <button class="time-slot" data-time="11:00">11:00 AM</button>
                        <button class="time-slot" data-time="12:00">12:00 PM</button>
                        <button class="time-slot" data-time="13:00">01:00 PM</button>
                        <button class="time-slot" data-time="14:00">02:00 PM</button>
                        <button class="time-slot" data-time="15:00">03:00 PM</button>
                        <button class="time-slot" data-time="16:00">04:00 PM</button>
                        <button class="time-slot" data-time="17:00">05:00 PM</button>
                        <button class="time-slot" data-time="18:00">06:00 PM</button>
                    </div>
                    <button id="save-schedule" class="save-btn">Save Schedule</button>

                    <div class="selected-schedule" id="selected-schedule">
                        <h4>Scheduled Times:</h4>
                        <ul id="schedule-list"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/calender.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
    <script src="../js/schedule.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>