CREATE DATABASE IF NOT EXISTS niren_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE niren_db;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('cetak','creamer') NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    unit VARCHAR(30) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    badge VARCHAR(50),
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(30) NOT NULL UNIQUE,
    customer_name VARCHAR(100) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address TEXT,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('baru','diproses','dikirim','selesai','dibatalkan') NOT NULL DEFAULT 'baru',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    qty INT NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, category, price, unit, description, image, badge, stock)
SELECT 'Niren Hijau', 'cetak', 50000, '1kg',
       'Untuk kamu yang suka rasa manis dan creamy.',
       'nirenhijau.jpg', 'Terlaris', 100
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Niren Hijau');

INSERT INTO products (name, category, price, unit, description, image, badge, stock)
SELECT 'Niren Orange', 'cetak', 50000, '1kg',
       'Untuk kamu yang suka Aren dengan rasa yang bold.',
       'nirenorange.jpg', 'Favorit', 100
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Niren Orange');

INSERT INTO products (name, category, price, unit, description, image, badge, stock)
SELECT 'Crimer', 'creamer', 45000, '1kg',
       'Creamer powder yang pas dipadukan dengan gula aren Niren, larut cepat dan bikin minuman lebih creamy.',
       'crimer.jpg', 'Favorit', 100
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Crimer');

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
