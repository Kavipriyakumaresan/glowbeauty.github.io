<?php
require_once __DIR__ . '/includes/db.php';
header('Content-Type: application/json');
$action = $_POST['action'] ?? '';
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$response = ['success' => false];

if (!$productId) {
    echo json_encode(['success' => false, 'message' => 'Invalid product.']);
    exit;
}

switch ($action) {
    case 'add':
        if (!isset($_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = [];
        }
        $_SESSION['wishlist'][$productId] = true;
        $response['success'] = true;
        $response['message'] = 'Added to wishlist.';
        break;
    case 'remove':
        if (isset($_SESSION['wishlist'][$productId])) {
            unset($_SESSION['wishlist'][$productId]);
            $response['success'] = true;
            $response['message'] = 'Removed from wishlist.';
        } else {
            $response['message'] = 'Item not in wishlist.';
        }
        break;
    default:
        $response['message'] = 'Unknown action.';
}

$response['wishlist_count'] = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
echo json_encode($response);
