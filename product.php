<?php
// Start the session at the beginning of the script
session_start();

include "Account.php";
// Require necessary files
require_once 'Header.php';
require_once 'components/Header.php';

// Check if the user is logged in
if (empty($_SESSION["logged_in"])) {
    header("Location: account/login.php");
    exit();
}
// Adding cart in specified product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_Cart'])) {
        $_productID = $_POST["productID"] ?? '';
        $_userID = $_POST["userID"] ?? '';
        $_quantity = $_POST["quantity"] ?? '';

        if (!empty($_productID) && !empty($_userID) && !empty($_quantity)) {
            addToCart();
        } else {
            header("Location: index.php");
            exit();
        }
    } elseif (isset($_POST['add_to_cart'])) {
        $_productID = $_POST["productID"] ?? '';
        $_userID = $_POST["userID"] ?? '';
        $_quantity = $_POST["quantity"] ?? '';

        if (!empty($_productID) && !empty($_userID) && !empty($_quantity)) {
            addToCart();
        } else {
            echo "<script>alert('Product is not available or out of stock!')</script>";
        }
    }
}

// Set or retrieve pID from session or POST
if (isset($_POST["pID"])) {
    $_SESSION["pID"] = $_POST["pID"];
} elseif (isset($_SESSION["pID"])) {
    $_POST["pID"] = $_SESSION["pID"];
} else {
    echo "No product ID specified.";
    exit();
}

// Get specific product by ID
$product = getSpecificProductbyID($_POST["pID"]);
?>

<?= HeaderStatic("Product") ?>

<?php
if (!empty($_POST["pID"])) {
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container d-flex justify-content-between px-4 px-lg-5">
            <a href="index.php">
                <picture>
                    <source srcset="https://purebloom.ch/cdn/shop/files/PureBloom_Logo.png?v=1697338824&width=400" media="(min-width: 768px)">
                    <img src="https://purebloom.ch/cdn/shop/files/PureBloom_Logo.png?v=1697338824&width=400" alt="logo">
                </picture>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                </ul>

                <?php
                if (isset($_SESSION["logged_in"])) {
                    $firstName = getAccountDetails($_SESSION["email"]);
                ?>
                    <a href="./account/profile.php" class="mx-2 btn btn-default">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                            <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                        </svg>
                        <span><?php echo htmlspecialchars($firstName["FirstName"]); ?></span>
                    </a>
                    <a href="logout.php" class="btn">Logout</a>
                <?php
                } else {
                ?>
                    <a href="../account/login.php" class="mx-2 btn btn-default">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                            <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                        </svg>
                        <span>Log In</span>
                    </a>
                <?php
                }
                ?>
                <div class="d-flex" id="cartBtn">
                    <div class="btn btn-outline-dark">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?= getCartCount() ?></span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="account/<?php echo htmlspecialchars($product["ProductImage"]); ?>" alt="Product Image" /></div>
                <div class="col-md-6">
                    <div class="small mb-1">SKU: <?php echo htmlspecialchars($_POST["pID"]); ?></div>
                    <h1 class="display-5 fw-bolder"><?php echo htmlspecialchars($product["ProductTitle"]); ?></h1>
                    <div class="fs-5 mb-5">
                        <span class="text-decoration-line-through">$ <?php echo htmlspecialchars($product["Price"]); ?></span>
                        <span>$ <?php echo htmlspecialchars($product["Price"]); ?></span>
                    </div>
                    <p class="lead"><?php echo htmlspecialchars($product["ProductDescription"]); ?></p>
                    <div class="d-flex">
                        <!-- Can you make this add to cart button working without contradicting any other codes? -->
                        <form class="d-flex" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

                            <input type="hidden" name="productID" value="<?php echo htmlspecialchars($relatedProduct['ProductID']); ?>">
                            <input type="hidden" name="userID" value="<?php echo htmlspecialchars($_SESSION['UserID']); ?>">
                            <input class="form-control text-center me-3"  style="max-width: 3rem" type="num" name="quantity" value="1">
                            <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="add_Cart">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related items section-->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Related products</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $relatedProducts = getRandomProducts(); // Assuming this function exists and returns 4 random products
                foreach ($relatedProducts as $relatedProduct) {
                ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" style="border-bottom: 1px solid gray;" src="account/<?php echo htmlspecialchars($relatedProduct['ProductImage']); ?>" alt="Product Image" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <div class="d-flex justify-content-between flex-column align-items-center">
                                        <h5 class="fw-bolder text-start"><?php echo htmlspecialchars($relatedProduct['ProductTitle']); ?></h5>
                                        <span>₱ <?php echo htmlspecialchars($relatedProduct['Price']); ?></span>
                                    </div>
                                    <hr>
                                    <p class="text-end" style="font-size: 12px!important;margin-top:-13px;">Available Stock (<?php echo htmlspecialchars($relatedProduct['Stock']); ?>)</p>
                                    <hr>
                                    <div class="text-start" style="font-size: 12px!important;display:flex;flex-direction:column;">
                                        <span>Description:</span>
                                        <span style="width: 100%;">
                                            <?php echo htmlspecialchars($relatedProduct['ProductDescription']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer d-flex gap-2 align-items-center justify-content-center p-4 pt-0 border-top-0 bg-transparent">
                                <form action="product.php" method="POST">
                                    <input type="hidden" name="pID" value="<?php echo htmlspecialchars($relatedProduct['ProductID']); ?>">
                                    <button class="btn btn-outline-dark mt-auto" type="submit">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> View
                                    </button>
                                </form>
                                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <input type="hidden" name="productID" value="<?php echo htmlspecialchars($relatedProduct['ProductID']); ?>">
                                    <input type="hidden" name="userID" value="<?php echo htmlspecialchars($_SESSION['UserID']); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="btn btn-outline-dark mt-auto" type="submit" name="add_to_cart">
                                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
} else {
    header("Location: index.php");
}
?>

<?php require('components/Footer.php'); ?>
