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
                    <a href="admin_staff.php">
                        <i class="fas fa-user"></i>
                        <div class="title">staffs</div>
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
                        <td>Contact</td>
                        <td>email</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                            <?php
                            $staffs = viewstaffsController();
                            if (!empty($staffs)) {
                                foreach ($staffs as $staff) {
                                    echo "<tr>";
                                    echo "<td>{$staff['staff_id']}</td>";
                                    echo "<td>{$staff['first_name']}</td>";
                                    echo "<td>{$staff['last_name']}</td>";
                                    echo "<td>{$staff['Position']}</td>";
                                    echo "<td>{$staff['Department']}</td>";
                                    echo "<td>{$staff['contact']}</td>";
                                    echo "<td>
                                        <i data-staff-id='{$staff['staff_id']}' class='far fa-trash-alt deleteItemBtn'></i>
                                        <i data-staff-id='{$staff['staff_id']}' class='far fa-edit editItemBtn'></i>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No staffs</td></tr>";
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
                <input type="text" id="staffId" name ="staffId" placeholder="Staff ID" required>
                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                <input type="text" id="position" name="postion" placeholder="Position" required>
                
                <!-- Dropdown for Department -->
                <label for="department">Department:</label>
                <select id="department" name="department" required>
                    <option value="">Select a department</option>
                    <option value="administration">Administration</option>
                    <option value="pediatrics">Pediatrics</option>
                    <option value="gynaecology">Gynaecology</option>
                    <option value="surgical">Surgical</option>
                </select>

                <input type="tel" id="contact" placeholder="Contact Number" required>
                <input type="email" id="email" placeholder="Email" required>
                <input type="text" id="default-password" name="default-password" placeholder="Enter default password" 
                minlength="6" required>   

                <button type="submit">Add</button>
                <button type="button" class="cancel" id="cancelAddItem">Cancel</button>
            </form>
        </div>

        <!-- Edit Staff Pop-up Form -->
        <div class="popup-form" id="editItemForm">
            <h3>Edit Staff</h3>
            <form id="editItem">
                <!-- Staff Details -->
                <input type="text" id="editStaffId" placeholder="Staff ID" required>
                <input type="text" id="editFirstName" placeholder="First Name" required>
                <input type="text" id="editLastName" placeholder="Last Name" required>
                <input type="text" id="editPosition" placeholder="Position" required>
                
                <!-- Dropdown for Department -->
                <label for="editDepartment">Department:</label>
                <select id="editDepartment" name="editDepartment" required>
                    <option value="">Select a department</option>
                    <option value="administration">Administration</option>
                    <option value="pediatrics">Pediatrics</option>
                    <option value="gynaecology">Gynaecology</option>
                    <option value="surgical">Surgical</option>
                </select>

                <input type="tel" id="editContact" placeholder="Contact Number" required>
                <input type="email" id="editEmail" placeholder="Email" required>
                <input type="hidden" id="default-password" name="default-password" placeholder="Enter default password" 
                minlength="6" required>   

                <button type="submit">Update</button>
                <button type="button" class="cancel" id="cancelEditItem">Cancel</button>
            </form>
        </div>
    
    <script src="../js/add_edit.js"></script> 
</body>
</html>