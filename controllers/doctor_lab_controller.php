<?php
require_once("../classes/doctor_lab_class.php");

class DoctorLabController {
    private $labClass;

    public function __construct() {
        $this->labClass = new DoctorLabClass();
    }

    public function getDoctorLabRequests($doctor_id) {
        $requests = $this->labClass->getDoctorLabRequests($doctor_id);
        return ["success" => true, "requests" => $requests];
    }

    public function getDoctorLabResultById($lab_id, $doctor_id) {
        $result = $this->labClass->getDoctorLabResultById($lab_id, $doctor_id);
        if ($result) {
            return ["success" => true, "result" => $result];
        }
        return ["success" => false, "message" => "Lab result not found or you do not have access to it"];
    }
}
?>