<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Technician Dashboard</title>
    <link rel="stylesheet" href="../css/lab_tech.css">
    <link rel="stylesheet" href="../css/pharmacist_header.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<?php
<<<<<<< HEAD
require_once('../settings/core.php');
redirect_if_not_logged_in();
=======
session_start();
require_once('../classes/userName_class.php');

// Get patient_id from session
$user_id = $_SESSION['user_id'] ?? null;
$userProfile = new userName_class();
>>>>>>> 03f4374976c4d18a5ef5e277e8226eb59c9e625e
?>
<body>
    <div class="dashboard">
    <div class="header">
            <div class="header-left">
                <div class="username-section">
                    <i class="fas fa-user-circle"></i>
                    <span id="username"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>
            <div class="header-right">
                <div class="header-date">
                    <i class="fas fa-calendar-alt"></i> 
                    <span id="real-time-date"></span>
                </div>
                <button class="settings-btn" id="settingsBtn" title="Settings">
                    <i class="fas fa-cog"></i>
                </button>
                <a href="../actions/logoutactions.php" class="logout-btn" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <h2>Pending Lab Requests</h2>
        <div class="request-cards" id="requestCards">
            <!-- Lab request cards will be populated dynamically -->
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
<<<<<<< HEAD
    <script src="../js/dark_mode.js"></script>
=======
    <script src="../js/real_time_date.js"></script>
>>>>>>> 03f4374976c4d18a5ef5e277e8226eb59c9e625e
</body>
</html>