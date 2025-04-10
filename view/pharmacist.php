<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist Dashboard</title>
    <link rel="stylesheet" href="../css/pharmacist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>
    <div class="dashboard">
        <div class="header">
            <input type="text" class="search-bar" placeholder="Search patient name/ID...">
            <div><i class="fas fa-calendar-alt"></i> Tuesday, May 14</div>
        </div>
        
        <!-- View Prescription Mode -->
        <div class="view-mode" id="viewMode">
            <h2><i class="fas fa-prescription-bottle-alt"></i> Prescriptions to Fill</h2>
            
            <!-- First Prescription Card -->
            <div class="prescription-card">
                <div class="patient-info">
                    <div class="patient-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>John Doe</strong><br>
                        ID: PT-1024 | Dr. Smith
                    </div>
                </div>
                <div class="medication-list">
                    <div class="med-item">
                        <div class="medication-name">Amoxicillin 500mg</div>
                        <div class="instructions">Take 1 tablet every 8 hours for 7 days</div>
                    </div>
                    <div class="med-item">
                        <div class="medication-name">Ibuprofen 200mg</div>
                        <div class="instructions">Take as needed for pain (max 3/day)</div>
                    </div>
                </div>
                <div class="action-btns">
                    <button class="btn btn-secondary" onclick="toggleMode()">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </button>
                    <button class="btn btn-primary" onclick="startDispensing('JD')">
                        <i class="fas fa-pills"></i> Fill Prescription
                    </button>
                </div>
            </div>
            
            <!-- Second Prescription Card -->
            <div class="prescription-card">
                <div class="patient-info">
                    <div class="patient-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>Mary Smith</strong><br>
                        ID: PT-2048 | Dr. Johnson
                    </div>
                </div>
                <div class="medication-list">
                    <div class="med-item">
                        <div class="medication-name">Lisinopril 10mg</div>
                        <div class="instructions">Take 1 tablet daily in the morning</div>
                    </div>
                    <div class="med-item">
                        <div class="medication-name">Metformin 500mg</div>
                        <div class="instructions">Take 1 tablet twice daily with meals</div>
                    </div>
                    <div class="med-item">
                        <div class="medication-name">Atorvastatin 20mg</div>
                        <div class="instructions">Take 1 tablet at bedtime</div>
                    </div>
                </div>
                <div class="action-btns">
                    <button class="btn btn-secondary" onclick="toggleMode()">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </button>
                    <button class="btn btn-primary" onclick="startDispensing('MS')">
                        <i class="fas fa-pills"></i> Fill Prescription
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Dispensing Form Mode -->
        <div class="dispense-mode hidden" id="dispenseMode">
            <h2><i class="fas fa-pills"></i> Dispense Medication</h2>
            <div class="patient-info" id="dispensePatientInfo">
                <!-- Patient info will be inserted here by JavaScript -->
            </div>
            
            <form class="dispense-form" id="dispenseForm">
                <table id="dispenseTable">
                    <thead>
                        <tr>
                            <th>Medication</th>
                            <th>Quantity to Dispense</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Medication rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
                
                <div class="action-btns">
                    <button type="button" class="btn btn-secondary" onclick="toggleMode()">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-cash-register"></i> Send to Cashier
                    </button>
                </div>
            </form>
        </div>
        
        <div class="footer">
            <button class="btn btn-secondary">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>

    <script src="../js/pharmacist.js"></script>
</body>
</html>