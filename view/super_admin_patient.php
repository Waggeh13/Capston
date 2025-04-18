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
    <title>Patients</title>
</head>
<?php
require('../controllers/patient_controller.php');
require_once('../settings/core.php');
redirect_superadmin_if_not_logged_in();
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
                    <a href="../actions/logoutactions.php">
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
                    <a href="#" class="btn" id="addItemBtn">Add Patient</a>
                </div>
                <table class="available">
                    <thead>
                        <td>Patient ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Gender</td>
                        <td>DOB</td>
                        <td>Weight</td>
                        <td>Address</td>
                        <td>Contact</td>
                        <td>Action</td>
                    </thead>
                        <tbody>
                            <?php
                            $patients = viewPatientsController();
                            if (!empty($patients)) {
                                foreach ($patients as $patient) {
                                    echo "<tr>";
                                    echo "<td>{$patient['patient_id']}</td>";
                                    echo "<td>{$patient['first_name']}</td>";
                                    echo "<td>{$patient['last_name']}</td>";
                                    echo "<td>{$patient['DOB']}</td>";
                                    echo "<td>{$patient['Gender']}</td>";
                                    echo "<td>{$patient['weight']}</td>";
                                    echo "<td>{$patient['address']}</td>";
                                    echo "<td>{$patient['contact']}</td>";
                                    echo "<td>
                                        <i data-patient-id='{$patient['patient_id']}' class='far fa-trash-alt deleteItemBtn'></i>
                                        <i data-patient-id='{$patient['patient_id']}' class='far fa-edit editItemBtn'></i>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No patients</td></tr>";
                            }
                            ?>
                        </tbody>
                </table>
            </div>
        </div>
        <!-- Add Patient Pop-up Form -->
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Patient</h3>
            <form id="addItem">
                <!-- Patient Details -->
                <input type="text" id="patientId" name="patientId" placeholder="Patient ID" required>
                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                <input type="date" id="dob" name="dob" placeholder="Date of Birth" required>
                <input type="number" id="weight" name="weight" placeholder="Weight (kg)" required>
                <input type="text" id="address" name="address" placeholder="Address" required>
                <input type="tel" id="contact" name="contact" placeholder="Contact Number" required>
                <!-- Gender Field (missing in original form) -->
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                
                <!-- Next of Kin Details -->
                <input type="text" id="nextOfKin" name="nextOfKin" placeholder="Next of Kin" required>
                <input type="tel" id="nextOfKinContact" name="nextOfKinContact" placeholder="Next of Kin Contact" required>
                <select id="nextOfKinGender" name="nextOfKinGender" required>
                    <option value="">Select Kin's Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" id="nextOfKinRelationship" name="nextOfKinRelationship" placeholder="Relationship to Kin" required>
                <!-- Hidden password field -->
                <input type="hidden" id="default-password" name="default-password" value="Bafrrow@2025">
                <!-- Form buttons -->
                <button type="submit">Add</button>
                <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
            </form>
        </div>
        
        <!-- Edit Patient Pop-up Form -->
        <div class="popup-form" id="editItemForm">
            <h3>Edit Patient</h3>
            <form id="editItem">
                <!-- Patient Details -->
                <input type="hidden" id="editPatientId" name="patient_id" required>
                <input type="text" id="editFirstName" name="first_name" placeholder="First Name" required>
                <input type="text" id="editLastName" name="last_name" placeholder="Last Name" required>
                <input type="date" id="editDob" name="DOB" placeholder="Date of Birth" required>
                <input type="number" id="editWeight" name="weight" placeholder="Weight (kg)" required>
                <input type="text" id="editAddress" name="address" placeholder="Address" required>
                <input type="tel" id="editContact" name="contact" placeholder="Contact Number" required>
                <select id="editGender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <!-- Next of Kin Details -->
                <input type="text" id="editNextOfKin" name="nextofkinname" placeholder="Next of Kin" required>
                <input type="tel" id="editNextOfKinContact" name="nextofkincontact" placeholder="Next of Kin Contact" required>
                <select id="editNextOfKinGender" name="nextofkingender" required>
                    <option value="">Select Kin's Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" id="editNextOfKinRelationship" name="nextofkinrelationship" placeholder="Relationship to Kin" required>
                
                <button type="submit">Update</button>
                <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
            </form>
        </div>
    
        <script src="../js/patient_add_edit.js"></script>
        <script src="../js/dark_mode.js"></script>
    </body>
</html>