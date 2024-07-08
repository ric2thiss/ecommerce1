<?php
    include '../Header.php';

    include '../Account.php'; 

    session_start();

    $login_error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Validate_Login($email, $password)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            
            $mail = getAccountDetails($email);
            
            // Ensure $mail contains the UserID key
            if (isset($mail['UserID'])) {
                $_SESSION['UserID'] = $mail['UserID'];
            } else {
                // Handle the case where UserID is not set in $mail
                $login_error = 'User details not found. Please contact support.';
            }
            
            // Redirect to dashboard or any other page after successful login
            header('Location: profile.php');
            exit;
        } else {
            // Handle invalid credentials scenario
            $login_error = 'Invalid email or password. Please try again.';
        }
    }

    if (!empty($_SESSION["email"]) && $_SESSION["logged_in"]) {
        header('Location: profile.php');
        exit;
    }

?>