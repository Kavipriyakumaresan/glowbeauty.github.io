<?php
require_once __DIR__ . '/includes/header.php';
$cartItems = $_SESSION['cart'] ?? [];
$cartTotal = cartTotalAmount($pdo);
$error = '';

if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($name && $email && $phone && $address) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('INSERT INTO orders (user_id, name, email, phone, address, total_amount, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
            $userId = $_SESSION['user']['id'] ?? null;
            $stmt->execute([$userId, $name, $email, $phone, $address, $cartTotal]);
            $orderId = $pdo->lastInsertId();

            foreach ($cartItems as $productId => $entry) {
                $quantity = (int)$entry['quantity'];
                $productStmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
                $productStmt->execute([$productId]);
                $product = $productStmt->fetch();

                if ($product) {
                    $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
                    $stmt->execute([$orderId, $productId, $quantity, $product['price']]);
                }
            }

            $pdo->commit();
            $_SESSION['cart'] = [];
            header('Location: order_success.php?order_id=' . $orderId);
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'There was a problem placing your order. Please try again.';
        }
    } else {
        $error = 'Please fill in every field to complete your order.';
    }
}
?>

<section class="section">
    <h2>Checkout</h2>
    <?php if ($error): ?>
        <div class="form-error"><?php echo sanitize($error); ?></div>
    <?php endif; ?>
    <div class="checkout-grid">
        <div class="checkout-form">
            <form method="post" action="checkout.php">
                <label>Full Name</label>
                <input type="text" name="name" required>

                <label>Email Address</label>
                <input type="email" name="email" required>

                <label>Phone Number</label>
                <input type="tel" name="phone" required>

                <label>Delivery Address</label>
                <textarea name="address" rows="5" required></textarea>

                <button class="btn" type="submit">Place Order</button>
            </form>
        </div>
        <div class="checkout-summary">
            <h3>Order Summary</h3>
            <p>Items in cart: <strong><?php echo cartItemCount(); ?></strong></p>
            <p>Total amount: <strong>₹<?php echo number_format($cartTotal, 0); ?></strong></p>
            <p>Shipping and GST included at checkout.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
