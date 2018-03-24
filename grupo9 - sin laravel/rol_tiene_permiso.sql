-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2017 a las 06:51:34
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `grupo9`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_tiene_permiso`
--

CREATE TABLE IF NOT EXISTS `rol_tiene_permiso` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol_tiene_permiso`
--

INSERT INTO `rol_tiene_permiso` (`id`, `rol_id`, `permiso_id`) VALUES
(5, 2, 1),
(6, 2, 5),
(7, 2, 6),
(8, 3, 1),
(9, 3, 5),
(10, 3, 6),
(17, 1, 3),
(19, 2, 2),
(20, 3, 2),
(23, 2, 13),
(24, 3, 13),
(25, 2, 12),
(26, 3, 12),
(27, 1, 11),
(28, 2, 10),
(29, 3, 10),
(37, 1, 19),
(38, 1, 20),
(39, 1, 21),
(40, 1, 22),
(41, 1, 23),
(42, 1, 29),
(43, 1, 30),
(44, 1, 31),
(45, 1, 32),
(46, 1, 33),
(50, 1, 32);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `rol_tiene_permiso`
--
ALTER TABLE `rol_tiene_permiso`
  ADD PRIMARY KEY (`id`), ADD KEY `rol_id` (`rol_id`), ADD KEY `permiso_id` (`permiso_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `rol_tiene_permiso`
--
ALTER TABLE `rol_tiene_permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `rol_tiene_permiso`
--
ALTER TABLE `rol_tiene_permiso`
ADD CONSTRAINT `rol_tiene_permiso_ibfk_1` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`id`),
ADD CONSTRAINT `rol_tiene_permiso_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
