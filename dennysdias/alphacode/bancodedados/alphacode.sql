-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/02/2024 às 01:39
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `alphacode`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidato`
--

CREATE TABLE `candidato` (
  `idcandidato` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `endereco` text DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `idpais` bigint(20) NOT NULL,
  `idestado` bigint(20) NOT NULL,
  `idcidade` bigint(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `candidato`
--

INSERT INTO `candidato` (`idcandidato`, `nome`, `endereco`, `numero`, `bairro`, `cep`, `idpais`, `idestado`, `idcidade`, `email`, `rg`, `cpf`, `cnpj`, `telefone`, `celular`, `obs`) VALUES
(1, 'Dennys Dias Lopes', '', '', '', '', 1, 1, 1, '', '', '111.111.111-11', '', '', '', ''),
(2, 'Ana maria oliveira dias', NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Joana', 'rua  rogaciano leite ', '100', 'luciano cavalcante', NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Sodexo', NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `centrodecusto`
--

CREATE TABLE `centrodecusto` (
  `idcentrodecusto` bigint(20) UNSIGNED NOT NULL,
  `centrodecusto` varchar(100) NOT NULL,
  `endereco` text DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `centrodecusto`
--

INSERT INTO `centrodecusto` (`idcentrodecusto`, `centrodecusto`, `endereco`, `numero`, `bairro`, `cep`, `email`, `telefone`) VALUES
(1, 'Alphacode unidade I', '', '', '', '', 'teste@alphacode.com.br', '(99) 99999-9999'),
(3, 'Alphacode unidade II', NULL, NULL, NULL, NULL, 'teste@alphacode.com.br', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidade`
--

CREATE TABLE `cidade` (
  `idcidade` bigint(20) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `idpais` bigint(20) NOT NULL,
  `idestado` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cidade`
--

INSERT INTO `cidade` (`idcidade`, `cidade`, `idpais`, `idestado`) VALUES
(1, 'Fortaleza', 1, 1),
(2, 'São Paulo', 1, 2),
(3, 'Rio de Janeiro', 1, 3),
(6, 'Salvador', 1, 5),
(11, 'Jericoacoara', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `endereco` text DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `idpais` bigint(20) NOT NULL,
  `idestado` bigint(20) NOT NULL,
  `idcidade` bigint(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nome`, `endereco`, `numero`, `bairro`, `cep`, `idpais`, `idestado`, `idcidade`, `email`, `rg`, `cpf`, `cnpj`, `telefone`, `celular`, `obs`) VALUES
(1, 'Dennys Dias Lopes', '', '', '', '', 1, 1, 1, '', '', '111.111.111-11', '', '', '', ''),
(2, 'Ana maria oliveira dias', NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Joana', 'rua  rogaciano leite ', '100', 'luciano cavalcante', NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Sodexo', NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `estado`
--

CREATE TABLE `estado` (
  `idestado` bigint(20) NOT NULL,
  `sigla` varchar(10) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `idpais` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `estado`
--

INSERT INTO `estado` (`idestado`, `sigla`, `estado`, `idpais`) VALUES
(1, 'CE', 'Ceará', 1),
(2, 'SP', 'São Paulo', 1),
(3, 'RJ', 'Rio de Janeiro', 1),
(5, 'BA', 'Bahia', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivelacesso`
--

CREATE TABLE `nivelacesso` (
  `idnivelacesso` bigint(20) NOT NULL,
  `nivelacesso` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `nivelacesso`
--

INSERT INTO `nivelacesso` (`idnivelacesso`, `nivelacesso`) VALUES
(2, 'Gerente de unidade'),
(4, 'Atendente de curso'),
(5, 'Financeiro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pais`
--

CREATE TABLE `pais` (
  `idpais` bigint(20) NOT NULL,
  `pais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `pais`
--

INSERT INTO `pais` (`idpais`, `pais`) VALUES
(1, 'Brasil');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `funcionario` varchar(200) NOT NULL,
  `login` varchar(10) NOT NULL,
  `senha` varchar(10) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `telefone` varchar(16) NOT NULL,
  `idsolucao` int(11) NOT NULL,
  `idnivelacesso` int(11) NOT NULL,
  `datanascimento` date NOT NULL,
  `idcentrodecusto` bigint(20) NOT NULL,
  `usuarios` tinyint(1) NOT NULL,
  `alterarsenha` tinyint(1) NOT NULL,
  `painel` tinyint(1) NOT NULL,
  `solucoes` tinyint(1) NOT NULL,
  `nivelacesso` tinyint(1) NOT NULL,
  `centro` tinyint(1) NOT NULL,
  `relatoriousuarios` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nome`, `funcionario`, `login`, `senha`, `cpf`, `cnpj`, `telefone`, `idsolucao`, `idnivelacesso`, `datanascimento`, `idcentrodecusto`, `usuarios`, `alterarsenha`, `painel`, `solucoes`, `nivelacesso`, `centro`, `relatoriousuarios`) VALUES
(3, 'Dennys Dias Lopes ', 'Dennys Dias Lopes', 'dennys', '123', '619.349.093-00', '18.331.736/0001-08', '(11) 11111-1111', 2, 4, '2021-02-01', 1, 1, 1, 1, 1, 1, 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `candidato`
--
ALTER TABLE `candidato`
  ADD PRIMARY KEY (`idcandidato`),
  ADD UNIQUE KEY `idcandidato` (`idcandidato`);

--
-- Índices de tabela `centrodecusto`
--
ALTER TABLE `centrodecusto`
  ADD PRIMARY KEY (`idcentrodecusto`),
  ADD UNIQUE KEY `idcentrodecusto` (`idcentrodecusto`);

--
-- Índices de tabela `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`idcidade`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD UNIQUE KEY `idcliente` (`idcliente`);

--
-- Índices de tabela `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idestado`);

--
-- Índices de tabela `nivelacesso`
--
ALTER TABLE `nivelacesso`
  ADD PRIMARY KEY (`idnivelacesso`);

--
-- Índices de tabela `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`idpais`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `candidato`
--
ALTER TABLE `candidato`
  MODIFY `idcandidato` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `centrodecusto`
--
ALTER TABLE `centrodecusto`
  MODIFY `idcentrodecusto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cidade`
--
ALTER TABLE `cidade`
  MODIFY `idcidade` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `estado`
--
ALTER TABLE `estado`
  MODIFY `idestado` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `nivelacesso`
--
ALTER TABLE `nivelacesso`
  MODIFY `idnivelacesso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pais`
--
ALTER TABLE `pais`
  MODIFY `idpais` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
