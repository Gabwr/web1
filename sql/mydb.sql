-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 06, 2025 at 10:03 PM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `concepto`
--

CREATE TABLE `concepto` (
  `idconcepto` int(11) NOT NULL,
  `qr_id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `tipo` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `concepto`
--

INSERT INTO `concepto` (`idconcepto`, `qr_id`, `nombre`, `tipo`) VALUES
(1, 1, 'Salario', 'Ingreso'),
(2, 2, 'Compra de materiales', 'Gasto');

-- --------------------------------------------------------

--
-- Table structure for table `gasto`
--

CREATE TABLE `gasto` (
  `idGasto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idconcepto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `valor` decimal(4,2) NOT NULL,
  `medio_de_pago` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `acreedor_cobrador` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descripcion` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gasto`
--

INSERT INTO `gasto` (`idGasto`, `idUsuario`, `idconcepto`, `fecha`, `valor`, `medio_de_pago`, `acreedor_cobrador`, `descripcion`, `estado`) VALUES
(1, 1, 2, '2025-03-01', '99.99', 'Efectivo', 'Proveedor XYZ', 'Compra de materiales de oficina', '');

-- --------------------------------------------------------

--
-- Table structure for table `ingreso`
--

CREATE TABLE `ingreso` (
  `idIngreso` int(11) NOT NULL,
  `idconcepto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `valor` decimal(4,2) NOT NULL,
  `medio_de_pago` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fuente_beneficiario` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descripcion` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingreso`
--

INSERT INTO `ingreso` (`idIngreso`, `idconcepto`, `idUsuario`, `fecha`, `valor`, `medio_de_pago`, `fuente_beneficiario`, `descripcion`, `estado`) VALUES
(1, 1, 1, '2025-03-01', '99.99', 'Transferencia', 'Empresa ABC', 'Pago mensual de salario', '');

-- --------------------------------------------------------

--
-- Table structure for table `perfiles`
--

CREATE TABLE `perfiles` (
  `perfil` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lectura_ingresos` tinyint(1) DEFAULT '0',
  `Insercion_ingresos` tinyint(1) DEFAULT '0',
  `edicion_ingresos` tinyint(1) DEFAULT '0',
  `lectura_gastos` tinyint(1) DEFAULT '0',
  `insercion_gastos` tinyint(1) DEFAULT '0',
  `edicion_gastos` tinyint(1) DEFAULT '0',
  `lectura_usuarios` tinyint(1) DEFAULT '0',
  `insercion_usuarios` tinyint(1) DEFAULT '0',
  `edicion_usuarios` tinyint(1) DEFAULT '0',
  `lectura_perfiles` tinyint(1) DEFAULT '0',
  `insercion_perfiles` tinyint(1) DEFAULT '0',
  `edicion_perfiles` tinyint(1) DEFAULT '0',
  `lectura_conceptos` tinyint(1) DEFAULT '0',
  `insercion_conceptos` tinyint(1) DEFAULT '0',
  `edicion_conceptos` tinyint(1) DEFAULT '0',
  `permiso_qr` tinyint(1) DEFAULT '0',
  `estado` varchar(32) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `perfiles`
--

INSERT INTO `perfiles` (`perfil`, `lectura_ingresos`, `Insercion_ingresos`, `edicion_ingresos`, `lectura_gastos`, `insercion_gastos`, `edicion_gastos`, `lectura_usuarios`, `insercion_usuarios`, `edicion_usuarios`, `lectura_perfiles`, `insercion_perfiles`, `edicion_perfiles`, `lectura_conceptos`, `insercion_conceptos`, `edicion_conceptos`, `permiso_qr`, `estado`) VALUES
('Administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'Activo'),
('Perfil pruebaDOS', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 'Activo'),
('Pruebas', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `qr`
--

CREATE TABLE `qr` (
  `qr_id` int(11) NOT NULL,
  `qr_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apellido` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `usuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `contrasenia` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `conexion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `perfil` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `usuario`, `contrasenia`, `estado`, `conexion`, `perfil`) VALUES
(1, 'Admines', 'Admin', 'admin', '$2y$10$kgtbciRTM4q5kJb5.oxmSOajk64unWfM/fOmqA/IRvXxBbTfspGaa', 'Activo', '2025-03-04 13:59:16', 'Administrador'),
(2, 'Gabriel Matias', 'Admin', 'admin2', '$2y$10$6HFeNixa8fAwsttnLwtYGebQmd9MXfufOBqoe0HCTNvYr75t3u6wu', 'Activo', '2025-03-06 14:45:04', 'Perfil pruebaDOS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`idconcepto`);

--
-- Indexes for table `gasto`
--
ALTER TABLE `gasto`
  ADD PRIMARY KEY (`idGasto`),
  ADD KEY `FK_gasto_usuario` (`idUsuario`),
  ADD KEY `FK_gasto_concepto` (`idconcepto`);

--
-- Indexes for table `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idIngreso`),
  ADD KEY `FK_ingreso_usuario` (`idUsuario`),
  ADD KEY `FK_ingreso_concepto` (`idconcepto`);

--
-- Indexes for table `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`perfil`);

--
-- Indexes for table `qr`
--
ALTER TABLE `qr`
  ADD PRIMARY KEY (`qr_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `fk_usuario_perfil` (`perfil`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `concepto`
--
ALTER TABLE `concepto`
  MODIFY `idconcepto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gasto`
--
ALTER TABLE `gasto`
  MODIFY `idGasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idIngreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qr`
--
ALTER TABLE `qr`
  MODIFY `qr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gasto`
--
ALTER TABLE `gasto`
  ADD CONSTRAINT `FK_gasto_concepto` FOREIGN KEY (`idconcepto`) REFERENCES `concepto` (`idconcepto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_gasto_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `FK_ingreso_concepto` FOREIGN KEY (`idconcepto`) REFERENCES `concepto` (`idconcepto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_ingreso_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`perfil`) REFERENCES `perfiles` (`perfil`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
