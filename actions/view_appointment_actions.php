<?php
include("../controllers/appointment_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = sanitize_input($_POST['booking_id']);

    if (empty($booking_id)) {
        $response["message"] = "Booking ID is required.";
    } else {
        $bookings = get_all_bookings_ctr();
        $booking = array_filter($bookings, function($b) use ($booking_id) {
            return $b['booking_id'] == $booking_id;
        });
        $booking = array_values($booking);
        
        if (!empty($booking)) {
            $response["success"] = true;
            $response["data"] = $booking[0];
        } else {
            $response["message"] = "Booking not found.";
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>