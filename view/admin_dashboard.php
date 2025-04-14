<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/btn_style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/edit_add.css">
    <link rel="stylesheet" href="../css/reset_password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Admin Dashboard</title>
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
                    <a href="admin_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="admin_appointment.php">
                        <i class="fas fa-stethoscope"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="admin_staff.php">
                        <i class="fas fa-users"></i>
                        <div class="title">Staff</div>
                    </a>
                </li>
                <li>
                    <a href="admin_patient.php">
                        <i class="fas fa-user"></i>
                        <div class="title">Patients</div>
                    </a>
                </li>
                <li>
                    <a href="admin_department.php">
                        <i class="fas fa-puzzle-piece"></i>
                        <div class="title">Departments</div>
                    </a>
                </li>
                <li>
                    <a href="admin_clinic.php">
                        <i class="fas fa-briefcase-medical"></i>
                        <div class="title">Clinics</div>
                    </a>
                </li>
                <li>
                    <a href="admin_setting.php">
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
                        <div class="number">67</div>
                        <div class="card-name">Appointments</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">105</div>
                        <div class="card-name">Patients</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">100</div>
                        <div class="card-name">Staff</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">12</div>
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
                        <a href="admin_appointment.php" class="btn">View All</a>
                    </div>
                    <table class="appointments">
                        <thead>
                            <td>Patient Name</td>
                            <td>Doctor</td>
                            <td>Clinic</td>
                            <td>Time</td>
                        </thead>
                        <tr>
                            <td>Lamin Sanneh</td>
                            <td>Dr. Singhateh</td>
                            <td>ENT</td>
                            <td>10:00 AM</td>
                        </tr>
                        <tr>
                            <td>Lamin Sanneh</td>
                            <td>Dr. Singhateh</td>
                            <td>ENT</td>
                            <td>11:30 AM</td>
                        </tr>
                        <tr>
                            <td>Lamin Sanneh</td>
                            <td>Dr. Singhateh</td>
                            <td>ENT</td>
                            <td>2:15 PM</td>
                        </tr>
                        <tr>
                            <td>Lamin Sanneh</td>
                            <td>Dr. Singhateh</td>
                            <td>ENT</td>
                            <td>9:00 AM</td>
                        </tr>
                        <tr>
                            <td>Lamin Sanneh</td>
                            <td>Dr. Singhateh</td>
                            <td>ENT</td>
                            <td>3:45 PM</td>
                        </tr>
                        <tr>
                            <td>Lamin Sanneh</td>
                            <td>Dr. Singhateh</td>
                            <td>ENT</td>
                            <td>1:30 PM</td>
                        </tr>
                    </table>
                </div>
                <div class="doctor-available">
                    <div class="heading">
                        <h2>Doctors Available</h2>
                        <a href="admin_staff.php" class="btn">View All</a>
                    </div>
                    <table class="available">
                        <thead>
                            <td>Name</td>
                            <td>Deparatment</td>
                            <td>Available Time</td>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Singhateh</td>
                                <td>Gynocology</td>
                                <td>8:00 - 13:00</td>
                                
                            </tr>
                            <tr>
                                <td>Singhateh</td>
                                <td>Gynocology</td>
                                <td>8:00 - 13:00</td>
                         
                            </tr>
                            <tr>
                                <td>Singhateh</td>
                                <td>Gynocology</td>
                                <td>8:00 - 13:00</td>
                        
                            </tr>
                            <tr>
                                <td>Singhateh</td>
                                <td>Gynocology</td>
                                <td>8:00 - 13:00</td>
                              
                            </tr>
                            <tr>
                                <td>Singhateh</td>
                                <td>Gynocology</td>
                                <td>8:00 - 13:00</td>
                              
                            </tr>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/add_edit.js"></script>  
    <script src="../js/reset_password.js"></script>  
</body>
</html>