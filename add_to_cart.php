<?php
// session_start();
// require_once 'DB.php';
// $db = dbconn();

// $product_id = $_POST['product_id'];
// $quantity = $_POST['quantity'];

// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = [];
// }

// if (isset($_SESSION['cart'][$product_id])) {
//     $_SESSION['cart'][$product_id] += $quantity;
// } else {
//     $_SESSION['cart'][$product_id] = $quantity;
// }

// $cart = $_SESSION['cart'];

// $products = [];
// foreach ($cart as $id => $qty) {
//     $stmt = $db->prepare("SELECT * FROM product WHERE ProductID = :id");
//     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//     $stmt->execute();
//     $product = $stmt->fetch(PDO::FETCH_ASSOC);
//     $product['Stock'] = $qty;
//     $products[] = $product;
// }

// $cart_html = '<ul>';
// $total_price = 0;
// foreach ($products as $product) {
//     $cart_html .= '<li>' . htmlspecialchars($product['ProductTitle']) . 
//                   ' <button class="decrement" data-product-id="' . htmlspecialchars($product['ProductID']) . '">-</button> ' . 
//                   htmlspecialchars($product['Stock']) . 
//                   ' <button class="increment" data-product-id="' . htmlspecialchars($product['ProductID']) . '">+</button> x $' . 
//                   htmlspecialchars($product['Price']) . '</li>';
//     $total_price += $product['Stock'] * $product['Price'];
// }
// $cart_html .= '</ul>';
// $cart_html .= '<p>Total: $' . htmlspecialchars($total_price) . '</p>';
// $cart_html .= '<button id="checkout" class="btn btn-default border">Checkout</button>';

// echo $cart_html;
?>
