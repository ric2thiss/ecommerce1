<?php
    session_start();
    include '../Account.php';
    // Check if user is logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: login.php');
        exit();
    }

    // Attempt to delete all items from the cart
    $result = deleteAllItemsFromMyCart();

    if ($result === true) {
        // Successful deletion, redirect to profile page
        header('Location: profile.php');
        exit();
    } else {
        // Error occurred, handle it accordingly (optional)
        // For example, you can redirect to an error page or display a message
        header('Location: error.php');
        exit();
    }
?>
