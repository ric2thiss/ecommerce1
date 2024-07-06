<?php
require_once('../DB.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = dbconn();

    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $image = $_FILES['image'] ?? null;

    if (empty($title) || empty($description) || empty($price) || empty($stock) || !$image) {
        echo "All fields are required.";
        exit;
    }

    // Ensure the uploads directory exists
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Validate and move the uploaded image
    $targetFile = $targetDir . basename($image['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $validExtensions = array("jpg", "jpeg", "png");

    if (!in_array($imageFileType, $validExtensions)) {
        echo "Only JPG, JPEG, and PNG files are allowed.";
        exit;
    }

    if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
        echo "There was an error uploading your file.";
        exit;
    }

    try {
        $stmt = $conn->prepare('INSERT INTO product (ProductTitle, ProductDescription, Price, Stock, ProductImage) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$title, $description, $price, $stock, $targetFile]);

        echo "<p>Product added successfully!<i style='font-size: 1rem;' class='fa-solid fa-circle-check'></i></p>";
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
