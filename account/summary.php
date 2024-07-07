<?php
require_once '../Header.php';
require('../components/Navbar.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();

// print_r($_SESSION);  
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
                <span><?php echo ($user["Role"]) ? "Admin" : "Member"; ?> since <?php echo $user["RegDate"]; ?></span>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>My Account</h1>
        <hr>
        
        <?php
            $userCarts = getCart();
            $totalAmount = calculateTotalAmount($userCarts);
            
            if (!empty($userCarts)) {
                ?>
                <section>
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div class="d-flex flex-row align-items-center">
                            <h4 class="text-uppercase mt-1">Order Summary</h4>
                        </div>
                        <a href="../index.php">Cancel and return to the Shop</a>
                    </div>
                <?php
                foreach ($userCarts as $userCart) {
                    $product = getSpecificProductbyID($userCart['ProductID']);
                    if ($product) {
                        $product_ID = htmlspecialchars($userCart['ProductID']);
                        $title = htmlspecialchars($product['ProductTitle']);
                        $desc = htmlspecialchars($product['ProductDescription']);
                        $price = htmlspecialchars(number_format($product['Price'], 2));
                        $total = htmlspecialchars(number_format($product['Price'] * $userCart['Quantity'], 2));
                        $Quantity = htmlspecialchars($userCart['Quantity']);
                        ?>
                        <div class="row">
                            <div class="col-md-7 col-lg-7 col-xl-6 mb-4 mb-md-0">
                                <h5 class="mb-0 text-success">Total ₱ <?=$total?></h5>
                                <h5 class="mb-3"><?=$title?></h5>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row mt-1">
                                            <h6>Description:</h6>
                                        </div>
                                        <div class="d-flex flex-row align-items-center text-primary">
                                        </div>
                                    </div>
                                    <p><?=$desc?></p>
                                    <div class="p-2 d-flex justify-content-between align-items-center bg-body-tertiary">
                                        <span>₱ <?=$price?> each</span>
                                        <span>SKU : <?=$product_ID?></span>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-4 col-xl-4 offset-lg-1 offset-xl-2">
                                <div class="p-3 bg-body-tertiary">
                                    <span class="fw-bold">Order Recap</span>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span>Total Price</span> <span>₱ <?=$total?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span>Price : </span> <span>₱ <?=$price?> X <?=$Quantity?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span>Copayment</span> <span>₱ 0.00</span>
                                    </div>
                                    <hr />
                                    <div class="d-flex justify-content-between mt-2">
                                        <span>Total</span> <span class="text-success">₱ <?=$total?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                ?>
                </section>
                <section>
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div class="d-flex flex-row align-items-center">
                            <h4 class="text-uppercase mt-1">Order Total</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-lg-7 col-xl-6 mb-4 mb-md-0">
                            <h5 class="mb-0 text-success">Total Amount: ₱ <?=htmlspecialchars(number_format($totalAmount, 2))?></h5>
                        </div>
                        <div class="col-md-5 col-lg-4 col-xl-4 offset-lg-1 offset-xl-2">
                            <div class="p-3 bg-body-tertiary">
                                <span class="fw-bold">Order Summary</span>
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Total Price</span> <span>₱ <?=htmlspecialchars(number_format($totalAmount, 2))?></span>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Amount Deductible</span> <span>₱ 0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Copayment</span> <span>₱ 0.00</span>
                                </div>
                                <hr />
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Total</span> <span class="text-success">₱ <?=htmlspecialchars(number_format($totalAmount, 2))?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="paypal-button-container"></div>
                </section>
                <?php
            } else {
                ?>
                <p>Nothing in my Cart <a href="../index.php">Shop Now!</a></p>
                <?php
            }
        ?>
        <hr>
        <div class="pb-5">
            <h5>Purchase History</h5>
            <br>
            <h6>You have not made any purchases yet!</h6>
            <br>
        </div>
    </div>
    <?php include '../components/Footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?=$totalAmount?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Send transaction details to server for saving in the database
                    fetch('save_transaction.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            payerID: details.payer.payer_id,
                            paymentID: details.id,
                            amount: details.purchase_units[0].amount.value,
                            currency: details.purchase_units[0].amount.currency_code,
                            status: details.status,
                            payerName: details.payer.name.given_name + ' ' + details.payer.name.surname,
                            payerEmail: details.payer.email_address
                        })
                    }).then(response => {
                        // Check if the response is valid JSON
                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error('Network response was not ok.');
                        }
                    }).then(data => {
                        // Check the status from the server response
                        if (data.status === 'success') {
                            alert('Transaction completed by ' + details.payer.name.given_name);
                            window.location.href = 'delete_cart_items.php';
                        } else {
                            alert('Failed to save transaction details: ' + data.message);
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while saving the transaction: ' + error.message);
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>


</body>
</html>
