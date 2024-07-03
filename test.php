<?php
include 'Account.php'; // Assuming 'Account.php' contains your functions, including getSpecificProductbyID()

// Test by getting a specific product details
$productID = 20; // Replace with the actual product ID you want to retrieve

$product = getSpecificProductbyID($productID);

if ($product) {
    // Output product details
    echo '<pre>';
    print_r($product); // Output the entire product array for testing purposes
    echo '</pre>';
} else {
    echo 'Product not found or database error occurred.';
}
?>
