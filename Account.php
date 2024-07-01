<?php
require_once('DB.php');

    function Create_Account() {
        $conn = dbconn();
        $msg = '';

        // Validate input and sanitize if necessary
        $firstname = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
        $lastname = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = 'Invalid email format.';
            return $msg;
        }

        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Begin transaction for atomicity
            $conn->beginTransaction();

            // Check if the account already exists based on email
            $stmt_check = $conn->prepare('SELECT COUNT(*) FROM users WHERE Email = ?');
            $stmt_check->execute([$email]);
            $count = $stmt_check->fetchColumn();

            if ($count > 0) {
                // Account already exists, rollback transaction and return error
                $msg = 'An account with the provided email already exists.';
                $conn->rollBack();
                return $msg;
            }

            // Prepare and execute the SQL statement using a prepared statement
            $stmt_insert = $conn->prepare('INSERT INTO users (FirstName, LastName, Email, Contact, Password) VALUES (?, ?, ?, ?, ?)');
            $success = $stmt_insert->execute([$firstname, $lastname, $email, $contact, $hashed_password]);

            if ($success) {
                // Commit transaction if successful
                $conn->commit();
                $msg = 'Account Created Successfully!';
                echo "
                <script>
                setTimeout(function() {
                    window.location.href = '../login.php'; // Redirect to login page
                }, 3000); // 3000 milliseconds = 3 seconds
                </script>";
            } else {
                // Handle the error, rollback transaction on failure
                $conn->rollBack();
                $msg = 'Error creating Account.';
            }

        } catch (PDOException $e) {
            // Handle PDO exceptions
            $msg = 'Database Error: ' . $e->getMessage();
            $conn->rollBack();
        }

        return $msg;
    }

    // Example function to validate login credentials
    function Validate_Login($email, $password) {
        $conn = dbconn(); // Connect to the database

        try {
            // Prepare SQL statement to fetch user details by email
            $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
            $stmt->execute([$email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password
                if (password_verify($password, $user['Password'])) {
                    // Password matches, login successful
                    return true;
                } else {
                    // Invalid password
                    error_log("Invalid password for email: " . $email);
                    return false;
                }
            } else {
                // User not found with the given email
                error_log("User not found for email: " . $email);
                return false;
            }

        } catch(PDOException $e) {
            // Handle database connection or query errors
            // You can log the error or display a generic message to the user
            error_log("Database Error: " . $e->getMessage());
            return false;
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

    function getAllProducts(){
        $conn = dbconn();
        try {
            $stmt = $conn->prepare("SELECT * FROM product");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }

    }

    function getAllProductCount(){
        $conn = dbconn();
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM product");
            $stmt->execute();
            $count = $stmt->fetchColumn();
        return $count;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }

    }


?>
