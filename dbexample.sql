-- Criação das tabelas do banco de dados (testephp)

-- Primeiro, crie a database:

CREATE DATABASE testephp;

-- Depois, crie as tabelas necessárias

-- Tabela de Usuários (para autenticação)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    email VARCHAR(100),
    telefone VARCHAR(20),
    endereco VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nome (nome),
    INDEX idx_cpf (cpf)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cod_barras VARCHAR(20) UNIQUE,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nome (nome),
    INDEX idx_cod_barras (cod_barras)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_pedido VARCHAR(20) NOT NULL UNIQUE,
    cliente_id INT NOT NULL,
    data_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Em Aberto', 'Pago', 'Cancelado') NOT NULL DEFAULT 'Em Aberto',
    desconto DECIMAL(10, 2) DEFAULT 0.00,
    valor_total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    observacoes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT,
    INDEX idx_numero (numero_pedido),
    INDEX idx_cliente (cliente_id),
    INDEX idx_status (status),
    INDEX idx_data (data_pedido)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Itens do Pedido
CREATE TABLE IF NOT EXISTS pedido_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
    INDEX idx_pedido (pedido_id),
    INDEX idx_produto (produto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SEED

-- Use esses comandos para popular as tabelas do banco de dados criado

-- Inserir usuário admin padrão (senha: admin123)
INSERT INTO usuarios (nome, email, senha) VALUES 
('Administrador', 'admin@teste.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Dados de exemplo para Clientes
INSERT INTO clientes (nome, cpf, email, telefone, endereco) VALUES
('João Silva', '12345678901', 'joao@email.com', '(11) 98765-4321', 'Rua A, 123'),
('Maria Santos', '98765432109', 'maria@email.com', '(11) 91234-5678', 'Av. B, 456'),
('Pedro Oliveira', '45678912345', 'pedro@email.com', '(11) 99999-8888', 'Rua C, 789');

-- Dados de exemplo para Produtos
INSERT INTO produtos (nome, cod_barras, preco, estoque, descricao) VALUES
('Notebook Dell', '7891234567890', 3500.00, 10, 'Notebook Dell Inspiron 15'),
('Mouse Logitech', '7891234567891', 150.00, 50, 'Mouse Logitech MX Master 3'),
('Teclado Mecânico', '7891234567892', 450.00, 30, 'Teclado Mecânico RGB'),
('Monitor LG 24"', '7891234567893', 800.00, 15, 'Monitor LG 24 polegadas Full HD'),
('Webcam Logitech', '7891234567894', 350.00, 25, 'Webcam Logitech C920');

-- Dados de exemplo para Pedidos
INSERT INTO pedidos (numero_pedido, cliente_id, data_pedido, status, desconto, valor_total) VALUES
('PED-2025-001', 1, '2025-09-01 10:30:00', 'Pago', 0.00, 3650.00),
('PED-2025-002', 2, '2025-09-15 14:20:00', 'Em Aberto', 100.00, 1150.00),
('PED-2025-003', 3, '2025-09-20 16:45:00', 'Cancelado', 0.00, 800.00);

-- Dados de exemplo para Itens dos Pedidos
INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, valor_unitario, subtotal) VALUES
(1, 1, 1, 3500.00, 3500.00),
(1, 2, 1, 150.00, 150.00),
(2, 3, 1, 450.00, 450.00),
(2, 4, 1, 800.00, 800.00),
(3, 4, 1, 800.00, 800.00);