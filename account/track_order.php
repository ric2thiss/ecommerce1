
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

        <div class="pb-5 container mb-2">
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
                                <th scope="col">Amount Paid</th>
                                <th scope="col">Order Date</th>
                                <!-- <th scope="col">Action</th> -->
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
                                        echo "<td>" . "₱ " .number_format($fetched['TotalPrice'],2) . "</td>";
                                        echo "<td>" . $fetched['OrderDate'] . "</td>";
                                        // echo "<td><a href='track_order.php?order_id=" . $fetched['OrderID'] . "' class='text-decoration-none text-dark'>View Tracking Details</a></td>";
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
        <div class="container">
            <hr>
            <h5>Tracking Details</h5>
            <hr>
            <div class="modal-body text-start px-4 pt-0 pb-4">
                <div class="text-center">
                  <h5 class="mb-3">Order Status</h5>
                  <h5 class="mb-5">AWB Number-5335T5S</h5>
                </div>

                <div class="d-flex justify-content-between mb-5">
                  <div class="text-center">
                    <i class="fas fa-circle"></i>
                    <p>Order placed</p>
                  </div>
                  <div class="text-center">
                  <i class="fas fa-circle" style="color: #979595;"></i>
                    <p>In Transit</p>
                  </div>
                  <div class="text-center">
                  <i class="fas fa-circle" style="color: #979595;"></i>
                    <p class="lead fw-normal">Out of Delivery</p>
                  </div>
                  <div class="text-center">
                    <i class="fas fa-circle" style="color: #979595;"></i>
                    <p style="color: #979595;">Delivered</p>
                  </div>
                </div>

                <div class="row justify-content-center">
                  <div class="col-md-4 text-center">
                    <p class="lead fw-normal">Shipped with</p>
                  </div>
                  <div class="col-md-4 text-center">
                    <p class="lead fw-normal">UPS Expedited</p>
                  </div>
                  <div class="col-md-2 text-center">
                    <i class="fas fa-phone fa-lg"></i>
                  </div>
                </div>

                <div class="row justify-content-center">
                  <div class="col-md-4 text-center">
                    <p class="lead fw-normal">Estimated Delivery</p>
                  </div>
                  <div class="col-md-4 text-center">
                    <p class="lead fw-normal"><?=date("Y/m/d")?></p>
                  </div>
                  <div class="col-md-2 text-center">
                    <i class="fas fa-envelope fa-lg"></i>
                  </div>
                </div>
              </div>
              <hr>
        </div>

        <?php
        include '../components/Footer.php';
        ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
