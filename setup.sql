-- setup.sql - Database setup script for PHP Store

CREATE DATABASE IF NOT EXISTS phpstore;

USE phpstore;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL
);

INSERT INTO products (name, description, price) VALUES
('Laptop', 'A powerful laptop for work and gaming', 999.99),
('Mouse', 'Wireless optical mouse', 25.50),
('Keyboard', 'Mechanical keyboard with RGB lights', 89.99),
('Monitor', '27-inch 4K monitor', 349.99),
('Headphones', 'Noise-cancelling wireless headphones', 199.99);