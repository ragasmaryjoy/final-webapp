<?php
require_once 'db_con.php';

// ✅ CREATE - Add product
function addProduct($title, $price, $description, $image, $seller_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO products (title, price, description, image, seller_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssi", $title, $price, $description, $image, $seller_id);
    return $stmt->execute();
}

// ✅ READ - Get all products
function getAllProducts() {
    global $mysqli;
    $result = $mysqli->query("SELECT * FROM products ORDER BY id DESC");
    return $result;
}

// ✅ READ - Get single product
function getProductById($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// ✅ UPDATE - Edit product
function updateProduct($id, $title, $price, $description, $image) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE products SET title=?, price=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sdssi", $title, $price, $description, $image, $id);
    return $stmt->execute();
}

// ✅ DELETE - Remove product
function deleteProduct($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
