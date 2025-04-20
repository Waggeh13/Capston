<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_adminDoctor.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/edit_add.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Appointments</title>
</head>
<?php
require_once('../controllers/clinic_controller.php');
require_once('../controllers/doc_schedule_controller.php');
require_once('../classes/userName_class.php');
require_once('../settings/core.php');
redirect_admin_if_not_logged_in();

$userProfile = new userName_class();
?>
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
    margin-top: 22px;
    }
    .fas.fa-bell {
        margin-left: 1180px;
    }
    .profile-text{
    color: black;
    font-size: 20px;
    }
</style>
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
                    <a href="admin_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="admin_appointment.php">
                        <i class="fas fa-stethoscope"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="admin_staff.php">
                        <i class="fas fa-users"></i>
                        <div class="title">Staff</div>
                    </a>
                </li>
                <li>
                    <a href="admin_patient.php">
                        <i class="fas fa-user"></i>
                        <div class="title">Patients</div>
                    </a>
                </li>
                <li>
                    <a href="admin_department.php">
                        <i class="fas fa-puzzle-piece"></i>
                        <div class="title">Departments</div>
                    </a>
                </li>
                <li>
                    <a href="admin_clinic.php">
                        <i class="fas fa-briefcase-medical"></i>
                        <div class="title">Clinics</div>
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
                    <span id="username"><?php echo $userProfile->getUserName(); ?></span>
                </div>
            </div>
            <div class="doctor-available">
                <div class="heading">
                    <h2>Appointments</h2>
                    <a href="#" class="btn" id="addItemBtn">Add Appointment</a>
                </div>
                <table class="available">
                    <thead>
                        <td>Patient Name</td>
                        <td>Doctor Name</td>
                        <td>Date</td>
                        <td>Time</td>
                        <td>Appointment Type</td>
                        <td>Clinic Name</td>
                        <td>Status</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                        <!-- Dynamic data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add Appointment Pop-up Form -->
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Appointment</h3>
            <form id="addItem">
                <label for="patientName">Patient Name:</label>
                <input type="text" id="patientName" name="patientName" placeholder="Full Name" required>
                
                <label for="doctorName">Doctor Name:</label>
                <select id="doctorName" name="staff_id" required>
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

                <label for="appointmentDate">Appointment Date:</label>
                <select id="appointmentDate" name="appointmentDate" required>
                    <option value="">Select a date</option>
                    <!-- Dates will be populated dynamically -->
                </select>

                <label for="appointmentTime">Appointment Time:</label>
                <select id="appointmentTime" name="appointmentTime" required>
                    <option value="">Select a time</option>
                    <!-- Times will be populated dynamically -->
                </select>

                <input type="hidden" name="appointmentType" value="inPerson">

                <label for="clinic">Clinic Name:</label>
                <select id="clinic" name="clinic_id" required>
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

                <button type="submit">Add</button>
                <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
            </form>
        </div>

        <!-- Edit Appointment Pop-up Form -->
        <div class="popup-form" id="editItemForm">
            <h3>Edit Appointment</h3>
            <form id="editItem">
                <input type="hidden" id="editBookingId" name="booking_id">
                <label for="editpatientName">Patient Name:</label>
                <input type="text" id="editpatientName" name="patientName" placeholder="Full Name" required>
                
                <label for="editdoctorName">Doctor Name:</label>
                <select id="editdoctorName" name="staff_id" required>
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

                <label for="editappointmentDate">Appointment Date:</label>
                <select id="editappointmentDate" name="appointmentDate" required>
                    <option value="">Select a date</option>
                    <!-- Dates will be populated dynamically -->
                </select>

                <label for="editappointmentTime">Appointment Time:</label>
                <select id="editappointmentTime" name="appointmentTime" required>
                    <option value="">Select a time</option>
                    <!-- Times will be populated dynamically -->
                </select>

                <input type="hidden" name="appointmentType" value="inPerson">

                <label for="editclinic">Clinic Name:</label>
                <select id="editclinic" name="clinic_id" required>
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

                <button type="submit">Update</button>
                <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
            </form>
        </div>
    </div>
    <script src="../js/appointment_add_edit.js"></script>
    <script>
        document.querySelectorAll('.status-dropdown').forEach(select => {
            function updateColor(dropdown) {
                let color = {
                    "Scheduled": "blue",
                    "Completed": "green",
                    "Cancelled": "red"
                }[dropdown.value] || "black";
                dropdown.style.color = color;
            }
            updateColor(select);
            select.addEventListener('change', function() {
                updateColor(this);
            });
        });
    </script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>