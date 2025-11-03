<?php
require 'functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addProduct($_POST['title'], $_POST['price'], $_POST['description'], $_POST['image'], $_SESSION['user_id']);
    header("Location: orders.php");
}


$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $seller_id = $_SESSION['user_id'];
    $image = '';

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        }
    }

    $stmt = $mysqli->prepare("INSERT INTO products (seller_id, category_id, title, description, price, stock, image, created_at) VALUES (?,?,?,?,?,?,?,NOW())");
    $stmt->bind_param('iissdis', $seller_id, $category_id, $title, $description, $price, $stock, $image);
    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">✅ Product added successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">❌ Error adding product.</div>';
    }
}
?>

<div class="container mt-5">
  <h3 class="mb-4">➕ Add New Product</h3>
  <?= $msg ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Product Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select" required>
        <option value="">-- Select Category --</option>
        <?php
        $cat = $mysqli->query("SELECT id, name FROM categories");
        while ($row = $cat->fetch_assoc()):
        ?>
          <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Price (₱)</label>
      <input type="number" step="0.01" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Stock</label>
      <input type="number" name="stock" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Product Image</label>
      <input type="file" name="image" class="form-control" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-warning text-white">Save Product</button>
  </form>
</div>

<?php include 'footer.php'; ?>

 
