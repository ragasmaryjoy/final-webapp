<?php
// ===============================
// E-Market Hub: dashboard.php
// ===============================

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - E-Market Hub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      min-height: 100vh;
      margin: 0;
      background: linear-gradient(135deg, #ff6600, #ffb347);
      font-family: 'Poppins', sans-serif;
      color: #333;
    }

    .navbar {
      background-color: #ff5f00 !important;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .navbar-brand {
      font-weight: 700;
      letter-spacing: 1px;
    }

    .welcome {
      font-weight: 500;
    }

    .dashboard-container {
      margin-top: 100px;
      text-align: center;
    }

    h2 {
      font-weight: 700;
      color: white;
    }

    p.subtext {
      color: #fff;
      opacity: 0.9;
      font-size: 1rem;
      margin-bottom: 40px;
    }

    .card {
      background: #fff;
      border: none;
      border-radius: 25px;
      padding: 30px 20px;
      text-align: center;
      transition: all 0.3s ease;
      height: 100%;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .card img {
      width: 80px;
      margin-bottom: 15px;
    }

    .card-title {
      color: #ff6600;
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 1.2rem;
    }

    .card p {
      font-size: 0.95rem;
      color: #666;
      margin-bottom: 20px;
    }

    .btn-orange {
      background-color: #ff6600;
      color: #fff;
      border: none;
      border-radius: 25px;
      padding: 10px 25px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-orange:hover {
      background-color: #ff8533;
      color: #fff;
    }

    footer {
      background: rgba(0, 0, 0, 0.15);
      color: #fff;
      padding: 15px 0;
      position: fixed;
      width: 100%;
      bottom: 0;
      font-size: 0.9rem;
    }
  </style>
</head>
<form action="add_to_cart.php" method="POST">
  <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
  <button type="submit" class="btn btn-buy btn-sm">Add to Cart</button>
</form>


<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="#">🛍️ E-Market Hub</a>
    <div class="d-flex align-items-center">
      <span class="text-white me-3 welcome">Welcome, <?= htmlspecialchars($_SESSION['fullname'] ?? 'User') ?>!</span>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container dashboard-container">
  <h2> Dashboard</h2>
  <p class="subtext">Choose what you want to do today</p>

  <div class="row justify-content-center g-4">
    <!-- Shop Products -->
    <div class="col-md-3">
      <div class="card">
        <img src="https://cdn-icons-png.flaticon.com/512/3081/3081648.png" alt="Shop Products">
        <h5 class="card-title">Shop Products</h5>
        <p>Browse and purchase your favorite items.</p>
        <a href="index.php" class="btn btn-orange">Go to Shop</a>
      </div>
    </div>

    <!-- Manage Products -->
    <div class="col-md-3">
      <div class="card">
        <img src="https://cdn-icons-png.flaticon.com/512/3096/3096673.png" alt="Manage Products">
        <h5 class="card-title">Manage Products</h5>
        <p>Add, edit, or delete your store items.</p>
        <a href="products.php" class="btn btn-orange">Manage</a>
      </div>
    </div>

    <!-- Orders -->
    <div class="col-md-3">
      <div class="card">
        <img src="https://cdn-icons-png.flaticon.com/512/3500/3500833.png" alt="Orders">
        <h5 class="card-title">Orders</h5>
        <p>View customer orders and delivery updates.</p>
        <a href="orders.php" class="btn btn-orange">View Orders</a>
      </div>
    </div>

    <!-- My Profile -->
    <div class="col-md-3">
      <div class="card">
        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077063.png" alt="Profile">
        <h5 class="card-title">My Profile</h5>
        <p>Edit your account details and settings.</p>
        <a href="profile.php" class="btn btn-orange">Update Profile</a>
      </div>
    </div>
  </div>
</div>

<footer class="text-center">
  <p>&copy; Inspired by Shopee</p>
</footer>

</body>
</html>
