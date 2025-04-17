<?php
require_once("../classes/tech_class.php");

class LabController {
    private $labClass;

    public function __construct() {
        $this->labClass = new LabClass();
    }

    public function getPendingLabRequests() {
        $requests = $this->labClass->getPendingLabRequests();
        return ["success" => true, "requests" => $requests];
    }

    public function getLabRequestById($lab_id) {
        $request = $this->labClass->getLabRequestById($lab_id);
        if ($request) {
            return ["success" => true, "request" => $request];
        }
        return ["success" => false, "message" => "Lab request not found"];
    }

    public function submitLabResults($lab_id, $lab_tech_id, $results, $specimen_received_by, $specimen_date, $specimen_time, $sample_accepted, $lab_tech_signature, $lab_tech_date, $supervisor_signature, $supervisor_date) {
        return $this->labClass->submitLabResults($lab_id, $lab_tech_id, $results, $specimen_received_by, $specimen_date, $specimen_time, $sample_accepted, $lab_tech_signature, $lab_tech_date, $supervisor_signature, $supervisor_date);
    }
}
?>