<?php
require_once("../settings/db_class.php");

class ZoomCallback extends db_connection {
    private $zoom_client_id = 'JWxNJ_siTs6WKTBZZ9IFw';
    private $zoom_client_secret = 'DNxXbSOv70Md8i5ohHgazs6ooxDuuGTW';
    private $redirect_uri = 'https://96b3-154-161-170-39.ngrok-free.app/capston/utils/zoom-callback.php';

    public function handleCallback() {
        error_log("Zoom callback invoked");
        if (!isset($_GET['code'])) {
            error_log("Authorization code not provided");
            die("Authorization code not provided.");
        }

        $code = $_GET['code'];
        error_log("Received authorization code: $code");
        $url = 'https://zoom.us/oauth/token';
        $data = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirect_uri
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
            error_log("Failed to exchange authorization code: $error_message");
            die("Failed to exchange authorization code for token: $error_message");
        }

        $token = json_decode($result, true);
        if (!isset($token['access_token'])) {
            error_log("Failed to obtain access token: " . json_encode($token));
            die("Failed to obtain access token: " . json_encode($token));
        }

        error_log("Access token obtained: " . $token['access_token']);
        // Store token in database
        $conn = $this->db_conn();
        if ($conn === false) {
            error_log("Database connection failed in Zoom callback");
            die("Database connection failed.");
        }

        $expires_at = date('Y-m-d H:i:s', time() + $token['expires_in']);
        $sql = "INSERT INTO token_table (access_token, refresh_token, expires_at) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE access_token = ?, refresh_token = ?, expires_at = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            error_log("Failed to prepare token insert: " . mysqli_error($conn));
            die("Failed to prepare token insert: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "ssssss", 
            $token['access_token'], 
            $token['refresh_token'], 
            $expires_at, 
            $token['access_token'], 
            $token['refresh_token'], 
            $expires_at
        );
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Failed to store token: " . mysqli_error($conn));
            die("Failed to store token: " . mysqli_error($conn));
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        error_log("Zoom token stored successfully");

        // Redirect to appointment page
        header("Location: ../view/patient_appointments.php");
        exit();
    }
}

$callback = new ZoomCallback();
$callback->handleCallback();
?>