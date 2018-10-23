-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-10-2018 a las 17:45:35
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_estudiante`
--

INSERT INTO `t_estudiante` (`id_estudiante`, `fecha_inscripcion`, `nivel_kmg`, `es_activo`, `id_individuo`) VALUES
(2, '2018-10-12', 'Aspirante', b'1', '113243021'),
(5, '2018-10-20', 'Aspirante', b'1', '12353322'),
(6, '2018-10-20', 'P1', b'1', '12340122'),
(8, '2018-10-21', 'G1', b'0', '115530864');

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
  PRIMARY KEY (`id_estudiante`,`id_paquete`,`id_sede`,`id_instructor`,`fecha_inicio`) USING BTREE,
  KEY `FK_PE_PAQUETE` (`id_paquete`),
  KEY `FK_PE_SEDE` (`id_sede`),
  KEY `FK_PE_INSTRUCTOR` (`id_instructor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_estudiante_paquete`
--

INSERT INTO `t_estudiante_paquete` (`id_estudiante`, `id_paquete`, `id_sede`, `id_instructor`, `fecha_inicio`, `dias_restantes`, `asistencias`, `es_activo`) VALUES
(2, 1, 1, 1, '2018-10-17', 45, 12, b'1'),
(2, 2, 1, 1, '2018-10-06', 45, 30, b'0'),
(2, 2, 1, 1, '2018-10-10', 45, 17, b'0'),
(2, 2, 2, 1, '2018-10-27', 45, 15, b'1'),
(5, 1, 2, 2, '2018-10-18', 45, 0, b'1'),
(6, 2, 1, 1, '2018-10-22', 45, 3, b'1'),
(8, 1, 1, 2, '2018-10-21', 45, 6, b'1');

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
('113243021', 'Marcos', 'Santos', 'Santos', 'Costa Rica', '', '1992-10-18', 2),
('115530864', 'Johan', 'Karlson', 'Carrillo', 'Costa Rica', 'Miope', '1993-10-27', 1),
('12340122', 'Valeria', 'Gonzalez', '', 'Costa Rica', 'Miope', '1993-03-12', 10),
('12353322', 'Enrique', 'Gomez', 'Santos', 'Costa Rica', '', '1991-02-10', 9),
('12430103', 'Veronica', 'Ramirez', '', 'Costa Rica', '', '1994-06-01', 11);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_instructor`
--

INSERT INTO `t_instructor` (`id_instructor`, `fecha_inicio`, `es_activo`, `id_individuo`) VALUES
(1, '2018-10-11', b'1', '115530864'),
(2, '2018-10-01', b'1', '12430103');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_paquete`
--

INSERT INTO `t_paquete` (`id_paquete`, `nombre_paquete`, `cantidad_clases`, `monto_precio`) VALUES
(1, 'Golden', 15, '20000.00'),
(2, 'Premium', 30, '30000.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_rol`
--

INSERT INTO `t_rol` (`id_rol`, `nombre_rol`, `descripcion`) VALUES
(1, 'Instructor', NULL),
(2, 'Estudiante', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_sede`
--

INSERT INTO `t_sede` (`id_sede`, `nombre_sede`, `ubicacion`, `es_activo`) VALUES
(1, 'San Pablo', '', b'1'),
(2, 'Llorente', '', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_usuario`
--

DROP TABLE IF EXISTS `t_usuario`;
CREATE TABLE IF NOT EXISTS `t_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `correo_electronico` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`),
  KEY `FK_ROL` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_usuario`
--

INSERT INTO `t_usuario` (`id_usuario`, `correo_electronico`, `contrasena`, `id_rol`) VALUES
(1, 'johan@johan.com', '1234', 1),
(2, 'marcos@marcos.com', '123', 2),
(9, 'enrique@msn.com', '1234', 2),
(10, 'vale@hotmail.com', '1234', 2),
(11, 'vero@msn.com', '1234', 1),
(16, 'ana@ana.com', '1234', 2),
(21, 'eliecer@eliecer.com', '1234', 2),
(26, 'ser@ser.com', '1234', 2),
(29, 'allan@allan.com', '1234', 2),
(30, 'adrian@adrian.com', '1234', 2),
(31, 'alberto@alberto.com', '1234', 2),
(32, 'ricardo@ricard.com', '1234', 2),
(33, 'pablo@pablo.com', '1234', 2),
(34, 'paola@paola.com', '1234', 2);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
