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
    <title>Clinics</title>
</head>
<?php
require_once('../controllers/clinic_controller.php');
require_once('../controllers/department_controller.php');
require_once('../classes/userName_class.php');
require_once('../settings/core.php');
redirect_admin_if_not_logged_in();

$userProfile = new userName_class();
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
    .profile-text{
    color: black;
    font-size: 20px;
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
                <div class="user">
                    <span id="username"><?php echo $userProfile->getUserName(); ?></span>
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
                        <?php
                            $clinics = viewclinicsController();
                            $departments = viewdepartmentsController();
                            foreach ($departments as $dept) {
                                $departmentMap[$dept['department_id']] = $dept['department_name'];
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

        <div class="overlay" id="overlay"></div>
        <div class="popup-form" id="addItemForm">
            <h3>Add Clinic</h3>
            <form id="addItem">
                <input type="text" id="clinicID" name="clinicID" placeholder="Enter clinic ID" required>
                <input type="text" id="clinicName" name="clinicName" placeholder="Enter clinic name" required>
                
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

        <div class="popup-form" id="editItemForm">
            <h3>Edit Clinic</h3>
            <form id="editItem">
                <input type="hidden" id="editclinicId" name="editclinicId">
                <input type="text" id="editclinicName" name="editclinicName" placeholder="Edit clinic name" required>
                
                <label for="editDepartment">Department:</label>
                    <select id="editDepartment" name="editDepartment" required>
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
        <script src="../js/dark_mode.js"></script>
    </body>
</html>