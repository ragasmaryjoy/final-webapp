<?php 
session_start();
require 'db_con.php';

// ✅ Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch the orders for this user
$query = $mysqli->prepare("SELECT id, status, total, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$query->bind_param('i', $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Orders - E-Market Hub</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body {
  background: linear-gradient(135deg, #ff6600, #ffb347);
  font-family: 'Poppins', sans-serif;
  min-height: 100vh;
}
.container {
  margin-top: 100px;
}
.table {
  background: white;
  border-radius: 15px;
  overflow: hidden;
}
th {
  background-color: #ff6600;
  color: white;
}
h2 {
  color: white;
  font-weight: 700;
  margin-bottom: 30px;
}
.btn-back {
  background: white;
  color: #ff6600;
  border-radius: 25px;
  font-weight: 600;
  padding: 8px 20px;
  text-decoration: none;
}
.btn-back:hover {
  background: #ff8533;
  color: white;
}
</style>
</head>

<body>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'added'): ?>
  <div class="alert alert-success text-center">
    ✅ Product added to your cart successfully!
  </div>
<?php endif; ?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>🛍️ My Orders</h2>
    <a href="dashboard.php" class="btn-back">← Back to Dashboard</a>
  </div>

  <table class="table table-bordered table-striped text-center shadow">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Date</th>
        <th>Status</th>
        <th>Total</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): ?>
          <tr>
            <td>#<?= htmlspecialchars($order['id']) ?></td>
            <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($order['created_at']))) ?></td>
            <td>
              <?php if (strtolower($order['status']) == 'delivered'): ?>
                <span class="badge bg-success">Delivered</span>
              <?php elseif (strtolower($order['status']) == 'pending'): ?>
                <span class="badge bg-warning text-dark">Pending</span>
              <?php else: ?>
                <span class="badge bg-danger"><?= htmlspecialchars($order['status']) ?></span>
              <?php endif; ?>
            </td>
            <td>₱<?= number_format($order['total'], 2) ?></td>
            <td><a href="order_view.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">View</a></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center text-muted">No orders found yet 😢</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
