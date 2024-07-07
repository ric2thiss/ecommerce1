<?php
    include '../Account.php';

    session_start();

    // Check if the user is logged in
    if (empty($_SESSION["logged_in"])) {
        header("Location: login.php");
        exit();
    }

    // Sanitize and validate input
    function sanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["sku"])) {
        $productID = sanitizeInput($_GET["sku"]);

        // Validate that $productID is a numeric value or adheres to the expected format
        if (filter_var($productID, FILTER_VALIDATE_INT) === false) {
            // Handle invalid input
            echo "Invalid Product ID.";
            exit();
        }

        $userID = $_SESSION['UserID'];

        minusItemFromCart($userID, $productID);

        header("Location: profile.php");
        exit();
    }

?>
