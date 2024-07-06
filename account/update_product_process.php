<?php
require_once '../Header.php';
require_once '../Account.php';

session_start();

// Get user details
$user = getAccountDetails($_SESSION["email"]);

function isAdmin($user) {
    return isset($user["Role"]);
}

function redirectIfNotAdmin($user) {
    if (!isAdmin($user)) {
        header("Location: ../unauthorized.php");
        exit();
    }
}

// Check if the user is an admin
if (!isAdmin($user)) {
    header("Location: ../unauthorized.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productID = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);
    $productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_STRING);
    $productDescription = filter_input(INPUT_POST, 'productDescription', FILTER_SANITIZE_STRING);
    $productPrice = filter_input(INPUT_POST, 'productPrice', FILTER_VALIDATE_FLOAT);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

    // File upload handling
    $productImage = $_FILES['productImage']['name'];
    $uploadDirectory = 'uploads/'; 
    $targetFile = $uploadDirectory . $productImage;


    // Validate file upload
    if ($_FILES['productImage']['error'] == UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES['productImage']['tmp_name'], $uploadDirectory . $productImage);
    } else {
        $targetFile = filter_input(INPUT_POST, 'currentProductImage', FILTER_SANITIZE_STRING);
    }

    if ($productID && $productName && $productDescription && $productPrice !== false && $stock !== false) {
        $conn = dbconn();
        try {
            $stmt = $conn->prepare("UPDATE product SET ProductTitle = :productName, ProductDescription = :productDescription, Price = :productPrice, Stock = :stock, ProductImage = :productImage WHERE ProductID = :productID");
            $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
            $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
            $stmt->bindParam(':productDescription', $productDescription, PDO::PARAM_STR);
            $stmt->bindParam(':productPrice', $productPrice, PDO::PARAM_STR);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':productImage', $targetFile, PDO::PARAM_STR);
            $stmt->execute();

            header("Location: product_list.php");
            exit();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            header("Location: ../error.php");
            exit();
        }
    } else {
        header("Location: ../invalid_input.php");
        exit();
    }
} else {
    header("Location: ../invalid_request.php");
    exit();
}
?>
