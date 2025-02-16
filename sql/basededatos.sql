-- MySQL Script generated by MySQL Workbench
-- Sat Feb 15 14:17:34 2025
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;


-- -----------------------------------------------------
-- Table `mydb`.`PERFIL`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`PERFIL` (
  `idPerfil` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idPerfil`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`USUARIO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`USUARIO` (
  `idUsuario` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `contrasenia` VARCHAR(60) NOT NULL,
  `idPerfil` INT NOT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_USUARIO_PERFIL1_idx` (`idPerfil` ASC) ,
  CONSTRAINT `fk_USUARIO_PERFIL1`
    FOREIGN KEY (`idPerfil`)
    REFERENCES `mydb`.`PERFIL` (`idPerfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`GASTO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`GASTO` (
  `idGasto` INT NOT NULL,
  `fecha` DATE NOT NULL,
  `valor` DECIMAL(4,2) NOT NULL,
  `medio_de_pago` VARCHAR(45) NOT NULL,
  `acreedor_cobrador` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(128) NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idGasto`),
  INDEX `fk_GASTO_USUARIO_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_GASTO_USUARIO`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `mydb`.`USUARIO` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`INGRESO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`INGRESO` (
  `idIngreso` INT NOT NULL,
  `fecha` DATE NOT NULL,
  `valor` DECIMAL(4,2) NOT NULL,
  `medio_de_pago` VARCHAR(45) NOT NULL,
  `fuente_beneficiario` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(128) NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idIngreso`),
  INDEX `fk_INGRESO_USUARIO1_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_INGRESO_USUARIO1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `mydb`.`USUARIO` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- Inserts para PERFIL
INSERT INTO `mydb`.`PERFIL` (`idPerfil`, `nombre`, `descripcion`) VALUES (1, 'Administrador', 'Acceso total');
INSERT INTO `mydb`.`PERFIL` (`idPerfil`, `nombre`, `descripcion`) VALUES (2, 'GIngresos', 'Solo ingresos');
INSERT INTO `mydb`.`PERFIL` (`idPerfil`, `nombre`, `descripcion`) VALUES (3, 'GEgresos', 'Solo egresos');

-- Inserts para USUARIO
INSERT INTO `mydb`.`USUARIO` (`idUsuario`, `nombre`, `apellido`, `usuario`, `contrasenia`, `idPerfil`) 
VALUES (1, 'Juan', 'Pérez', 'jperez', 'holaaa12', 1);
INSERT INTO `mydb`.`USUARIO` (`idUsuario`, `nombre`, `apellido`, `usuario`, `contrasenia`, `idPerfil`) 
VALUES (2, 'Ana', 'Gómez', 'agomez', 'holaaa12', 2);
INSERT INTO `mydb`.`USUARIO` (`idUsuario`, `nombre`, `apellido`, `usuario`, `contrasenia`, `idPerfil`) 
VALUES (3, 'Carlos', 'López', 'clopez', 'holaaa12', 3);

-- Inserts para GASTO
INSERT INTO `mydb`.`GASTO` (`idGasto`, `fecha`, `valor`, `medio_de_pago`, `acreedor_cobrador`, `descripcion`, `idUsuario`) 
VALUES (1, '2025-02-01', 50.00, 'Tarjeta', 'Supermercado', 'Compra de víveres', 1);
INSERT INTO `mydb`.`GASTO` (`idGasto`, `fecha`, `valor`, `medio_de_pago`, `acreedor_cobrador`, `descripcion`, `idUsuario`) 
VALUES (2, '2025-02-10', 30.50, 'Efectivo', 'Gasolinera', 'Carga de combustible', 2);
INSERT INTO `mydb`.`GASTO` (`idGasto`, `fecha`, `valor`, `medio_de_pago`, `acreedor_cobrador`, `descripcion`, `idUsuario`) 
VALUES (3, '2025-02-12', 100.00, 'Transferencia', 'Médico', 'Consulta médica', 3);

-- Inserts para INGRESO
INSERT INTO `mydb`.`INGRESO` (`idIngreso`, `fecha`, `valor`, `medio_de_pago`, `fuente_beneficiario`, `descripcion`, `idUsuario`) 
VALUES (1, '2025-02-01', 1500.00, 'Transferencia', 'Empresa X', 'Salario mensual', 1);
INSERT INTO `mydb`.`INGRESO` (`idIngreso`, `fecha`, `valor`, `medio_de_pago`, `fuente_beneficiario`, `descripcion`, `idUsuario`) 
VALUES (2, '2025-02-05', 200.00, 'Efectivo', 'Cliente Y', 'Pago por servicio', 2);
INSERT INTO `mydb`.`INGRESO` (`idIngreso`, `fecha`, `valor`, `medio_de_pago`, `fuente_beneficiario`, `descripcion`, `idUsuario`) 
VALUES (3, '2025-02-08', 500.00, 'Tarjeta', 'Plataforma Z', 'Venta de producto', 3);
