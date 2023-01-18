-- Adminer 4.8.1 MySQL 5.5.5-10.4.12-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comision`;
CREATE TABLE `comision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `instancias_estados`;
CREATE TABLE `instancias_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `materia`;
CREATE TABLE `materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `usuarios_tipos`;
CREATE TABLE `usuarios_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `usuarios_tipos` (`id`, `descripcion`) VALUES
(1,	'Estudiante'),
(2,	'Profesor'),
(3,	'Administración');


DROP TABLE IF EXISTS `materia_x_comision`;
CREATE TABLE `materia_x_comision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `materia_id` int(11) NOT NULL,
  `comision_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `materia_id` (`materia_id`),
  KEY `comision_id` (`comision_id`),
  CONSTRAINT `materia_x_comision_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`),
  CONSTRAINT `materia_x_comision_ibfk_2` FOREIGN KEY (`comision_id`) REFERENCES `comision` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `legajo` varchar(10) NOT NULL,
  `contrasenia` char(60) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_id` (`tipo_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `usuarios_tipos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `consultas`;
CREATE TABLE `consultas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `materia_x_comision_id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `hora_desde` time NOT NULL,
  `hora_hasta` time NOT NULL,
  `dia_de_la_semana` varchar(10) NOT NULL,
  `aula` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `materia_x_comision_id` (`materia_x_comision_id`),
  KEY `profesor_id` (`profesor_id`),
  CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`materia_x_comision_id`) REFERENCES `materia_x_comision` (`id`),
  CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`profesor_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `instancias`;
CREATE TABLE `instancias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `motivo` varchar(500) DEFAULT NULL,
  `hora_nueva` time DEFAULT NULL,
  `cupo` int(11) NOT NULL,
  `enlace` varchar(100) DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estado_id` (`estado_id`),
  KEY `consulta_id` (`consulta_id`),
  CONSTRAINT `instancias_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `instancias_estados` (`id`),
  CONSTRAINT `instancias_ibfk_2` FOREIGN KEY (`consulta_id`) REFERENCES `consultas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `suscripciones`;
CREATE TABLE `suscripciones` (
  `instancia_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  KEY `instancia_id` (`instancia_id`),
  KEY `estudiante_id` (`estudiante_id`),
  CONSTRAINT `suscripciones_ibfk_1` FOREIGN KEY (`instancia_id`) REFERENCES `instancias` (`id`),
  CONSTRAINT `suscripciones_ibfk_2` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2023-01-09 20:17:40
