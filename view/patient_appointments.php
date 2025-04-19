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
require_once('../controllers/clinic_controller.php');
require_once('../controllers/doc_schedule_controller.php');
require_once('../classes/userName_class.php');

require_once('../settings/core.php');
redirect_patient_if_not_logged_in();

$userProfile = new userName_class();
?>
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
                    <a href="patient_message.php">
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
                    <a href="../actions/logoutactions.php">
                        <i class="fas fa-right-from-bracket"></i>
                        <div class="title">Logout</div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="main">
            <div class="top-bar">
                <i class="fas fa-bell"></i>
                <div class="user">
                    <span class="profile-text"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="main-content">
                <!-- Appointments Card -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">My Appointments</h2>
                        <button class="add-btn" id="addAppointmentBtn">
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
                            <tbody id="appointmentsBody">
                                <!-- Dynamic data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Appointment Modal -->
    <div id="addAppointmentModal" class="modal">
        <div class="modal-content">
            <h2>Add Appointment</h2>
            <form id="addAppointmentForm">
                <div class="form-group">
                    <label for="addDoctorName">Doctor Name</label>
                    <select id="addDoctorName" name="staff_id" required>
                        <option value="">Select a doctor</option>
                        <?php
                        $doctors = get_doctors_with_schedules_ctr();
                        if (!empty($doctors)) {
                            foreach ($doctors as $doctor) {
                                echo "<option value='{$doctor['staff_id']}'>{$doctor['first_name']} {$doctor['last_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="addAppointmentDate">Appointment Date</label>
                    <select id="addAppointmentDate" name="appointmentDate" required>
                        <option value="">Select a date</option>
                        <!-- Populated dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="addAppointmentTime">Appointment Time</label>
                    <select id="addAppointmentTime" name="appointmentTime" required>
                        <option value="">Select a time</option>
                        <!-- Populated dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="addAppointmentType">Appointment Type</label>
                    <select id="addAppointmentType" name="appointmentType" required>
                        <option value="">Select type</option>
                        <option value="inPerson">In-person</option>
                        <option value="virtual">Virtual</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="addClinic">Clinic Name</label>
                    <select id="addClinic" name="clinic_id" required>
                        <option value="">Select a clinic</option>
                        <?php
                        $clinics = viewclinicsController();
                        if (!empty($clinics)) {
                            foreach ($clinics as $clinic) {
                                echo "<option value='{$clinic['clinic_id']}'>{$clinic['clinic_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="addAppointmentCancelBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Appointment</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Appointment Modal -->
    <div id="editAppointmentModal" class="modal">
        <div class="modal-content">
            <h2>Edit Appointment</h2>
            <form id="editAppointmentForm">
                <input type="hidden" id="editBookingId" name="booking_id">
                <div class="form-group">
                    <label for="editDoctorName">Doctor Name</label>
                    <select id="editDoctorName" name="staff_id" required>
                        <option value="">Select a doctor</option>
                        <?php
                        $doctors = get_doctors_with_schedules_ctr();
                        if (!empty($doctors)) {
                            foreach ($doctors as $doctor) {
                                echo "<option value='{$doctor['staff_id']}'>{$doctor['first_name']} {$doctor['last_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editAppointmentDate">Appointment Date</label>
                    <select id="editAppointmentDate" name="appointmentDate" required>
                        <option value="">Select a date</option>
                        <!-- Populated dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="editAppointmentTime">Appointment Time</label>
                    <select id="editAppointmentTime" name="appointmentTime" required>
                        <option value="">Select a time</option>
                        <!-- Populated dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="editAppointmentType">Appointment Type</label>
                    <select id="editAppointmentType" name="appointmentType" required>
                        <option value="">Select type</option>
                        <option value="inPerson">In-person</option>
                        <option value="virtual">Virtual</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editClinic">Clinic Name</label>
                    <select id="editClinic" name="clinic_id" required>
                        <option value="">Select a clinic</option>
                        <?php
                        $clinics = viewclinicsController();
                        if (!empty($clinics)) {
                            foreach ($clinics as $clinic) {
                                echo "<option value='{$clinic['clinic_id']}'>{$clinic['clinic_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="editAppointmentCancelBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Appointment</button>
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
                <button type="button" class="btn btn-secondary" id="confirmCancelNoBtn">No, Keep It</button>
                <button type="button" class="btn btn-primary" id="confirmCancelBtn">Yes, Cancel</button>
            </div>
        </div>
    </div>

    <script src="../js/patient_appointment.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>