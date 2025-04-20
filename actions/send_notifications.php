<?php
require_once("../controllers/prescription_notification_controller.php");
require_once("../settings/onesignal_config.php"); // Create this file for OneSignal credentials

// OneSignal configuration
$onesignal_app_id = ONESIGNAL_APP_ID;
$onesignal_api_key = ONESIGNAL_API_KEY;

$now = new DateTime();
$notifications = get_patient_notification_times_ctr('all'); // Modify get_patient_notification_times to support 'all'

foreach ($notifications as $notification) {
    $patient_id = $notification['patient_id'];
    $medication_id = $notification['medication_id'];
    $interval_hours = $notification['interval_hours'];
    $last_sent = $notification['last_sent'] ?? null;

    if ($interval_hours !== null) {
        $send = false;
        if ($last_sent === null) {
            $send = true; // First notification
        } else {
            $last_sent_time = new DateTime($last_sent);
            $hours_since_last = ($now->getTimestamp() - $last_sent_time->getTimestamp()) / 3600;
            if ($hours_since_last >= $interval_hours) {
                $send = true;
            }
        }

        if ($send) {
            // Send OneSignal notification
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Basic $onesignal_api_key",
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                "app_id" => $onesignal_app_id,
                "include_external_user_ids" => ["patient_$patient_id"],
                "contents" => ["en" => "Time to take your {$notification['medication']} ({$notification['dosage']})"]
            ]));
            curl_exec($ch);
            curl_close($ch);

            // Update last_sent timestamp
            $sql = "UPDATE prescription_notifications SET last_sent = NOW() WHERE notification_id = '{$notification['notification_id']}'";
            $db = new db_connection();
            $db->db_query($sql);
        }
    }
}
?>