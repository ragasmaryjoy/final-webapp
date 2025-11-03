<?php
session_start();
require 'db_con.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'] ?? 0;

// ✅ Fetch product info
$query = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
$query->bind_param("i", $product_id);
$query->execute();
$product = $query->get_result()->fetch_assoc();

if (!$product) {
    die("Product not found!");
}

// ✅ Insert into orders table (simplified)
$insert = $mysqli->prepare("INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, 'Pending', NOW())");
$insert->bind_param("id", $user_id, $product['price']);
$insert->execute();

$order_id = $mysqli->insert_id;

// ✅ Optionally insert order details
$details = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, 1, ?)");
$details->bind_param("iid", $order_id, $product_id, $product['price']);
$details->execute();

// ✅ Redirect back
header("Location: my_orders.php?msg=added");
exit;
