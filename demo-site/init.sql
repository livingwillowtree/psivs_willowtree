CREATE DATABASE IF NOT EXISTS shop;
USE shop;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  description TEXT,
  price DECIMAL(10,2),
  image VARCHAR(255),
  category VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS attachments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    filename VARCHAR(255)
);


INSERT INTO products (name, description, price, image, category) VALUES
('Gaming Laptop', 'High performance laptop for gaming', 1299.99, 'laptop.jpg', 'Electronics'),
('Smartphone Pro', 'Latest smartphone with OLED display', 899.99, 'smartphone.jpg', 'Electronics'),
('Wireless Headphones', 'Noise cancelling over-ear headphones', 199.99, 'headphones.jpg', 'Accessories'),
('Mechanical Keyboard', 'RGB mechanical keyboard', 149.99, 'keyboard.jpg', 'Accessories');

CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  author VARCHAR(50),
  content TEXT
);

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(50)
);

INSERT INTO admins (username, password) VALUES
('admin', 'supersecret'),
('manager', 'password123');

