<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Technician Dashboard</title>
    <link rel="stylesheet" href="../css/lab_tech.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <input type="text" class="search-bar" placeholder="Search patient name/ID...">
            <div><i class="fas fa-calendar-alt"></i> <span id="current-date">Tuesday, May 14</span></div>
            <button class="logout-btn" onclick="window.location.href='index.php';">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
        </div>
        
        <h2>Pending Lab Requests</h2>
        <div class="request-cards">
            <!-- Request Card 1 -->
            <div class="request-card">
                <div class="patient-info">
                    <div class="patient-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>John Doe</strong><br>
                        Dr. Smith
                    </div>
                </div>
                <div class="request-actions">
                    <button class="btn btn-secondary" onclick="openRequestModal(1)">
                        <i class="fas fa-eye"></i> View Request
                    </button>
                    <button class="btn btn-primary" onclick="openResultsModal(1)">
                        <i class="fas fa-flask"></i> Enter Results
                    </button>
                </div>
            </div>
            
            <!-- Request Card 2 -->
            <div class="request-card">
                <div class="patient-info">
                    <div class="patient-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>Mary Smith</strong><br>
                        Dr. Johnson
                    </div>
                </div>
                <div class="request-actions">
                    <button class="btn btn-secondary" onclick="openRequestModal(2)">
                        <i class="fas fa-eye"></i> View Request
                    </button>
                    <button class="btn btn-primary" onclick="openResultsModal(2)">
                        <i class="fas fa-flask"></i> Enter Results
                    </button>
                </div>
            </div>
        </div>
    </div>
    
   <!-- Request View Modal -->
<div class="modal" id="requestModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Lab Request Form</h2>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <div class="lab-form">
            <div class="section-title">BAFROW</div>
            <div class="section-title">HAEMATOLOGY</div>
            
            <!-- Added Patient Demographics -->
            <table>
                <tr>
                    <th colspan="2">PATIENT INFORMATION</th>
                </tr>
                <tr>
                    <td width="50%">
                        <strong>NAME:</strong> John Doe<br>
                        <strong>AGE:</strong> 35 years<br>
                        <strong>SEX:</strong> Male
                    </td>
                    <td>
                        <strong>ID NUMBER:</strong> PT-1024<br>
                        <strong>DATE OF BIRTH:</strong> 15/05/1988
                    </td>
                </tr>
            </table>
            
            <table>
                <tr>
                    <th colspan="2">ORDERING PHYSICIAN INFORMATION</th>
                </tr>
                <tr>
                    <td width="50%">
                        <strong>NAME:</strong> Dr. Smith<br>
                        <strong>SIGNATURE:</strong> <i class="fas fa-signature"></i>
                    </td>
                    <td>
                        <strong>REQUEST DATE:</strong> 15/11/2023
                    </td>
                </tr>
            </table>
            
            <div class="section-title">REQUEST:</div>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 15px;">
                <div class="checkbox-item">
                    <input type="checkbox" id="haemoglobin" checked disabled> <label for="haemoglobin">Haemoglobin</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="fbc" checked disabled> <label for="fbc">Full Blood Count & DIFF</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="blood-film" disabled> <label for="blood-film">Blood Film</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="blood-group" disabled> <label for="blood-group">Blood group</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="retics" disabled> <label for="retics">Retics</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="stickle" disabled> <label for="stickle">Stickle test</label>
                </div>
            </div>
            
            <div class="form-actions">
                <button class="btn btn-secondary" onclick="closeModal()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
    
    <!-- Results Entry Modal -->
    <div class="modal" id="resultsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Lab Results Form</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="lab-form">
                <div class="section-title">BAFROW</div>
                <div class="section-title">HAEMATOLOGY</div>
                
                <table>
                    <tr>
                        <th>EXAMINATION</th>
                        <th>RESULT</th>
                        <th>REFERANCE RANGE</th>
                    </tr>
                    <tr>
                        <td>Haemoglobin</td>
                        <td><input type="text"></td>
                        <td>Men 13 – 18 g/dl<br>Women 12.5 – 16.5 g/dl<br>Babies 13.5 – 19.5 g/dl</td>
                    </tr>
                    <tr>
                        <td>WBC Total</td>
                        <td><input type="text"> X 10^9/L</td>
                        <td>4 – 10 x 10^9/L</td>
                    </tr>
                    <tr>
                        <td>DIFF COUNT: Neutrophils</td>
                        <td><input type="text">%</td>
                        <td>50.0 – 70.0%</td>
                    </tr>
                    <tr>
                        <td>Lymphocytes</td>
                        <td><input type="text">%</td>
                        <td>20.0 – 40.0%</td>
                    </tr>
                    <tr>
                        <td>Monocytes</td>
                        <td><input type="text">%</td>
                        <td>3.0 – 14.0%</td>
                    </tr>
                    <tr>
                        <td>RBC</td>
                        <td><input type="text"></td>
                        <td>3.50 – 5.50 x 10^12/L</td>
                    </tr>
                    <tr>
                        <td>Platelets</td>
                        <td><input type="text"></td>
                        <td>100 – 300 x 10^9/L</td>
                    </tr>
                    <tr>
                        <td>ESR</td>
                        <td><input type="text"> mm/hr</td>
                        <td>1-7mm/hr</td>
                    </tr>
                </table>
                
                <div class="section-title">FOR LABORATORY USE ONLY</div>
                <table>
                    <tr>
                        <th>SPECIMEN RECEIVED BY</th>
                        <th>DATE</th>
                        <th>TIME</th>
                        <th>SAMPLE ACCEPTED YES/NO</th>
                    </tr>
                    <tr>
                        <td><input type="text"></td>
                        <td><input type="date"></td>
                        <td><input type="time"></td>
                        <td>
                            <select>
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                            </select>
                        </td>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th>LAB TECH SIGN & DATE</th>
                        <th>SUPERVISOR SIGN & DATE</th>
                    </tr>
                    <tr>
                        <td><input type="text" placeholder="Signature"> <input type="date"></td>
                        <td><input type="text" placeholder="Signature"> <input type="date"></td>
                    </tr>
                </table>
                
                <div class="form-actions">
                    <button class="btn btn-secondary" onclick="closeModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button class="btn btn-primary" onclick="submitResults()">
                        <i class="fas fa-paper-plane"></i> Send to Doctor
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/lab_tech.js"></script>
</body>
</html>