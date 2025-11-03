<?php
session_start();
require 'db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // ✅ Fetch product details
    $stmt = $mysqli->prepare("SELECT id, title, price, image FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product) {
        die("Product not found!");
    }

    // ✅ Initialize cart if not existing
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ✅ Add or update quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'title' => $product['title'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1
        ];
    }

    header('Location: view_cart.php');
    exit;
}
?>
