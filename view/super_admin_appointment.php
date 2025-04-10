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
                    <a href="super_admin_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_appointment.php">
                        <i class="fas fa-stethoscope"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="admin.php">
                        <i class="fas fa-users"></i>
                        <div class="title">Admins</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_staff.php">
                        <i class="fas fa-users"></i>
                        <div class="title">Staff</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_patient.php">
                        <i class="fas fa-user"></i>
                        <div class="title">Patients</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_department.php">
                        <i class="fas fa-puzzle-piece"></i>
                        <div class="title">Departments</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_clinic.php">
                        <i class="fas fa-briefcase-medical"></i>
                        <div class="title">Clinics</div>
                    </a>
                </li>
                <li>
                    <a href="super_admin_setting.php">
                        <i class="fas fa-briefcase-medical"></i>
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
            <div class="doctor-available">
                <div class="heading">
                    <h2>Patients</h2>
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
                        <tr>
                            <td>Lalia Jobe</td>
                            <td>Alfa Jarju</td>
                            <td>13/12/25</td>
                            <td>13:15</td>
                            <td>In-Person</td>
                            <td>Postnatal</td>
                            <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>Lalia Jobe</td>
                            <td>Alfa Jarju</td>
                            <td>13/12/25</td>
                            <td>13:15</td>
                            <td>In-Person</td>
                            <td>Postnatal</td>
                            <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>Lalia Jobe</td>
                            <td>Alfa Jarju</td>
                            <td>13/12/25</td>
                            <td>13:15</td>
                            <td>In-Person</td>
                            <td>Postnatal</td>
                            <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>Lalia Jobe</td>
                            <td>Alfa Jarju</td>
                            <td>13/12/25</td>
                            <td>13:15</td>
                            <td>In-Person</td>
                            <td>Postnatal</td>
                            <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>Lalia Jobe</td>
                            <td>Alfa Jarju</td>
                            <td>13/12/25</td>
                            <td>13:15</td>
                            <td>In-Person</td>
                            <td>Postnatal</td>
                            <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add Appointment Pop-up Form -->
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Appointment</h3>
            <form id="addItem">
                <input type="text" name="patientName" placeholder="Patient Name" required>
                <input type="text" name="doctorName" placeholder="Doctor Name" required>
                <input type="date" name="appointmentDate" placeholder="Date" required>
                <input type="time" name="appointmentTime" placeholder="Time" required>

                <label>Appointment Type:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="appointmentType" value="inPerson" required> In Person
                    </label>
                    <label>
                        <input type="radio" name="appointmentType" value="virtual" required> Virtual Consultation
                    </label>
                </div>

                <label for="clinicName">Clinic Name:</label>
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
                <input type="text" name="patientName" placeholder="Patient Name" required>
                <input type="text" name="doctorName" placeholder="Doctor Name" required>
                <input type="date" name="appointmentDate" placeholder="Date" required>
                <input type="time" name="appointmentTime" placeholder="Time" required>

                <label>Appointment Type:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="appointmentType" value="inPerson" required> In Person
                    </label>
                    <label>
                        <input type="radio" name="appointmentType" value="virtual" required> Virtual Consultation
                    </label>
                </div>

                <label for="clinicName">Clinic Name:</label>
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
        <script src="../js/appointment_add_edit.js"></script>

        <script>
            document.querySelectorAll('.status-dropdown').forEach(select => {
                function updateColor(dropdown) {
                    let color = {
                        "pending": "orange",
                        "confirmed": "blue",
                        "in-progress": "darkblue",
                        "completed": "green",
                        "cancelled": "red",
                        "no-show": "gray",
                        "rescheduled": "purple"
                    }[dropdown.value] || "black"; 
            
                    dropdown.style.color = color;
                }
            
                // Update color on page load
                updateColor(select);
            
                // Update color when the value changes
                select.addEventListener('change', function() {
                    updateColor(this);
                });
            });

        </script>
    
</body>
</html>