-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2020 a las 12:37:58
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id11300646_wp_77fa51d9f66aaa28c5c9c470beda1e39`
--
-- CREATE DATABASE IF NOT EXISTS `id11300646_wp_77fa51d9f66aaa28c5c9c470beda1e39` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `id11300646_wp_77fa51d9f66aaa28c5c9c470beda1e39`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquila`
--

CREATE TABLE `alquila` (
  `cod_usuario` int(11) NOT NULL,
  `cod_inmueble` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `contrato` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comenta`
--

CREATE TABLE `comenta` (
  `cod_usuario` int(11) NOT NULL,
  `cod_inmueble` int(11) NOT NULL,
  `fecha_comentario` date NOT NULL,
  `comentario` text COLLATE utf8_spanish2_ci NOT NULL,
  `estrellas` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `cod_foto` int(11) NOT NULL,
  `cod_inmueble` int(11) NOT NULL,
  `imagen` varchar(20) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'no_foto.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE `informes` (
  `cod_informe` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `Informe` text COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_informe` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmueble`
--

CREATE TABLE `inmueble` (
  `cod_inmueble` int(11) NOT NULL,
  `cod_propietario` int(11) NOT NULL,
  `num_hab` tinyint(4) NOT NULL,
  `terraza` tinyint(1) NOT NULL,
  `jardin` tinyint(1) NOT NULL,
  `piscina` tinyint(1) NOT NULL,
  `garaje` tinyint(1) NOT NULL,
  `distancia_centro` int(11) NOT NULL,
  `m2` decimal(10,0) NOT NULL,
  `vacio` tinyint(1) NOT NULL,
  `idufir` bigint(14) UNSIGNED NOT NULL,
  `estrellas` int(1) NOT NULL,
  `localidad` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `baja` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opina`
--

CREATE TABLE `opina` (
  `cod_propietario` int(11) NOT NULL,
  `cod_inquilino` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `opinion` text COLLATE utf8_spanish2_ci NOT NULL,
  `estrellas` int(1) NOT NULL,
  `denuncia` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `tipo` enum('admin','normal') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'normal',
  `nombre` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `dni` varchar(9) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `copia_dni` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `prop_confirm` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_fin_suscripcion` date NOT NULL,
  `foto_perfil` varchar(30) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'perfil.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquila`
--
ALTER TABLE `alquila`
  ADD PRIMARY KEY (`cod_usuario`,`cod_inmueble`,`fecha_ini`),
  ADD KEY `cod_inmueble` (`cod_inmueble`);

--
-- Indices de la tabla `comenta`
--
ALTER TABLE `comenta`
  ADD PRIMARY KEY (`cod_usuario`,`cod_inmueble`,`fecha_comentario`),
  ADD KEY `cod_inmueble` (`cod_inmueble`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`cod_foto`,`cod_inmueble`),
  ADD KEY `cod_inmueble` (`cod_inmueble`);

--
-- Indices de la tabla `informes`
--
ALTER TABLE `informes`
  ADD PRIMARY KEY (`cod_informe`),
  ADD KEY `id_usuario` (`cod_usuario`);

--
-- Indices de la tabla `inmueble`
--
ALTER TABLE `inmueble`
  ADD PRIMARY KEY (`cod_inmueble`),
  ADD KEY `cod_propietario` (`cod_propietario`);

--
-- Indices de la tabla `opina`
--
ALTER TABLE `opina`
  ADD PRIMARY KEY (`cod_propietario`,`cod_inquilino`,`fecha`),
  ADD KEY `cod_inquilino` (`cod_inquilino`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `cod_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informes`
--
ALTER TABLE `informes`
  MODIFY `cod_informe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inmueble`
--
ALTER TABLE `inmueble`
  MODIFY `cod_inmueble` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alquila`
--
ALTER TABLE `alquila`
  ADD CONSTRAINT `alquila_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `alquila_ibfk_2` FOREIGN KEY (`cod_inmueble`) REFERENCES `inmueble` (`cod_inmueble`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `comenta`
--
ALTER TABLE `comenta`
  ADD CONSTRAINT `comenta_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `comenta_ibfk_2` FOREIGN KEY (`cod_inmueble`) REFERENCES `inmueble` (`cod_inmueble`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`cod_inmueble`) REFERENCES `inmueble` (`cod_inmueble`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `informes`
--
ALTER TABLE `informes`
  ADD CONSTRAINT `informes_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `inmueble`
--
ALTER TABLE `inmueble`
  ADD CONSTRAINT `inmueble_ibfk_1` FOREIGN KEY (`cod_propietario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `opina`
--
ALTER TABLE `opina`
  ADD CONSTRAINT `opina_ibfk_1` FOREIGN KEY (`cod_propietario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `opina_ibfk_2` FOREIGN KEY (`cod_inquilino`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
