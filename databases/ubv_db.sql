/*
Navicat MySQL Data Transfer

Source Server         : Localhost(XAMPP)
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : ubv_db

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2014-06-17 22:44:17
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of aldea
-- ----------------------------
INSERT INTO `aldea` VALUES ('1', 'Aldea Universitaria Cunaguaro', 'POr ahi en algun beta', '7');

-- ----------------------------
-- Table structure for `cohorte`
-- ----------------------------
DROP TABLE IF EXISTS `cohorte`;
CREATE TABLE `cohorte` (
  `cod_cohorte` int(11) NOT NULL AUTO_INCREMENT,
  `anno` int(4) NOT NULL,
  `inicio` int(2) NOT NULL,
  `fin` int(2) NOT NULL,
  PRIMARY KEY (`cod_cohorte`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cohorte
-- ----------------------------
INSERT INTO `cohorte` VALUES ('1', '2014', '6', '7');

-- ----------------------------
-- Table structure for `configuracion`
-- ----------------------------
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of configuracion
-- ----------------------------
INSERT INTO `configuracion` VALUES ('1', 'Sistema UBV', 'carlos@ubv.com');

-- ----------------------------
-- Table structure for `coordinador_aldea`
-- ----------------------------
DROP TABLE IF EXISTS `coordinador_aldea`;
CREATE TABLE `coordinador_aldea` (
  `cod_coordinador` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cedula` int(11) NOT NULL,
  `cod_aldea` int(11) NOT NULL,
  PRIMARY KEY (`cod_coordinador`),
  KEY `coordinador_persona` (`cedula`),
  KEY `coordinador_aldea` (`cod_aldea`),
  CONSTRAINT `coordinador_aldea` FOREIGN KEY (`cod_aldea`) REFERENCES `aldea` (`cod_aldea`),
  CONSTRAINT `coordinador_persona` FOREIGN KEY (`cedula`) REFERENCES `persona` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of coordinador_aldea
-- ----------------------------

-- ----------------------------
-- Table structure for `documentos`
-- ----------------------------
DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `matricula` int(11) NOT NULL,
  `verificacion_academica` tinyint(1) DEFAULT '0',
  `contancia_culminacion` tinyint(1) DEFAULT '0',
  `trabajo_grado` tinyint(1) DEFAULT '0',
  `consignacion_recaudos` tinyint(1) DEFAULT '0',
  `fotografia` tinyint(1) DEFAULT '0',
  `copia_cedula` tinyint(1) DEFAULT '0',
  `partida_nacimiento` tinyint(1) DEFAULT '0',
  `titulo_bachiller` tinyint(1) DEFAULT '0',
  `fondo_negro` tinyint(1) DEFAULT '0',
  `autenticidad_titulo` tinyint(1) DEFAULT '0',
  `notas_bachillerato` tinyint(1) DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of empleado
-- ----------------------------
INSERT INTO `empleado` VALUES ('1', '17681201', 'admin', '21232f297a57a5a743894a0e4a801fc3', '0', '0');
INSERT INTO `empleado` VALUES ('2', '158889623', 'prueba', '21232f297a57a5a743894a0e4a801fc3', '0', '0');

-- ----------------------------
-- Table structure for `entidad_federal`
-- ----------------------------
DROP TABLE IF EXISTS `entidad_federal`;
CREATE TABLE `entidad_federal` (
  `cod_entidad_federal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`cod_entidad_federal`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of entidad_federal
-- ----------------------------
INSERT INTO `entidad_federal` VALUES ('1', 'Amazonas');
INSERT INTO `entidad_federal` VALUES ('2', 'Anzoátegui');
INSERT INTO `entidad_federal` VALUES ('3', 'Apure');
INSERT INTO `entidad_federal` VALUES ('4', 'Aragua');
INSERT INTO `entidad_federal` VALUES ('5', 'Barinas');
INSERT INTO `entidad_federal` VALUES ('6', 'Bolívar');
INSERT INTO `entidad_federal` VALUES ('7', 'Carabobo');
INSERT INTO `entidad_federal` VALUES ('8', 'Cojedes');
INSERT INTO `entidad_federal` VALUES ('9', 'Delta Amacuro');
INSERT INTO `entidad_federal` VALUES ('10', 'Distrito Capital');
INSERT INTO `entidad_federal` VALUES ('11', 'Falcón');
INSERT INTO `entidad_federal` VALUES ('12', 'Guárico');
INSERT INTO `entidad_federal` VALUES ('13', 'Lara');
INSERT INTO `entidad_federal` VALUES ('14', 'Mérida');
INSERT INTO `entidad_federal` VALUES ('15', 'Miranda');
INSERT INTO `entidad_federal` VALUES ('16', 'Monagas');
INSERT INTO `entidad_federal` VALUES ('17', 'Nueva Esparta');
INSERT INTO `entidad_federal` VALUES ('18', 'Portuguesa');
INSERT INTO `entidad_federal` VALUES ('19', 'Sucre');
INSERT INTO `entidad_federal` VALUES ('20', 'Táchira');
INSERT INTO `entidad_federal` VALUES ('21', 'Trujillo');
INSERT INTO `entidad_federal` VALUES ('22', 'Vargas');
INSERT INTO `entidad_federal` VALUES ('23', 'Yaracuy');
INSERT INTO `entidad_federal` VALUES ('24', 'Zulia');

-- ----------------------------
-- Table structure for `estudiante`
-- ----------------------------
DROP TABLE IF EXISTS `estudiante`;
CREATE TABLE `estudiante` (
  `matricula` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `cod_pfg` int(4) NOT NULL,
  `cod_cohorte` int(11) NOT NULL,
  PRIMARY KEY (`matricula`),
  KEY `estudiante_persona` (`cedula`),
  KEY `estudiante_mencion` (`cod_pfg`),
  KEY `estudiante_cohorte` (`cod_cohorte`),
  CONSTRAINT `estudiante_cohorte` FOREIGN KEY (`cod_cohorte`) REFERENCES `cohorte` (`cod_cohorte`),
  CONSTRAINT `estudiante_mencion` FOREIGN KEY (`cod_pfg`) REFERENCES `pfg` (`cod_pfg`),
  CONSTRAINT `estudiante_persona` FOREIGN KEY (`cedula`) REFERENCES `persona` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estudiante
-- ----------------------------
INSERT INTO `estudiante` VALUES ('1806040752', '18054822', '2', '1');
INSERT INTO `estudiante` VALUES ('1806040843', '15210364', '1', '1');
INSERT INTO `estudiante` VALUES ('1806041136', '85965412', '1', '1');
INSERT INTO `estudiante` VALUES ('1806041219', '21040999', '1', '1');
INSERT INTO `estudiante` VALUES ('1806050528', '11954827', '1', '1');
INSERT INTO `estudiante` VALUES ('1806050551', '11258999', '1', '1');

-- ----------------------------
-- Table structure for `modulo`
-- ----------------------------
DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo` (
  `modulo_id` varchar(20) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `in_menu` int(1) DEFAULT '1',
  `orden` int(2) DEFAULT NULL,
  PRIMARY KEY (`modulo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of modulo
-- ----------------------------
INSERT INTO `modulo` VALUES ('config', 'Configuracion del sistema', 'configuracion.png', '1', '8');
INSERT INTO `modulo` VALUES ('constancy', 'Constancia de Culminacion', 'culminacion.png', '1', '5');
INSERT INTO `modulo` VALUES ('documents', 'Consignacion de Recaudos', 'documentos.png', '1', '6');
INSERT INTO `modulo` VALUES ('employees', 'Usuarios del Sistema', null, '0', '0');
INSERT INTO `modulo` VALUES ('home', 'Inicio', null, '0', '1');
INSERT INTO `modulo` VALUES ('reports', 'Estadisticas y Reportes', 'reportes.png', '1', '7');
INSERT INTO `modulo` VALUES ('requests-notes', 'Solicitud de Notas', 'notas.png', '1', '2');
INSERT INTO `modulo` VALUES ('requests-transfer', 'Solicitud de Traslado', 'traslado.png', '1', '3');
INSERT INTO `modulo` VALUES ('students', 'Administracion de Bachilleres', 'estudiantes.png', '1', '6');
INSERT INTO `modulo` VALUES ('universities', 'Administrar Aldeas', null, '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of municipio
-- ----------------------------
INSERT INTO `municipio` VALUES ('1', '7', 'Bejuma');
INSERT INTO `municipio` VALUES ('2', '7', 'Carlos Arvelo');
INSERT INTO `municipio` VALUES ('4', '7', 'Diego Ibarra');
INSERT INTO `municipio` VALUES ('5', '7', 'Guacara');
INSERT INTO `municipio` VALUES ('6', '7', 'Juan Jose Mora');
INSERT INTO `municipio` VALUES ('7', '7', 'Libertador');
INSERT INTO `municipio` VALUES ('8', '7', 'Los Guayos');
INSERT INTO `municipio` VALUES ('9', '7', 'Miranda');
INSERT INTO `municipio` VALUES ('10', '7', 'Montalban');
INSERT INTO `municipio` VALUES ('11', '7', 'Naguanagua');
INSERT INTO `municipio` VALUES ('12', '7', 'Puerto Cabello');
INSERT INTO `municipio` VALUES ('13', '7', 'San Diego');
INSERT INTO `municipio` VALUES ('14', '7', 'San Joaquin');
INSERT INTO `municipio` VALUES ('15', '7', 'Valencia');

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
INSERT INTO `nivel` VALUES ('0', 'Administrador', 'home,config,students,requests-notes,requests-transfer,universities,reports,constancy,employees,documents');
INSERT INTO `nivel` VALUES ('1', 'Analista', 'home');
INSERT INTO `nivel` VALUES ('2', 'Coordinador de Aldea', 'home,students,reports');

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
INSERT INTO `persona` VALUES ('0', '0', '0', '0', '0', '0', 'ninguna');
INSERT INTO `persona` VALUES ('11258999', 'Carlos', 'Lopez', '', '', '', 'ninguna');
INSERT INTO `persona` VALUES ('11954827', 'Sinforozo', 'Petro', '', '', '', 'ninguna');
INSERT INTO `persona` VALUES ('15210364', 'Manuel', 'Ramirez', '', '', '', 'ninguna');
INSERT INTO `persona` VALUES ('17681201', 'Eli', 'Chavez', '0414-4720780', 'elijose.c@gmail.com', 'Trigal Norte', 'ninguna');
INSERT INTO `persona` VALUES ('18054822', 'LLuvia', 'DNMC', '0424-4954451', 'nohely28@hotmail.com', 'Nirgua. Edo Yaracuy', 'ninguna');
INSERT INTO `persona` VALUES ('21040999', 'Antonio', 'Ortega', '', '', '', 'ninguna');
INSERT INTO `persona` VALUES ('85965412', 'Aristoteles', 'Chonfin', '', '', 'Naguanagua', 'ninguna');
INSERT INTO `persona` VALUES ('158889623', 'Prueba', 'Prueba', '', '', '', 'ninguna');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pfg
-- ----------------------------
INSERT INTO `pfg` VALUES ('1', 'Informatica', 'Todo sobre la informatica', '1');
INSERT INTO `pfg` VALUES ('2', 'Agronomia', 'No lo se', '1');

-- ----------------------------
-- Table structure for `solicitud`
-- ----------------------------
DROP TABLE IF EXISTS `solicitud`;
CREATE TABLE `solicitud` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(10) NOT NULL,
  `matricula` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `fecha_retiro` datetime DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `semestre_solicitado` int(2) DEFAULT NULL,
  `aldea_anterior` int(11) DEFAULT NULL,
  `aldea_nueva` int(11) DEFAULT NULL,
  `comentarios` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitud_estudiante_idx` (`matricula`),
  CONSTRAINT `solicitud_estudiante` FOREIGN KEY (`matricula`) REFERENCES `estudiante` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of solicitud
-- ----------------------------
INSERT INTO `solicitud` VALUES ('1', 'traslado', '1806040752', '2014-06-18 04:09:54', null, '0', null, null, null, null);
