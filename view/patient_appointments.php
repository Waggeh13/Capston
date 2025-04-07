<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Appointments</title>
    <link rel="stylesheet" href="../css/data.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/telemedicine.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/patient_appointment.css">
    <link rel="stylesheet" href="../css/sidebarx.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
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
                    <a href="patient_appointments.php" class="active">
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
                    <a href="patient_setting.php">
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

        <!-- Main Content Area -->
        <div class="main">
            <div class="top-bar">
                    <div class="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="search">
                        <input type="text" name="search" placeholder="search here">
                        <label for="search"><i class="fas fa-search"></i></label>
                    </div>
                    <i class="fas fa-bell"></i>
                    <div class="user">
                        <span class="profile-text">Profile</span>
                    </div>
                </div>
            
            <!-- Main Content -->
            <div class="main-content">
                <!-- Appointments Card -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">My Appointments</h2>
                        <button class="add-btn" onclick="openAppointmentModal()">
                            <i class="fas fa-plus"></i> New Appointment
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Clinic</th>
                                    <th>Doctor</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>May 15, 2023 - 10:00 AM</td>
                                    <td>Cardiology Center</td>
                                    <td>Dr. John Smith</td>
                                    <td>In-person</td>
                                    <td><span class="badge badge-confirmed">Confirmed</span></td>
                                    <td>
                                        <button class="action-btn edit-btn" onclick="editAppointment(1)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn cancel-btn" onclick="cancelAppointment(1)" title="Cancel">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>May 18, 2023 - 2:30 PM</td>
                                    <td>Dermatology Clinic</td>
                                    <td>Dr. Sarah Johnson</td>
                                    <td>Virtual</td>
                                    <td><span class="badge badge-pending">Pending</span></td>
                                    <td>
                                        <button class="action-btn edit-btn" onclick="editAppointment(2)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn cancel-btn" onclick="cancelAppointment(2)" title="Cancel">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>June 2, 2023 - 9:15 AM</td>
                                    <td>General Medicine</td>
                                    <td>Dr. Michael Brown</td>
                                    <td>In-person</td>
                                    <td><span class="badge badge-cancelled">Cancelled</span></td>
                                    <td>
                                        <button class="action-btn edit-btn" disabled title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn cancel-btn" disabled title="Cancel">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Appointment Modal -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">New Appointment</h2>
            
            <form id="appointmentForm">
                <input type="hidden" id="appointmentId">
                
                <div class="form-group">
                    <label for="patientName">Patient Name</label>
                    <input type="text" id="patientName" placeholder="Enter patient name" required>
                </div>
                
                <div class="form-group">
                    <label for="clinic">Clinic</label>
                    <select id="clinic" required onchange="updateDoctors()">
                        <option value="">Select a clinic</option>
                        <option value="cardiology">Cardiology Center</option>
                        <option value="dermatology">Dermatology Clinic</option>
                        <option value="general">General Medicine</option>
                        <option value="pediatrics">Pediatrics</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="doctor">Doctor</label>
                    <select id="doctor" required>
                        <option value="">Select a doctor</option>
                        <!-- Doctors will be populated based on clinic selection -->
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="appointmentDate">Date</label>
                    <input type="date" id="appointmentDate" required>
                </div>
                
                <div class="form-group">
                    <label for="appointmentTime">Time</label>
                    <input type="time" id="appointmentTime" required>
                </div>
                
                <div class="form-group">
                    <label for="appointmentType">Appointment Type</label>
                    <select id="appointmentType" required>
                        <option value="">Select type</option>
                        <option value="in-person">In-person</option>
                        <option value="virtual">Virtual Consultation</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" rows="3" placeholder="Any additional information"></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeAppointmentModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Appointment</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <h3>Confirm Cancellation</h3>
            <p>Are you sure you want to cancel this appointment?</p>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeConfirmModal()">No, Keep It</button>
                <button type="button" class="btn btn-primary" id="confirmCancelBtn">Yes, Cancel</button>
            </div>
        </div>
    </div>

    <script src="../js/patient_appointment.js"></script>
</body>
</html>