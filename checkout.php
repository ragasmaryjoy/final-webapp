<?php
session_start();
require 'db_con.php'; // ✅ Database connection

// ✅ Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ✅ Check if cart is empty
if (empty($_SESSION['cart'])) {
    $_SESSION['message'] = "Your cart is empty. Add some products first!";
    header("Location: view_cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$total = 0;

// ✅ Calculate total price
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// ✅ Correct SQL order and binding
// (created_at) column should be set by NOW() after the parameters
$order_query = $mysqli->prepare("INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, 'Pending', NOW())");
$order_query->bind_param("id", $user_id, $total);

if ($order_query->execute()) {
    $order_id = $mysqli->insert_id; // ✅ get last inserted order ID

    // ✅ Insert each product into order_items table
    $item_query = $mysqli->prepare("INSERT INTO orders (id,user_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart as $item) {
        $item_query->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $item_query->execute();
    }

    // ✅ Clear the cart after successful checkout
    unset($_SESSION['cart']);
    $_SESSION['message'] = "🎉 Your order has been placed successfully!";
    header("Location: order_success.php?id=" . $order_id);
    exit;
} else {
    // ❌ Error fallback
    $_SESSION['message'] = "Something went wrong. Please try again.";
    header("Location: view_cart.php");
    exit;
}
?>
