<?php
require_once("../settings/db_class.php");

class DoctorDashboard_class extends db_connection {
    private $doctor_id;
    private $current_date;

    public function __construct($doctor_id) {
        $this->doctor_id = $doctor_id;
        $this->current_date = date('Y-m-d'); // Reverted to dynamic date
    }

    // Card: Today's Appointments
    public function getTodayAppointmentsCount() {
        $sql = "
            SELECT COUNT(*) AS count
            FROM appointment_table a
            JOIN appointment_timeslots t ON t.appointment_id = a.appointment_id
            JOIN booking_table b ON b.timeslot_id = t.timeslot_id
            WHERE a.staff_id = ? AND a.appointment_date = ? 
            AND b.status = 'Scheduled' AND t.status = 'Booked'
        ";
        $conn = $this->db_conn();
        if (!$conn) {
            error_log("DoctorDashboard_class::getTodayAppointmentsCount: Database connection failed");
            return 0;
        }
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $this->doctor_id, $this->current_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count = mysqli_fetch_assoc($result)['count'] ?? 0;
        error_log("getTodayAppointmentsCount: staff_id={$this->doctor_id}, date={$this->current_date}, count={$count}");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $count;
    }

    // Card: Patients Seen
    public function getPatientsSeenCount() {
        $sql = "
            SELECT COUNT(*) AS count
            FROM appointment_table a
            JOIN appointment_timeslots t ON t.appointment_id = a.appointment_id
            JOIN booking_table b ON b.timeslot_id = t.timeslot_id
            WHERE a.staff_id = ? AND a.appointment_date = ? 
            AND b.status = 'Completed' AND t.status = 'Booked'
        ";
        $conn = $this->db_conn();
        if (!$conn) {
            error_log("DoctorDashboard_class::getPatientsSeenCount: Database connection failed");
            return 0;
        }
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $this->doctor_id, $this->current_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count = mysqli_fetch_assoc($result)['count'] ?? 0;
        error_log("getPatientsSeenCount: staff_id={$this->doctor_id}, date={$this->current_date}, count={$count}");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $count;
    }

    // Card: Virtual Consultations
    public function getVirtualConsultationsCount() {
        $sql = "
            SELECT COUNT(*) AS count
            FROM appointment_table a
            JOIN appointment_timeslots t ON t.appointment_id = a.appointment_id
            JOIN booking_table b ON b.timeslot_id = t.timeslot_id
            WHERE a.staff_id = ? AND a.appointment_date = ? 
            AND b.appointment_type = 'Virtual Consultation' 
            AND b.status = 'Scheduled' AND t.status = 'Booked'
        ";
        $conn = $this->db_conn();
        if (!$conn) {
            error_log("DoctorDashboard_class::getVirtualConsultationsCount: Database connection failed");
            return 0;
        }
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $this->doctor_id, $this->current_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count = mysqli_fetch_assoc($result)['count'] ?? 0;
        error_log("getVirtualConsultationsCount: staff_id={$this->doctor_id}, date={$this->current_date}, count={$count}");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $count;
    }

    // Today's Appointments Table
    public function getTodayAppointments() {
        $sql = "
            SELECT 
                p.first_name, 
                p.last_name, 
                p.Gender, 
                p.DOB, 
                p.patient_id, 
                d.department_name AS clinic, 
                t.time_slot, 
                b.status
            FROM appointment_table a
            JOIN appointment_timeslots t ON t.appointment_id = a.appointment_id
            JOIN booking_table b ON b.timeslot_id = t.timeslot_id
            JOIN patient_table p ON b.patient_id = p.patient_id
            JOIN clinic_table c ON b.clinic_id = c.clinic_id
            JOIN department_table d ON c.department_id = d.department_id
            WHERE a.staff_id = ? AND a.appointment_date = ? AND t.status = 'Booked'
            ORDER BY t.time_slot ASC
        ";
        $conn = $this->db_conn();
        if (!$conn) {
            error_log("DoctorDashboard_class::getTodayAppointments: Database connection failed");
            return [];
        }
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $this->doctor_id, $this->current_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $appointments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $row['age'] = $this->calculateAge($row['DOB']);
            $row['time_slot'] = date('h:i A', strtotime($row['time_slot'])); // Format to '01:00 PM'
            $appointments[] = $row;
        }
        error_log("getTodayAppointments: staff_id={$this->doctor_id}, date={$this->current_date}, rows=" . count($appointments));
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $appointments;
    }

    // Next Patient
    public function getNextPatient() {
        $sql = "
            SELECT 
                p.first_name, 
                p.last_name, 
                p.Gender, 
                p.DOB, 
                p.weight, 
                p.address, 
                p.patient_id, 
                b.appointment_type, 
                t.time_slot
            FROM appointment_table a
            JOIN appointment_timeslots t ON t.appointment_id = a.appointment_id
            JOIN booking_table b ON b.timeslot_id = t.timeslot_id
            JOIN patient_table p ON b.patient_id = p.patient_id
            WHERE a.staff_id = ? AND a.appointment_date = ? 
            AND b.status = 'Scheduled' AND t.status = 'Booked'
            ORDER BY t.time_slot ASC
            LIMIT 1
        ";
        $conn = $this->db_conn();
        if (!$conn) {
            error_log("DoctorDashboard_class::getNextPatient: Database connection failed");
            return null;
        }
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $this->doctor_id, $this->current_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $patient = mysqli_fetch_assoc($result);
        if ($patient) {
            $patient['age'] = $this->calculateAge($patient['DOB']);
            $patient['dob_formatted'] = date('d F Y', strtotime($patient['DOB']));
            $patient['time_slot'] = date('h:i A', strtotime($patient['time_slot'])); // Format to '01:00 PM'
        }
        error_log("getNextPatient: staff_id={$this->doctor_id}, date={$this->current_date}, patient=" . ($patient ? $patient['patient_id'] : 'none'));
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $patient;
    }

    // Helper: Calculate age
    private function calculateAge($dob) {
        $birthDate = new DateTime($dob);
        $today = new DateTime();
        return $today->diff($birthDate)->y;
    }
}
?>