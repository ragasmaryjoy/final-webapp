<?php
require 'db_con.php';
include 'header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = in_array($_POST['role'] ?? 'customer', ['customer','seller']) ? $_POST['role'] : 'customer';

    if (!$fullname || !$email || !$password) $errors[] = 'All fields are required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO users (fullname,email,password,role) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $fullname, $email, $hash, $role);
        if ($stmt->execute()) {
            header('Location: login.php'); exit;
        } else {
            $errors[] = 'Could not register: email may already be registered.';
        }
    }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h3>Register</h3>
    <?php if ($errors): ?>
      <div class="alert alert-danger"><?=implode('<br>', array_map('htmlspecialchars',$errors))?></div>
    <?php endif; ?>
    <form method="post" novalidate>
      <div class="mb-3"><label>Full Name</label><input name="fullname" class="form-control" required></div>
      <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
      <div class="mb-3"><label>Role</label>
        <select name="role" class="form-select">
          <option value="customer">Customer</option>
          <option value="seller">Seller</option>
        </select>
      </div>
      <button class="btn btn-success">Register</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
