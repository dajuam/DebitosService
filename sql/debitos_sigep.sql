-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-05-2015 a las 15:50:31
-- Versión del servidor: 5.5.43
-- Versión de PHP: 5.3.10-1ubuntu3.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sigea`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `debitos_sigep`
--

CREATE TABLE IF NOT EXISTS `debitos_sigep` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ultimo_archivo_id` bigint(20) NOT NULL,
  `pdv_numero` bigint(20) NOT NULL,
  `importe` decimal(9,2) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=175 ;

--
-- Volcado de datos para la tabla `debitos_sigep`
--

INSERT INTO `debitos_sigep` (`id`, `ultimo_archivo_id`, `pdv_numero`, `importe`, `status`) VALUES
(1, 160, 0, 123456.00, 'OK');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
