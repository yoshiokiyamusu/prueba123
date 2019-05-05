-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2019 a las 19:45:46
-- Versión del servidor: 10.2.12-MariaDB
-- Versión de PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `corner_tool`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo_orden_corte`
--

CREATE TABLE `insumo_orden_corte` (
  `insumo_id` int(11) NOT NULL,
  `orden_corte` varchar(25) NOT NULL,
  `fecha_emision` date NOT NULL,
  `string_categ_sku` varchar(50) NOT NULL,
  `color_rollo` varchar(150) NOT NULL,
  `sku` varchar(250) NOT NULL,
  `cant_solicitada_kg` double(8,2) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `insumo_orden_corte`
--

INSERT INTO `insumo_orden_corte` (`insumo_id`, `orden_corte`, `fecha_emision`, `string_categ_sku`, `color_rollo`, `sku`, `cant_solicitada_kg`, `status`, `timestamp`) VALUES
(109, 'OC-2019-5-1v1', '2019-05-01', 'ML', 'verde agua', 'TJSC011', 7.00, 'para_produccion', '2019-05-01 17:28:43'),
(110, 'OC-2019-5-1v2', '2019-05-01', 'ML', 'crema', 'TJSC005', 9.00, 'para_produccion', '2019-05-01 17:35:53'),
(111, 'OC-2019-5-1v2', '2019-05-01', 'ML', 'melon', 'TJSC017', 12.00, 'para_produccion', '2019-05-01 17:35:53'),
(112, 'OC-2019-5-1v3', '2019-05-01', 'ML', 'blanco', 'TJSC001', 19.00, 'para_produccion', '2019-05-01 17:40:22'),
(113, 'OC-2019-5-1v3', '2019-05-01', 'ML', 'rosado', 'TJSC008', 8.00, 'para_produccion', '2019-05-01 17:40:22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `insumo_orden_corte`
--
ALTER TABLE `insumo_orden_corte`
  ADD PRIMARY KEY (`insumo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `insumo_orden_corte`
--
ALTER TABLE `insumo_orden_corte`
  MODIFY `insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
