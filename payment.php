<?php
require 'dbconnection.php';

$total = $_POST['total'];
$payment = $_POST['payment'];
$balance = $_POST['balance'];

// Insert into billing table
$stmt = $pdo->prepare('INSERT INTO billing (total_amount) VALUES (?)');
$stmt->execute([$total]);

$billing_id = $pdo->lastInsertId();

// Insert into payment table
$stmt = $pdo->prepare('INSERT INTO payment (billing_id, payment_amount, balance) VALUES (?, ?, ?)');
$stmt->execute([$billing_id, $payment, $balance]);

echo "Payment Successfully!";
header('Location: products.php');
?>
