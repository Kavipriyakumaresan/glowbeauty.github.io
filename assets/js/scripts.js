$(document).ready(function () {
    function updateCartCount(count) {
        $('#cart-count').text(count);
    }

    function updateWishlistCount(count) {
        $('#wishlist-count').text(count);
    }

    // Add to cart (delegated)
    $(document).on('click', '.add-cart', function () {
        const productId = $(this).data('id');
        $.post('ajax_cart.php', { action: 'add', product_id: productId, quantity: 1 }, function (response) {
            if (response.success) {
                updateCartCount(response.cart_count);
                alert(response.message);
            } else {
                alert(response.message || 'Unable to update cart.');
            }
        }, 'json');
    });

    // Wishlist
    $(document).on('click', '.add-wishlist', function () {
        const productId = $(this).data('id');
        $.post('ajax_wishlist.php', { action: 'add', product_id: productId }, function (response) {
            if (response.success) {
                updateWishlistCount(response.wishlist_count);
                alert(response.message);
            } else {
                alert(response.message || 'Unable to update wishlist.');
            }
        }, 'json');
    });

    // Buy now: add to cart then go to checkout
    $(document).on('click', '.buy-now', function () {
        const productId = $(this).data('id');
        $.post('ajax_cart.php', { action: 'add', product_id: productId, quantity: 1 }, function (response) {
            if (response.success) {
                updateCartCount(response.cart_count);
                window.location.href = 'checkout.php';
            } else {
                alert(response.message || 'Unable to buy now.');
            }
        }, 'json');
    });

    // Thumbnail click: swap main image (works on product cards and product details)
    $(document).on('click', '.product-thumb', function () {
        const src = $(this).attr('src');
        const card = $(this).closest('.product-card');
        if (card.length) {
            card.find('.product-main').attr('src', src);
            return;
        }
        const gallery = $(this).closest('.gallery');
        if (gallery.length) {
            gallery.find('#gallery-main').attr('src', src);
        }
    });

    // Remove and update handlers (delegated)
    $(document).on('click', '.remove-cart', function () {
        const productId = $(this).data('id');
        $.post('ajax_cart.php', { action: 'remove', product_id: productId }, function (response) {
            if (response.success) {
                location.reload();
            } else {
                alert(response.message || 'Unable to remove item.');
            }
        }, 'json');
    });

    $(document).on('change', '.qty-input', function () {
        const productId = $(this).data('id');
        const quantity = parseInt($(this).val(), 10);
        if (isNaN(quantity) || quantity < 1) {
            $(this).val(1);
            return;
        }
        $.post('ajax_cart.php', { action: 'update', product_id: productId, quantity: quantity }, function (response) {
            if (response.success) {
                location.reload();
            } else {
                alert(response.message || 'Unable to update quantity.');
            }
        }, 'json');
    });
});
