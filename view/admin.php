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
        <!-- Add Item Pop-up Form -->
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Clinic</h3>
            <form id="addItem">
                <input type="text" id="itemName" placeholder="Admin ID" required>
                <input type="text" id="itemDescription" placeholder="First name" required>
                <input type="text" id="itemDescription" placeholder="Last name" required>
                <input type="text" id="itemDescription" placeholder="Contact" required>
                <button type="submit">Add</button>
                <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
            </form>
        </div>

        <!-- Edit Item Pop-up Form -->
        <div class="popup-form" id="editItemForm">
            <h3>Edit Clinic</h3>
            <form id="editItem">
                <input type="hidden" id="editItemName" placeholder="Admin ID" required>
                <input type="text" id="editItemName" placeholder="First Name" required>
                <input type="text" id="editItemName" placeholder="Last Name" required>
                <input type="text" id="editItemName" placeholder="Contact" required>
                <button type="submit">Update</button>
                <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
            </form>
        </div>
        <script src="../js/add_edit.js"></script> 
    
</body>
</html>