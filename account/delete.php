<?php
include '../Account.php';

session_start();


if (empty($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}


// Function to check if the user is an admin
function isAdmin($user) {
    return $user["Role"];
}

// Redirect to a different page if the user is not an admin
function redirectIfNotAdmin($user) {
    if (!isAdmin($user)) {
        header("Location: ../unauthorized.php");
        exit();
    }
}

// Get user details
$user = getAccountDetails($_SESSION["email"]);

// Check if the user is an admin
redirectIfNotAdmin($user);

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["productID"])) {

    $productID = sanitizeInput($_GET["productID"]);


    if (deleteSpecificProductbyID($productID)) {
        header("Location: product_list.php");
        exit();
    } else {
        echo "Error deleting product.";

    }
}
?>
