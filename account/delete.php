<?php
include '../Account.php';

session_start();


if (empty($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}


function isAdmin($user) {
    return isset($user["Role"]); 
}


function redirectIfNotAdmin($user) {
    if (!isAdmin($user)) {
        header("Location: ../unauthorized.php");
        exit();
    }
}


$user = getAccountDetails($_SESSION["email"]);

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
