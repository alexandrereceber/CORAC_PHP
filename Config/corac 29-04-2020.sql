-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 29-Abr-2020 às 17:02
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `corac`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agentesautonomos`
--

CREATE TABLE `agentesautonomos` (
  `idAgentes` int(11) NOT NULL,
  `idEquipamento` int(11) NOT NULL,
  `Registro` int(11) NOT NULL,
  `Status` enum('Ativado','Desativado') NOT NULL,
  `dtCriado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cmpinformacoes`
--

CREATE TABLE `cmpinformacoes` (
  `idInfo` int(11) NOT NULL,
  `idEquipamento` int(11) NOT NULL,
  `Dominio` varchar(50) NOT NULL,
  `CPU` varchar(10) NOT NULL,
  `Memoria` mediumint(9) NOT NULL,
  `dtUpdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `controleequipamentos`
--

CREATE TABLE `controleequipamentos` (
  `idControle` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idStatus` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `Serie` varchar(50) NOT NULL,
  `Patrimonio` varchar(50) NOT NULL,
  `dtUpdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamentos`
--

CREATE TABLE `departamentos` (
  `idDepartamento` int(11) NOT NULL,
  `Nome` int(11) NOT NULL,
  `Descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipamentos`
--

CREATE TABLE `equipamentos` (
  `idEquipamentos` int(11) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Ligada` enum('Ligada','Desligada') NOT NULL DEFAULT 'Desligada',
  `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtUpdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `idLogin` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `tipousuario` enum('Comum','Gerente','Administrador') NOT NULL,
  `habilitado` bit(1) NOT NULL,
  `tentativa` tinyint(4) NOT NULL,
  `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`idLogin`, `usuario`, `senha`, `tipousuario`, `habilitado`, `tentativa`, `dtCriado`) VALUES
(2, 'alexandre.marques@riodoce.com.br', 'cdb55901623edb9109bdd3e980ea4054', 'Gerente', b'1', 1, '2020-04-28 12:53:44'),
(6, 'alexandre.marques.teste@riodoce.com.br', 'cdb55901623edb9109bdd3e980ea4054', 'Comum', b'0', 0, '2020-04-28 13:06:45');

-- --------------------------------------------------------

--
-- Estrutura da tabela `privilegios`
--

CREATE TABLE `privilegios` (
  `idPriv` int(11) NOT NULL,
  `idLogin` int(11) NOT NULL,
  `Tabela` varchar(60) NOT NULL,
  `Priv` enum('Select','Select/Insert','Select/Insert/Update','Select/Insert/Update/Delete') NOT NULL,
  `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusequipamentos`
--

CREATE TABLE `statusequipamentos` (
  `idStatus` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipoequipamentos`
--

CREATE TABLE `tipoequipamentos` (
  `idTipo` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarioinformacoes`
--

CREATE TABLE `usuarioinformacoes` (
  `idEndereco` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `dtNascimento` date DEFAULT NULL,
  `EstadoCivil` tinyint(2) DEFAULT NULL,
  `Sexo` tinyint(2) DEFAULT NULL,
  `Rua` varchar(200) DEFAULT NULL,
  `Numero` tinyint(4) DEFAULT NULL,
  `Complemento` varchar(50) NOT NULL,
  `Estado` varchar(2) DEFAULT NULL,
  `Cidade` varchar(50) DEFAULT NULL,
  `TelResidencial` varchar(30) DEFAULT NULL,
  `TelCelular` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `NomeCompleto` varchar(200) NOT NULL,
  `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agentesautonomos`
--
ALTER TABLE `agentesautonomos`
  ADD PRIMARY KEY (`idAgentes`);

--
-- Indexes for table `cmpinformacoes`
--
ALTER TABLE `cmpinformacoes`
  ADD PRIMARY KEY (`idInfo`),
  ADD KEY `IdxEquipamento` (`idEquipamento`);

--
-- Indexes for table `controleequipamentos`
--
ALTER TABLE `controleequipamentos`
  ADD PRIMARY KEY (`idControle`),
  ADD KEY `idUsuario` (`idUsuario`,`idStatus`),
  ADD KEY `ChExStatus` (`idStatus`),
  ADD KEY `idDepartamento` (`idDepartamento`);

--
-- Indexes for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`idDepartamento`);

--
-- Indexes for table `equipamentos`
--
ALTER TABLE `equipamentos`
  ADD PRIMARY KEY (`idEquipamentos`),
  ADD KEY `IdxNomeMaquina` (`Nome`) USING BTREE,
  ADD KEY `IdxTipo` (`idTipo`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idLogin`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indexes for table `privilegios`
--
ALTER TABLE `privilegios`
  ADD PRIMARY KEY (`idPriv`),
  ADD KEY `FK_IDLogin` (`idLogin`);

--
-- Indexes for table `statusequipamentos`
--
ALTER TABLE `statusequipamentos`
  ADD PRIMARY KEY (`idStatus`);

--
-- Indexes for table `tipoequipamentos`
--
ALTER TABLE `tipoequipamentos`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indexes for table `usuarioinformacoes`
--
ALTER TABLE `usuarioinformacoes`
  ADD PRIMARY KEY (`idEndereco`),
  ADD KEY `idUsuarioEx` (`idUsuario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cmpinformacoes`
--
ALTER TABLE `cmpinformacoes`
  MODIFY `idInfo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `controleequipamentos`
--
ALTER TABLE `controleequipamentos`
  MODIFY `idControle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipamentos`
--
ALTER TABLE `equipamentos`
  MODIFY `idEquipamentos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `idLogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `privilegios`
--
ALTER TABLE `privilegios`
  MODIFY `idPriv` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statusequipamentos`
--
ALTER TABLE `statusequipamentos`
  MODIFY `idStatus` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipoequipamentos`
--
ALTER TABLE `tipoequipamentos`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarioinformacoes`
--
ALTER TABLE `usuarioinformacoes`
  MODIFY `idEndereco` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `cmpinformacoes`
--
ALTER TABLE `cmpinformacoes`
  ADD CONSTRAINT `ChExInfoEqui` FOREIGN KEY (`idEquipamento`) REFERENCES `equipamentos` (`idEquipamentos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `controleequipamentos`
--
ALTER TABLE `controleequipamentos`
  ADD CONSTRAINT `ChExDepartamento` FOREIGN KEY (`idDepartamento`) REFERENCES `departamentos` (`idDepartamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ChExStatus` FOREIGN KEY (`idStatus`) REFERENCES `statusequipamentos` (`idStatus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ChExUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  ADD CONSTRAINT `ChExTipo` FOREIGN KEY (`idTipo`) REFERENCES `tipoequipamentos` (`idTipo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `privilegios`
--
ALTER TABLE `privilegios`
  ADD CONSTRAINT `FK_IDLogin` FOREIGN KEY (`idLogin`) REFERENCES `login` (`idLogin`);

--
-- Limitadores para a tabela `usuarioinformacoes`
--
ALTER TABLE `usuarioinformacoes`
  ADD CONSTRAINT `Dono` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
