# GlowBeauty Ecommerce Website

This project is a complete frontend and backend ecommerce website for "Online beautycare and skincare product" built with PHP, MySQL, jQuery, and vanilla JavaScript.

## Setup Instructions

1. Install PHP and MySQL on your Windows machine.
2. Copy the project folder into your web server root (for example, `C:\xampp\htdocs\ecommers` or `C:\inetpub\wwwroot\ecommers`).
3. Create the database:
   - Open MySQL Workbench or phpMyAdmin.
   - Run the SQL in `database.sql`.
4. Update database credentials if needed in `includes/db.php`.
5. Start your PHP server and open `http://localhost/ecommers/index.php`.

## Files Added

- `index.php`, `products.php`, `categories.php`, `skincare.php`, `contact.php`
- `cart.php`, `checkout.php`, `order_success.php`
- `login.php`, `register.php`, `logout.php`
- `ajax_cart.php`
- `includes/db.php`, `includes/functions.php`, `includes/header.php`, `includes/footer.php`
- `assets/js/scripts.js`
- `database.sql`

## Features

- Dynamic product listing from MySQL
- Category filtering and search
- Add to cart with AJAX
- Cart and checkout flow with order saving
- Contact form saved to database
- User registration and login

## Notes

- Use `index.php` instead of the old HTML files so the PHP backend is active.
- If you need admin or product management pages, I can add them next.
