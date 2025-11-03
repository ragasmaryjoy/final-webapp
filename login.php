<?php
// ===============================
// Login Page: login.php
// ===============================

require 'db_con.php';
include 'header.php';

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate email and password
    if (!empty($email) && !empty($password)) {
        $stmt = $mysqli->prepare("
            SELECT id, fullname, password, role 
            FROM users 
            WHERE email = ? 
            LIMIT 1
        ");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($user = $res->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                session_start();
                session_regenerate_id(true);

                $_SESSION['user_id']   = $user['id'];
                $_SESSION['fullname']  = $user['fullname'];
                $_SESSION['role']      = $user['role'];

                header('Location: dashboard.php');
                exit;
            } else {
                $err = 'Invalid email or password.';
            }
        } else {
            $err = 'Invalid email or password.';
        }
    } else {
        $err = 'Please fill in all fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - E-Market Hub</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body {
  background: linear-gradient(135deg, #ff6600, #ff9900);
  min-height: 100vh;
  font-family: 'Poppins', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-card {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
  width: 400px;
  padding: 40px;
  animation: fadeIn 1s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

h3 {
  font-weight: 700;
  text-align: center;
  color: #ff6600;
  margin-bottom: 30px;
}

.btn-primary {
  background: #ff6600;
  border: none;
  border-radius: 30px;
  width: 100%;
  padding: 10px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  background: #e65c00;
  transform: translateY(-2px);
}

.form-control {
  border-radius: 10px;
  padding: 12px;
}

small a {
  color: #ff6600;
  text-decoration: none;
}

small a:hover {
  text-decoration: underline;
}

.alert-danger {
  border-radius: 10px;
  text-align: center;
}
</style>
</head>

<body>
  <div class="login-card">
    <h3>Welcome 👋</h3>

    <?php if ($err): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>

      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>

      <button class="btn btn-primary">Login</button>

      <div class="text-center mt-3">
        <small>Don't have an account? <a href="register.php">Register</a></small>
      </div>
    </form>
  </div>
</body>
</html>

<?php include 'footer.php'; ?>
