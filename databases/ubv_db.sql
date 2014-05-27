/*
Navicat MySQL Data Transfer

Source Server         : Localhost(XAMPP)
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : ubv_db

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2014-05-02 10:00:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `aldea`
-- ----------------------------
DROP TABLE IF EXISTS `aldea`;
CREATE TABLE `aldea` (
  `cod_aldea` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `cod_municipio` int(11) NOT NULL,
  PRIMARY KEY (`cod_aldea`),
  KEY `aldea_municipio` (`cod_municipio`),
  CONSTRAINT `aldea_municipio` FOREIGN KEY (`cod_municipio`) REFERENCES `municipio` (`cod_municipio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of aldea
-- ----------------------------

-- ----------------------------
-- Table structure for `cohorte`
-- ----------------------------
DROP TABLE IF EXISTS `cohorte`;
CREATE TABLE `cohorte` (
  `cod_cohorte` int(11) NOT NULL,
  `anno` int(4) NOT NULL,
  `inicio` int(2) NOT NULL,
  `fin` int(2) NOT NULL,
  PRIMARY KEY (`cod_cohorte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cohorte
-- ----------------------------

-- ----------------------------
-- Table structure for `documentos`
-- ----------------------------
DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `matricula` int(11) NOT NULL,
  `verificacion_academica` tinyint(1) NOT NULL DEFAULT '0',
  `contancia_culminacion` tinyint(1) NOT NULL DEFAULT '0',
  `trabajo_grado` tinyint(1) NOT NULL DEFAULT '0',
  `consignacion_recaudos` tinyint(1) NOT NULL DEFAULT '0',
  `fotografia` tinyint(1) NOT NULL DEFAULT '0',
  `copia_cedula` tinyint(1) NOT NULL DEFAULT '0',
  `partida_nacimiento` tinyint(1) NOT NULL DEFAULT '0',
  `titulo_bachiller` tinyint(1) NOT NULL DEFAULT '0',
  `fondo_negro` tinyint(1) NOT NULL DEFAULT '0',
  `autenticidad_titulo` tinyint(1) NOT NULL DEFAULT '0',
  `notas_bachillerato` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`matricula`),
  CONSTRAINT `documentos_estudiante` FOREIGN KEY (`matricula`) REFERENCES `estudiante` (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of documentos
-- ----------------------------

-- ----------------------------
-- Table structure for `empleado`
-- ----------------------------
DROP TABLE IF EXISTS `empleado`;
CREATE TABLE `empleado` (
  `cod_empleado` int(4) NOT NULL AUTO_INCREMENT,
  `cedula` int(11) NOT NULL,
  `apodo` varchar(30) NOT NULL,
  `contrasena` varchar(150) NOT NULL,
  `cod_nivel` int(1) NOT NULL DEFAULT '2',
  `eliminado` int(1) DEFAULT '0',
  PRIMARY KEY (`cod_empleado`),
  KEY `empleado_persona` (`cedula`),
  KEY `empleado_nivel` (`cod_nivel`),
  CONSTRAINT `empleado_nivel` FOREIGN KEY (`cod_nivel`) REFERENCES `nivel` (`cod_nivel`),
  CONSTRAINT `empleado_persona` FOREIGN KEY (`cedula`) REFERENCES `persona` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of empleado
-- ----------------------------
INSERT INTO `empleado` VALUES ('1', '17681201', 'admin', '21232f297a57a5a743894a0e4a801fc3', '0', '0');

-- ----------------------------
-- Table structure for `entidad_federal`
-- ----------------------------
DROP TABLE IF EXISTS `entidad_federal`;
CREATE TABLE `entidad_federal` (
  `cod_entidad_federal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`cod_entidad_federal`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of entidad_federal
-- ----------------------------
INSERT INTO `entidad_federal` VALUES ('1', 'Amazonas');

-- ----------------------------
-- Table structure for `estudiante`
-- ----------------------------
DROP TABLE IF EXISTS `estudiante`;
CREATE TABLE `estudiante` (
  `matricula` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `cod_mencion` int(4) NOT NULL,
  `cod_cohorte` int(11) NOT NULL,
  PRIMARY KEY (`matricula`),
  KEY `estudiante_persona` (`cedula`),
  KEY `estudiante_mencion` (`cod_mencion`),
  KEY `estudiante_cohorte` (`cod_cohorte`),
  CONSTRAINT `estudiante_cohorte` FOREIGN KEY (`cod_cohorte`) REFERENCES `cohorte` (`cod_cohorte`),
  CONSTRAINT `estudiante_mencion` FOREIGN KEY (`cod_mencion`) REFERENCES `mencion` (`cod_mencion`),
  CONSTRAINT `estudiante_persona` FOREIGN KEY (`cedula`) REFERENCES `persona` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estudiante
-- ----------------------------

-- ----------------------------
-- Table structure for `mencion`
-- ----------------------------
DROP TABLE IF EXISTS `mencion`;
CREATE TABLE `mencion` (
  `cod_mencion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  `cod_pfg` int(11) NOT NULL,
  PRIMARY KEY (`cod_mencion`),
  KEY `mencion_pfg` (`cod_pfg`),
  CONSTRAINT `mencion` FOREIGN KEY (`cod_pfg`) REFERENCES `pfg` (`cod_pfg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mencion
-- ----------------------------

-- ----------------------------
-- Table structure for `modulo`
-- ----------------------------
DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo` (
  `modulo_id` varchar(20) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `orden` int(2) DEFAULT NULL,
  PRIMARY KEY (`modulo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of modulo
-- ----------------------------
INSERT INTO `modulo` VALUES ('config', 'Configuracion del sistema', null, '8');
INSERT INTO `modulo` VALUES ('home', 'Inicio', null, '1');

-- ----------------------------
-- Table structure for `municipio`
-- ----------------------------
DROP TABLE IF EXISTS `municipio`;
CREATE TABLE `municipio` (
  `cod_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `cod_entidad_federal` int(3) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`cod_municipio`),
  KEY `municipio_entidad_federal` (`cod_entidad_federal`),
  CONSTRAINT `municipio_entidad_federal` FOREIGN KEY (`cod_entidad_federal`) REFERENCES `entidad_federal` (`cod_entidad_federal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of municipio
-- ----------------------------

-- ----------------------------
-- Table structure for `nivel`
-- ----------------------------
DROP TABLE IF EXISTS `nivel`;
CREATE TABLE `nivel` (
  `cod_nivel` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `modulos` varchar(200) NOT NULL,
  PRIMARY KEY (`cod_nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of nivel
-- ----------------------------
INSERT INTO `nivel` VALUES ('0', 'Administrador', 'home,config');
INSERT INTO `nivel` VALUES ('1', 'Analista', 'home');
INSERT INTO `nivel` VALUES ('2', 'Coordinador', 'home');

-- ----------------------------
-- Table structure for `persona`
-- ----------------------------
DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `telefono` varchar(12) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL,
  `direccion` text NOT NULL,
  `discapacidad` varchar(100) DEFAULT 'ninguna',
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of persona
-- ----------------------------
INSERT INTO `persona` VALUES ('17681201', 'Eli', 'Chavez', '0414-4720780', 'elijose.c@gmail.com', 'Trigal Norte', 'ninguna');

-- ----------------------------
-- Table structure for `pfg`
-- ----------------------------
DROP TABLE IF EXISTS `pfg`;
CREATE TABLE `pfg` (
  `cod_pfg` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  `cod_aldea` int(4) DEFAULT NULL,
  PRIMARY KEY (`cod_pfg`),
  KEY `pfg_aldea` (`cod_aldea`),
  CONSTRAINT `pfg_aldea` FOREIGN KEY (`cod_aldea`) REFERENCES `aldea` (`cod_aldea`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pfg
-- ----------------------------
