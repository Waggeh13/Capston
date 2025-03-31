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
        <div class="form-section">
            <h4>Patient Information</h4>
            <div class="form-group">
                <label for="patientId">Patient ID:</label>
                <input type="text" id="patientId" name="patientId" placeholder="Enter patient ID" required>
            </div>
            <div class="name-fields">
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Enter first name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Enter last name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" placeholder="Enter weight in kg" step="0.1" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter full address" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact Number:</label>
                <input type="tel" id="contact" name="contact" placeholder="Enter phone number" required>
            </div>
        </div>

        <!-- Next of Kin Details -->
        <div class="form-section">
            <h4>Next of Kin Information</h4>
            <div class="form-group">
                <label for="nextOfKin">Full Name:</label>
                <input type="text" id="nextOfKin" name="nextOfKin" placeholder="Enter next of kin name" required>
            </div>
            <div class="form-group">
                <label for="nextOfKinContact">Contact Number:</label>
                <input type="tel" id="nextOfKinContact" name="nextOfKinContact" placeholder="Enter phone number" required>
            </div>
            <div class="form-group">
                <label for="nextOfKinGender">Gender:</label>
                <select id="nextOfKinGender" name="nextOfKinGender" required>
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nextOfKinRelationship">Relationship:</label>
                <input type="text" id="nextOfKinRelationship" name="nextOfKinRelationship" placeholder="Enter relationship" required>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit">Add Patient</button>
            <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
        </div>
    </form>
</div>

    <!-- Edit Patient Pop-up Form -->
    <div class="popup-form" id="editItemForm">
        <h3>Edit Patient</h3>
        <form id="editItem">
            <!-- Patient Details -->
            <div class="form-section">
                <h4>Patient Information</h4>
                <input type="hidden" id="editPatientId" name="patientId">
                <div class="name-fields">
                    <div class="form-group">
                        <label for="editFirstName">First Name:</label>
                        <input type="text" id="editFirstName" name="firstName" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label for="editLastName">Last Name:</label>
                        <input type="text" id="editLastName" name="lastName" placeholder="Enter last name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editDob">Date of Birth:</label>
                    <input type="date" id="editDob" name="dob" required>
                </div>
                <div class="form-group">
                    <label for="editWeight">Weight (kg):</label>
                    <input type="number" id="editWeight" name="weight" placeholder="Enter weight in kg" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="editAddress">Address:</label>
                    <input type="text" id="editAddress" name="address" placeholder="Enter full address" required>
                </div>
                <div class="form-group">
                    <label for="editContact">Contact Number:</label>
                    <input type="tel" id="editContact" name="contact" placeholder="Enter phone number" required>
                </div>
            </div>

            <!-- Next of Kin Details -->
            <div class="form-section">
                <h4>Next of Kin Information</h4>
                <div class="form-group">
                    <label for="editNextOfKin">Full Name:</label>
                    <input type="text" id="editNextOfKin" name="nextOfKin" placeholder="Enter next of kin name" required>
                </div>
                <div class="form-group">
                    <label for="editNextOfKinContact">Contact Number:</label>
                    <input type="tel" id="editNextOfKinContact" name="nextOfKinContact" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label for="editNextOfKinGender">Gender:</label>
                    <select id="editNextOfKinGender" name="nextOfKinGender" required>
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editNextOfKinRelationship">Relationship:</label>
                    <input type="text" id="editNextOfKinRelationship" name="nextOfKinRelationship" placeholder="Enter relationship" required>
                </div>
            </div>

            <div class="form-buttons">
                <button type="submit">Update Patient</button>
                <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
            </div>
        </form>
    </div>

    <script src="../js/add_edit.js"></script>
</body>
</html>