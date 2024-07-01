<?php
// Start the session at the beginning of the script
session_start();

include "Account.php";
// Require necessary files
require_once 'Header.php';
require('components/Header.php');

// Check if the user is logged in
if (empty($_SESSION["logged_in"])) {
    header("Location: account/login.php");
    exit();
}
?>

<?=HeaderStatic("Home")?>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container d-flex justify-content-between px-4 px-lg-5">
                        <picture>
                            <source srcset="https://purebloom.ch/cdn/shop/files/PureBloom_Logo.png?v=1697338824&width=400" media="(min-width: 768px)">
                            <img src="https://purebloom.ch/cdn/shop/files/PureBloom_Logo.png?v=1697338824&width=400" alt="logo">
                        </picture>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#!">All Products</a></li>
                                        <li><hr class="dropdown-divider" /></li>
                                        <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                        <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <?php
                            if(isset($_SESSION["logged_in"])){
                                $firstName = getAccountDetails($_SESSION["email"]);

                                ?>
                                <a href="./account/profile.php" class="mx-2 btn btn-default">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                        <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span><?php echo $firstName["FirstName"] ?></span>
                                </a>
                                <a href="" class="btn">Logout</a>


                                <?php
                            }else{
                                ?>
                                <a href="../account/login/" class="mx-2 btn btn-default">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
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
                                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </nav>

        <!-- Header-->
        <?php
        echo Headers();
        ?>
        
        <!-- Product Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">


                <?php 
                    $products = getAllProducts();

                    foreach($products as $product) {
                    ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="account/<?php echo $product['ProductImage']; ?>" alt="Product Image" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo $product['ProductTitle']; ?></h5>
                                    <!-- Product reviews-->
                                    
                                    <!-- Product price-->
                                    
                                    $<?php echo $product['Price']; ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center add-to-cart" data-product-id="<?php echo $product['ProductID']; ?>"><span class="btn btn-outline-dark mt-auto" href="#">Add to cart</span></div>
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
        include 'components/Footer.php';
        ?>


<!-- Add this script to your index.php -->
<script>
document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const quantity = 1; // Default quantity to add

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'add_to_cart.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Update the cart UI with the response
                        document.getElementById('cart').innerHTML = xhr.responseText;
                    }
                };

                xhr.send('product_id=' + productId + '&quantity=' + quantity);
            });
        });

        function updateQuantity(productId, change) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('cart').innerHTML = xhr.responseText;
                }
            };

            xhr.send('product_id=' + productId + '&change=' + change);
        }

        document.getElementById('cart').addEventListener('click', function(e) {
            if (e.target.classList.contains('increment')) {
                const productId = e.target.dataset.productId;
                updateQuantity(productId, 1);
            } else if (e.target.classList.contains('decrement')) {
                const productId = e.target.dataset.productId;
                updateQuantity(productId, -1);
            }
        });
    });

    const cartBtn = document.getElementById('cartBtn')
    cartBtn.addEventListener("click", ()=>{
        alert("TEST")
        document.querySelector('.cart-container').style.right = "0";
    })
</script>

<!-- Cart container -->
<style>
        .cart-container {
            position: fixed;
            background-color: lightgray;
            height: 100vh;
            z-index: 9999;
            top: 0;
            right: -150%; /* Initially hidden off-screen */
            width: 20%;
            padding: 1rem;
            transition: right 0.3s ease; /* Smooth sliding effect */
        }

        .cart-container.active {
            right: 0; /* Slide in when active */
        }

        ul {
            display: flex;
            flex-direction: column;
            padding: 0;
        }

        ul li {
            list-style-type: none;
            margin: 1rem;
        }

        #checkout {
            background-color: white;
            padding: .5rem;
        }
    </style>

        <div class="cart-container">

            <hr>
            <br>
            <h3 class="text-center">Your Cart</h3>
            <br>
            <hr>
            <div id="cart" class="my_cart">
                <h5>Nothing in your cart</h5>
            </div>
        </div>
    </body>
</html>
