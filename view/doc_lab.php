<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/lab.css">
    <link rel="stylesheet" href="../css/lab_title.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Lab Test</title>
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
            
            <!-- Lab Content Section -->
            <div class="lab-content">
                <div class="lab-results-header">
                    <div class="header-content">
                        <h2 class="section-title">Lab Test</h2>
                        <button class="new-request-btn" id="newRequestBtn">
                            <i class="fas fa-plus"></i> New Lab Request
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th>Test Type</th>
                                <th>Request Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="labRequestsTableBody">
                            <!-- Lab requests will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
    
            <!-- Lab Request Modal -->
            <div id="labModal" class="modal">
                <div class="modal-content">
                    <span class="close">×</span>
                    <h2>BAFROW HEMATOLOGY REQUEST FORM</h2>

                    <form action="#" id="labRequestForm" class="form">
                        <!-- Section 1: PATIENT INFORMATION -->
                        <div class="form-section">
                            <h3>PATIENT INFORMATION</h3>
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Last Name</label>
                                    <input type="text" id="lastName" name="lastName" placeholder="Enter last name" required>
                                </div>
                                <div class="input-box">
                                    <label>First Name</label>
                                    <input type="text" id="firstName" name="firstName" placeholder="Enter first name" required>
                                </div>
                            </div>
                            <div class="input-box">
                                <label>Suspected Diagnosis</label>
                                <input type="text" id="diagnosis" name="diagnosis" placeholder="Enter suspected diagnosis" required>
                            </div>
                            <div class="input-box">
                                <label>Lab Code</label>
                                <input type="text" id="labCode" name="labCode" placeholder="Enter lab code">
                            </div>
                        </div>

                        <!-- Section 2: ORDERING PHYSICIAN INFORMATION -->
                        <div class="form-section">
                            <h3>ORDERING PHYSICIAN INFORMATION</h3>
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Signature</label>
                                    <input type="text" id="signature" name="signature" placeholder="Physician signature" required>
                                </div>
                                <div class="input-box">
                                    <label>Extension</label>
                                    <input type="text" id="extension" name="extension" placeholder="Ext.">
                                </div>
                            </div>
                            <div class="input-box">
                                <label>Request Date</label>
                                <input type="date" id="requestDate" name="requestDate" required>
                            </div>
                        </div>

                        <!-- TEST REQUESTS -->
                        <div class="form-section">
                            <h3>TEST REQUESTS</h3>
                            <div class="checkbox-group">
                                <div class="checkbox-options">
                                    <div class="checkbox-column">
                                        <label><input type="checkbox" name="testRequest[]" value="Haemoglobin"> Haemoglobin</label>
                                        <label><input type="checkbox" name="testRequest[]" value="Full Blood Count & DIFF"> Full Blood Count & DIFF</label>
                                        <label><input type="checkbox" name="testRequest[]" value="Blood Film"> Blood Film</label>
                                        <label><input type="checkbox" name="testRequest[]" value="Blood group"> Blood group</label>
                                        <label><input type="checkbox" name="testRequest[]" value="Retics"> Retics</label>
                                    </div>
                                    <div class="checkbox-column">
                                        <label><input type="checkbox" name="testRequest[]" value="Sickle test"> Sickle test</label>
                                        <label><input type="checkbox" name="testRequest[]" value="Hb genotype"> Hb genotype</label>
                                        <label><input type="checkbox" name="testRequest[]" value="PT"> PT</label>
                                        <label><input type="checkbox" name="testRequest[]" value="aPTT"> aPTT</label>
                                        <label><input type="checkbox" name="testRequest[]" value="INR"> INR</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="request-btn">Submit Lab Test Request</button>
                    </form>
                </div>
            </div>

            <!-- Results Modal -->
            <div id="resultsModal" class="modal">
                <div class="modal-content">
                    <span class="close">×</span>
                    <h2>BAFROW HEMATOLOGY RESULTS</h2>
                    
                    <div class="results-form">
                        <!-- Patient Info -->
                        <div class="form-section">
                            <h3>PATIENT INFORMATION</h3>
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Patient ID</label>
                                    <p id="resultPatientId"></p>
                                </div>
                                <div class="input-box">
                                    <label>Patient Name</label>
                                    <p id="resultPatientName"></p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Age</label>
                                    <p id="resultPatientAge"></p>
                                </div>
                                <div class="input-box">
                                    <label>Sex</label>
                                    <p id="resultPatientGender"></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Doctor Info -->
                        <div class="form-section">
                            <h3>ORDERING PHYSICIAN INFORMATION</h3>
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Doctor Name</label>
                                    <p id="resultDoctorName"></p>
                                </div>
                                <div class="input-box">
                                    <label>Signature</label>
                                    <p id="resultDoctorSignature"></p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Extension</label>
                                    <p id="resultDoctorExtension"></p>
                                </div>
                                <div class="input-box">
                                    <label>Request Date</label>
                                    <p id="resultRequestDate"></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Test Results -->
                        <div class="form-section">
                            <h3>TEST RESULTS</h3>
                            <table>
                                <thead>
                                    <th>EXAMINATION</th>
                                    <th>RESULT</th>
                                    <th></th>
                                    <th>EXAMINATION</th>
                                    <th>RESULT</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Haemoglobin</td>
                                        <td><p id="resultHaemoglobin"></p></td>
                                        <td></td>
                                        <td>Sickle test</td>
                                        <td><p id="resultSickleTest"></p></td>
                                    </tr>
                                    <tr>
                                        <td>Full Blood Count & DIFF</td>
                                        <td><p id="resultFullBloodCount"></p></td>
                                        <td></td>
                                        <td>Hb genotype</td>
                                        <td><p id="resultHbGenotype"></p></td>
                                    </tr>
                                    <tr>
                                        <td>Blood Film</td>
                                        <td><p id="resultBloodFilm"></p></td>
                                        <td></td>
                                        <td>PT</td>
                                        <td><p id="resultPT"></p></td>
                                    </tr>
                                    <tr>
                                        <td>Blood group</td>
                                        <td><p id="resultBloodGroup"></p></td>
                                        <td></td>
                                        <td>aPTT</td>
                                        <td><p id="resultAPTT"></p></td>
                                    </tr>
                                    <tr>
                                        <td>Retics</td>
                                        <td><p id="resultRetics"></p></td>
                                        <td></td>
                                        <td>INR</td>
                                        <td><p id="resultINR"></p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Laboratory Use Section -->
                        <div class="form-section">
                            <h3>FOR LABORATORY USE ONLY</h3>
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Specimen Received By</label>
                                    <p id="resultSpecimenReceivedBy"></p>
                                </div>
                                <div class="input-box">
                                    <label>Date Received</label>
                                    <p id="resultSpecimenDate"></p>
                                </div>
                                <div class="input-box">
                                    <label>Time Received</label>
                                    <p id="resultSpecimenTime"></p>
                                </div>
                                <div class="input-box">
                                    <label>Sample Accepted</label>
                                    <p id="resultSampleAccepted"></p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Lab Tech Signature & Date</label>
                                    <p id="resultLabTechSignature"></p>
                                </div>
                                <div class="input-box">
                                    <label>Supervisor Signature & Date</label>
                                    <p id="resultSupervisorSignature"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script src="../js/doc_lab.js"></script>
            <script src="../js/dark_mode.js"></script>
        </div>
    </div>
</body>
</html>