<?php
require_once __DIR__ . '/includes/header.php';
$orderId = intval($_GET['order_id'] ?? 0);
$order = null;
if ($orderId) {
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? LIMIT 1');
    $stmt->execute([$orderId]);
    $order = $stmt->fetch();
}
?>

<section class="section">
    <h2>Order Confirmed</h2>
    <?php if ($order): ?>
        <div class="order-success-card">
            <h3>Thank you, <?php echo sanitize($order['name']); ?>!</h3>
            <p>Your order has been placed successfully.</p>
            <p>Order ID: <strong>#<?php echo $order['id']; ?></strong></p>
            <p>Total Amount: <strong>₹<?php echo number_format($order['total_amount'], 0); ?></strong></p>
            <p>We will notify you via email at <strong><?php echo sanitize($order['email']); ?></strong> when your order is shipped.</p>
            <a href="index.php" class="btn">Continue Shopping</a>
        </div>
    <?php else: ?>
        <p class="empty-message">We could not locate your order details. Please check your order ID and try again.</p>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
