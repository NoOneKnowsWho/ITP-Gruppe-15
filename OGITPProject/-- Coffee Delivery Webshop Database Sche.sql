-- Coffee Delivery Webshop Database Schema
-- Created for PHP-based coffee webshop

-- Create database
CREATE DATABASE IF NOT EXISTS coffee_webshop;
USE coffee_webshop;

-- Users table for customer management
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- Categories table for product organization
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table (enhanced from your JSON structure)
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    category_id INT,
    stock_quantity INT DEFAULT 0,
    weight DECIMAL(8,2), -- in grams
    origin_country VARCHAR(100),
    roast_level ENUM('light', 'medium', 'dark') DEFAULT 'medium',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Addresses table for delivery locations
CREATE TABLE addresses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    address_type ENUM('billing', 'shipping', 'both') DEFAULT 'both',
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    company VARCHAR(100),
    street_address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(100) DEFAULT 'Deutschland',
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Orders table for order management
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(10,2) NOT NULL,
    shipping_cost DECIMAL(10,2) DEFAULT 0.00,
    tax_amount DECIMAL(10,2) DEFAULT 0.00,
    payment_method ENUM('credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery') NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    shipping_address_id INT,
    billing_address_id INT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (shipping_address_id) REFERENCES addresses(id) ON DELETE SET NULL,
    FOREIGN KEY (billing_address_id) REFERENCES addresses(id) ON DELETE SET NULL
);

-- Order items table for order details
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Shopping cart table (persistent cart storage)
CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    session_id VARCHAR(255), -- For guest users
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id),
    UNIQUE KEY unique_session_item (session_id, product_id)
);

-- Reviews table for product reviews
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    order_id INT, -- Link to verified purchase
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(255),
    comment TEXT,
    is_verified_purchase BOOLEAN DEFAULT FALSE,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL,
    UNIQUE KEY unique_user_product_review (user_id, product_id)
);

-- Coupons table for discount management
CREATE TABLE coupons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    description VARCHAR(255),
    discount_type ENUM('percentage', 'fixed_amount') NOT NULL,
    discount_value DECIMAL(10,2) NOT NULL,
    minimum_order_amount DECIMAL(10,2) DEFAULT 0.00,
    usage_limit INT DEFAULT NULL, -- NULL means unlimited
    usage_count INT DEFAULT 0,
    valid_from DATE NOT NULL,
    valid_until DATE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order coupons junction table
CREATE TABLE order_coupons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    coupon_id INT NOT NULL,
    discount_amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
);

-- Contact messages table (from contact forms)
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Newsletter subscribers table
CREATE TABLE newsletter_subscribers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL
);

-- Insert sample categories
INSERT INTO categories (name, description) VALUES 
('Kaffeebohnen', 'Premium Kaffeebohnen aus aller Welt'),
('Filterkaffee', 'Gemahlener Kaffee für Filterzubereitung'),
('Zubehör', 'Kaffee-Zubehör und Filter');

-- Insert sample products (matching your JSON structure)
INSERT INTO products (name, price, image, category_id, description, stock_quantity) VALUES 
('Kaffee Bohnen', 50.00, 'image/coffeebeans.png', 1, 'Premium Arabica Kaffeebohnen', 100),
('Filterkaffee', 50.00, 'image/coffeefilter.png', 2, 'Gemahlener Filterkaffee', 150),
('Kaffee Filter', 20.00, 'image/filter.png', 3, 'Hochwertige Papierfilter', 200);

-- Create indexes for better performance
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_active ON products(is_active);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_orders_date ON orders(created_at);
CREATE INDEX idx_cart_user ON cart_items(user_id);
CREATE INDEX idx_cart_session ON cart_items(session_id);
CREATE INDEX idx_reviews_product ON reviews(product_id);
CREATE INDEX idx_reviews_user ON reviews(user_id);

-- Create views for common queries
CREATE VIEW active_products AS
SELECT p.*, c.name as category_name 
FROM products p 
LEFT JOIN categories c ON p.category_id = c.id 
WHERE p.is_active = TRUE;

CREATE VIEW order_summary AS
SELECT 
    o.*,
    u.email as customer_email,
    u.first_name,
    u.last_name,
    COUNT(oi.id) as item_count,
    SUM(oi.quantity) as total_quantity
FROM orders o
LEFT JOIN users u ON o.user_id = u.id
LEFT JOIN order_items oi ON o.id = oi.order_id
GROUP BY o.id;

-- Sample stored procedure for order creation
DELIMITER //
CREATE PROCEDURE CreateOrder(
    IN p_user_id INT,
    IN p_total_amount DECIMAL(10,2),
    IN p_shipping_cost DECIMAL(10,2),
    IN p_payment_method VARCHAR(50),
    IN p_shipping_address_id INT,
    OUT p_order_id INT
)
BEGIN
    DECLARE order_num VARCHAR(50);
    
    -- Generate order number
    SET order_num = CONCAT('ORD-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD(FLOOR(RAND() * 10000), 4, '0'));
    
    -- Insert order
    INSERT INTO orders (user_id, order_number, total_amount, shipping_cost, payment_method, shipping_address_id, billing_address_id)
    VALUES (p_user_id, order_num, p_total_amount, p_shipping_cost, p_payment_method, p_shipping_address_id, p_shipping_address_id);
    
    SET p_order_id = LAST_INSERT_ID();
END //
DELIMITER ;