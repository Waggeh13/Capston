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
    <title>Departments</title>
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
require('../controllers/department_controller.php');
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
                    <span class="profile-text">Fatou Waggeh</span>
                </div>
            </div>
            <div class="doctor-available">
                <div class="heading">
                    <h2>departments</h2>
                    <a href="#" class="btn" id="addItemBtn">Add Department</a>
                </div>
                <table class="available">
                    <thead>
                        <td>Department ID</td>
                        <td>Department Name</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                        <?php
                            $departments = viewdepartmentsController();
                            if (!empty($departments)) {
                                foreach ($departments as $department) {
                                    echo "<tr>";
                                    echo "<td>{$department['department_id']}</td>";
                                    echo "<td>{$department['department_name']}</td>";
                                    echo "<td>
                                        <i data-department-id='{$department['department_id']}' class='far fa-trash-alt deleteItemBtn'></i>
                                        <i data-department-id='{$department['department_id']}' class='far fa-edit editItemBtn'></i>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No departments</td></tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Department</h3>
            <form id="addItem">
                <input type="text" id="departmentId" name="departmentId" placeholder="Department ID" required>
                <input type="text" id="departmentName" name="departmentName" placeholder="Department Name" required>

                <button type="submit">Add</button>
                <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
            </form>
        </div>

        <div class="popup-form" id="editItemForm">
            <h3>Edit Department</h3>
            <form id="editItem">
                <input type="hidden" id="editDepartmentId" name="editdepartmentId">
                <input type="text" id="editDepartmentName" name="editdepartmentName" placeholder="Department Name" required>

                <button type="submit">Update</button>
                <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
            </form>
        </div>
        <script src="../js/department_add_edit.js"></script>
        <script src="../js/dark_mode.js"></script>
</body>
</html>