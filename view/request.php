
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/lab_container.css">
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
</style>

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
                <div class="search">
                    <input type="text" name="search" placeholder="Search appointments...">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
                <i class="fas fa-bell"></i>
                <div class="user">
                    <span class="profile-text">Profile</span>
                </div>
            </div>
            <div class="requests-container">
                <div class="requests-header">
                    <h1 class="requests-title">Medical Summary Requests <span class="notification-dot"></span></h1>
                    <div class="request-count">3 Pending Requests</div>
                </div>
                
                <div class="requests-list">
                    <!-- Request Item 1 -->
                    <div class="request-item">
                        <div class="request-info">
                            <div class="patient-name">John Doe <span class="badge badge-new">New</span></div>
                            <div class="request-meta">
                                <span>ID: PT12345</span>
                                <span>Requested: Today, 09:30 AM</span>
                                <span>Destination: Serrekunda General Hospital</span>
                            </div>
                        </div>
                        <div class="request-actions">
                            <button class="btn btn-primary">
                                <i class="fas fa-file-medical"></i> Prepare Summary
                            </button>
                        </div>
                    </div>
                    
                    <!-- Request Item 2 -->
                    <div class="request-item">
                        <div class="request-info">
                            <div class="patient-name">Amina Ceesay</div>
                            <div class="request-meta">
                                <span>ID: PT12346</span>
                                <span>Requested: Yesterday, 02:15 PM</span>
                                <span>Destination: EFSTH</span>
                            </div>
                        </div>
                        <div class="request-actions">
                            <button class="btn btn-primary">
                                <i class="fas fa-file-medical"></i> Prepare Summary
                            </button>
                        </div>
                    </div>
                    
                    <!-- Request Item 3 -->
                    <div class="request-item">
                        <div class="request-info">
                            <div class="patient-name">Michael Brown</div>
                            <div class="request-meta">
                                <span>ID: PT12347</span>
                                <span>Requested: 2 days ago</span>
                                <span>Destination: Bansang Hospital</span>
                            </div>
                        </div>
                        <div class="request-actions">
                            <button class="btn btn-primary">
                                <i class="fas fa-file-medical"></i> Prepare Summary
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>