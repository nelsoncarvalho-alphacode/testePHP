-- Script de inicialização do banco de dados para Docker
-- Este arquivo será executado automaticamente quando o container MySQL for criado

CREATE DATABASE IF NOT EXISTS ordersapp;
USE ordersapp;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    cpf VARCHAR(14),
    endereco TEXT,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de produtos
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    value DECIMAL(10,2) NOT NULL,
    image_file VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de pedidos
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    barcode VARCHAR(255) UNIQUE NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    status ENUM('Pendente', 'Processando', 'Enviado', 'Entregue', 'Cancelado') DEFAULT 'Pendente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de itens do pedido
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    qty INT NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Inserir usuário administrador padrão
INSERT INTO users (name, email, cpf, endereco, password, is_admin) VALUES 
('Admin', 'admin@admin.com', '000.000.000-00', 'Rua Francisco dos Reis, 425 - São Paulo - SP', '$2y$10$3j/eCJDdmKt17EZBtpN6UeiZqtH3ytIYwbY.9wduG4qbKhnaU.1iW', 1)
ON DUPLICATE KEY UPDATE id=id;