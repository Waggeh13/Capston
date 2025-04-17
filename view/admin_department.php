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
    <title>Departments</title>
</head>
<?php
require('../controllers/department_controller.php');
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
        <!-- Add Department Pop-up Form -->
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Department</h3>
            <form id="addItem">
                <!-- Department Details -->
                <input type="text" id="departmentId" name="departmentId" placeholder="Department ID" required>
                <input type="text" id="departmentName" name="departmentName" placeholder="Department Name" required>

                <button type="submit">Add</button>
                <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
            </form>
        </div>

        <!-- Edit Department Pop-up Form -->
        <div class="popup-form" id="editItemForm">
            <h3>Edit Department</h3>
            <form id="editItem">
                <!-- Department Details -->
                <input type="hidden" id="editDepartmentId" name="editdepartmentId">
                <input type="text" id="editDepartmentName" name="editdepartmentName" placeholder="Department Name" required>
                <button type="submit">Update</button>
                <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
            </form>
        </div>
        <script src="../js/department_add_edit.js"></script>
</body>
</html>