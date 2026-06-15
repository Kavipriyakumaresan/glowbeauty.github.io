<?php
require_once __DIR__ . '/includes/header.php';
$items = $_SESSION['wishlist'] ?? [];
$products = [];
if ($items) {
    $ids = array_keys($items);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();
}
?>
<section class="section">
    <h2>Your Wishlist</h2>
    <?php if (empty($products)): ?>
        <p class="empty-message">Your wishlist is empty.</p>
    <?php else: ?>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product-card" data-id="<?php echo $product['id']; ?>">
                    <img src="<?php echo sanitize($product['image']); ?>" alt="<?php echo sanitize($product['name']); ?>">
                    <h3><?php echo sanitize($product['name']); ?></h3>
                    <div class="price">₹<?php echo number_format($product['price'], 0); ?></div>
                    <div class="card-actions">
                        <button class="btn add-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
                        <button class="btn" onclick="if(confirm('Remove from wishlist?')){ $.post('ajax_wishlist.php',{action:'remove',product_id:<?php echo $product['id']; ?>},function(){ location.reload(); }); }">Remove</button>
                        <a class="btn details" href="product.php?id=<?php echo $product['id']; ?>">Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
