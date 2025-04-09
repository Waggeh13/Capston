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
                        <tbody>
                            <tr class="result-item" data-id="1">
                                <td>PAT001</td>
                                <td>John Doe</td>
                                <td>Full Blood Count & DIFF</td>
                                <td>2023-10-15</td>
                                <td><span class="status-badge status-completed">Completed</span></td>
                            </tr>
                            <tr class="result-item" data-id="2">
                                <td>PAT002</td>
                                <td>Jane Smith</td>
                                <td>Haemoglobin, Blood Group</td>
                                <td>2023-10-16</td>
                                <td><span class="status-badge status-completed">Completed</span></td>
                            </tr>
                            <tr class="result-item" data-id="3">
                                <td>PAT003</td>
                                <td>Michael Johnson</td>
                                <td>Sickle Test, Hb genotype</td>
                                <td>2023-10-17</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                            </tr>
                            <tr class="result-item" data-id="4">
                                <td>PAT004</td>
                                <td>Sarah Williams</td>
                                <td>PT, aPTT, INR</td>
                                <td>2023-10-18</td>
                                <td><span class="status-badge status-completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    
        <!-- Lab Request Modal -->
        <div id="labModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>BAFROW HEMATOLOGY REQUEST FORM</h2>

                <form action ="#"  id="labRequestForm" class="form">
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
                        <div class="input-box">
                            <label>Doctor Full Name</label>
                            <input type="text" id="dFullName" name="dFullName" placeholder="Enter doctor full name" required>
                        </div>
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
                <span class="close">&times;</span>
                <h2>BAFROW HEMATOLOGY RESULTS</h2>
                
                <div class="results-form">
                    <!-- Patient Info -->
                    <div class="form-section">
                        <h3>PATIENT INFORMATION</h3>
                        <div class="input-row">
                            <div class="input-box">
                                <label>Patient ID</label>
                                <p>PAT001</p>
                            </div>
                            <div class="input-box">
                                <label>Patient Name</label>
                                <p>John Doe</p>
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="input-box">
                                <label>Age</label>
                                <p>35</p>
                            </div>
                            <div class="input-box">
                                <label>Sex</label>
                                <p>Male</p>
                            </div>
                        </div>
                        <div class="input-box">
                            <label>Suspected Diagnosis</label>
                            <p>Anemia</p>
                        </div>
                    </div>
                    
                    <!-- Test Results -->
                    <div class="form-section">
                        <h3>TEST RESULTS</h3>
                        <table>
                            <tr>
                                <th>EXAMINATION</th>
                                <th>RESULT</th>
                                <th>REFERENCE RANGE</th>
                                <th>EXAMINATION</th>
                                <th>RESULT</th>
                                <th>REFERENCE RANGE</th>
                            </tr>
                            <tr>
                                <td>Haemoglobin</td>
                                <td>14.2</td>
                                <td>Men 13 – 18 g/dl</td>
                                <td>Thick Blood Film</td>
                                <td>Negative</td>
                                <td>N/A</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Women 12.5 – 16.5 g/dl</td>
                                <td>Blood Group</td>
                                <td>O+</td>
                                <td>N/A</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Babies 13.5 – 19.5 g/dl</td>
                                <td>Retics</td>
                                <td>2.8%</td>
                                <td>2-3.5%</td>
                            </tr>
                            <tr>
                                <td>WBC Total</td>
                                <td>7.5 X 10^9/L</td>
                                <td>4 – 10 x 10^9/L</td>
                                <td>ESR</td>
                                <td>5mm/hr</td>
                                <td>1-7mm/hr</td>
                            </tr>
                            <tr>
                                <td>DIFF COUNT:</td>
                                <td></td>
                                <td></td>
                                <td>Sickle Test</td>
                                <td>Negative</td>
                                <td>N/A</td>
                            </tr>
                            <tr>
                                <td>Neutrophils</td>
                                <td>65.0%</td>
                                <td>50.0 – 70.0%</td>
                                <td>HB Genotype</td>
                                <td>AA</td>
                                <td>N/A</td>
                            </tr>
                            <tr>
                                <td>Lymphocytes</td>
                                <td>30.0%</td>
                                <td>20.0 – 40.0%</td>
                                <td>PT</td>
                                <td>12 secs</td>
                                <td>11-13.5 secs</td>
                            </tr>
                            <tr>
                                <td>Monocytes</td>
                                <td>4.0%</td>
                                <td>3.0 – 14.0%</td>
                                <td>INR</td>
                                <td>1.0</td>
                                <td>0.9-1.2 ratio</td>
                            </tr>
                            <tr>
                                <td>Eosinophils</td>
                                <td>1.0%</td>
                                <td>Nil</td>
                                <td>aPTT</td>
                                <td>30 secs</td>
                                <td>25-35 secs</td>
                            </tr>
                            <tr>
                                <td>Basophils</td>
                                <td>0.0%</td>
                                <td>Nil</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Normoblasts</td>
                                <td>0 /100WBCs</td>
                                <td>Nil</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>RBC</td>
                                <td>4.80 x 10^12/L</td>
                                <td>3.50 – 5.50 x 10^12/L</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>PCV / HCT</td>
                                <td>45.0%</td>
                                <td>37.0 – 54.0%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>MCV</td>
                                <td>88.0fl</td>
                                <td>80.0 – 100fl</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>MCH</td>
                                <td>30.0pg</td>
                                <td>27.0 – 34.0pg</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>MCHC</td>
                                <td>34.0g/dl</td>
                                <td>32.0 – 36.0g/dl</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Platelets</td>
                                <td>220 x 10^9/L</td>
                                <td>100 – 300 x 10^9/L</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>MPV</td>
                                <td>9.5fl</td>
                                <td>6.5 – 12.0fl</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>PCT</td>
                                <td>0.209%</td>
                                <td>0.108 – 0.282%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Laboratory Use Section -->
                    <div class="form-section">
                        <h3>FOR LABORATORY USE ONLY</h3>
                        <div class="input-row">
                            <div class="input-box">
                                <label>Specimen Received By</label>
                                <p>Lab Technician Name</p>
                            </div>
                            <div class="input-box">
                                <label>Date Received</label>
                                <p>2023-10-16</p>
                            </div>
                            <div class="input-box">
                                <label>Time Received</label>
                                <p>10:30 AM</p>
                            </div>
                            <div class="input-box">
                                <label>Sample Accepted</label>
                                <p>YES</p>
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="input-box">
                                <label>Lab Tech Signature & Date</label>
                                <p>Signature / 2023-10-16</p>
                            </div>
                            <div class="input-box">
                                <label>Supervisor Signature & Date</label>
                                <p>Signature / 2023-10-16</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="../js/doc_lab.js"></script>
    </div>
</body>
</html>