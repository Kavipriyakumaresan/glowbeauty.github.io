<?php
require_once __DIR__ . '/includes/header.php';
$featured = fetchProducts($pdo, null, null);
?>

<section class="hero">
    <div class="hero-content">
        <h2>Discover Your Inner Glow</h2>
        <p>Luxury beauty care products for modern women.</p>
        <a href="products.php"><button class="btn">Shop Now</button></a>
    </div>
</section>

<section class="section">
    <h2>Featured Products</h2>
    <div class="products">
        <?php foreach (array_slice($featured, 0, 6) as $product): ?>
            <div class="product-card" data-id="<?php echo $product['id']; ?>">
                <div class="img-wrap">
                    <img class="product-main" src="<?php echo sanitize($product['image']); ?>" alt="<?php echo sanitize($product['name']); ?>">
                    <?php if (!empty($product['images'])):
                        $imgs = json_decode($product['images'], true);
                        if (!$imgs) $imgs = array_filter(array_map('trim', explode(',', $product['images'])));
                    ?>
                        <div class="thumbs">
                            <?php foreach ($imgs as $img): ?>
                                <img class="product-thumb" src="<?php echo sanitize($img); ?>" alt="thumb">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <h3><?php echo sanitize($product['name']); ?></h3>
                <div class="price">₹<?php echo number_format($product['price'], 0); ?></div>
                <div class="card-actions">
                    <button class="btn add-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
                    <button class="btn add-wishlist" data-id="<?php echo $product['id']; ?>">Wishlist</button>
                    <button class="btn buy-now" data-id="<?php echo $product['id']; ?>">Buy Now</button>
                    <a class="btn details" href="product.php?id=<?php echo $product['id']; ?>">Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section categories-grid">
    <h2>Shop By Category</h2>
    <?php $categories = fetchCategories($pdo); ?>
    <div class="category-cards">
        <?php foreach ($categories as $category): ?>
            <a class="category-card-link" href="categories.php?category=<?php echo urlencode($category); ?>">
                <div class="category-card">
                    <h3><?php echo sanitize($category); ?></h3>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
