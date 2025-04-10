<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/lab_request.css">
    <link rel="stylesheet" href="../css/lab_container.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/doc_appointment.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Doctor Appointments</title>
</head>
<style>
    .status-dropdown {
    padding: 10px 15px;
    border: 1px solid #ccc; /* Grey border */
    border-radius: 8px; /* Rounded edges */
    background-color: white;
    font-size: 16px;
    color: #333;
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease;
    appearance: none; /* Removes default system styling */
    -webkit-appearance: none; /* For Safari */
    -moz-appearance: none; /* For Firefox */
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
    padding-right: 35px; 
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
                    <a href="doctor_dashboard.php">
                        <i class="fas fa-th-large"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="doc_appointment.php">
                        <i class="fas fa-stethoscope"></i>
                        <div class="title">Appointments</div>
                    </a>
                </li>
                <li>
                    <a href="doc_schedule.php">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="title">Schedule</div>
                    </a>
                </li>
                <li>
                    <a href="doc_lab.php">
                        <i class="fas fa-vial"></i>
                        <div class="title">Lab Test</div>
                    </a>
                </li>
                <li>
                    <a href="doc_prescription.php">
                        <i class="fas fa-prescription-bottle-alt"></i>
                        <div class="title">Prescription</div>
                    </a>
                </li>
                <li>
                    <a href="doc_telemedicine.php">
                        <i class="fas fa-video"></i>
                        <div class="title">Virtual Consultation</div>
                    </a>
                </li>
                <li>
                    <a href="doc_message.php">
                        <i class="fas fa-envelope"></i>
                        <div class="title">Messages</div>
                    </a>
                </li>
                <li>
                    <a href="request.php">
                        <i class="fas fa-file-medical"></i>
                        <div class="title">Report Request</div>
                    </a>
                </li>
                <li>
                    <a href="doc_setting.php">
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
                    <input type="text" name="search" placeholder="Search appointments...">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
                <i class="fas fa-bell"></i>
                <div class="user">
                    <span class="profile-text">Profile</span>
                </div>
            </div>
            
            <div class="appointments-container">
                <div class="appointments-header">
                    <h1 class="appointments-title">Today's Appointments</h1>
                    <div class="date-selector">
                    <button id="prevDay"><i class="fas fa-chevron-left"></i></button>
                        <span id="currentDate">Loading...</span>
                    <button id="nextDay"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                
                <div class="appointments-list">
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Patient</th>
                                <th>Appointment Type</th>
                                <th>Clinic Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>09:00 AM</td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div>John Doe</div>
                                            <div style="font-size: 0.8rem; color: #718096;">ID: PT12345</div>
                                        </div>
                                    </div>
                                </td>
                                <td>In-person</td>
                                <td>Postnatal</td>
                                <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            </tr>
                            <tr>
                                <td>10:30 AM</td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div>Sarah Johnson</div>
                                            <div style="font-size: 0.8rem; color: #718096;">ID: PT12346</div>
                                        </div>
                                    </div>
                                </td>
                                <td>In-person</td>
                                <td>Postnatal</td>
                                <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            </tr>
                            <tr>
                                <td>11:45 AM</td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div>Michael Brown</div>
                                            <div style="font-size: 0.8rem; color: #718096;">ID: PT12347</div>
                                        </div>
                                    </div>
                                </td>
                                <td>In-person</td>
                                <td>Postnatal</td>
                                <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            </tr>
                            <tr>
                                <td>02:15 PM</td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div>Amina Ceesay</div>
                                            <div style="font-size: 0.8rem; color: #718096;">ID: PT12348</div>
                                        </div>
                                    </div>
                                </td>
                                <td>In-person</td>
                                <td>Postnatal</td>
                                <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            </tr>
                            <tr>
                                <td>03:30 PM</td>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div>David Camara</div>
                                            <div style="font-size: 0.8rem; color: #718096;">ID: PT12349</div>
                                        </div>
                                    </div>
                                </td>
                                <td>In-person</td>
                                <td>Postnatal</td>
                                <td>
                                <select class="status-dropdown">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rescheduled">Rescheduled</option>
                                </select>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
            document.querySelectorAll('.status-dropdown').forEach(select => {
                function updateColor(dropdown) {
                    let color = {
                        "pending": "orange",
                        "confirmed": "blue",
                        "in-progress": "darkblue",
                        "completed": "green",
                        "cancelled": "red",
                        "no-show": "gray",
                        "rescheduled": "purple"
                    }[dropdown.value] || "black"; 
            
                    dropdown.style.color = color;
                }
            
                // Update color on page load
                updateColor(select);
            
                // Update color when the value changes
                select.addEventListener('change', function() {
                    updateColor(this);
                });
            });

        </script>
        <script src="../js/doc_aptmt_date.js"></script>
    </body>
</html>