
<?php
    // Require
    require_once '../Header.php';
    require('../components/Navbar.php');
    session_start();
    $user = getAccountDetails($_SESSION["email"]);

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

<?=HeaderStatic($user["FirstName"] . " - Profile")?>
    <body>
        <!-- Navigation-->
        <?php  
        echo Navbar();
        
        ?>
        <!-- Header-->

        <style>
            .profile_details{
                display: flex;
                align-items: center;
            }
            #alert-success-product {
            display: none;
            position: fixed;
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%);
            padding: 15px;
            background-color: #5cb85c;
            color: white; 
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            z-index: 9999;
            text-align: center; 
            max-width: 300px; 
            }

            #alert-success-product.show {
                display: block;
            }
            .cart-item{
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                /* border-bottom: 1px solid black; */
                text-align: end;
                align-items: center;
            }
        </style>
        <div class="container p-5 mt-5 mb-5" style="background-color: #FE9FB3;">
            <!-- <h1 class="text-white">Profile</h1> -->
            <div class="profile_details text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="white" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <div class="p-2">
                    <h3><?php echo $user["FirstName"] .  " " . $user["LastName"] ?></h3>
                    <span><?php echo ($user["Role"]) ? "Admin": "Member"; ?> since <?php echo $user["RegDate"] ?></span>
                </div>
            </div>
        </div>

        <?php
            if($user["Role"]){ 
                ?>
                <div class="container">
                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                        Dashboard
                    </button>
                    /
                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Product
                    </button>
                    /
                    <a href="product_list.php" class="btn btn-default">
                        View Products
                    </a>
                </div>
                    <div class="container mb-5 mt-5" style="display:flex;justify-content:center; gap:.8rem;">
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">Total Product 
                                        <h1><?=getAllProductCount()?></h1>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-dark stretched-link" href="pending-post.php">View</a>
                                        <div class="small text-dark"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">Orders 
                                        <h1><?=count_orders()?></h1>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-dark stretched-link" href="pending-post.php">View</a>
                                        <div class="small text-dark"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">Customers 
                                        <h1><?=countUsersReg();?></h1>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-dark stretched-link" href="pending-post.php">View</a>
                                        <div class="small text-dark"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="container mb-5 mt-5" style="display:flex;justify-content:center; gap:.8rem;">
                        <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">Available 
                                        <h1><?=countAvailableProducts()?></h1>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-dark stretched-link" href="pending-post.php">View</a>
                                        <div class="small text-dark"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">Out of Stock 
                                        <h1><?php echo countOutOfStockProducts(); ?></h1>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-dark stretched-link" href="pending-post.php">View</a>
                                        <div class="small text-dark"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">Sales 
                                        <h1>₱ <?=compute_total_amount_from_transactions()?></h1>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-dark stretched-link" href="pending-post.php">View</a>
                                        <div class="small text-dark"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container mt-5 mb-5" id="dynamic-container">
                        <hr>
                        <h4>Orders</h4>
                        <hr>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">OrderID</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Account ID</th>
                                    <th scope="col">Buyer</th>
                                    <th scope="col">Qty.</th>
                                    <th scope="col">Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $orders = fetching_orders_for_admin_page();
                                foreach ($orders as $order) {
                                    // Assuming you have a function to get the product name by its ID
                                    $product = getSpecificProductbyID($order['ProductID']);
                                    $buyer = $order['FirstName']; // Assuming you want to display the buyer's first name

                                    echo "<tr>";
                                    echo "<td>" . $order['OrderID'] . "</td>";
                                    echo "<td>" . $product['ProductTitle'] . "</td>";
                                    echo "<td>" . $order['UserID'] . "</td>"; 
                                    echo "<td>" . $buyer . "</td>"; 
                                    echo "<td>" . $order['Quantity'] . "</td>";
                                    echo "<td>" . $order['OrderDate'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="container">
                    <hr>
                        <div>
                            <h5>Transactions</h5>
                            <hr>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">OrderID</th>
                                        <th scope="col">Payment ID</th>
                                        <th scope="col">Account ID</th>
                                        <th scope="col">Payer Name</th>
                                        <th scope="col">Payer Email</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Currency</th>
                                        <th scope="col">Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $transactions = fetching_transactions_for_admin_page();
                                    foreach ($transactions as $transaction) {
                                        echo "<tr>";
                                        echo "<td>" . $transaction['order_id'] . "</td>";
                                        echo "<td>" . $transaction['payer_id'] . "</td>"; 
                                        echo "<td>" . $transaction["user_id"] . "</td>";
                                        echo "<td>" . $transaction["payer_name"] . "</td>";
                                        echo "<td>" . $transaction['payer_email'] . "</td>";
                                        echo "<td>" . $transaction['status'] . "</td>";
                                        echo "<td>₱ " . $transaction['amount'] . "</td>"; 
                                        echo "<td>" .' PESO '. "</td>";
                                        echo "<td>" . $transaction['transaction_date'] . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                    </div>

                    <br>

                <?php
            }else{
                ?>
                <div class="container">
                    <h1>My Account</h1>
                    <hr>
                    <h5>My Cart (<?= getCartCount() ?>)</h5>
                    <?php
                        $userCarts = getCart();
                        $totalAmount = calculateTotalAmount($userCarts);
                        
                        if (!empty($userCarts)) {
                            foreach ($userCarts as $userCart) {
                                $product = getSpecificProductbyID($userCart['ProductID']);
                                // if($userCart['Quantity'] < 1){
                                //     deleteItemFromCart($_SESSION['UserID'],$userCart['ProductID']);
                                // }
                                if ($product) {
                                    ?>
                                    <hr>
                                    <div class="cart-item">
                                        <div>
                                            <img src="<?php echo $product['ProductImage']; ?>" alt="Product Image" width="250" height="250">
                                        </div>
                                        <div class="info">
                                            <p>SKU : <?=htmlspecialchars($userCart['ProductID'])?></p>
                                            <p class="fs-4 text fw-bold"> <?=htmlspecialchars($product['ProductTitle'])?></p>
                                            <p class="fs-5 text">Quantity : <?=htmlspecialchars($userCart['Quantity'])?></p>

                                            <form class="d-flex justify-content-end" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                                <input type="hidden" name="p_id" value="<?=htmlspecialchars($userCart['ProductID'])?>">
                                                <input type="hidden" name="u_id" value="<?=htmlspecialchars($_SESSION['UserID'])?>">
                                                <input disabled class="form-control text-center me-3"  style="max-width: 3rem" type="num" name="qty" value="<?=htmlspecialchars($userCart['Quantity'])?>">
                                                <a href="update.php?sku=<?=htmlspecialchars($userCart['ProductID'])?>&key=plus" class="mx-2 btn btn-outline-dark flex-shrink-0" name="plus">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                                <a href="delete_product.php?sku=<?=htmlspecialchars($userCart['ProductID'])?>&key=minus" class="btn btn-outline-dark flex-shrink-0" name="minus">
                                                    <i class="fa-solid fa-minus"></i>
                                                </a>
                                                <br>
                                            </form>
                                            <p class="fs-5 text mt-3">₱ <?=htmlspecialchars(number_format($product['Price'], 2))?> each X <?=htmlspecialchars($userCart['Quantity'])?></p>
                                            <p class="fs-5 text mt-3">Total ₱ <?=htmlspecialchars(number_format(calculateTotalPrice($product['Price'], $userCart['Quantity']), 2));?></p>
                                        </div>
                                    </div>
                                    <hr>    

                                    <?php
                                } else {
                                    // Handle case where product details could not be fetched
                                    echo '<div class="cart-item">';
                                    echo '<p>Product ID: ' . htmlspecialchars($userCart['ProductID']) . '</p>';
                                    echo '<p>Product Details Not Available</p>';
                                    echo '<p>Quantity: ' . htmlspecialchars($userCart['Quantity']) . '</p>';
                                    echo "<hr>";
                                    echo '</div>';
                                }
                            }
                        } else {
                    ?>
                        <p>Nothing in my Cart <a href="../index.php">Shop Now!</a></p>
                    <?php
                        }
                    ?>
                    <?php
                       if(!empty($userCarts)){
                        ?>
                            <div class="text-end d-flex align-items-center justify-content-end">
                            <h2 class="text-end">Total</h2>
                            <form action="summary.php" class="text-end d-flex align-items-center">
                                <input class="text-end fs-3 text" id="totalAmount" style="border:none;background-color:transparent;" type="num" value="₱ <?= number_format($totalAmount, 2) ?>" name="totalAmount" disabled>
                                <input type="submit" class="btn btn-default" value="Checkout">
                            </form>
                    </div>
                        <?php
                       }

                    ?>
                    <hr>
                    <div class="pb-5">
                        <h5>Purchase History</h5>
                        <br>
                        <?php
                            if(!fetching_orders()){
                                echo ' <h6>You have not made any purchases yet!</h6>';
                            }else{
                                ?>
                    <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th scope="col">OrderID</th>
                                <th scope="col">Product</th>
                                <th scope="col">Qty.</th>
                                <th scope="col">Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $fetch = fetching_orders();
                                foreach ($fetch as $fetched) {
                                    $product = getSpecificProductbyID($fetched["ProductID"]);
                                    echo "<tr>";
                                    echo "<td>" . $fetched['OrderID'] . "</td>";
                                    echo "<td>" . $product["ProductTitle"] . "</td>";
                                    echo "<td>" . $fetched['Quantity'] . "</td>";
                                    echo "<td>" . $fetched['OrderDate'] . "</td>";
                                    echo "</tr>";
                                    }
                                    ?>
                            </tbody>
                        </table>
                                <?php
                            }
                        ?>
                        <br>
                    </div>
                </div>

                <?php
            }

        ?>

        <!-- Adding of Product Form in Modal -->
        <div class="modal" tabindex="-1"  id="exampleModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="productTitle" placeholder="Product Title">
                            <label for="productTitle">Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Product Description" id="productDescription" style="height: 100px"></textarea>
                            <label for="productDescription">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="productPrice" placeholder="Price">
                            <label for="productPrice">Price</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="floatingStock" placeholder="Stock" name="stock">
                            <label for="floatingStock">Stock</label>
                        </div>

                        <div class="mb-3">
                            <label for="productImage" class="form-label">Insert Image</label>
                            <input class="form-control form-control-sm" id="productImage" type="file" accept=".jpg, .jpeg, .png">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn text-white" style="background-color: #FE9FB3;" id="addProductBtn">Add Product</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        <div id="alert-success-product" class="alert alert-success" role="alert">
            <span></span>
        </div>

    
        
    
        <?php
        
        include '../components/Footer.php';
        ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        const exampleModal = document.getElementById('exampleModal');
        const myInput = document.getElementById('productTitle'); // Assuming productTitle is the input to focus on

        exampleModal.addEventListener('shown.bs.modal', () => {
            myInput.focus();
        });

        function productAlertSuccess(res) {
            const alert = document.querySelector("#alert-success-product");
            alert.innerHTML = res;
            alert.classList.add("show");
            setTimeout(() => {
                alert.classList.remove("show");
                $('#exampleModal').modal('hide'); // Hide the modal using jQuery
                window.location.href = "./profile.php"; // Redirect to profile page after success
            }, 3000);
        }

        $('#addProductBtn').on('click', function() {
            var formData = new FormData();
            formData.append('title', $('#productTitle').val());
            formData.append('description', $('#productDescription').val());
            formData.append('price', $('#productPrice').val());
            formData.append('stock', $('#floatingStock').val());
            formData.append('image', $('#productImage')[0].files[0]);

            $.ajax({
                url: 'add_product.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    productAlertSuccess(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus, errorThrown);
                }
            });
        });
    });
</script>
    </body>
</html>
