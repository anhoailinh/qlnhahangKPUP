<?php
include 'connect.php';
session_start();
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Invalid request'];

if (isset($_SESSION['customer_id'], $_POST['cartid'], $_POST['quantity'])) {
    $user_id = (int)$_SESSION['customer_id'];
    $cart_id = (int)$_POST['cartid'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0) {
        $stmt = $conn->prepare("UPDATE giohang SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("iii", $quantity, $cart_id, $user_id);
        
        if ($stmt->execute()) {
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'error', 'message' => 'Update failed'];
        }

        $stmt->close();
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid quantity'];
    }
}

echo json_encode($response);
?>
