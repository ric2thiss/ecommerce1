<?php
require_once '../Header.php';
require('../components/Navbar.php');

session_start();


function isAdmin($user) {
    return isset($user["Role"]);
}


function redirectIfNotAdmin($user) {
    if (!isAdmin($user)) {
        header("Location: ../unauthorized.php");
        exit();
    }
}


$user = getAccountDetails($_SESSION["email"]);


redirectIfNotAdmin($user);


if (!isset($_GET["productID"]) || !filter_var($_GET["productID"], FILTER_VALIDATE_INT)) {
    header("Location: ../invalid_request.php");
    exit();
}

$productID = intval($_GET["productID"]);
$product = getSpecificProductbyID($productID);

if (!$product) {
    header("Location: ../product_not_found.php");
    exit();
}
?>

<?=HeaderStatic($user["FirstName"] . " - Update Product Management")?>
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
                <h3><?php echo htmlspecialchars($user["FirstName"] . " " . $user["LastName"]); ?></h3>
                <span><?php echo isAdmin($user) ? "Admin" : "Member"; ?> since <?php echo htmlspecialchars($user["RegDate"]); ?></span>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>Update Product</h1>
        <hr>
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <form action="update_product_process.php" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="hidden" name="productID" value="<?= htmlspecialchars($productID) ?>">
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Product" value="<?= htmlspecialchars($product["ProductTitle"]) ?>" required>
                            <label for="productName">Product Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="productDescription" name="productDescription" placeholder="Description" value="<?= htmlspecialchars($product["ProductDescription"]) ?>" required>
                            <label for="productDescription">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" step="0.01" class="form-control" id="productPrice" name="productPrice" placeholder="Price" value="<?= htmlspecialchars(number_format($product["Price"], 2)) ?>" required>
                            <label for="productPrice">Price</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="stock" value="<?= htmlspecialchars($product["Stock"]) ?>" required>
                            <label for="productPrice">Stock</label>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Image</label>
                            <input type="hidden" name="currentProductImage" value="<?= htmlspecialchars($product["ProductImage"]) ?>">
                            <input class="form-control" type="file" id="formFile" name="productImage">
                        </div>
                        <a href="javascript:history.back()" class="btn btn-outline-dark">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
                <div class="col-lg-6 mb-3">
                    <h5>Product Card</h5>
                    <hr>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?= htmlspecialchars($product["ProductImage"]) ?>" class="img-fluid rounded-start" alt="Product Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product["ProductTitle"]) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($product["ProductDescription"]) ?></p>
                                    <p class="card-text"><strong>Price: </strong><?= htmlspecialchars($product["Price"]) ?></p>
                                    <p class="card-text"><small class="text-muted">Uploaded on <?= htmlspecialchars($product["ProductReg"]) ?></small></p>
                                    <p class="card-text"><small class="text-muted">Available Stock: <?= htmlspecialchars($product["Stock"]) ?></small></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex gap-2 align-items-center justify-content-center p-4 pt-0 border-top-0 bg-transparent">
                            <div>
                                <input type="hidden" name="pID" value="<?= $product['ProductID']; ?>">
                                <button class="btn btn-outline-dark mt-auto" type="submit">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> View
                                </button>
                            </div>
                            <div>
                                <input type="hidden" name="productID" value="<?= $product['ProductID']; ?>">
                                <input type="hidden" name="userID" value="<?= $_SESSION['UserID']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <?php if (!$product['Stock']) : ?>
                                    <button class="btn btn-outline-dark mt-auto" disabled>
                                        <i class="fa-solid fa-cart-plus"></i> No Stock
                                    </button>
                                <?php else : ?>
                                    <button class="btn btn-outline-dark mt-auto" type="submit">
                                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../components/Footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
