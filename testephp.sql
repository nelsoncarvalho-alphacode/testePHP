-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 04/10/2025 às 01:48
-- Versão do servidor: 8.0.43
-- Versão do PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `testephp`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` char(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cpf`, `email`, `telefone`, `endereco`, `created_at`, `updated_at`) VALUES
(1, 'João Silva', '12345678901', 'joao@email.com', '(11) 98765-4321', 'Rua A, 123', '2025-10-01 01:45:13', '2025-10-01 01:45:13'),
(2, 'Maria Santos', '98765432109', 'maria@email.com', '(11) 91234-5678', 'Av. B, 456', '2025-10-01 01:45:13', '2025-10-01 01:45:13'),
(3, 'Pedro Oliveira', '45678912345', 'pedro@email.com', '(11) 99999-8888', 'Rua C, 789', '2025-10-01 01:45:13', '2025-10-01 01:45:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `numero_pedido` varchar(20) NOT NULL,
  `cliente_id` int NOT NULL,
  `data_pedido` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Em Aberto','Pago','Cancelado') NOT NULL DEFAULT 'Em Aberto',
  `desconto` decimal(10,2) DEFAULT '0.00',
  `valor_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `observacoes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `numero_pedido`, `cliente_id`, `data_pedido`, `status`, `desconto`, `valor_total`, `observacoes`, `created_at`, `updated_at`) VALUES
(1, 'PED-2025-001', 1, '2025-09-01 10:30:00', 'Pago', 0.00, 3650.00, NULL, '2025-10-01 01:45:13', '2025-10-01 01:45:13'),
(2, 'PED-2025-002', 2, '2025-09-15 14:20:00', 'Em Aberto', 100.00, 1150.00, NULL, '2025-10-01 01:45:13', '2025-10-01 01:45:13'),
(3, 'PED-2025-003', 3, '2025-09-20 16:45:00', 'Cancelado', 0.00, 800.00, NULL, '2025-10-01 01:45:13', '2025-10-01 01:45:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_itens`
--

CREATE TABLE `pedido_itens` (
  `id` int NOT NULL,
  `pedido_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pedido_itens`
--

INSERT INTO `pedido_itens` (`id`, `pedido_id`, `produto_id`, `quantidade`, `valor_unitario`, `subtotal`, `created_at`) VALUES
(1, 1, 1, 1, 3500.00, 3500.00, '2025-10-01 01:45:13'),
(2, 1, 2, 1, 150.00, 150.00, '2025-10-01 01:45:13'),
(3, 2, 3, 1, 450.00, 450.00, '2025-10-01 01:45:13'),
(4, 2, 4, 1, 800.00, 800.00, '2025-10-01 01:45:13'),
(5, 3, 4, 1, 800.00, 800.00, '2025-10-01 01:45:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cod_barras` varchar(20) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int NOT NULL DEFAULT '0',
  `descricao` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `cod_barras`, `preco`, `estoque`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Notebook Dell', '7891234567890', 3500.00, 10, 'Notebook Dell Inspiron 15', '2025-10-01 01:45:13', '2025-10-01 01:45:13'),
(2, 'Mouse Logitech', '7891234567891', 150.00, 50, 'Mouse Logitech MX Master 3', '2025-10-01 01:45:13', '2025-10-01 01:45:13'),
(3, 'Teclado Mecânico', '7891234567892', 450.00, 30, 'Teclado Mecânico RGB', '2025-10-01 01:45:13', '2025-10-01 01:45:13'),
(4, 'Monitor LG 24\"', '7891234567893', 800.00, 15, 'Monitor LG 24 polegadas Full HD', '2025-10-01 01:45:13', '2025-10-01 01:45:13'),
(5, 'Webcam Logitech', '7891234567894', 350.00, 25, 'Webcam Logitech C920', '2025-10-01 01:45:13', '2025-10-01 01:45:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `created_at`, `updated_at`) VALUES
(2, 'teste', 'teste@gmail.com', '$2y$10$p4ZrDdt6gMjjnsVStbQbl.Q.jvOJyL05uMc9lSvXdBu3HzI2x.3eS', '2025-10-02 01:17:41', '2025-10-02 01:17:41'),
(3, 'Administrador', 'admin@teste.com', '$2y$10$0jqQ94OvSbKvVVhieGTIGuAOV4yfDP9lRUCp1x5P/xiVY..cUUJ52', '2025-10-03 00:42:09', '2025-10-03 00:42:09');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `idx_nome` (`nome`),
  ADD KEY `idx_cpf` (`cpf`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_pedido` (`numero_pedido`),
  ADD KEY `idx_numero` (`numero_pedido`),
  ADD KEY `idx_cliente` (`cliente_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_data` (`data_pedido`);

--
-- Índices de tabela `pedido_itens`
--
ALTER TABLE `pedido_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pedido` (`pedido_id`),
  ADD KEY `idx_produto` (`produto_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cod_barras` (`cod_barras`),
  ADD KEY `idx_nome` (`nome`),
  ADD KEY `idx_cod_barras` (`cod_barras`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pedido_itens`
--
ALTER TABLE `pedido_itens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE RESTRICT;

--
-- Restrições para tabelas `pedido_itens`
--
ALTER TABLE `pedido_itens`
  ADD CONSTRAINT `pedido_itens_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_itens_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
