<?php
require_once __DIR__ . '/includes/header.php';
$cartItems = $_SESSION['cart'] ?? [];
$items = [];
$total = 0;

if ($cartItems) {
    $ids = array_keys($cartItems);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        $qty = $cartItems[$product['id']]['quantity'];
        $subTotal = $product['price'] * $qty;
        $total += $subTotal;
        $items[] = [
            'product' => $product,
            'quantity' => $qty,
            'subTotal' => $subTotal,
        ];
    }
}
?>

<section class="section">
    <h2>Your Cart</h2>
    <?php if (empty($items)): ?>
        <p class="empty-message">Your cart is empty. Add beauty products and come back here to checkout!</p>
    <?php else: ?>
        <div class="cart-table">
            <div class="cart-row cart-header">
                <span>Product</span>
                <span>Price</span>
                <span>Quantity</span>
                <span>Subtotal</span>
                <span>Action</span>
            </div>
            <?php foreach ($items as $item): ?>
                <div class="cart-row">
                    <div class="cart-product">
                        <img src="<?php echo sanitize($item['product']['image']); ?>" alt="<?php echo sanitize($item['product']['name']); ?>">
                        <div>
                            <strong><?php echo sanitize($item['product']['name']); ?></strong>
                            <p><?php echo sanitize($item['product']['category']); ?></p>
                        </div>
                    </div>
                    <span>₹<?php echo number_format($item['product']['price'], 0); ?></span>
                    <span>
                        <input class="qty-input" type="number" min="1" value="<?php echo $item['quantity']; ?>" data-id="<?php echo $item['product']['id']; ?>">
                    </span>
                    <span>₹<?php echo number_format($item['subTotal'], 0); ?></span>
                    <span><button class="btn remove-cart" data-id="<?php echo $item['product']['id']; ?>">Remove</button></span>
                </div>
            <?php endforeach; ?>
            <div class="cart-total">
                <strong>Total: ₹<?php echo number_format($total, 0); ?></strong>
            </div>
        </div>
        <div class="checkout-actions">
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
