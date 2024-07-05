<?php
    include '../Account.php';

    session_start();
    // Check if the user is logged in
    if (empty($_SESSION["logged_in"])) {
        header("Location: login.php");
        exit();
    }
    print_r($_SESSION);
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["sku"])) {
        $productID = htmlspecialchars($_GET["sku"]);
        $userID = $_SESSION['UserID'];
        minusItemFromCart($userID, $productID);
        header("Location: profile.php");
        exit();
    }

    

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     if (isset($_POST["minus"])) {
    //         // echo "THIS IS MINUS";
    //         $id = htmlspecialchars($_POST["p_id"]);
    //         $qty = intval($_POST["qty"]); // Ensure quantity is an integer
    //         $uid = htmlspecialchars($_SESSION["UserID"]);
    //         deleteItemFromCart($uid, $id);
    //         if ($qty < 1) {
    //             deleteItemFromCart($uid, $id);
    //         } else if($qty > 0) {
    //             minusItemFromCart($uid, $id, $qty);
    //         }
    //     } elseif (isset($_POST["plus"])) {
    //         // echo "THIS IS PLUS";
    //         $id = htmlspecialchars($_POST["p_id"]);
    //         $qty = intval($_POST["qty"]); // Ensure quantity is an integer
    //         $uid = htmlspecialchars($_SESSION["UserID"]);
    
    //         if ($qty < 1) {
    //             deleteItemFromCart($uid, $id);
    //         } else {
    //             updateCart($uid, $id, $qty);
    //         }
    //     }
    // }
?>