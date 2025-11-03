<?php
session_start();
require 'functions.php';

// ✅ Fetch all products using the function
$result = getAllProducts();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="text-center mb-4">🛒 Available Products</h2>
  <div class="row">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>" style="height: 200px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
              <p class="card-text text-muted">₱<?= number_format($row['price'], 2) ?></p>
              <p class="small text-secondary"><?= htmlspecialchars($row['description']) ?></p>
            </div>
            <div class="card-footer text-center">
              <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-warning btn-sm w-100">Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12 text-center">
        <p class="text-muted">No products available right now.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
