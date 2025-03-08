-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-03-2025 a las 01:55:08
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `economiaf`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `idAuditoria` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `detalle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`idAuditoria`, `idUsuario`, `detalle`, `fecha_hora`) VALUES
(1, 1, 'Registro del gasto ', '2025-03-07 19:06:14'),
(2, 1, 'Registro del gasto #8', '2025-03-07 19:37:13'),
(3, 1, 'Registro del ingreso #3', '2025-03-08 00:46:42'),
(4, 1, 'Anulación del ingreso N° 4', '2025-03-07 19:58:20'),
(5, 1, 'Anulación del gasto N° 4', '2025-03-07 19:58:22'),
(6, 1, 'Anulación del gasto N° 2', '2025-03-07 19:59:01'),
(7, 1, 'Anulación del ingreso N° 2', '2025-03-07 19:59:03'),
(8, 1, 'Anulación del gasto N° 2', '2025-03-07 19:59:05'),
(9, 1, 'Anulación del ingreso N° 1', '2025-03-07 19:59:30'),
(10, 1, 'Anulación del gasto N° 7', '2025-03-07 20:02:03'),
(11, 1, 'Anulación del gasto N° 3', '2025-03-07 20:02:26'),
(12, 1, 'Anulación del gasto N° 3', '2025-03-07 20:02:28'),
(13, 1, 'Modificación del gasto N° 6', '2025-03-07 20:18:01'),
(14, 1, 'Modificación del ingreso N° 3', '2025-03-07 20:44:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE `concepto` (
  `idconcepto` int(11) NOT NULL,
  `qr_id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `tipo` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`idconcepto`, `qr_id`, `nombre`, `tipo`) VALUES
(1, 1, 'Salario', 'Ingreso'),
(2, 2, 'Compra de materiales', 'Gasto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasto`
--

CREATE TABLE `gasto` (
  `idGasto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idconcepto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `valor` decimal(9,2) NOT NULL,
  `medio_de_pago` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `acreedor_cobrador` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descripcion` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `gasto`
--

INSERT INTO `gasto` (`idGasto`, `idUsuario`, `idconcepto`, `fecha`, `valor`, `medio_de_pago`, `acreedor_cobrador`, `descripcion`, `estado`) VALUES
(1, 1, 2, '2025-03-01', '99.99', 'Efectivo', 'Proveedor XYZ', 'Compra de materiales de oficina', 'Actiivo'),
(2, 1, 2, '2025-03-07', '4.25', 'Efectivo', 'Papelería Josefina', 'Compra de un sketchbook y lapiceros de colores.', 'Inactivo'),
(3, 1, 2, '2025-03-07', '10.00', 'Transferencia Bancaria', 'Jose', 'Compra de materiales de cocina', 'Inactivo'),
(4, 1, 2, '2025-03-07', '12.00', 'Efectivo', 'Jose', 'Conioasnoifniaf', 'Inactivo'),
(5, 1, 2, '2025-03-07', '6.00', 'Efectivo', 'Juan Felipe', 'Materiales de Construcción: Cemento y hormigón', 'Activo'),
(6, 1, 2, '2025-03-07', '10.00', 'Efectivo', 'Jose', 'Materiales de Limpieza', 'Activo'),
(7, 1, 2, '2025-03-07', '12.00', 'Efectivo', 'Jose', 'qwdqwdqw', 'Inactivo'),
(8, 1, 2, '2025-03-07', '1.00', 'Efectivo', 'fwefewfwfe', 'fewfwewfw', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idIngreso` int(11) NOT NULL,
  `idconcepto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `valor` decimal(9,2) NOT NULL,
  `medio_de_pago` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fuente_beneficiario` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descripcion` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`idIngreso`, `idconcepto`, `idUsuario`, `fecha`, `valor`, `medio_de_pago`, `fuente_beneficiario`, `descripcion`, `estado`) VALUES
(1, 1, 1, '2025-03-01', '99.99', 'Transferencia Bancaria', 'Empresa ABC', 'Pago mensual de salario', 'Inactivo'),
(2, 1, 1, '2025-03-07', '33.50', 'Efectivo', 'Empresa ABC', 'PAGO tiempo extra', 'Inactivo'),
(3, 1, 1, '2025-03-08', '61.00', 'Transferencia Bancaria', 'Banco Pichincha', 'Pago a empleados por comisión', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
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
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`perfil`, `lectura_ingresos`, `Insercion_ingresos`, `edicion_ingresos`, `lectura_gastos`, `insercion_gastos`, `edicion_gastos`, `lectura_usuarios`, `insercion_usuarios`, `edicion_usuarios`, `lectura_perfiles`, `insercion_perfiles`, `edicion_perfiles`, `lectura_conceptos`, `insercion_conceptos`, `edicion_conceptos`, `permiso_qr`, `estado`) VALUES
('Administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'Activo'),
('Juan', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Activo'),
('Perfil pruebaDOS', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 'Activo'),
('Pruebas', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `qr`
--

CREATE TABLE `qr` (
  `qr_id` int(11) NOT NULL,
  `qr_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `cedula` varchar(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apellido` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `usuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `contrasenia` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `conexion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `perfil` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `cedula`, `nombre`, `apellido`, `usuario`, `contrasenia`, `estado`, `conexion`, `perfil`) VALUES
(1, '0650160203', 'Administrador', 'Admin', '1234567890', '$2y$10$kgtbciRTM4q5kJb5.oxmSOajk64unWfM/fOmqA/IRvXxBbTfspGaa', 'Activo', '2025-03-07 22:16:40', 'Administrador'),
(2, '0650160204', 'Gabriel', 'Admin', 'admin2', '$2y$10$6HFeNixa8fAwsttnLwtYGebQmd9MXfufOBqoe0HCTNvYr75t3u6wu', 'Activo', '2025-03-06 14:45:04', 'Perfil pruebaDOS'),
(6, '1700238471', 'Gabriel', 'Perez', 'Juanillo', '$2y$10$vckvzffFo0nhwC1kIwAvdeF7rBrW30BKX9jhWss5ooFy54h2myE1a', 'Activo', '2025-03-07 13:27:58', 'Perfil pruebaDOS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`idAuditoria`);

--
-- Indices de la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`idconcepto`);

--
-- Indices de la tabla `gasto`
--
ALTER TABLE `gasto`
  ADD PRIMARY KEY (`idGasto`),
  ADD KEY `FK_gasto_usuario` (`idUsuario`),
  ADD KEY `FK_gasto_concepto` (`idconcepto`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idIngreso`),
  ADD KEY `FK_ingreso_usuario` (`idUsuario`),
  ADD KEY `FK_ingreso_concepto` (`idconcepto`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`perfil`);

--
-- Indices de la tabla `qr`
--
ALTER TABLE `qr`
  ADD PRIMARY KEY (`qr_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `fk_usuario_perfil` (`perfil`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `idAuditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `concepto`
  MODIFY `idconcepto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `gasto`
--
ALTER TABLE `gasto`
  MODIFY `idGasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idIngreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `qr`
--
ALTER TABLE `qr`
  MODIFY `qr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gasto`
--
ALTER TABLE `gasto`
  ADD CONSTRAINT `FK_gasto_concepto` FOREIGN KEY (`idconcepto`) REFERENCES `concepto` (`idconcepto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_gasto_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `FK_ingreso_concepto` FOREIGN KEY (`idconcepto`) REFERENCES `concepto` (`idconcepto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_ingreso_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`perfil`) REFERENCES `perfiles` (`perfil`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
