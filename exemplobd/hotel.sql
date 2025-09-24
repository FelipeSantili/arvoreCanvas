-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 12-Set-2025 às 23:30
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hotel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `hospedagens`
--

CREATE TABLE `hospedagens` (
  `id` int(11) NOT NULL,
  `numero_hospedes` int(11) NOT NULL,
  `tipo_viagem` enum('Romântica','Trabalho','Família','Lazer') NOT NULL,
  `orcamento` enum('Baixo','Médio','Alto') NOT NULL,
  `preferencia` enum('Spa','Transfer','Café da manhã','Piscina') NOT NULL,
  `quarto_escolhido` enum('Suíte Master','Executivo','Standard','Luxo') NOT NULL,
  `codigo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `hospedagens`
--

INSERT INTO `hospedagens` (`id`, `numero_hospedes`, `tipo_viagem`, `orcamento`, `preferencia`, `quarto_escolhido`, `codigo`) VALUES
(1, 2, 'Romântica', 'Médio', 'Spa', 'Luxo', 'h11'),
(2, 3, 'Família', 'Baixo', 'Piscina', 'Standard', 'h12'),
(3, 1, 'Trabalho', 'Alto', 'Transfer', 'Executivo', 'h13'),
(4, 4, 'Lazer', 'Médio', 'Piscina', 'Luxo', 'h14'),
(5, 2, 'Romântica', 'Baixo', 'Café da manhã', 'Standard', 'h15'),
(6, 3, 'Família', 'Alto', 'Spa', 'Suíte Master', 'h16'),
(7, 1, 'Trabalho', 'Médio', 'Transfer', 'Executivo', 'h17'),
(8, 4, 'Lazer', 'Baixo', 'Café da manhã', 'Standard', 'h18'),
(9, 2, 'Romântica', 'Alto', 'Spa', 'Luxo', 'h19'),
(10, 3, 'Família', 'Médio', 'Piscina', 'Luxo', 'h20'),
(11, 1, 'Trabalho', 'Baixo', 'Café da manhã', 'Standard', 'h21'),
(12, 2, 'Romântica', 'Médio', 'Spa', 'Luxo', 'h22'),
(13, 3, 'Família', 'Baixo', 'Piscina', 'Standard', 'h23'),
(14, 4, 'Lazer', 'Alto', 'Spa', 'Suíte Master', 'h24'),
(15, 2, 'Romântica', 'Médio', 'Café da manhã', 'Executivo', 'h25'),
(16, 1, 'Trabalho', 'Baixo', 'Piscina', 'Standard', 'h26'),
(17, 3, 'Família', 'Médio', 'Transfer', 'Executivo', 'h27'),
(18, 4, 'Lazer', 'Baixo', 'Café da manhã', 'Luxo', 'h28'),
(19, 2, 'Romântica', 'Alto', 'Spa', 'Luxo', 'h29'),
(20, 1, 'Trabalho', 'Médio', 'Transfer', 'Executivo', 'h30'),
(21, 3, 'Família', 'Baixo', 'Piscina', 'Standard', 'h31'),
(22, 4, 'Lazer', 'Médio', 'Café da manhã', 'Luxo', 'h32'),
(23, 2, 'Romântica', 'Baixo', 'Spa', 'Executivo', 'h33'),
(24, 1, 'Trabalho', 'Alto', 'Café da manhã', 'Standard', 'h34'),
(25, 3, 'Família', 'Médio', 'Piscina', 'Luxo', 'h35'),
(26, 2, 'Romântica', 'Baixo', 'Transfer', 'Executivo', 'h36'),
(27, 4, 'Lazer', 'Alto', 'Spa', 'Suíte Master', 'h37'),
(28, 3, 'Família', 'Baixo', 'Café da manhã', 'Standard', 'h38'),
(29, 2, 'Romântica', 'Médio', 'Piscina', 'Luxo', 'h39'),
(30, 1, 'Trabalho', 'Médio', 'Transfer', 'Executivo', 'h40');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `hospedagens`
--
ALTER TABLE `hospedagens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `hospedagens`
--
ALTER TABLE `hospedagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
