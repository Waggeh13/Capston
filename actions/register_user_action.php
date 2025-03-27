<?php

include("../settings/core.php");
include("../controllers/customer_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST['email']);

    // Check if email already exists
    if (email_exists_ctr($email)) {
        $response["message"] = "Email already registered. Please use a different email.";
        echo json_encode($response);
        exit();
    }

    $fullName = sanitize_input($_POST['fullName']);
    $phoneNumber = sanitize_input($_POST['phoneNumber']);
    $password = sanitize_input($_POST['newPassword']);
    $country = sanitize_input($_POST['country']);
    $city = sanitize_input($_POST['city']);
    $userRole = sanitize_input($_POST['userRole']);
    $imagePath = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageExtension, $allowedExtensions)) {
            $uploadDir = '../images/';
            $newImageName = uniqid() . '.' . $imageExtension;
            $uploadFilePath = $uploadDir . $newImageName;

            if (move_uploaded_file($imageTmpPath, $uploadFilePath)) {
                $imagePath = $uploadFilePath;
            } else {
                $response["message"] = "Error uploading the image.";
                echo json_encode($response);
                exit();
            }
        } else {
            $response["message"] = "Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed.";
            echo json_encode($response);
            exit();
        }
    }

    $result = add_customer_ctr($fullName, $phoneNumber, $email, $password, $country, $city, $imagePath, $userRole);

    if ($result) {
        $response["success"] = true;
        $response["message"] = "Customer registered successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to register customer. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
