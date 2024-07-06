<?php

require_once '../DB.php';
session_start();

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $orderID = $data['orderID'];
    $payerID = $data['payerID'];
    $paymentID = $data['paymentID'];
    $amount = $data['amount'];
    $currency = $data['currency'];
    $status = $data['status'];
    $payerName = $data['payerName'];
    $payerEmail = $data['payerEmail'];
    $userID = $_SESSION['UserID'];

    try {
        // Connect to the database
        $conn = dbconn();

        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO transactions (order_id, payer_id, payment_id, amount, currency, status, payer_name, payer_email, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$orderID, $payerID, $paymentID, $amount, $currency, $status, $payerName, $payerEmail, $userID]);
        
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save transaction: ' . $e->getMessage()]);
    }

    // Close the connection
    $conn = null;
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received.']);
}
?>
