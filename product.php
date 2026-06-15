<?php
require_once __DIR__ . '/includes/header.php';
$prodId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$prodId) {
    header('Location: products.php');
    exit;
}
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$prodId]);
$product = $stmt->fetch();
if (!$product) {
    echo '<section class="section"><p>Product not found.</p></section>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
$images = [];
if (!empty($product['images'])) {
    $images = json_decode($product['images'], true);
    if (!$images) {
        $images = array_filter(array_map('trim', explode(',', $product['images'])));
    }
}
if (empty($images)) {
    $images[] = $product['image'];
}
?>
<section class="section product-details">
    <div class="details-grid">
        <div class="gallery">
            <img id="gallery-main" src="<?php echo sanitize($images[0]); ?>" alt="<?php echo sanitize($product['name']); ?>">
            <div class="thumbs">
                <?php foreach ($images as $img): ?>
                    <img class="product-thumb" src="<?php echo sanitize($img); ?>" alt="thumb">
                <?php endforeach; ?>
            </div>
        </div>
        <div class="info">
            <h2><?php echo sanitize($product['name']); ?></h2>
            <p class="price">₹<?php echo number_format($product['price'], 0); ?></p>
            <?php if (!empty($product['short_desc'])): ?>
                <p class="desc"><?php echo sanitize($product['short_desc']); ?></p>
            <?php endif; ?>
            <div class="actions">
                <button class="btn add-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
                <button class="btn buy-now" data-id="<?php echo $product['id']; ?>">Buy Now</button>
                <button class="btn add-wishlist" data-id="<?php echo $product['id']; ?>">Add to Wishlist</button>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
