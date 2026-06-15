<?php
require_once __DIR__ . '/includes/db.php';
header('Content-Type: application/json');
$response = ['success' => false];
$action = $_POST['action'] ?? '';
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;

if (!$productId) {
    echo json_encode(['success' => false, 'message' => 'Invalid product.']);
    exit;
}

switch ($action) {
    case 'add':
        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = ['quantity' => $quantity];
        } else {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        }
        $response['success'] = true;
        $response['message'] = 'Product added to cart.';
        break;
    case 'remove':
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            $response['success'] = true;
            $response['message'] = 'Item removed from cart.';
        } else {
            $response['message'] = 'Item not found in cart.';
        }
        break;
    case 'update':
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
            $response['success'] = true;
            $response['message'] = 'Cart updated.';
        } else {
            $response['message'] = 'Item not found in cart.';
        }
        break;
    default:
        $response['message'] = 'Unknown action.';
}

$response['cart_count'] = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
echo json_encode($response);
