<?php
session_start();
require 'db_con.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$order_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Successful - E-Market Hub</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container text-center py-5">
  <h1 class="text-success mb-4">✅ Order Placed Successfully!</h1>
  <p class="lead">Thank you for your purchase! Your order ID is <strong>#<?= htmlspecialchars($order_id) ?></strong>.</p>
  <a href="orders.php" class="btn btn-primary mt-3">View My Orders</a>
  <a href="shop.php" class="btn btn-outline-secondary mt-3">Continue Shopping</a>
</div>

</body>
</html>
