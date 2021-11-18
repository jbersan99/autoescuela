-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-11-2021 a las 13:15:41
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `autoescuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

DROP TABLE IF EXISTS `examen`;
CREATE TABLE IF NOT EXISTS `examen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `duracion` int(11) NOT NULL,
  `numero_preguntas` int(11) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_hechos`
--

DROP TABLE IF EXISTS `examen_hechos`;
CREATE TABLE IF NOT EXISTS `examen_hechos` (
  `id_examen` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  UNIQUE KEY `id_examen` (`id_examen`,`id_usuario`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_preguntas`
--

DROP TABLE IF EXISTS `examen_preguntas`;
CREATE TABLE IF NOT EXISTS `examen_preguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_examen` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `calificacion` int(11) NOT NULL,
  `ejecucion` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_examen` (`id_examen`),
  UNIQUE KEY `id_pregunta` (`id_pregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE IF NOT EXISTS `preguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enunciado` varchar(350) COLLATE utf8_spanish_ci NOT NULL,
  `respuesta_correcta` int(11) NOT NULL,
  `recurso` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `id_tematica` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tematica` (`id_tematica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

DROP TABLE IF EXISTS `respuesta`;
CREATE TABLE IF NOT EXISTS `respuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enunciado` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `pregunta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pregunta` (`pregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tematica`
--

DROP TABLE IF EXISTS `tematica`;
CREATE TABLE IF NOT EXISTS `tematica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tema` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `nacimiento` date NOT NULL,
  `rol` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `examen_hechos`
--
ALTER TABLE `examen_hechos`
  ADD CONSTRAINT `examen_hechos_ibfk_1` FOREIGN KEY (`id_examen`) REFERENCES `examen` (`id`),
  ADD CONSTRAINT `examen_hechos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `examen_preguntas`
--
ALTER TABLE `examen_preguntas`
  ADD CONSTRAINT `examen_preguntas_ibfk_1` FOREIGN KEY (`id_examen`) REFERENCES `examen` (`id`),
  ADD CONSTRAINT `examen_preguntas_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id`);

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`id_tematica`) REFERENCES `tematica` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
