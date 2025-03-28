<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/lab_container.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Lab Test</title>
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
                    <a href="doctor_dashboard.html">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="doc_appointment.html">
                        <i class="fas fa-stethoscope"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="doc_schedule.html">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="title">Schedule</div>
                    </a>
                </li>
                <li>
                    <a href="doc_lab.html">
                        <i class="fas fa-vial"></i>
                        <div class="title">Lab Test</div>
                    </a>
                </li>
                <li>
                    <a href="doc_prescription.html">
                        <i class="fas fa-prescription-bottle-alt"></i>
                        <div class="title">Prescription</div>
                    </a>
                </li>
                <li>
                    <a href="doc_telemedicine.html">
                        <i class="fas fa-video"></i>
                        <div class="title">Virtual Consultation</div>
                    </a>
                </li>
                <li>
                    <a href="doc_message.html">
                        <i class="fas fa-envelope"></i>
                        <div class="title">Messages</div>
                    </a>
                </li>
                <li>
                    <a href="request.html">
                        <i class="fas fa-file-medical"></i>
                        <div class="title">Report Request</div>
                    </a>
                </li>
                <li>
                    <a href="setting.html">
                        <i class="fas fa-cog"></i>
                        <div class="title">Settings</div>
                    </a>
                </li>
                <li>
                    <a href="index.html">
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
            <div class="heading">
                <h2>Lab Test Request Form</h2>
            </div>
            <div class="lab-container">
                <form action="#" class="form">
                    <div class="input-box">
                        <label>Doctor Full Name</label>
                        <input type="text" placeholder="Enter doctor full name" required>
                    </div>
                    <div class="input-box">
                        <label>Patient Full Name</label>
                        <input type="text" placeholder="Enter patient full name" required>
                    </div>
                    <div class="gender-box">
                        <h3>Gender</h3>
                        <div class="gender-option">
                            <div class="gender">
                                <input type="radio" name="gender">
                                <label>Male</label>
                            </div>
                            <div class="gender">
                                <input type="radio" name="gender">
                                <label>Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="input-box">
                        <label>Patient D.O.B</label>
                        <input type="date" placeholder="Enter birth date" required>
                    </div>
                    <div class="input-box">
                        <label>Patient Address</label>
                        <input type="text" placeholder="Enter patient address" required>
                    </div>
                    <div class="input-box">
                        <label>Test</label>
                        <input type="text" placeholder="Enter lab test" required>
                    </div>
                    <div class="input-box">
                        <label>Price</label>
                        <input type="number" placeholder="Enter lab price" required>
                    </div>
                    <button  class="request-btn">Request Lab Test</button>
                </form>
            </div>
        </div>
</body>
</html>