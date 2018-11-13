-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-11-2018 a las 18:02:45
-- Versión del servidor: 5.7.21
-- Versión de PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_kmg_cr`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_estudiante`
--

DROP TABLE IF EXISTS `t_estudiante`;
CREATE TABLE IF NOT EXISTS `t_estudiante` (
  `id_estudiante` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inscripcion` date NOT NULL,
  `nivel_kmg` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `es_activo` bit(1) NOT NULL,
  `id_individuo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_estudiante`),
  KEY `FK_EST_INDIVIDUO` (`id_individuo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_estudiante`
--

INSERT INTO `t_estudiante` (`id_estudiante`, `fecha_inscripcion`, `nivel_kmg`, `es_activo`, `id_individuo`) VALUES
(2, '2018-10-11', 'P1', b'1', '113243021'),
(5, '2018-10-20', 'Aspirante', b'1', '12353322'),
(6, '2018-10-20', 'P1', b'1', '12340122'),
(8, '2018-10-21', 'G1', b'0', '115530864'),
(11, '2018-10-24', 'Aspirante', b'1', '23123421'),
(12, '2018-10-24', 'Aspirante', b'1', '12331341'),
(13, '2018-10-21', 'P5', b'1', '32432487'),
(14, '2018-11-11', 'Aspirante', b'1', '324234324'),
(15, '2018-11-13', 'P1', b'1', '123403244'),
(16, '2018-11-13', 'Aspirante', b'0', '23123312');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_estudiante_paquete`
--

DROP TABLE IF EXISTS `t_estudiante_paquete`;
CREATE TABLE IF NOT EXISTS `t_estudiante_paquete` (
  `id_estudiante` int(11) NOT NULL,
  `id_paquete` int(11) NOT NULL,
  `id_sede` int(11) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `dias_restantes` int(11) NOT NULL,
  `asistencias` int(11) NOT NULL,
  `es_activo` bit(1) NOT NULL,
  `es_pagado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`,`id_paquete`,`id_sede`,`id_instructor`,`fecha_inicio`) USING BTREE,
  KEY `FK_PE_PAQUETE` (`id_paquete`),
  KEY `FK_PE_SEDE` (`id_sede`),
  KEY `FK_PE_INSTRUCTOR` (`id_instructor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_estudiante_paquete`
--

INSERT INTO `t_estudiante_paquete` (`id_estudiante`, `id_paquete`, `id_sede`, `id_instructor`, `fecha_inicio`, `dias_restantes`, `asistencias`, `es_activo`, `es_pagado`) VALUES
(2, 1, 1, 1, '2018-10-17', 45, 15, b'1', b'1'),
(2, 1, 1, 1, '2018-11-02', 45, 0, b'0', b'1'),
(2, 2, 1, 1, '2018-10-06', 23, 28, b'0', b'1'),
(2, 2, 1, 1, '2018-10-10', 45, 17, b'0', b'1'),
(2, 2, 2, 1, '2018-10-27', 45, 27, b'1', b'1'),
(5, 1, 1, 1, '2018-11-08', 45, 3, b'1', b'1'),
(5, 1, 2, 2, '2018-10-18', 3, 0, b'0', b'1'),
(5, 2, 2, 1, '2018-01-04', 23, 4, b'1', b'1'),
(6, 2, 1, 1, '2018-10-22', 30, 30, b'1', b'1'),
(8, 1, 1, 2, '2018-10-21', 10, 6, b'0', b'1'),
(14, 1, 1, 1, '2018-11-12', 30, 0, b'0', b'0'),
(16, 1, 2, 1, '2018-11-16', 30, 0, b'1', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_individuo`
--

DROP TABLE IF EXISTS `t_individuo`;
CREATE TABLE IF NOT EXISTS `t_individuo` (
  `id_individuo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido1` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido2` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nacionalidad` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `condicion_medica` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_individuo`),
  KEY `FK_USUARIO` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_individuo`
--

INSERT INTO `t_individuo` (`id_individuo`, `nombre`, `apellido1`, `apellido2`, `nacionalidad`, `condicion_medica`, `fecha_nacimiento`, `id_usuario`) VALUES
('113243021', 'Marcos', 'Santos', 'Santos', 'CR', '', '1992-10-18', 2),
('115530864', 'Johan', 'Karlson', 'Carrillo', 'CR', 'Miope', '1993-10-27', 1),
('12331341', 'Edgar', 'Morales', '', 'CR', 'Hipertenso', '1982-02-01', 38),
('12340122', 'Valeria', 'Gonzalez', '', 'CR', 'Miope', '1993-03-12', 10),
('123403244', 'Tanya', 'Martinez', '', 'CR', '', '1993-08-15', 42),
('12353322', 'Enrique', 'Gomez', 'Santos', 'CR', '', '1991-02-10', 9),
('12430103', 'Veronica', 'Ramirez', '', 'CR', '', '1994-06-01', 11),
('13312313', 'Lucy', 'Gomez', 'Gomez', 'CR', '', '1992-01-12', 44),
('23123312', 'Cornelio', 'Ramirez', 'Perez', 'CR', '', '1982-12-28', 43),
('23123421', 'Maria', 'Morelos', 'Pereira', 'CR', '', '1992-03-01', 37),
('232441313', 'Paola', 'Matadero', '', 'CR', '', '1992-12-12', 41),
('324234324', 'Allan', 'Garnier', '', 'CR', '', '1983-04-04', 40),
('32432487', 'Luva', 'Luva', 'Luva', 'CR', 'Imbecil', '1990-01-01', 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_instructor`
--

DROP TABLE IF EXISTS `t_instructor`;
CREATE TABLE IF NOT EXISTS `t_instructor` (
  `id_instructor` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `es_activo` bit(1) NOT NULL,
  `id_individuo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_instructor`),
  KEY `FK_INS_INDIVIDUO` (`id_individuo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_instructor`
--

INSERT INTO `t_instructor` (`id_instructor`, `fecha_inicio`, `es_activo`, `id_individuo`) VALUES
(1, '2018-10-12', b'1', '115530864'),
(2, '2018-10-03', b'1', '12430103'),
(4, '2018-10-24', b'1', '23123421'),
(5, '2018-10-24', b'1', '12331341'),
(6, '2018-11-11', b'0', '324234324'),
(7, '2018-11-13', b'1', '23123312'),
(8, '2018-11-13', b'0', '13312313');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_paquete`
--

DROP TABLE IF EXISTS `t_paquete`;
CREATE TABLE IF NOT EXISTS `t_paquete` (
  `id_paquete` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_paquete` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_clases` int(11) NOT NULL,
  `monto_precio` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id_paquete`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_paquete`
--

INSERT INTO `t_paquete` (`id_paquete`, `nombre_paquete`, `cantidad_clases`, `monto_precio`) VALUES
(1, 'Golden', 15, '20000.00'),
(2, 'Premium', 30, '30000.00'),
(3, 'Bronce', 10, '4300.00'),
(4, 'Esfinge', 12, '1200.02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_rol`
--

DROP TABLE IF EXISTS `t_rol`;
CREATE TABLE IF NOT EXISTS `t_rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_rol`
--

INSERT INTO `t_rol` (`id_rol`, `nombre_rol`, `descripcion`) VALUES
(1, 'Instructor', NULL),
(2, 'Estudiante', NULL),
(3, 'Usuario', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_sede`
--

DROP TABLE IF EXISTS `t_sede`;
CREATE TABLE IF NOT EXISTS `t_sede` (
  `id_sede` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_sede` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion` text COLLATE utf8_spanish_ci NOT NULL,
  `es_activo` bit(1) NOT NULL,
  PRIMARY KEY (`id_sede`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_sede`
--

INSERT INTO `t_sede` (`id_sede`, `nombre_sede`, `ubicacion`, `es_activo`) VALUES
(1, 'San Pablo', 'Por La Guacamaya', b'1'),
(2, 'Moravia', 'Kabac, Los Colegios, Moravia', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_usuario`
--

DROP TABLE IF EXISTS `t_usuario`;
CREATE TABLE IF NOT EXISTS `t_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `correo_electronico` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`),
  KEY `FK_ROL` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_usuario`
--

INSERT INTO `t_usuario` (`id_usuario`, `correo_electronico`, `contrasena`, `id_rol`) VALUES
(1, 'johan@johan.com', '$2y$10$Z1xYMqZob..JSrFv2BNfbuUHsxe4/O5tlZRwZfkXpYzbxCnWAJnkm', 1),
(2, 'marcos@marcos.com', '$2y$10$YumISF8C4hWawbIJfJZaVuGiN2.T/vUKj45xCFN4XO9lFmHLYGpPq', 2),
(9, 'enrique@msn.com', '$2y$10$7A9OXpAAh4n.eH1xoc7noOEThXIoZhPtt8K4FPPbYs3e.zT08tqp6', 2),
(10, 'vale@hotmail.com', '$2y$10$1MNkc.3jUVmejvHevFYTj.On4FKJMlvS4l0cnAGv6qLwx9LAdQxGC', 2),
(11, 'vero@msn.com', '$2y$10$8Ev5o14qLwBc/srMsUA3JukFcK66wHAnhce61JRiI.TO94kIeHvnC', 1),
(37, 'maria@maria.com', '$2y$10$jjKGEyHuHSGynysQcyYP6euDrfJF13W7I5zJ.RQt/qvKCvu9BvN1m', 1),
(38, 'edgar@edgar.com', '$2y$10$t6rgS5Zw.0ePvkQAd157yejlTJmbAtFRTgtNTVQdJoW9sgD/RDEJi', 1),
(39, 'luva@luva.com', '$2y$10$JmkByHst0LCOPkc.0.W0ZeKjNVkeez2ipDpSPv/ZSdLhNRrPyGSqC', 2),
(40, 'allan@allan.com', '$2y$10$z/UHbehd1NnGU1w21EJ82OQVdpoLd0m1buQ/T5re.eWPhcLrEDSF6', 2),
(41, 'paolas@msn.com', '$2y$10$yYzkVuj2od9HHvvLBVCWuuFjkvMXSSy2GmiKjttXyEi1eqAPqLuTS', 2),
(42, 'tanya@tanya.com', '$2y$10$hSsf0Ywkpr9n47ssoDPQB.9c8w/ZPC1R1I/8MD25yBATy8eFS.54m', 2),
(43, 'cornelio@cornelio.com', '$2y$10$H39.PFISVcqUnOqNWtLcZehxsOE/n02FRohSBtSlbslZl.c.GDfVG', 1),
(44, 'lucy@lucy.com', '$2y$10$5vkvfhSZDzm.8ApX4PhXz.rfRacG1FL9tz9LRUMnDVlVwU7JjSvDW', 3);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `t_estudiante`
--
ALTER TABLE `t_estudiante`
  ADD CONSTRAINT `FK_EST_INDIVIDUO` FOREIGN KEY (`id_individuo`) REFERENCES `t_individuo` (`id_individuo`);

--
-- Filtros para la tabla `t_estudiante_paquete`
--
ALTER TABLE `t_estudiante_paquete`
  ADD CONSTRAINT `FK_PE_ESTUDIANTE` FOREIGN KEY (`id_estudiante`) REFERENCES `t_estudiante` (`id_estudiante`),
  ADD CONSTRAINT `FK_PE_INSTRUCTOR` FOREIGN KEY (`id_instructor`) REFERENCES `t_instructor` (`id_instructor`),
  ADD CONSTRAINT `FK_PE_PAQUETE` FOREIGN KEY (`id_paquete`) REFERENCES `t_paquete` (`id_paquete`),
  ADD CONSTRAINT `FK_PE_SEDE` FOREIGN KEY (`id_sede`) REFERENCES `t_sede` (`id_sede`);

--
-- Filtros para la tabla `t_individuo`
--
ALTER TABLE `t_individuo`
  ADD CONSTRAINT `FK_USUARIO` FOREIGN KEY (`id_usuario`) REFERENCES `t_usuario` (`id_usuario`);

--
-- Filtros para la tabla `t_instructor`
--
ALTER TABLE `t_instructor`
  ADD CONSTRAINT `FK_INS_INDIVIDUO` FOREIGN KEY (`id_individuo`) REFERENCES `t_individuo` (`id_individuo`);

--
-- Filtros para la tabla `t_usuario`
--
ALTER TABLE `t_usuario`
  ADD CONSTRAINT `FK_ROL` FOREIGN KEY (`id_rol`) REFERENCES `t_rol` (`id_rol`);

DELIMITER $$
--
-- Eventos
--
DROP EVENT IF EXISTS `descuentoDias`$$
CREATE DEFINER=`root`@`localhost` EVENT `descuentoDias` ON SCHEDULE EVERY 24 HOUR STARTS '2018-11-12 00:04:20' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	UPDATE t_estudiante_paquete SET dias_restantes = dias_restantes - 1 WHERE dias_restantes > 0;
    
    UPDATE t_estudiante_paquete SET es_activo = 0 WHERE dias_restantes = 0;
    END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
