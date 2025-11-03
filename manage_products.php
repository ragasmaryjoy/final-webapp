<?php
session_start();
require 'db_con.php';

// ✅ Check if admin or seller is logged in (optional)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// ✅ Fetch all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products - E-Market Hub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .container {
      margin-top: 80px;
    }
    h2 {
      font-weight: 700;
      color: #ff6600;
      margin-bottom: 20px;
    }
    .btn-order {
      background-color: #ff6600;
      color: white;
      border-radius: 25px;
      font-weight: 600;
      padding: 5px 15px;
    }
    .btn-order:hover {
      background-color: #e65c00;
      color: white;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📦 Manage Products</h2>
    <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
  </div>

  <table class="table table-bordered table-striped text-center shadow">
    <thead class="table-warning">
      <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td>₱<?= number_format($row['price'], 2) ?></td>
            <td><?= htmlspecialchars($row['stock']) ?></td>
            <td>
              <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
              <!-- 🛒 NEW ORDER BUTTON -->
              <a href="order_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-order">Order</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5" class="text-muted">No products found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
