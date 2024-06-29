<?php
require_once('DB.php');

    function SecureRoute() {
        session_start(); // Start the session

        // Check if the user is logged in
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: login.php'); // Redirect to the login page
            exit(); // Ensure no further code is executed
        }
    }

    function getAccountDetails($email) {
        $conn = dbconn();

        try {
            // Prepare SQL statement to fetch user details by email
            $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
            $stmt->execute([$email]);

            // Fetch the user details
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Return the user details
            return $user;

        } catch (PDOException $e) {
            // Handle database connection or query errors
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }


?>
