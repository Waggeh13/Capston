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
                        <td>DOB</td>
                        <td>weight</td>
                        <td>address</td>
                        <td>contact</td>
                        <td>Next of Kin</td>
                        <td>contact of next of Kin</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                        <tr>
                            <td>45901939559</td>
                            <td>Lamin</td>
                            <td>Sanneh</td>
                            <td>12/4/12</td>
                            <td>55kg</td>
                            <td>Pipeline</td>
                            <td>5679485</td>
                            <td>Mama Sanneh</td>
                            <td>2385749</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>45901939559</td>
                            <td>Lamin</td>
                            <td>Sanneh</td>
                            <td>12/4/12</td>
                            <td>55kg</td>
                            <td>Pipeline</td>
                            <td>5679485</td>
                            <td>Mama Sanneh</td>
                            <td>2385749</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>45901939559</td>
                            <td>Lamin</td>
                            <td>Sanneh</td>
                            <td>12/4/12</td>
                            <td>55kg</td>
                            <td>Pipeline</td>
                            <td>5679485</td>
                            <td>Mama Sanneh</td>
                            <td>2385749</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>45901939559</td>
                            <td>Lamin</td>
                            <td>Sanneh</td>
                            <td>12/4/12</td>
                            <td>55kg</td>
                            <td>Pipeline</td>
                            <td>5679485</td>
                            <td>Mama Sanneh</td>
                            <td>2385749</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>45901939559</td>
                            <td>Lamin</td>
                            <td>Sanneh</td>
                            <td>12/4/12</td>
                            <td>55kg</td>
                            <td>Pipeline</td>
                            <td>5679485</td>
                            <td>Mama Sanneh</td>
                            <td>2385749</td>
                            <td>
                                <i class="far fa-edit"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                       
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
            <input type="text" id="patientId" placeholder="Patient ID" required>
            <input type="text" id="firstName" placeholder="First Name" required>
            <input type="text" id="lastName" placeholder="Last Name" required>
            <input type="date" id="dob" placeholder="Date of Birth" required>
            <input type="number" id="weight" placeholder="Weight (kg)" required>
            <input type="text" id="address" placeholder="Address" required>
            <input type="tel" id="contact" placeholder="Contact Number" required>

            <!-- Next of Kin Details -->
            <input type="text" id="nextOfKin" placeholder="Next of Kin" required>
            <input type="tel" id="nextOfKinContact" placeholder="Next of Kin Contact" required>
            <input type="text" id="nextOfKinGender" placeholder="Gender of Next of Kin" required>
            <input type="text" id="nextOfKinRelationship" placeholder="Relationship to Kin" required>

            <button type="submit">Add</button>
            <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
        </form>
    </div>

    <!-- Edit Patient Pop-up Form -->
    <div class="popup-form" id="editItemForm">
        <h3>Edit Patient</h3>
        <form id="editItem">
            <!-- Patient Details -->
            <input type="hidden" id="editPatientId" name="patient_id"  placeholder="Patient ID" required>
            <input type="text" id="editFirstName" placeholder="First Name" required>
            <input type="text" id="editLastName"  placeholder="Last Name" required>
            <input type="date" id="editDob" placeholder="Date of Birth" required>
            <input type="number" id="editWeight" placeholder="Weight (kg)" required>
            <input type="text" id="editAddress"  placeholder="Address" required>
            <input type="tel" id="editContact"  placeholder="Contact Number" required>

            <!-- Next of Kin Details -->
            <input type="text" id="editNextOfKin"  placeholder="Next of Kin" required>
            <input type="tel" id="editNextOfKinContact"  placeholder="Next of Kin Contact" required>
            <input type="text" id="editNextOfKinGender"  placeholder="Gender of Next of Kin" required>
            <input type="text" id="editNextOfKinRelationship"  placeholder="Relationship to Kin" required>

            <button type="submit">Update</button>
            <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
        </form>
    </div>

    <script src="../js/add_edit.js"></script>
</body>
</html>