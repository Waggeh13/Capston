<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Technician Dashboard</title>
    <link rel="stylesheet" href="../css/lab_tech.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<?php
require_once('../settings/core.php');
redirect_if_not_logged_in();
?>
<body>
    <div class="dashboard">
        <div class="header">
            <input type="text" class="search-bar" id="searchBar" placeholder="Search patient name/ID...">
            <div><i class="fas fa-calendar-alt"></i> <span id="current-date"></span></div>
            <button class="logout-btn" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
        
        <h2>Pending Lab Requests</h2>
        <div class="request-cards" id="requestCards">
            <!-- Lab request cards will be populated dynamically -->
        </div>
    </div>
    
    <!-- Request View Modal -->
    <div class="modal" id="requestModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Lab Request Form</h2>
                <button class="close-btn" id="closeRequestModal">×</button>
            </div>
            <div class="lab-form">
                <div class="section-title">BAFROW</div>
                <div class="section-title">HAEMATOLOGY</div>
                
                <!-- Patient Demographics -->
                <table>
                    <tr>
                        <th colspan="2">PATIENT INFORMATION</th>
                    </tr>
                    <tr>
                        <td width="50%">
                            <strong>NAME:</strong> <span id="patientName"></span><br>
                            <strong>AGE:</strong> <span id="patientAge"></span><br>
                            <strong>SEX:</strong> <span id="patientGender"></span>
                        </td>
                        <td>
                            <strong>ID NUMBER:</strong> <span id="patientId"></span><br>
                            <strong>DATE OF BIRTH:</strong> <span id="patientDOB"></span>
                        </td>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th colspan="2">ORDERING PHYSICIAN INFORMATION</th>
                    </tr>
                    <tr>
                        <td width="50%">
                            <strong>NAME:</strong> <span id="doctorName"></span><br>
                            <strong>SIGNATURE:</strong> <span id="doctorSignature"></span>
                        </td>
                        <td>
                            <strong>REQUEST DATE:</strong> <span id="requestDate"></span>
                        </td>
                    </tr>
                </table>
                
                <div class="section-title">REQUEST:</div>
                <div id="testCheckboxes" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 15px;">
                    <!-- Test checkboxes will be populated dynamically -->
                </div>
                
                <div class="form-actions">
                    <button class="btn btn-secondary" id="closeRequestModalBtn">
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
                <button class="close-btn" id="closeResultsModal">×</button>
            </div>
            <form id="resultsForm" class="lab-form">
                <input type="hidden" id="labId" name="lab_id">
                <div class="section-title">BAFROW</div>
                <div class="section-title">HAEMATOLOGY</div>
                
                <table>
                    <thead>
                        <tr>
                            <th>EXAMINATION</th>
                            <th>RESULT</th>
                        </tr>
                    </thead>
                    <tbody id="dynamicTestResults">
                        <!-- Test result fields will be populated dynamically -->
                    </tbody>
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
                        <td><input type="text" name="specimen_received_by"></td>
                        <td><input type="date" name="specimen_date"></td>
                        <td><input type="time" name="specimen_time"></td>
                        <td>
                            <select name="sample_accepted">
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
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
                        <td><input type="text" name="lab_tech_signature" placeholder="Signature"> <input type="date" name="lab_tech_date"></td>
                        <td><input type="text" name="supervisor_signature" placeholder="Signature"> <input type="date" name="supervisor_date"></td>
                    </tr>
                </table>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelResultsModalBtn">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Send to Doctor
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/lab_tech.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>