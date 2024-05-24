-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql110.infinityfree.com
-- Tempo de geração: 22/05/2024 às 20:51
-- Versão do servidor: 10.4.17-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_36439084_realsmile`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `AddressBase`
--

CREATE TABLE `AddressBase` (
  `id` int(11) NOT NULL,
  `cep` char(9) DEFAULT NULL,
  `uf` char(2) NOT NULL,
  `locality` varchar(100) NOT NULL,
  `neighborhood` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `houseNumber` int(11) NOT NULL,
  `employeeId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Employee`
--

CREATE TABLE `Employee` (
  `id` int(11) NOT NULL,
  `hiringDate` date NOT NULL,
  `wage` decimal(8,2) NOT NULL,
  `cro` varchar(15) NOT NULL,
  `specialty` varchar(70) NOT NULL,
  `personId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Login`
--

CREATE TABLE `Login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwordHash` varchar(256) NOT NULL,
  `employeeId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Patient`
--

CREATE TABLE `Patient` (
  `id` int(11) NOT NULL,
  `personId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Person`
--

CREATE TABLE `Person` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `sex` char(1) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Scheduling`
--

CREATE TABLE `Scheduling` (
  `id` int(11) NOT NULL,
  `consultationDate` date NOT NULL,
  `consultationTime` time NOT NULL,
  `patientId` int(11) DEFAULT NULL,
  `employeeId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `AddressBase`
--
ALTER TABLE `AddressBase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Índices de tabela `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personId` (`personId`);

--
-- Índices de tabela `Login`
--
ALTER TABLE `Login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Índices de tabela `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personId` (`personId`);

--
-- Índices de tabela `Person`
--
ALTER TABLE `Person`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `Scheduling`
--
ALTER TABLE `Scheduling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patientId` (`patientId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `AddressBase`
--
ALTER TABLE `AddressBase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Employee`
--
ALTER TABLE `Employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Login`
--
ALTER TABLE `Login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Patient`
--
ALTER TABLE `Patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Person`
--
ALTER TABLE `Person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Scheduling`
--
ALTER TABLE `Scheduling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
