<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['cart'][$_GET['id']])) {
    unset($_SESSION['cart'][$_GET['id']]);
    $_SESSION['message'] = "Item removed from your cart.";
} else {
    $_SESSION['message'] = "Item not found in your cart.";
}

header("Location: view_cart.php");
exit;
?>
