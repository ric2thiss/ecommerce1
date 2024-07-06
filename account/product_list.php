<?php
require_once '../Header.php';
require('../components/Navbar.php');

session_start();

// Function to check if the user is an admin
function isAdmin($user) {
    return isset($user["Role"]);
}

// Redirect to a different page if the user is not an admin
function redirectIfNotAdmin($user) {
    if (!isAdmin($user)) {
        header("Location: ../unauthorized.php");
        exit();
    }
}

// Get user details
$user = getAccountDetails($_SESSION["email"]);

// Check if the user is an admin
redirectIfNotAdmin($user);

function calculateTotalAmount($cartItems) {
    $totalAmount = 0;
    foreach ($cartItems as $item) {
        $product = getSpecificProductbyID($item['ProductID']);
        if ($product) {
            $totalAmount += $product['Price'] * $item['Quantity'];
        }
    }
    return $totalAmount;
}

function calculateTotalPrice($price, $quantity) {
    return $price * $quantity;
}
?>

<?=HeaderStatic($user["FirstName"] . " - Product Management")?>
<body>
    <!-- Navigation-->
    <?php echo Navbar(); ?>
    <!-- Header-->

    <style>
        .profile_details {
            display: flex;
            align-items: center;
        }
    </style>
    <div class="container p-5 mt-5 mb-5" style="background-color: #FE9FB3;">
        <div class="profile_details text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="white" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
            <div class="p-2">
                <h3><?php echo $user["FirstName"] . " " . $user["LastName"]; ?></h3>
                <span><?php echo isAdmin($user) ? "Admin" : "Member"; ?> since <?php echo $user["RegDate"]; ?></span>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>Product List</h1>
        <hr>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Date/Time Uploaded</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                   $products = getAllProducts();
                   foreach($products as $product){
                    echo "<tr>";
                    echo "<td>" . $product["ProductID"] . "</td>";
                    echo "<td>" . $product["ProductTitle"] . "</td>";
                    echo "<td>" . $product["ProductDescription"] . "</td>";
                    echo "<td>" . $product["Price"] . "</td>";
                    echo "<td><img src='". $product["ProductImage"] . "' width='100' height='100'></td>";
                    echo "<td>" . $product["ProductReg"] . "</td>";
                    echo "<td>" . $product["Stock"] . "</td>";
                    echo "<td><a href='edit_product.php?productID=" . $product["ProductID"] . "' class='btn btn-primary'>Edit</a></td>";
                    echo "<td><a href='delete.php?productID=" . $product["ProductID"] . "' class='btn btn-danger'>Delete</a></td>";
                    echo "</tr>";
                   }
                ?>
            </tbody>
        </table>
        
    </div>
    <?php include '../components/Footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
