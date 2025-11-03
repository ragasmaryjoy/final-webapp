<?php
session_start();
require 'db_con.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart - E-Market Hub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="text-center mb-4">🛒 My Shopping Cart</h2>

  <!-- ✅ Message alert -->
  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info text-center">
      <?= htmlspecialchars($_SESSION['message']) ?>
    </div>
    <?php unset($_SESSION['message']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['cart'])): ?>
    <table class="table table-bordered text-center align-middle shadow-sm">
      <thead class="table-warning">
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $item):
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;
        ?>
        <tr>
          <td><?= htmlspecialchars($item['title']) ?></td>
          <td>₱<?= number_format($item['price'], 2) ?></td>
          <td><?= htmlspecialchars($item['quantity']) ?></td>
          <td>₱<?= number_format($subtotal, 2) ?></td>
          <td>
            <a href="cart_remove.php?id=<?= $id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this item?');">
              Remove
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="text-end">
      <h4>Total: ₱<?= number_format($total, 2) ?></h4>
      <a href="checkout.php" class="btn btn-success mt-3">Proceed to Checkout</a>
    </div>
  <?php else: ?>
    <div class="alert alert-secondary text-center">
      🛍️ Your cart is empty.
    </div>
  <?php endif; ?>
</div>
</body>
</html>
