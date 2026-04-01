-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/04/2026 às 01:38
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cimed_farma`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL,
  `nome_empresa` varchar(100) NOT NULL,
  `cnpj` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id_fornecedor`, `nome_empresa`, `cnpj`) VALUES
(1, 'NeoQuimica', '28283283892'),
(3, 'Med', '121212121212'),
(4, 'Armandos', '0230203202');

-- --------------------------------------------------------

--
-- Estrutura para tabela `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id_medicamento` varchar(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `tarja` varchar(20) DEFAULT NULL,
  `lote` varchar(50) DEFAULT NULL,
  `validade` date DEFAULT NULL,
  `quantidade` int(11) DEFAULT 0,
  `preco` decimal(10,2) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_usuario_cad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medicamentos`
--

INSERT INTO `medicamentos` (`id_medicamento`, `nome`, `tipo`, `tarja`, `lote`, `validade`, `quantidade`, `preco`, `id_fornecedor`, `id_usuario_cad`) VALUES
('22222', 'Elax', 'Genérico', 'Preta', 'XKE2', '2025-05-02', 8, 22.00, 4, 1),
('23333', 'ZINCOX3', 'Genérico', 'Vermelha', 'DMDW', '2007-03-30', 7, 28.00, 4, 1),
('32323', 'Zerax', 'Genérico', 'Livre', 'OIXS', '2000-10-01', 20, 20.00, 1, 1),
('49494', 'JOCAS', 'Genérico', 'Vermelha', 'KJSAS', '2000-04-27', 5, 200.00, 4, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('admin','funcionario') DEFAULT 'funcionario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `login`, `senha`, `nivel`) VALUES
(1, 'Anderson Nunes Santos', 'anderson', '123', 'admin'),
(2, 'Anderson Nunes Santos', 'anderson1', '123', 'funcionario');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Índices de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id_medicamento`),
  ADD KEY `id_fornecedor` (`id_fornecedor`),
  ADD KEY `fk_usuario_medicamento` (`id_usuario_cad`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD CONSTRAINT `fk_usuario_medicamento` FOREIGN KEY (`id_usuario_cad`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `medicamentos_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
