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
                    window.location.href = './login.php'; // Redirect to login page
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
            // Fetch the product price
            $stmt = $conn->prepare("SELECT Price FROM product WHERE ProductID = :productID");
            $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$product) {
                throw new Exception("Product not found.");
            }
            
            $price = $product['Price'];
            $totalPrice = $price * $quantity;
            
            // Check if the product already exists in the cart
            $stmt = $conn->prepare("SELECT * FROM carts WHERE ProductID = :productID AND UserID = :userID");
            $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                // Product already exists, update the quantity and total price
                $newQuantity = $row['Quantity'] + $quantity;
                $newTotalPrice = $price * $newQuantity;
                
                $updateStmt = $conn->prepare("UPDATE carts SET Quantity = :newQuantity, TotalPrice = :newTotalPrice WHERE ProductID = :productID AND UserID = :userID");
                $updateStmt->bindParam(':newQuantity', $newQuantity, PDO::PARAM_INT);
                $updateStmt->bindParam(':newTotalPrice', $newTotalPrice, PDO::PARAM_STR);
                $updateStmt->bindParam(':productID', $productID, PDO::PARAM_INT);
                $updateStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                $updateStmt->execute();
            } else {
                // Product doesn't exist, insert new record
                $insertStmt = $conn->prepare("INSERT INTO carts (ProductID, UserID, Quantity, TotalPrice) VALUES (:productID, :userID, :quantity, :totalPrice)");
                $insertStmt->bindParam(':productID', $productID, PDO::PARAM_INT);
                $insertStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $insertStmt->bindParam(':totalPrice', $totalPrice, PDO::PARAM_STR);
                $insertStmt->execute();
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }    
    
    function getCart() {
        $conn = dbconn();
        $userID = $_SESSION['UserID'];
        
        try {
            $stmt = $conn->prepare("SELECT * FROM carts WHERE UserID = :userID AND Quantity >=1 ORDER BY CartID ASC");
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $cart;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
    function deleteAllItemsFromMyCart() {
        // Establish database connection
        $conn = dbconn();
        
        // Check if userID is set in session
        if (!isset($_SESSION['UserID'])) {
            return ['status' => 'error', 'message' => 'User ID not set in session.'];
        }
        
        $userID = $_SESSION['UserID']; 
        
        try {
            // Prepare the SQL statement
            $stmt = $conn->prepare("DELETE FROM carts WHERE UserID = :userID");
            
            // Bind parameters
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT); // Assuming UserID is an integer
            
            // Execute the statement
            $stmt->execute();
    
            // Check if any rows were affected
            $rowCount = $stmt->rowCount();
            
            // Return true if deletion was successful and at least one row was affected
            return $rowCount > 0;
        } catch (PDOException $e) {
            // Log the error
            error_log("Database Error: " . $e->getMessage());
            
            // Return an error message
            return ['status' => 'error', 'message' => 'Failed to delete items from cart.'];
        }
    }
    
    
    
    function getCartCount() {
        $conn = dbconn();
        $userID = $_SESSION['UserID'];
        
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM carts WHERE UserID = :userID AND Quantity >=1");
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
    function updateCart($UserID, $ProductID) {
        try {
            $conn = dbconn();
            
            // Begin transaction
            $conn->beginTransaction();
    
            // Increment quantity by 1
            $stmt = $conn->prepare("
                UPDATE carts
                SET Quantity = Quantity + 1
                WHERE UserID = :UserID AND ProductID = :ProductID
            ");
            $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
            $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt->execute();
    
            // Get the updated quantity and price
            $stmt = $conn->prepare("
                SELECT Quantity, Price
                FROM carts
                JOIN product ON carts.ProductID = product.ProductID
                WHERE UserID = :UserID AND carts.ProductID = :ProductID
            ");
            $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
            $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $quantity = $result['Quantity'];
                $price = $result['Price'];
                $totalPrice = $price * $quantity;
    
                // Update the total price in the cart
                $stmt = $conn->prepare("
                    UPDATE carts
                    SET TotalPrice = :TotalPrice
                    WHERE UserID = :UserID AND ProductID = :ProductID
                ");
                $stmt->bindParam(':TotalPrice', $totalPrice, PDO::PARAM_STR);
                $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
                $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
                $stmt->execute();
    
                // Commit transaction
                $conn->commit();
    
                echo "Updated Successfully!";
            } else {
                echo "No matching record found!";
            }
    
            // Close the connection
            $conn = null;
        } catch (PDOException $e) {
            // Rollback transaction in case of error
            if ($conn) {
                $conn->rollBack();
            }
            echo "Error: " . $e->getMessage();
        }
    }
    
    function minusItemFromCart($UserID, $ProductID) {
        try {
            $conn = dbconn();
            
            // Start transaction
            $conn->beginTransaction();
            
            // Update the quantity
            $stmt = $conn->prepare("
                UPDATE carts
                SET Quantity = Quantity - 1
                WHERE UserID = :UserID AND ProductID = :ProductID
            ");
            $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
            $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt->execute();
            
            // Check the new quantity and get the price
            $stmt = $conn->prepare("
                SELECT Quantity, Price
                FROM carts
                JOIN product ON carts.ProductID = product.ProductID
                WHERE UserID = :UserID AND carts.ProductID = :ProductID
            ");
            $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['Quantity'] < 1) {
                // Delete the item if quantity is less than 1
                $stmt = $conn->prepare("
                    DELETE FROM carts
                    WHERE UserID = :UserID AND ProductID = :ProductID
                ");
                $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
                $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                // Calculate the new total price
                $totalPrice = $result['Price'] * $result['Quantity'];
                
                // Update the total price in the cart
                $stmt = $conn->prepare("
                    UPDATE carts
                    SET TotalPrice = :TotalPrice
                    WHERE UserID = :UserID AND ProductID = :ProductID
                ");
                $stmt->bindParam(':TotalPrice', $totalPrice, PDO::PARAM_STR);
                $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
                $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
                $stmt->execute();
            }
    
            // Commit transaction
            $conn->commit();
            
            // Close the connection
            $conn = null;
    
            echo "Updated Successfully!";
        } catch (PDOException $e) {
            // Rollback transaction in case of error
            if ($conn) {
                $conn->rollBack();
            }
            echo "Error: " . $e->getMessage();
        }
    }
    
//     function deleteItemFromCart($UserID, $ProductID) {
//     try {
//         $conn = dbconn();
        
//         // Prepare the DELETE statement with the condition
//         $stmt = $conn->prepare("
//             DELETE FROM carts
//             WHERE UserID = :UserID AND ProductID = :ProductID AND Quantity < 1
//         ");
//         $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
//         $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
//         $stmt->execute();

//         // Check if any rows were affected
//         $rowsAffected = $stmt->rowCount();
//         if ($rowsAffected > 0) {
//             // echo "Deleted Successfully because Quantity was less than 1!";
//         } else {
//             // echo "No items deleted because Quantity was not less than 1 or item not found.";
//         }

//         // Close the connection
//         $conn = null;
//     } catch (PDOException $e) {
//         echo "Error: " . $e->getMessage();
//     }
// }
?>
