<?php
require_once('DB.php');

    function Create_Account() {
        $conn = dbconn();
        $msg = '';

        $firstname = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
        $lastname = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = 'Invalid email format.';
            return $msg;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $conn->beginTransaction();
            $stmt_check = $conn->prepare('SELECT COUNT(*) FROM users WHERE Email = ?');
            $stmt_check->execute([$email]);
            $count = $stmt_check->fetchColumn();

            if ($count > 0) {
                $msg = 'An account with the provided email already exists.';
                $conn->rollBack();
                return $msg;
            }

            $stmt_insert = $conn->prepare('INSERT INTO users (FirstName, LastName, Email, Contact, Password) VALUES (?, ?, ?, ?, ?)');
            $success = $stmt_insert->execute([$firstname, $lastname, $email, $contact, $hashed_password]);

            if ($success) {
                $conn->commit();
                $msg = 'Account Created Successfully!';
                echo "
                <script>
                setTimeout(function() {
                    window.location.href = '../login.php'; // Redirect to login page
                }, 3000); // 3000 milliseconds = 3 seconds
                </script>";
            } else {
                $conn->rollBack();
                $msg = 'Error creating Account.';
            }

        } catch (PDOException $e) {
            $msg = 'Database Error: ' . $e->getMessage();
            $conn->rollBack();
        }

        return $msg;
    }

    function Validate_Login($email, $password) {
        $conn = dbconn();

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if (password_verify($password, $user['Password'])) {
                    return true;
                } else {
                    error_log("Invalid password for email: " . $email);
                    return false;
                }
            } else {
                error_log("User not found for email: " . $email);
                return false;
            }
        } catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    function getAccountDetails($email) {
        $conn = dbconn();

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;

        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }

    function getAllProducts(){
        $conn = dbconn();
        try {
            $stmt = $conn->prepare("SELECT * FROM product ORDER BY ProductID DESC");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }

    }
    function getRandomProducts() {
        $conn = dbconn();
        try {
            $stmt = $conn->prepare("SELECT * FROM product ORDER BY RAND() LIMIT 4");
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
    
    function addToCart() {
        $conn = dbconn();
        $productID = $_POST['productID'];
        $userID = $_POST['userID'];
        $quantity = $_POST['quantity'];
        
        try {
            $stmt = $conn->prepare("INSERT INTO carts (ProductID, UserID, Quantity)
                                    VALUES (:productID, :userID, :quantity)");
            $stmt->bindParam(':productID', $productID);
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    
    function getCart() {
        $conn = dbconn();
        $userID = $_SESSION['UserID'];
        
        try {
            $stmt = $conn->prepare("SELECT * FROM carts WHERE UserID = :userID");
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $cart;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
    
    function getCartCount() {
        $conn = dbconn();
        $userID = $_SESSION['UserID'];
        
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM carts WHERE UserID = :userID");
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
    
    function deleteFromCart($cartID) {
        $conn = dbconn();
        
        try {
            $stmt = $conn->prepare("DELETE FROM carts WHERE CartID = :cartID");
            $stmt->bindParam(':cartID', $cartID);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    function getSpecificProductbyID($productID) {
        $conn = dbconn();
        
        try {
            $stmt = $conn->prepare("SELECT ProductTitle, Price, ProductImage, ProductDescription FROM product WHERE ProductID = :productID");
            $stmt->bindParam(':productID', $productID);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return $product;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }

    function getHighestCartCount() {
        $conn = dbconn();
    
        try {
            $stmt = $conn->prepare("
                SELECT productID, COUNT(productID) AS cart_count
                FROM carts
                GROUP BY productID
                ORDER BY cart_count DESC
                LIMIT 1;
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn = null;
            return $result;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
    function getOutOfStockProducts() {
        $conn = dbconn();
    
        try {
            $stmt = $conn->prepare("
                SELECT *
                FROM products
                WHERE Stock <= 0
            ");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $conn = null;
            return $results;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }

    function countOutOfStockProducts() {
        $conn = dbconn();
    
        try {
            $stmt = $conn->prepare("
                SELECT COUNT(*) AS out_of_stock_count
                FROM product
                WHERE Stock <= 0
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn = null;
            return $result['out_of_stock_count'];
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        }
    }
    function countAvailableProducts() {
        $conn = dbconn();
    
        try {
            $stmt = $conn->prepare("
                SELECT COUNT(*) AS available_stock_count
                FROM product
                WHERE Stock > 0
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn = null;
            return $result['available_stock_count'];
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        }
    }
    function countUsersReg() {
        $conn = dbconn();
    
        try {
            $stmt = $conn->prepare("
                SELECT COUNT(UserID) AS user_count
                FROM users
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn = null;
            return $result['user_count'];
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0; // Return 0 on error
        }
    }
    
    
    


?>
