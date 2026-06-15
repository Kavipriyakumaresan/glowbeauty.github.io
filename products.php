<?php
require_once __DIR__ . '/includes/header.php';
$category = $_GET['category'] ?? null;
$search = $_GET['search'] ?? null;
$products = fetchProducts($pdo, $category, $search);
?>

<section class="section">
    <h2>All Products</h2>
    <form class="search-bar" method="get" action="products.php">
        <input type="text" name="search" placeholder="Search skincare, makeup, haircare..." value="<?php echo sanitize($search); ?>">
        <button type="submit" class="btn">Search</button>
    </form>

    <?php if ($category): ?>
        <p class="filter-label">Showing category: <strong><?php echo sanitize($category); ?></strong></p>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <p class="empty-message">No products found for your search.</p>
    <?php endif; ?>

    <div class="products">
        <?php foreach ($products as $product): ?>
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
                <p class="product-category"><?php echo sanitize($product['category']); ?></p>
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>
