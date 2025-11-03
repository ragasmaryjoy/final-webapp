<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require 'db_con.php';

// Fetch current user info (example only)
$user_id = $_SESSION['user_id'];
$result = $mysqli->query("SELECT fullname, email FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Profile - E-Market Hub</title>
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
  max-width: 600px;
}
.card {
  border-radius: 20px;
  border: none;
  padding: 30px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.card-title {
  color: #ff6600;
  font-weight: 700;
}
.btn-orange {
  background-color: #ff6600;
  border: none;
  color: white;
  border-radius: 25px;
  padding: 10px 25px;
  font-weight: 600;
}
.btn-orange:hover {
  background-color: #ff8533;
}
.btn-back {
  background: white;
  color: #ff6600;
  border-radius: 20px;
  font-weight: 600;
}
.btn-back:hover {
  background: #ff8533;
  color: white;
}
</style>
</head>

<body>
<div class="container">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-white">👤 My Profile</h2>
  </div>

  <div class="card">
    <form method="post" action="update_profile_action.php">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">New Password (optional)</label>
        <input type="password" name="password" class="form-control" placeholder="Enter new password">
      </div>
      <div class="d-flex justify-content-between">
        <a href="dashboard.php" class="btn btn-back">← Back</a>
        <button type="submit" class="btn btn-orange">Update Profile</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
