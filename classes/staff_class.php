<?php
require_once("../settings/db_class.php");

class staff_class extends db_connection {

    public function addstaff($staff_id, $first_name, $last_name, $gender, $position, $department_id,$contact,$email) {
        $staff_id = mysqli_real_escape_string($this->db_conn(), $staff_id);
        $first_name = mysqli_real_escape_string($this->db_conn(), $first_name);
        $last_name = mysqli_real_escape_string($this->db_conn(), $last_name);
        $gender = mysqli_real_escape_string($this->db_conn(),$gender);
        $position = mysqli_real_escape_string($this->db_conn(), $position);
        $department_id = mysqli_real_escape_string($this->db_conn(), $department_id);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);
        $email = mysqli_real_escape_string($this->db_conn(), $email);
        $sql = "INSERT INTO staff_table (staff_id, first_name, last_name,Gender, department_id,phone, email, position)
                VALUES ('$staff_id', '$first_name', '$last_name','$gender', '$department_id', '$contact', '$email','$position')";
        
        return $this->db_query($sql);
    }

    public function deletestaff($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM user_table WHERE user_id = '$id'";
        return $this->db_query($sql);
    }


    public function getstaffs() {
        $sql = "SELECT * FROM staff_table";
        return $this->db_fetch_all($sql);
    }

    public function getstaffsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM staff_table WHERE staff_id = '$id'";
        return $this->db_fetch_all($sql);
    }

    public function updatestaff($staff_id, $first_name, $last_name, $gender, $position, $department_id, $contact, $email) {
        $staff_id = mysqli_real_escape_string($this->db_conn(), $staff_id);
        $first_name = mysqli_real_escape_string($this->db_conn(), $first_name);
        $last_name = mysqli_real_escape_string($this->db_conn(), $last_name);
        $gender = mysqli_real_escape_string($this->db_conn(), $gender);
        $position = mysqli_real_escape_string($this->db_conn(), $position);
        $department_id = mysqli_real_escape_string($this->db_conn(), $department_id);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);
        $email = mysqli_real_escape_string($this->db_conn(), $email);
        
        $sql = "UPDATE staff_table
                SET first_name = '$first_name',
                    last_name = '$last_name',
                    gender = '$gender',
                    position = '$position',
                    department_id = '$department_id',
                    phone = '$contact',
                    email = '$email'
                WHERE staff_id = '$staff_id'";
        
        return $this->db_query($sql);
    }
    

    public function addUser($patientId, $password, $userRole)
    {
        $patientId = mysqli_real_escape_string($this->db_conn(), $patientId);
        $password = mysqli_real_escape_string($this->db_conn(), $password);
        $userRole = mysqli_real_escape_string($this->db_conn(), $userRole);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_table(user_id, password, role)
                VALUES ('$patientId', '$hashed_password', '$userRole')";
        
        return $this->db_query($sql);
    }

    public function staff_ID_exists($staff_id) {
        $staff_id= mysqli_real_escape_string($this->db_conn(), $staff_id);
        $sql = "SELECT user_id FROM user_table WHERE user_id = '$staff_id'";
        return $this->db_fetch_all($sql);
    }

public function update_ID($original_staff_id, $staffId)
{
    $staff_id = mysqli_real_escape_string($this->db_conn(), $staffId);
    $original_staffid = mysqli_real_escape_string($this->db_conn(), $original_staff_id);

    $sql = "UPDATE user_table
    SET user_id = '$staff_id'
    WHERE user_id = '$original_staffid'";
    
return $this->db_query($sql);

}
}
?>
