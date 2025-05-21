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
    <link rel="stylesheet" href="../css/doc_appointment.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Doctor Appointments</title>
</head>

<style>
    .status-dropdown {
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: white;
    font-size: 16px;
    color: #333;
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
    padding-right: 35px; 
    }
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
            
            <div class="appointments-container">
                <div class="appointments-header">
                    <h1 class="appointments-title">Today's Appointments</h1>
                    <div class="date-selector">
                        <button id="prevDay"><i class="fas fa-chevron-left"></i></button>
                        <span id="currentDate">Loading...</span>
                        <button id="nextDay"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                
                <div class="appointments-list">
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Patient Name</th>
                                <th>Date</th>
                                <th>Appointment Type</th>
                                <th>Clinic Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentsBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/doc_aptmt_date.js"></script>
    <script>
        document.querySelectorAll('.status-dropdown').forEach(select => {
            function updateColor(dropdown) {
                let color = {
                    "Scheduled": "blue",
                    "Completed": "green",
                    "Cancelled": "red"
                }[dropdown.value] || "black";
                dropdown.style.color = color;
            }
            updateColor(select);
            select.addEventListener('change', function() {
                updateColor(this);
                const bookingId = this.getAttribute('data-booking-id');
                const status = this.value;
                fetch('../actions/update_appointment_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `booking_id=${bookingId}&status=${status}`
                });
            });
        });
    </script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>