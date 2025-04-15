<?php
require_once("../settings/db_class.php");

class patient_appointment_class extends db_connection {
    private $zoom_client_id = 'JWxNJ_siTs6WKTBZZ9IFw';
    private $zoom_client_secret = 'DNxXbSOv70Md8i5ohHgazs6ooxDuuGTW';
    private $zoom_redirect_uri = 'https://91bf-154-161-44-234.ngrok-free.app/capston/utils/zoom-callback.php';

    public function book_appointment($patient_id, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in book_appointment");
            return ["success" => false, "message" => "Database connection failed"];
        }
    
        try {
            mysqli_begin_transaction($conn);
    
            // Insert into booking_table
            $appointmentTypeDB = $appointmentType === 'inPerson' ? 'In-Person' : 'Virtual';
            $sql = "INSERT INTO booking_table (patient_id, timeslot_id, appointment_type, clinic_id, status) 
                    VALUES (?, ?, ?, ?, 'Scheduled')";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt === false) {
                throw new Exception("Failed to prepare booking statement: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($stmt, "sisi", $patient_id, $timeslot_id, $appointmentTypeDB, $clinic_id);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to insert into booking_table: " . mysqli_error($conn));
            }
    
            $booking_id = mysqli_insert_id($conn);
            error_log("Booking inserted: booking_id=$booking_id");
            mysqli_stmt_close($stmt);
    
            // Update timeslot status
            $update_sql = "UPDATE appointment_timeslots SET status = 'Booked' WHERE timeslot_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            if ($update_stmt === false) {
                throw new Exception("Failed to prepare timeslot update: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($update_stmt, "i", $timeslot_id);
            
            if (!mysqli_stmt_execute($update_stmt)) {
                throw new Exception("Failed to update appointment_timeslots: " . mysqli_error($conn));
            }
            error_log("Timeslot updated: timeslot_id=$timeslot_id");
            mysqli_stmt_close($update_stmt);
    
            // Handle Zoom meeting for virtual appointments
            if ($appointmentType === 'virtual') {
                // Fetch appointment date and time for Zoom meeting
                $time_sql = "SELECT t.time_slot, a.appointment_date 
                             FROM appointment_timeslots t 
                             JOIN appointment_table a ON t.appointment_id = a.appointment_id 
                             WHERE t.timeslot_id = ?";
                $time_stmt = mysqli_prepare($conn, $time_sql);
                if ($time_stmt === false) {
                    throw new Exception("Failed to prepare time query: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($time_stmt, "i", $timeslot_id);
                if (!mysqli_stmt_execute($time_stmt)) {
                    throw new Exception("Failed to execute time query: " . mysqli_error($conn));
                }
                $time_result = mysqli_stmt_get_result($time_stmt);
                if (!$time_result || mysqli_num_rows($time_result) === 0) {
                    throw new Exception("No timeslot found for timeslot_id: $timeslot_id");
                }
                $time_row = mysqli_fetch_assoc($time_result);
                $start_time = date('Y-m-d\TH:i:s', strtotime($time_row['appointment_date'] . ' ' . $time_row['time_slot']));
                error_log("Zoom meeting time: start_time=$start_time");
                mysqli_stmt_close($time_stmt);
    
                // Get or refresh Zoom access token
                $token = $this->getValidZoomToken($conn);
                if (!$token) {
                    throw new Exception("Zoom authorization required");
                }
                error_log("Zoom token obtained: token_id={$token['token_id']}");
    
                // Create Zoom meeting
                $meeting_details = $this->createZoomMeeting($token['access_token'], $patient_id, $staff_id, $start_time);
                if (!$meeting_details) {
                    throw new Exception("Failed to create Zoom meeting: Check Zoom API credentials or permissions");
                }
                error_log("Zoom meeting created: meeting_id={$meeting_details['id']}");
    
                // Insert Zoom meeting details into telemedicine_table
                $tele_sql = "INSERT INTO telemedicine_table (booking_id, patient_id, staff_id, meeting_id, join_url, password, topic, start_time, duration, status) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Scheduled')";
                $tele_stmt = mysqli_prepare($conn, $tele_sql);
                if ($tele_stmt === false) {
                    throw new Exception("Failed to prepare telemedicine insert: " . mysqli_error($conn));
                }
                $topic = "Virtual Consultation with Patient $patient_id";
                $duration = 30; // Default duration in minutes
                mysqli_stmt_bind_param($tele_stmt, "isssssssi", 
                    $booking_id, 
                    $patient_id, 
                    $staff_id, 
                    $meeting_details['id'], 
                    $meeting_details['join_url'], 
                    $meeting_details['password'], 
                    $topic, 
                    $start_time, 
                    $duration
                );
                if (!mysqli_stmt_execute($tele_stmt)) {
                    throw new Exception("Failed to insert into telemedicine_table: " . mysqli_error($conn));
                }
                error_log("Telemedicine record inserted: booking_id=$booking_id");
                mysqli_stmt_close($tele_stmt);
            }
    
            mysqli_commit($conn);
            error_log("Appointment booked successfully: booking_id=$booking_id");
            return ["success" => true, "message" => "Appointment booked successfully"];
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log("Book appointment failed: " . $e->getMessage());
            return ["success" => false, "message" => $e->getMessage()];
        } finally {
            mysqli_close($conn);
        }
    }

    public function checkZoomToken() {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in checkZoomToken");
            return ["has_token" => false, "message" => "Database connection failed"];
        }
        $token = $this->getValidZoomToken($conn);
        mysqli_close($conn);
        if ($token) {
            return ["has_token" => true, "message" => "Valid Zoom token found"];
        }
        return ["has_token" => false, "message" => "No valid Zoom token available"];
    }

    public function initiateZoomOAuth() {
        $url = 'https://zoom.us/oauth/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->zoom_client_id,
            'redirect_uri' => $this->zoom_redirect_uri,
            'state' => bin2hex(random_bytes(16))
        ]);
        error_log("Initiating Zoom OAuth: $url");
        return $url;
    }

    private function getValidZoomToken($conn) {
        // Check for existing token
        $sql = "SELECT token_id, access_token, refresh_token, expires_at 
                FROM token_table 
                WHERE expires_at > NOW() 
                ORDER BY created_at DESC 
                LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $token = mysqli_fetch_assoc($result);
            error_log("Valid token found: token_id={$token['token_id']}");
            return $token;
        }

        // Try refreshing token
        $sql = "SELECT token_id, refresh_token 
                FROM token_table 
                ORDER BY created_at DESC 
                LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $token = mysqli_fetch_assoc($result);
            $new_token = $this->refreshZoomToken($token['refresh_token']);
            if ($new_token) {
                $this->storeZoomToken($conn, $new_token['access_token'], $new_token['refresh_token'], $new_token['expires_in']);
                $new_token_data = [
                    'token_id' => $token['token_id'],
                    'access_token' => $new_token['access_token'],
                    'refresh_token' => $new_token['refresh_token'],
                    'expires_at' => date('Y-m-d H:i:s', time() + $new_token['expires_in'])
                ];
                error_log("Token refreshed: token_id={$token['token_id']}");
                return $new_token_data;
            }
            error_log("Failed to refresh token: token_id={$token['token_id']}");
        }

        error_log("No valid token or refresh token available");
        return false;
    }

    private function refreshZoomToken($refresh_token) {
        $url = 'https://zoom.us/oauth/token';
        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token
        ];
        $auth = base64_encode($this->zoom_client_id . ':' . $this->zoom_client_secret);
        $options = [
            'http' => [
                'header' => "Authorization: Basic $auth\r\n" .
                           "Content-Type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        if ($result === false) {
            $http_response = $http_response_header ?? [];
            $error_message = "Unknown error";
            foreach ($http_response as $header) {
                if (stripos($header, 'HTTP/') === 0) {
                    $error_message = $header;
                    break;
                }
            }
            error_log("Failed to refresh Zoom token: $error_message");
            return false;
        }
        $token = json_decode($result, true);
        if (isset($token['access_token'])) {
            error_log("Zoom token refreshed successfully");
            return [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? $refresh_token,
                'expires_in' => $token['expires_in']
            ];
        }
        error_log("Failed to refresh token: " . json_encode($token));
        return false;
    }

    private function storeZoomToken($conn, $access_token, $refresh_token, $expires_in) {
        $expires_at = date('Y-m-d H:i:s', time() + $expires_in);
        $sql = "INSERT INTO token_table (access_token, refresh_token, expires_at) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE access_token = ?, refresh_token = ?, expires_at = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Failed to prepare token insert: " . mysqli_error($conn));
            return false;
        }
        mysqli_stmt_bind_param($stmt, "ssssss", $access_token, $refresh_token, $expires_at, $access_token, $refresh_token, $expires_at);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            error_log("Failed to store token: " . mysqli_error($conn));
        } else {
            error_log("Zoom token stored successfully");
        }
        mysqli_stmt_close($stmt);
        return $result;
    }

    private function createZoomMeeting($access_token, $patient_id, $staff_id, $start_time) {
        $url = 'https://api.zoom.us/v2/users/me/meetings';
        $data = [
            'topic' => "Virtual Consultation with Patient $patient_id",
            'type' => 2, // Scheduled meeting
            'start_time' => $start_time,
            'duration' => 30,
            'timezone' => 'UTC',
            'password' => substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 8),
            'settings' => [
                'host_video' => true,
                'participant_video' => true,
                'join_before_host' => true,
                'mute_upon_entry' => false,
                'waiting_room' => false
            ]
        ];
        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n" .
                           "Authorization: Bearer $access_token\r\n",
                'method' => 'POST',
                'content' => json_encode($data)
            ]
        ];
        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        if ($result === false) {
            $http_response = $http_response_header ?? [];
            $error_message = "Unknown error";
            foreach ($http_response as $header) {
                if (stripos($header, 'HTTP/') === 0) {
                    $error_message = $header;
                    break;
                }
            }
            error_log("Failed to create Zoom meeting: $error_message");
            return false;
        }
        $meeting = json_decode($result, true);
        if (isset($meeting['id'])) {
            error_log("Zoom meeting created: id={$meeting['id']}");
            return [
                'id' => $meeting['id'],
                'join_url' => $meeting['join_url'],
                'password' => $meeting['password']
            ];
        }
        error_log("Failed to create Zoom meeting: " . json_encode($meeting));
        return false;
    }

    // Other methods unchanged
    public function update_appointment($booking_id, $patient_id, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in update_appointment");
            return false;
        }

        try {
            mysqli_begin_transaction($conn);

            $old_sql = "SELECT timeslot_id FROM booking_table WHERE booking_id = ?";
            $old_stmt = mysqli_prepare($conn, $old_sql);
            if ($old_stmt === false) {
                throw new Exception("Failed to prepare old timeslot query: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($old_stmt, "i", $booking_id);
            mysqli_stmt_execute($old_stmt);
            $old_result = mysqli_stmt_get_result($old_stmt);
            $old_timeslot_id = mysqli_fetch_assoc($old_result)['timeslot_id'] ?? null;
            mysqli_stmt_close($old_stmt);

            if ($old_timeslot_id && $old_timeslot_id != $timeslot_id) {
                $avail_sql = "UPDATE appointment_timeslots SET status = 'Available' WHERE timeslot_id = ?";
                $avail_stmt = mysqli_prepare($conn, $avail_sql);
                if ($avail_stmt === false) {
                    throw new Exception("Failed to prepare timeslot availability update: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($avail_stmt, "i", $old_timeslot_id);
                mysqli_stmt_execute($avail_stmt);
                mysqli_stmt_close($avail_stmt);
            }

            $appointmentTypeDB = $appointmentType === 'inPerson' ? 'In-Person' : 'Virtual';
            $sql = "UPDATE booking_table 
                    SET patient_id = ?, timeslot_id = ?, appointment_type = ?, clinic_id = ?
                    WHERE booking_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt === false) {
                throw new Exception("Failed to prepare update statement: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "sisii", $patient_id, $timeslot_id, $appointmentTypeDB, $clinic_id, $booking_id);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update appointment: " . mysqli_error($conn));
            }
            mysqli_stmt_close($stmt);

            $update_sql = "UPDATE appointment_timeslots SET status = 'Booked' WHERE timeslot_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            if ($update_stmt === false) {
                throw new Exception("Failed to prepare timeslot update: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($update_stmt, "i", $timeslot_id);
            
            if (!mysqli_stmt_execute($update_stmt)) {
                throw new Exception("Failed to update timeslot: " . mysqli_error($conn));
            }
            mysqli_stmt_close($update_stmt);

            if ($appointmentType === 'virtual') {
                $time_sql = "SELECT t.time_slot, a.appointment_date 
                             FROM appointment_timeslots t 
                             JOIN appointment_table a ON t.appointment_id = a.appointment_id 
                             WHERE t.timeslot_id = ?";
                $time_stmt = mysqli_prepare($conn, $time_sql);
                if ($time_stmt === false) {
                    throw new Exception("Failed to prepare time query: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($time_stmt, "i", $timeslot_id);
                mysqli_stmt_execute($time_stmt);
                $time_result = mysqli_stmt_get_result($time_stmt);
                $time_row = mysqli_fetch_assoc($time_result);
                if (!$time_row) {
                    throw new Exception("No timeslot found for timeslot_id: $timeslot_id");
                }
                $start_time = date('Y-m-d\TH:i:s', strtotime($time_row['appointment_date'] . ' ' . $time_row['time_slot']));
                mysqli_stmt_close($time_stmt);

                $check_sql = "SELECT telemedicine_id FROM telemedicine_table WHERE booking_id = ?";
                $check_stmt = mysqli_prepare($conn, $check_sql);
                if ($check_stmt === false) {
                    throw new Exception("Failed to prepare telemedicine check: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($check_stmt, "i", $booking_id);
                mysqli_stmt_execute($check_stmt);
                $check_result = mysqli_stmt_get_result($check_stmt);
                $exists = mysqli_fetch_assoc($check_result);
                mysqli_stmt_close($check_stmt);

                $token = $this->getValidZoomToken($conn);
                if (!$token) {
                    throw new Exception("Failed to obtain Zoom access token");
                }

                $meeting_details = $this->createZoomMeeting($token['access_token'], $patient_id, $staff_id, $start_time);
                if (!$meeting_details) {
                    throw new Exception("Failed to create Zoom meeting");
                }

                if ($exists) {
                    $tele_sql = "UPDATE telemedicine_table 
                                 SET patient_id = ?, staff_id = ?, meeting_id = ?, join_url = ?, password = ?, 
                                     topic = ?, start_time = ?, duration = ?, status = 'Scheduled' 
                                 WHERE booking_id = ?";
                    $tele_stmt = mysqli_prepare($conn, $tele_sql);
                    if ($tele_stmt === false) {
                        throw new Exception("Failed to prepare telemedicine update: " . mysqli_error($conn));
                    }
                    $topic = "Virtual Consultation with Patient $patient_id";
                    $duration = 30;
                    mysqli_stmt_bind_param($tele_stmt, "ssssssssi", 
                        $patient_id, 
                        $staff_id, 
                        $meeting_details['id'], 
                        $meeting_details['join_url'], 
                        $meeting_details['password'], 
                        $topic, 
                        $start_time, 
                        $duration, 
                        $booking_id
                    );
                } else {
                    $tele_sql = "INSERT INTO telemedicine_table (booking_id, patient_id, staff_id, meeting_id, join_url, password, topic, start_time, duration, status) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Scheduled')";
                    $tele_stmt = mysqli_prepare($conn, $tele_sql);
                    if ($tele_stmt === false) {
                        throw new Exception("Failed to prepare telemedicine insert: " . mysqli_error($conn));
                    }
                    $topic = "Virtual Consultation with Patient $patient_id";
                    $duration = 30;
                    mysqli_stmt_bind_param($tele_stmt, "isssssssi", 
                        $booking_id, 
                        $patient_id, 
                        $staff_id, 
                        $meeting_details['id'], 
                        $meeting_details['join_url'], 
                        $meeting_details['password'], 
                        $topic, 
                        $start_time, 
                        $duration
                    );
                }
                if (!mysqli_stmt_execute($tele_stmt)) {
                    throw new Exception("Failed to save Zoom meeting details: " . mysqli_error($conn));
                }
                mysqli_stmt_close($tele_stmt);
            }

            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log("Update appointment failed: " . $e->getMessage());
            return false;
        } finally {
            mysqli_close($conn);
        }
    }

    public function delete_appointment($booking_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in delete_appointment");
            return false;
        }

        try {
            mysqli_begin_transaction($conn);

            $sql = "SELECT timeslot_id FROM booking_table WHERE booking_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt === false) {
                throw new Exception("Failed to prepare timeslot query: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "i", $booking_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $timeslot_id = mysqli_fetch_assoc($result)['timeslot_id'] ?? null;
            mysqli_stmt_close($stmt);

            $delete_sql = "DELETE FROM booking_table WHERE booking_id = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_sql);
            if ($delete_stmt === false) {
                throw new Exception("Failed to prepare delete statement: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($delete_stmt, "i", $booking_id);
            
            if (!mysqli_stmt_execute($delete_stmt)) {
                throw new Exception("Failed to delete appointment: " . mysqli_error($conn));
            }
            mysqli_stmt_close($delete_stmt);

            if ($timeslot_id) {
                $update_sql = "UPDATE appointment_timeslots SET status = 'Available' WHERE timeslot_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                if ($update_stmt === false) {
                    throw new Exception("Failed to prepare timeslot update: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($update_stmt, "i", $timeslot_id);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            }

            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log("Delete appointment failed: " . $e->getMessage());
            return false;
        } finally {
            mysqli_close($conn);
        }
    }

    public function get_appointments($patient_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in get_appointments");
            return [];
        }

        $patient_id = mysqli_real_escape_string($conn, $patient_id);
        
        $sql = "SELECT b.booking_id, b.timeslot_id, CONCAT(s.first_name, ' ', s.last_name) as doctor_name,
                       a.appointment_date as date, t.time_slot as time, b.appointment_type, c.clinic_name, b.status
                FROM booking_table b
                JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                JOIN appointment_table a ON t.appointment_id = a.appointment_id
                JOIN staff_table s ON a.staff_id = s.staff_id
                JOIN clinic_table c ON b.clinic_id = c.clinic_id
                WHERE b.patient_id = ?
                ORDER BY a.appointment_date DESC, t.time_slot DESC";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in get_appointments: " . mysqli_error($conn));
            mysqli_close($conn);
            return [];
        }

        mysqli_stmt_bind_param($stmt, "s", $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result === false) {
            error_log("Query failed in get_appointments: " . mysqli_error($conn));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return [];
        }

        $appointments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $row['appointment_type'] = $row['appointment_type'] === 'In-Person' ? 'In-person' : 'Virtual';
            $appointments[] = $row;
        }
        
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $appointments;
    }

    public function get_appointment($booking_id) {
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in get_appointment");
            return false;
        }

        $booking_id = mysqli_real_escape_string($conn, $booking_id);
        
        $sql = "SELECT b.booking_id, b.timeslot_id, a.staff_id, CONCAT(s.first_name, ' ', s.last_name) as doctor_name,
                       a.appointment_date as date, t.time_slot as time, b.appointment_type, b.clinic_id, c.clinic_name, b.status
                FROM booking_table b
                JOIN appointment_timeslots t ON b.timeslot_id = t.timeslot_id
                JOIN appointment_table a ON t.appointment_id = a.appointment_id
                JOIN staff_table s ON a.staff_id = s.staff_id
                JOIN clinic_table c ON b.clinic_id = c.clinic_id
                WHERE b.booking_id = ?";
                
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Prepare failed in get_appointment: " . mysqli_error($conn));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result === false) {
            error_log("Query failed in get_appointment: " . mysqli_error($conn));
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }

        $appointment = mysqli_fetch_assoc($result);
        
        if ($appointment) {
            $appointment['appointment_type'] = strtolower($appointment['appointment_type']) === 'in-person' ? 'inPerson' : 'virtual';
        }

        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $appointment;
    }
}
?>