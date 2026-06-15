<?php

function cartItemCount()
{
    if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        return 0;
    }
    return array_sum(array_column($_SESSION['cart'], 'quantity'));
}

function cartTotalAmount($pdo)
{
    if (empty($_SESSION['cart'])) {
        return 0;
    }
    $total = 0;
    $ids = array_keys($_SESSION['cart']);
    if (empty($ids)) {
        return 0;
    }
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();
    foreach ($products as $product) {
        $qty = $_SESSION['cart'][$product['id']]['quantity'];
        $total += $product['price'] * $qty;
    }
    return $total;
}

function fetchCategories($pdo)
{
    $stmt = $pdo->query('SELECT DISTINCT category FROM products ORDER BY category ASC');
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function fetchProducts($pdo, $category = null, $search = null)
{
    $sql = 'SELECT * FROM products';
    $clauses = [];
    $params = [];

    if ($category) {
        $clauses[] = 'category = ?';
        $params[] = $category;
    }

    if ($search) {
        $clauses[] = 'name LIKE ?';
        $params[] = '%' . $search . '%';
    }

    if ($clauses) {
        $sql .= ' WHERE ' . implode(' AND ', $clauses);
    }

    $sql .= ' ORDER BY id ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function sanitize($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
