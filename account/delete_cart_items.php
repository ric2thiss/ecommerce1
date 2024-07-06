<?php
    session_start();
    include '../Account.php';
    // Check if user is logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: login.php');
        exit();
    }
    // Save first the items to orders before deleting to the cart
    $userID = $_SESSION["UserID"];

    if(saveCartItemsToOrders($userID)){
        deleteAllItemsFromMyCart();
        header("Location: profile.php");
        exit();
    }else {
        header('Location: error.php');
        exit();
    }

?>
