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
    <title>Staff</title>
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
            position: absolute;
            right: 150px;
            overflow: visible;
        }
    .profile-text{
    color: black;
    }
</style>
<?php
require_once('../controllers/staff_controller.php');
require_once('../controllers/department_controller.php');
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
                <div class="user">
                    <span class="profile-text">Fatou Waggeh</span>
                </div>
            </div>
            <div class="doctor-available">
                <div class="heading">
                    <h2>Staff</h2>
                    <a href="#" class="btn" id="addItemBtn">Add Staff</a>
                </div>
                <table class="available">
                    <thead>
                        <td>Staff ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Position</td>
                        <td>Deparatment</td>
                        <td>Gender</td>
                        <td>Contact</td>
                        <td>email</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                    <?php
                    $staffs = viewstaffsController();
                    $departments = viewdepartmentsController(); // Fetch all departments once
                    $departmentMap = [];
                    foreach ($departments as $dept) {
                        $departmentMap[$dept['department_id']] = $dept['department_name']; // Fixed the assignment operator
                        }
                        if (!empty($staffs)) {
                            foreach ($staffs as $staff) {
                                echo "<tr>";
                                echo "<td>{$staff['staff_id']}</td>";
                                echo "<td>{$staff['first_name']}</td>";
                                echo "<td>{$staff['last_name']}</td>";
                                echo "<td>{$staff['position']}</td>";
                                // Get department name from the map with a fallback
                                $deptName = $departmentMap[$staff['department_id']] ?? 'N/A'; // Fixed array access
                                echo "<td>{$deptName}</td>";
                                echo "<td>{$staff['Gender']}</td>";
                                echo "<td>{$staff['phone']}</td>";
                                echo "<td>{$staff['email']}</td>";
                                echo "<td>
                                <i data-staff-id='{$staff['staff_id']}' class='far fa-trash-alt deleteItemBtn'></i>
                                <i data-staff-id='{$staff['staff_id']}' class='far fa-edit editItemBtn'></i>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No staffs found</td></tr>";
                        }
                        ?>
                        </tbody>
                </table>
            </div>
        </div>
        <!-- Add Staff Pop-up Form -->
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Staff</h3>
            <form id="addItem">
                <!-- Staff Details -->
                <div class="form-group">
                    <label for="staffId">Staff ID:</label>
                    <input type="text" id="staffId" name="staffId" placeholder="Enter staff ID" required>
                </div>

                <div class="form-group">
                    <label>Full Name:</label>
                    <div class="name-fields">
                        <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                        <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="form-group">
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="position">Position:</label>
                    <input type="text" id="position" name="position" placeholder="Enter position" required>
                </div>
                
                <div class="form-group">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">Select a department</option>
                        <?php
                        $departments = viewdepartmentsController();
                        if (!empty($departments)) {
                            foreach ($departments as $department) {
                                echo "<option value='{$department['department_id']}'>{$department['department_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="tel" id="contact" name="contact" placeholder="Enter phone number" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" required>
                    <input type="hidden" id="default-password" name="default-password" value="Bafrrow@2025">
                </div>

                <div class="form-buttons">
                    <button type="submit">Add Staff</button>
                    <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Edit Staff Pop-up Form -->
        <div class="popup-form" id="editItemForm">
            <h3>Edit Staff</h3>
            <form id="editItem">
                <!-- Staff Details -->
                <input type="hidden" id="originalstaffId" name="originalstaffId">
                <div class="form-group">
                    <label for="editStaffId">Staff ID:</label>
                    <input type="text" id="editStaffId" name="staffId" required>
                </div>

                <div class="form-group">
                    <label>Full Name:</label>
                    <div class="name-fields">
                        <input type="text" id="editFirstName" name="firstName" placeholder="First Name" required>
                        <input type="text" id="editLastName" name="lastName" placeholder="Last Name" required>
                    </div>
                </div>
                <select id="editGender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <div class="form-group">
                    <label for="editPosition">Position:</label>
                    <input type="text" id="editPosition" name="position" placeholder="Enter position" required>
                </div>

                <div class="form-group">
                    <label for="editDepartment">Department:</label>
                    <select id="editDepartment" name="department" required>
                        <option value="">Select a department</option>
                        <?php
                        $departments = viewdepartmentsController();
                        if (!empty($departments)) {
                            foreach ($departments as $department) {
                                echo "<option value='{$department['department_id']}'>{$department['department_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="editContact">Contact Number:</label>
                    <input type="tel" id="editContact" name="contact" placeholder="Enter phone number" required>
                </div>

                <div class="form-group">
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail" name="email" placeholder="Enter email address" required>
                </div>

                <div class="form-buttons">
                    <button type="submit">Update Staff</button>
                    <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
                </div>
            </form>
        </div>
        
    
    <script src="../js/staff_add_edit.js"></script>
    <script src="../js/dark_mode.js"></script>
</body>
</html>