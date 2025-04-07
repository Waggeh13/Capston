<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/lab_container.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/prescription.css">
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
            <div class="heading">
                <h2>Prescription Form</h2>
            </div>
            <div class="lab-container">
            <form action="#" class="form" id="prescriptionForm">
                <div class="input-box">
                    <label>Doctor Full Name</label>
                    <input type="text" name="dFullName" placeholder="Enter doctor full name" required>
                </div>
                <div class="input-box">
                    <label>Patient Full Name</label>
                    <input type="text" name="pFullName" placeholder="Enter patient full name" required>
                </div>
                <div class="input-box">
                    <label>Date of Prescription</label>
                    <input type="date" name="date" placeholder="Enter prescription date" required>
                </div>
                <!-- Medication Container - will hold all medication entries -->
                <div id="medicationsContainer">
                    <!-- First medication entry (default) -->
                    <div class="medication-entry">
                        <div class="input-row">
                            <div class="input-box">
                                <label>Medicine Name</label>
                                <input type="text" name="medicines[]" placeholder="Enter medication name" required>
                            </div>
                            <div class="input-box">
                                <label>Dosage</label>
                                <input type="text" name="dosages[]" placeholder="e.g., 500mg, 1 tablet" required>
                            </div>
                        </div>
                        <div class="input-box">
                            <label>Instructions</label>
                            <textarea name="instructions[]" rows="3" placeholder="Enter instructions (frequency, duration, etc.)" required></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Button to add more medications -->
                <button type="button" id="addMedicationBtn" class="add-btn">
                    <i class="fas fa-plus"></i> Add Another Medication
                </button>
                
                <button type="submit" class="request-btn">Submit Prescription</button>
            </form>
        </div>
    </div>
    <script src="../js/prescription.js"></script>
</body>
</html>