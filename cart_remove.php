<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ✅ Check if item exists in cart
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]); // remove the product from cart
        $_SESSION['message'] = "🗑️ Item has been removed from your cart.";
    } else {
        $_SESSION['message'] = "⚠️ Item not found in your cart.";
    }
} else {
    $_SESSION['message'] = "❌ Invalid request.";
}

// ✅ Redirect back to cart page
header("Location: view_cart.php");
exit;
?>
