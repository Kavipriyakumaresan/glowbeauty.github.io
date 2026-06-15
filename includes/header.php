<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
$cartCount = cartItemCount();
$wishlistCount = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
$userName = $_SESSION['user']['name'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlowBeauty</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</head>
<body>
<header>
    <div class="brand">
        <a href="index.php"><h1>GlowBeauty</h1></a>
    </div>
    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="categories.php">Categories</a>
        <a href="contact.php">Contact</a>
        <a href="wishlist.php">Wishlist (<span id="wishlist-count"><?php echo $wishlistCount; ?></span>)</a>
        <a href="cart.php">Cart (<span id="cart-count"><?php echo $cartCount; ?></span>)</a>
        <?php if ($userName): ?>
            <span class="nav-user">Hello, <?php echo sanitize($userName); ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
