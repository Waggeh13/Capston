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
    <title>Staff</title>
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
                    <h2>Admins</h2>
                    <a href="#" class="btn" id="addItemBtn">Add Admin</a>
                </div>
                <table class="available">
                    <thead>
                        <td>Admin ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Contact</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                        <tr>
                            <td>B789Y012</td>
                            <td>Saloom</td>
                            <td>Singhateh</td>
                            <td>3678945</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt editItemBtn"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>B789Y012</td>
                            <td>Saloom</td>
                            <td>Singhateh</td>
                            <td>3678945</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>B789Y012</td>
                            <td>Saloom</td>
                            <td>Singhateh</td>
                            <td>3678945</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>B789Y012</td>
                            <td>Saloom</td>
                            <td>Singhateh</td>
                            <td>3678945</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>B789Y012</td>
                            <td>Saloom</td>
                            <td>Singhateh</td>
                            <td>3678945</td>
                            <td>
                                <i class="far fa-edit editItemBtn"></i>
                                <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>    
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add Clinic Admin Pop-up Form -->
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Clinic Admin</h3>
            <form id="addItem">
                <div class="form-group">
                    <label for="adminId">Admin ID:</label>
                    <input type="text" id="adminId" name="adminId" placeholder="Enter admin ID" required>
                </div>

                <div class="form-group">
                    <label>Full Name:</label>
                    <div class="name-fields">
                        <input type="text" id="firstName" name="firstName" placeholder="First name" required>
                        <input type="text" id="lastName" name="lastName" placeholder="Last name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="tel" id="contact" name="contact" placeholder="Enter phone number" required>
                </div>

                <div class="form-group">
                    <label for="password">Default Password:</label>
                    <input type="text" id="password" name="password" 
                        placeholder="Set default password" minlength="6" required>
                </div>

                <div class="form-buttons">
                    <button type="submit">Add Admin</button>
                    <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Edit Clinic Admin Pop-up Form -->
        <div class="popup-form" id="editItemForm">
            <h3>Edit Clinic Admin</h3>
            <form id="editItem">
                <input type="hidden" id="editAdminId" name="adminId">

                <div class="form-group">
                    <label>Full Name:</label>
                    <div class="name-fields">
                        <input type="text" id="editFirstName" name="firstName" placeholder="First name" required>
                        <input type="text" id="editLastName" name="lastName" placeholder="Last name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="editContact">Contact Number:</label>
                    <input type="tel" id="editContact" name="contact" placeholder="Enter phone number" required>
                </div>

                <input type="hidden" id="editPassword" name="password">

                <div class="form-buttons">
                    <button type="submit">Update Admin</button>
                    <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/add_edit.js"></script> 
    
</body>
</html>