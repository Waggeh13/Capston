<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/patient_prescription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Prescription</title>
</head>
<style>
    .sidebar ul li a {
    width: 100%;
    text-decoration: none;
    color: #fff;
    height: 70px;
    display: flex;
    align-items: center;
    }
    .user {
    display: inline-block;
    white-space: nowrap;
    margin-left: 10px; /* Reduced from 65px to 10px */
    }
    .fas.fa-bell {
        margin-left: 1180px;
    }
</style>
<?php
session_start();
require_once('../classes/userName_class.php');

// Get patient_id from session
$patient_id = $_SESSION['user_id'] ?? null;
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
                    <a href="patient_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="patient_appointments.php">
                        <i class="fas fa-calendar-check"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="patient_prescriptions.php">
                        <i class="fas fa-prescription-bottle-alt"></i>
                        <div class="title">Prescriptions</div>
                    </a>
                </li>
                <li>
                    <a href="patient_telemedicine.php">
                        <i class="fas fa-video"></i>
                        <div class="title">Virtual consultation</div>
                    </a>
                </li>
                <li>
                    <a href="patient_messages.php">
                        <i class="fas fa-envelope"></i>
                        <div class="title">Messages</div>
                    </a>
                </li>
                <li>
                    <a href="admin_setting.php">
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
            
            <div class="prescription-container">
                <div class="prescription-header">
                    <h2><i class="fas fa-prescription-bottle-alt"></i> My Prescription</h2>
                    <div class="prescription-meta">
                        <div class="meta-item">
                            <span class="meta-label">Date:</span>
                            <span class="meta-value">October 25, 2023</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Prescribed by:</span>
                            <span class="meta-value">Dr. Sarah Johnson</span>
                        </div>
                    </div>
                </div>

                <div class="medication-list">
                    <!-- Medication 1 -->
                    <div class="medication-card">
                        <div class="medication-header">
                            <h3>Amoxicillin</h3>
                            <span class="medication-status active">Active</span>
                        </div>
                        <div class="medication-details">
                            <div class="detail-row">
                                <span class="detail-label">Dosage:</span>
                                <span class="detail-value">500mg</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Schedule:</span>
                                <span class="detail-value">
                                    <span class="dosage-time">8:00 AM</span>
                                    <span class="dosage-time">2:00 PM</span>
                                    <span class="dosage-time">8:00 PM</span>
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Duration:</span>
                                <span class="detail-value">7 days (until Nov 1, 2023)</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Instructions:</span>
                                <span class="detail-value">Take with food. Complete entire course.</span>
                            </div>
                        </div>
                        <div class="alert-section">
                            <div class="alert-toggle">
                                <input type="checkbox" id="alert-amoxicillin" checked>
                                <label for="alert-amoxicillin">Enable medication reminders</label>
                            </div>
                            <div class="next-dose">
                                <i class="fas fa-bell"></i>
                                Next dose: <strong>Today at 2:00 PM</strong>
                            </div>
                        </div>
                    </div>

                <!-- Medication 2 -->
                <div class="medication-card">
                    <div class="medication-header">
                        <h3>Ibuprofen</h3>
                        <span class="medication-status as-needed">As Needed</span>
                    </div>
                    <div class="medication-details">
                        <div class="detail-row">
                            <span class="detail-label">Dosage:</span>
                            <span class="detail-value">200mg</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Frequency:</span>
                            <span class="detail-value">Every 6 hours as needed</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">Until pain subsides</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Instructions:</span>
                            <span class="detail-value">Do not exceed 4 doses in 24 hours</span>
                        </div>
                    </div>
                    <div class="alert-section">
                        <div class="alert-toggle">
                            <input type="checkbox" id="alert-ibuprofen">
                            <label for="alert-ibuprofen">Enable pain medication reminders</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script>
    // This would be connected to your actual reminder system
    document.addEventListener('DOMContentLoaded', function() {
        // Set up medication reminders
        const reminderCheckboxes = document.querySelectorAll('.alert-toggle input');
        
        reminderCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const medicationName = this.id.replace('alert-', '');
                if(this.checked) {
                    console.log(`Reminders enabled for ${medicationName}`);
                    // Actual implementation would connect to notification API
                } else {
                    console.log(`Reminders disabled for ${medicationName}`);
                }
            });
        });
        
        // This would be dynamic based on actual schedule
        function updateNextDoseDisplay() {
            // In a real implementation, this would calculate next dose time
            const now = new Date();
            const hours = now.getHours();
            let nextDoseTime = "2:00 PM"; // This would be calculated
            
            document.querySelector('.next-dose strong').textContent = `Today at ${nextDoseTime}`;
        }
        
        updateNextDoseDisplay();
    });
</script>