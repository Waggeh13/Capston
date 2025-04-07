<?php

include("../controllers/lab_form_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_title = sanitize_input($_POST['product-title']);
    $price = sanitize_input($_POST['productprice']);
    $description = sanitize_input($_POST['description']);
    $category = sanitize_input($_POST['product_cat']);
    $brand = sanitize_input($_POST['productbrand']);
    $keywords = sanitize_input($_POST['product_keyword']);


    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageExtension, $allowedExtensions)) {
            $uploadDir = '../images/product/';
            $newImageName = uniqid() . '.' . $imageExtension;
            $uploadFilePath = $uploadDir . $newImageName;

            if (move_uploaded_file($imageTmpPath, $uploadFilePath)) {
                $imagePath = $newImageName;
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
    } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $response["message"] = "Error uploading the image: " . $_FILES['image']['error'];
        echo json_encode($response);
        exit();
    }


    $result = addProductController($product_title, $brand, $category, $price, $description, $imagePath, $keywords);

    if ($result !== false) {
        header("Location: ../view/viewproduct.php");
        exit();
    } else {
        echo "Failed to add the product. Please try again.";
    }
} else {
    $response["success"] = false;
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
