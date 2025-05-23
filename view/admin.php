<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../images/bafrow_logo.png" type="image/png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_adminDoctor.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/edit_add.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Admins</title>
</head>
<?php
require_once('../controllers/admin_controller.php');
require_once('../settings/core.php');
redirect_superadmin_if_not_logged_in();
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
            position: absolute;
            right: 150px;
            overflow: visible;
        }
    .profile-text {
        color: black;
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
                    <a href="../actions/logoutactions.php">
                        <i class="fas fa-right-from-bracket"></i>
                        <div class="title">Logout</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="top-bar">
                <div class="user">
                    <span class="profile-text">Fatou Waggeh</span>
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
                    <?php
                        $admins = viewadminsController();
                        if (!empty($admins)) {
                            foreach ($admins as $admin) {
                                echo "<tr>";
                                echo "<td>{$admin['admin_id']}</td>";
                                echo "<td>{$admin['first_name']}</td>";
                                echo "<td>{$admin['last_name']}</td>";
                                echo "<td>{$admin['contact']}</td>";
                                echo "<td>
                                    <i data-admin-id='{$admin['admin_id']}' class='far fa-trash-alt deleteItemBtn'></i>
                                    <i data-admin-id='{$admin['admin_id']}' class='far fa-edit editItemBtn'></i>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No admins</td></tr>";
                        }
                    ?>
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
                <input type="hidden" id="default-password" name="default-password" value="Bafrrow@2025">
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
                <input type="hidden" id="originalAdminId" name="originalAdminId">
                <div class="form-group">
                    <label for="editadminId">Admin ID:</label>
                    <input type="text" id="editadminId" name="adminId" placeholder="Enter admin ID" required>
                </div>
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
                <div class="form-buttons">
                    <button type="submit">Update Admin</button>
                    <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/admin_add_edit.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>