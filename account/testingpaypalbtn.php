<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AfHWnXnEA1aIBw9L35ZwG7u909qrfMpsLrdik3T7-hCvcYIznjleeIEsXZgxlXjsIqD-VHNj9cY87xgD"></script>
</head>
<body>
    <div id="paypal-button-container"></div>


    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                console.log(data);
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '200'
                        }
                    }]
                            
                })
            },
            onApprove: function(data, actions) {
                console.log(data);
                return actions.order.capture().then(function(details){
                    console.log(details);
                    alert('Transaction completed by ' + details.payer.name.given_name);
                })
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>


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