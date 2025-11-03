<?php
require 'functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateProduct($_POST['id'], $_POST['title'], $_POST['price'], $_POST['description'], $_POST['image']);
    header("Location: products.php");
}



$id = $_GET['id'] ?? 0;
$stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "<div class='alert alert-danger'>Product not found.</div>";
    include 'footer.php'; exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $product['image'];

    // Optional new image
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        }
    }

    $stmt = $mysqli->prepare("UPDATE products SET title=?, category_id=?, description=?, price=?, stock=?, image=? WHERE id=?");
    $stmt->bind_param('sisdssi', $title, $category_id, $description, $price, $stock, $image, $id);
    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">✅ Product updated successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">❌ Failed to update product.</div>';
    }
}
?>

<div class="container mt-5">
  <h3 class="mb-4">✏️ Edit Product</h3>
  <?= $msg ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($product['title']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select" required>
        <?php
        $cat = $mysqli->query("SELECT id, name FROM categories");
        while ($row = $cat->fetch_assoc()):
        ?>
          <option value="<?= $row['id'] ?>" <?= $product['category_id']==$row['id']?'selected':'' ?>>
            <?= htmlspecialchars($row['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Price</label>
      <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Stock</label>
      <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Image</label><br>
      <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" width="120" class="rounded mb-2"><br>
      <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-warning text-white">Update Product</button>
  </form>
</div>

<?php include 'footer.php'; ?>
