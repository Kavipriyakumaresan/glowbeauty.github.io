<?php
require_once __DIR__ . '/includes/header.php';
$selectedCategory = $_GET['category'] ?? 'All';
$products = $selectedCategory === 'All' ? fetchProducts($pdo) : fetchProducts($pdo, $selectedCategory);
$categories = fetchCategories($pdo);
?>

<section class="section">
    <h2>Shop By Category</h2>
    <div class="filter-buttons">
        <a class="filter-link <?php echo $selectedCategory === 'All' ? 'active' : ''; ?>" href="categories.php?category=All">All</a>
        <?php foreach ($categories as $category): ?>
            <a class="filter-link <?php echo $selectedCategory === $category ? 'active' : ''; ?>" href="categories.php?category=<?php echo urlencode($category); ?>"><?php echo sanitize($category); ?></a>
        <?php endforeach; ?>
    </div>

    <div class="products">
        <?php if (empty($products)): ?>
            <p class="empty-message">No products are available in this category right now.</p>
        <?php endif; ?>

        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?php echo sanitize($product['image']); ?>" alt="<?php echo sanitize($product['name']); ?>">
                <h3><?php echo sanitize($product['name']); ?></h3>
                <p class="product-category"><?php echo sanitize($product['category']); ?></p>
                <div class="price">₹<?php echo number_format($product['price'], 0); ?></div>
                <button class="btn add-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
