-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2019 a las 20:16:42
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
-- Estructura de tabla para la tabla `orden_de_corte`
--

CREATE TABLE `orden_de_corte` (
  `corte_id` int(11) NOT NULL,
  `orden_corte` varchar(25) NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_de_corte` date NOT NULL,
  `categoria_sku` varchar(25) NOT NULL,
  `sku` varchar(25) NOT NULL,
  `sku_readable` varchar(250) NOT NULL,
  `cant_units` double(8,2) NOT NULL,
  `peso_kg` double(8,2) NOT NULL,
  `status` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `orden_de_corte`
--

INSERT INTO `orden_de_corte` (`corte_id`, `orden_corte`, `fecha_emision`, `fecha_de_corte`, `categoria_sku`, `sku`, `sku_readable`, `cant_units`, `peso_kg`, `status`) VALUES
(392, 'OC-2019-5-1v1', '2019-05-01', '2019-04-23', 'ML', 'ML-10006', 'ML-10006 | truza clasica corte alto dama ; talla-m color: verde agua', 110.00, 2.46, 'cortado'),
(393, 'OC-2019-5-1v1', '2019-05-01', '2019-04-23', 'ML', 'ML-12006', 'ML-12006 | truza clasica corte alto dama ; talla-xl color: verde agua', 110.00, 2.90, 'cortado'),
(394, 'OC-2019-5-1v2', '2019-05-01', '2019-04-23', 'ML', 'ML-09002', 'ML-09002 | truza clasica corte alto dama ; talla-s color: crema', 66.00, 1.34, 'cortado'),
(395, 'OC-2019-5-1v2', '2019-05-01', '2019-04-23', 'ML', 'ML-10002', 'ML-10002 | truza clasica corte alto dama ; talla-m color: crema', 66.00, 1.44, 'cortado'),
(396, 'OC-2019-5-1v2', '2019-05-01', '2019-04-23', 'ML', 'ML-11002', 'ML-11002 | truza clasica corte alto dama ; talla-l color: crema', 132.00, 3.18, 'cortado'),
(397, 'OC-2019-5-1v2', '2019-05-01', '2019-04-23', 'ML', 'ML-12002', 'ML-12002 | truza clasica corte alto dama ; talla-xl color: crema', 66.00, 1.72, 'cortado'),
(398, 'OC-2019-5-1v2', '2019-05-01', '2019-04-23', 'ML', 'ML-09008', 'ML-09008 | truza clasica corte alto dama ; talla-s color: melon', 82.00, 1.74, 'cortado'),
(399, 'OC-2019-5-1v2', '2019-05-01', '2019-04-23', 'ML', 'ML-10008', 'ML-10008 | truza clasica corte alto dama ; talla-m color: melon', 82.00, 1.88, 'cortado'),
(400, 'OC-2019-5-1v2', '2019-05-01', '2019-04-23', 'ML', 'ML-11008', 'ML-11008 | truza clasica corte alto dama ; talla-l color: melon', 164.00, 3.44, 'cortado'),
(401, 'OC-2019-5-1v2', '2019-05-01', '2019-04-23', 'ML', 'ML-12008', 'ML-12008 | truza clasica corte alto dama ; talla-xl color: melon', 82.00, 2.88, 'cortado'),
(402, 'OC-2019-5-1v3', '2019-05-01', '2019-04-23', 'ML', 'ML-09001', 'ML-09001 | truza clasica corte alto dama ; talla-s color: blanco', 80.00, 1.66, 'cortado'),
(403, 'OC-2019-5-1v3', '2019-05-01', '2019-04-23', 'ML', 'ML-10001', 'ML-10001 | truza clasica corte alto dama ; talla-m color: blanco', 240.00, 5.86, 'cortado'),
(404, 'OC-2019-5-1v3', '2019-05-01', '2019-04-23', 'ML', 'ML-11001', 'ML-11001 | truza clasica corte alto dama ; talla-l color: blanco', 240.00, 5.86, 'cortado'),
(405, 'OC-2019-5-1v3', '2019-05-01', '2019-04-23', 'ML', 'ML-12001', 'ML-12001 | truza clasica corte alto dama ; talla-xl color: blanco', 80.00, 2.20, 'cortado'),
(406, 'OC-2019-5-1v3', '2019-05-01', '2019-04-23', 'ML', 'ML-09007', 'ML-09007 | truza clasica corte alto dama ; talla-s color: rosado', 34.00, 2.26, 'cortado'),
(407, 'OC-2019-5-1v3', '2019-05-01', '2019-04-23', 'ML', 'ML-10007', 'ML-10007 | truza clasica corte alto dama ; talla-m color: rosado', 102.00, 2.10, 'cortado'),
(408, 'OC-2019-5-1v3', '2019-05-01', '2019-04-23', 'ML', 'ML-11007', 'ML-11007 | truza clasica corte alto dama ; talla-l color: rosado', 102.00, 2.44, 'cortado'),
(409, 'OC-2019-5-1v3', '2019-05-01', '2019-04-23', 'ML', 'ML-12007', 'ML-12007 | truza clasica corte alto dama ; talla-xl color: rosado', 34.00, 2.31, 'cortado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `orden_de_corte`
--
ALTER TABLE `orden_de_corte`
  ADD PRIMARY KEY (`corte_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `orden_de_corte`
--
ALTER TABLE `orden_de_corte`
  MODIFY `corte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
