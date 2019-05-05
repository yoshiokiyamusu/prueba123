-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2019 a las 20:25:53
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
-- Estructura de tabla para la tabla `orden_de_servicio_sku`
--

CREATE TABLE `orden_de_servicio_sku` (
  `orden_serv_sku_id` int(11) NOT NULL,
  `orden_servicio` varchar(45) NOT NULL,
  `orden_corte` varchar(25) NOT NULL,
  `sku` varchar(25) NOT NULL,
  `sku_readable` varchar(250) NOT NULL,
  `cantidad` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `orden_de_servicio_sku`
--

INSERT INTO `orden_de_servicio_sku` (`orden_serv_sku_id`, `orden_servicio`, `orden_corte`, `sku`, `sku_readable`, `cantidad`) VALUES
(392, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v3', 'ML-09001', 'ML-09001 | truza clasica corte alto dama ; talla-s color: blanco', 80.00),
(393, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v3', 'ML-10001', 'ML-10001 | truza clasica corte alto dama ; talla-m color: blanco', 240.00),
(394, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v3', 'ML-11001', 'ML-11001 | truza clasica corte alto dama ; talla-l color: blanco', 240.00),
(395, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v3', 'ML-12001', 'ML-12001 | truza clasica corte alto dama ; talla-xl color: blanco', 80.00),
(396, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v2', 'ML-09002', 'ML-09002 | truza clasica corte alto dama ; talla-s color: crema', 66.00),
(397, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v2', 'ML-10002', 'ML-10002 | truza clasica corte alto dama ; talla-m color: crema', 66.00),
(398, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v2', 'ML-11002', 'ML-11002 | truza clasica corte alto dama ; talla-l color: crema', 132.00),
(399, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v2', 'ML-12002', 'ML-12002 | truza clasica corte alto dama ; talla-xl color: crema', 66.00),
(400, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v1', 'ML-10006', 'ML-10006 | truza clasica corte alto dama ; talla-m color: verde agua', 110.00),
(401, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v1', 'ML-12006', 'ML-12006 | truza clasica corte alto dama ; talla-xl color: verde agua', 110.00),
(402, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v3', 'ML-09007', 'ML-09007 | truza clasica corte alto dama ; talla-s color: rosado', 34.00),
(403, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v3', 'ML-10007', 'ML-10007 | truza clasica corte alto dama ; talla-m color: rosado', 102.00),
(404, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v3', 'ML-11007', 'ML-11007 | truza clasica corte alto dama ; talla-l color: rosado', 102.00),
(405, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v3', 'ML-12007', 'ML-12007 | truza clasica corte alto dama ; talla-xl color: rosado', 34.00),
(406, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v2', 'ML-09008', 'ML-09008 | truza clasica corte alto dama ; talla-s color: melon', 82.00),
(407, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v2', 'ML-10008', 'ML-10008 | truza clasica corte alto dama ; talla-m color: melon', 82.00),
(408, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v2', 'ML-11008', 'ML-11008 | truza clasica corte alto dama ; talla-l color: melon', 164.00),
(409, 'Oconfbordado-2019-5-1v1', 'OC-2019-5-1v2', 'ML-12008', 'ML-12008 | truza clasica corte alto dama ; talla-xl color: melon', 82.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `orden_de_servicio_sku`
--
ALTER TABLE `orden_de_servicio_sku`
  ADD PRIMARY KEY (`orden_serv_sku_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `orden_de_servicio_sku`
--
ALTER TABLE `orden_de_servicio_sku`
  MODIFY `orden_serv_sku_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
