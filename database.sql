-- MySQL database schema for GlowBeauty ecommerce website

CREATE DATABASE IF NOT EXISTS glowbeauty CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE glowbeauty;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    images TEXT DEFAULT NULL,
    short_desc VARCHAR(255) DEFAULT NULL,
    stock INT NOT NULL DEFAULT 100
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(40) NOT NULL,
    address TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL
);

INSERT INTO products (name, category, price, image, short_desc, stock) VALUES
('Aloe Vera Gel', 'Skincare', 299, 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=800&auto=format&fit=crop&q=80', 'Cooling, soothing hydrate', 120),
('Herbal Face Cream', 'Skincare', 499, 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800&auto=format&fit=crop&q=80', 'Nourishes skin deeply', 110),
('Vitamin C Serum', 'Skincare', 899, 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=800&auto=format&fit=crop&q=80', 'Brightens and fades spots', 90),
('Luxury Moisturizer', 'Skincare', 849, 'https://images.unsplash.com/photo-1619451334792-150fd785ee74?w=800&auto=format&fit=crop&q=80', 'Silky hydration for all skin types', 100),
('Glow Face Serum', 'Skincare', 999, 'https://images.unsplash.com/photo-1608248597279-f99d160bfcbc?w=800&auto=format&fit=crop&q=80', 'Soft glow finishing serum', 100),
('Matte Lipstick', 'Makeup', 699, 'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?w=800&auto=format&fit=crop&q=80', 'Long lasting matte finish', 150),
('Eyeshadow Palette', 'Makeup', 1499, 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=800&auto=format&fit=crop&q=80', 'Professional palette with neutrals', 75),
('Hydrating Face Mist', 'Beautycare', 499, 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=800&auto=format&fit=crop&q=80', 'Instant hydration spray', 130),
('Keratin Smooth Shampoo', 'Haircare', 649, 'images/ker.jpg', 'Smoothing care for damaged hair', 95),
('Anti-Hair Fall Serum', 'Haircare', 999, 'images/serum.jpg', 'Strengthen and repair follicles', 85);
