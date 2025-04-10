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
    <link rel="stylesheet" href="../css/reset_password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Doctor Dashboard</title>
</head>
<body>
    <!-- Password Reset Modal -->
    <div class="password-modal" id="passwordModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-key"></i> Change Password</h2>
            </div>
            <div class="modal-body">
                <p style="margin-bottom: 20px;">For security reasons, please change your default password.</p>
                
                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" id="currentPassword" name="currentPassword" placeholder="Enter your current password">
                    <div class="error-message" id="currentPasswordError"></div>
                </div>
                
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" name="newPassword" placeholder="Enter your new password">
                    <div class="password-strength">Must be at least 8 characters with numbers and special characters</div>
                    <div class="error-message" id="newPasswordError"></div>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword">Confirm New Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password">
                    <div class="error-message" id="confirmPasswordError"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal btn-secondary" id="cancelBtn">Cancel</button>
                <button class="btn-modal btn-primary" id="submitBtn">Update Password</button>
            </div>
        </div>
    </div>

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
                    <a href="index.php">
                        <i class="fas fa-right-from-bracket"></i>
                        <div class="title">Logout</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="top-bar">
                <div class="search">
                    <input type="text" name="search" placeholder="search here">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
                <i class="fas fa-bell"></i>
                <div class="user">
                    <span class="profile-text">Profile</span>
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
    <script src= "../js/reset_password.js"></script>
</body>
</html>