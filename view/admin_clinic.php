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
    <title>Clinics</title>
</head>
<?php
require_once('../controllers/clinic_controller.php');
require_once('../controllers/department_controller.php');
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
                    <h2>Clinics</h2>
                    <a href="#" class="btn" id="addItemBtn">Add Clinic</a>
                </div>
                <table class="available">
                    <thead>
                        <td>Clinic ID</td>
                        <td>Clinic Name</td>
                        <td> Department Name</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                        <!-- Data will be fetched from the database -->
                        <?php
                            $clinics = viewclinicsController();
                            $departments = viewdepartmentsController();
                            foreach ($departments as $dept) {
                                $departmentMap[$dept['department_id']] = $dept['department_name']; // Fixed the assignment operator
                                }
                                if (!empty($clinics)) {
                                    foreach ($clinics as $clinic) {
                                        echo "<tr>";
                                        echo "<td>{$clinic['clinic_id']}</td>";
                                        echo "<td>{$clinic['clinic_name']}</td>";
                                        $deptName = $departmentMap[$clinic['department_id']] ?? 'N/A';
                                        echo "<td>{$deptName}</td>";
                                        echo "<td>
                                            <i data-clinic-id='{$clinic['clinic_id']}' class='far fa-trash-alt deleteItemBtn'></i>
                                            <i data-clinic-id='{$clinic['clinic_id']}' class='far fa-edit editItemBtn'></i>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>No clinics</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
        </div>

        <!-- Add Item Pop-up Form -->
        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Clinic</h3>
            <form id="addItem">
                <input type="text" id="clinicID" name="clinicID" placeholder="Enter clinic ID" required>
                <input type="text" id="clinicName" name="clinicName" placeholder="Enter clinic name" required>
                
                <!-- Dropdown for Category -->
                <label for="department">Department:</label>
                <select id="department" name="department_id" required>
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
                <button type="submit">Add</button>
                <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
            </form>
        </div>

        <!-- Edit Item Pop-up Form -->
        <div class="popup-form" id="editItemForm">
            <h3>Edit Clinic</h3>
            <form id="editItem">
                <input type="hidden" id="editClinicID" name="clinicId">
                <input type="text" id="editClinicName" name="clinicName" placeholder="Edit clinic name" required>
                
                <!-- Dropdown for Category -->
                <label for="editDepartment">Department:</label>
                    <select id="editDepartment" name="department_id" required>
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

                <button type="submit">Update</button>
                <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
            </form>
        </div>
        <script src="../js/clinic_add_edit.js"></script>
    </body>
</html>