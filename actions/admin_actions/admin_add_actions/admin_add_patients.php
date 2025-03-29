<?php

include("../settings/core.php");
include("../controllers/admin_controllers/admin_patient_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientId = sanitize_input($_POST['patientId']);

    // Check if email already exists
    if (ID_exists_ctr($patientId)) {
        $response["message"] = "ID already registered. Please Verify.";
        echo json_encode($response);
        exit();
    }

    $patientId = sanitize_input($_POST['patientId']);
    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $dob = sanitize_input($_POST['dob']);
    $weight = sanitize_input($_POST['weight']);
    $contact = sanitize_input($_POST['contact']);
    $gender = sanitize_input($_POST['gender']);
    $nextOfKin= sanitize_input($_POST['nextOfKin']);
    $nextOfKinContact = sanitize_input($_POST['nextOfKinContact']);
    $nextOfKinGender = sanitize_input($_POST['nextOfKinGender']);
    $nextOfKinRelationship = sanitize_input($_POST['nextOfKinRelationship']);
    $password = sanitize_input($_POST['newPassword']);
    $address = sanitize_input($_POST['address']);
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
