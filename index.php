<?php
// ===============================
// E-Market Hub: Auto Redirect + Shop Page
// ===============================

// 🔸 Automatically redirect to register.php
header("Location: register.php");
exit;

// The rest of your code below will not run because of the redirect above.
// If you want the redirect to happen only in specific cases (like no login), 
// move this header() inside a condition block.

session_start();
require 'db_con.php';
include 'header.php';

// ✅ Use 'id' if 'created_at' column doesn't exist
$query = "
  SELECT p.*, u.fullname AS seller_name 
  FROM products p
  LEFT JOIN users u ON p.seller_id = u.id
  ORDER BY p.id DESC
";

$res = $mysqli->query($query);

if (!$res) {
    die("Database Error: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>E-Market Hub - Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body {
  background: linear-gradient(135deg, #ff6a00, #ffb347);
  font-family: 'Poppins', sans-serif;
}
h1, .lead {
  color: white;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}
.product-card {
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  transition: 0.3s;
}
.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}
.price {
  color: #ff6600;
  font-weight: 700;
  font-size: 1.1rem;
}
.btn-primary {
  background-color: #ff6600;
  border: none;
}
.btn-primary:hover {
  background-color: #ff8533;
}
</style>
</head>

<body>
<div class="container my-5">
  <div class="text-center mb-4">
    <h1>🛒 E-Market Hub</h1>
    <p class="lead">Bridging Buyers and Sellers Online — Ragas, Mary Joy Magadia</p>
  </div>

  <div class="row">
    <?php if ($res->num_rows > 0): ?>
      <?php while ($row = $res->fetch_assoc()): ?>
        <div class="col-md-3 mb-4">
          <div class="card product-card h-100">
            <img src="<?= htmlspecialchars($row['image'] ?? 'https://via.placeholder.com/300x200?text=No+Image') ?>" 
                 class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
              <p class="small text-muted">Sold by: <?= htmlspecialchars($row['seller_name']) ?></p>
              <p class="price mt-auto">₱<?= number_format($row['price'], 2) ?></p>

              <div class="mt-2 d-grid gap-2">
                <a href="product_view.php?id=<?= $row['id'] ?>" class="btn btn-outline-secondary btn-sm">View Details</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                  <form action="cart_add.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                  </form>
                <?php else: ?>
                  <a href="login.php" class="btn btn-primary btn-sm">Login to Buy</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="text-center text-white">
        <h5>No products available at the moment.</h5>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
