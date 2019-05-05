-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2019 a las 20:24:12
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
-- Estructura de tabla para la tabla `enviados_a_servicio`
--

CREATE TABLE `enviados_a_servicio` (
  `alm_corte_id` int(11) NOT NULL,
  `orden_corte` varchar(25) NOT NULL,
  `orden_servicio` varchar(45) DEFAULT NULL,
  `sku` varchar(25) NOT NULL,
  `sku_readable` varchar(250) NOT NULL,
  `cantidad_units_enviadas` int(11) NOT NULL,
  `fecha_de_envio` date NOT NULL,
  `peso_kg` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `enviados_a_servicio`
--

INSERT INTO `enviados_a_servicio` (`alm_corte_id`, `orden_corte`, `orden_servicio`, `sku`, `sku_readable`, `cantidad_units_enviadas`, `fecha_de_envio`, `peso_kg`) VALUES
(391, 'OC-2019-5-1v3', 'Oconfbordado-2019-5-1v1', 'ML-09001', 'ML-09001 | truza clasica corte alto dama ; talla-s color: blanco', 80, '2019-04-24', 1.00),
(392, 'OC-2019-5-1v3', 'Oconfbordado-2019-5-1v1', 'ML-10001', 'ML-10001 | truza clasica corte alto dama ; talla-m color: blanco', 240, '2019-04-24', 1.00),
(393, 'OC-2019-5-1v3', 'Oconfbordado-2019-5-1v1', 'ML-11001', 'ML-11001 | truza clasica corte alto dama ; talla-l color: blanco', 240, '2019-04-24', 1.00),
(394, 'OC-2019-5-1v3', 'Oconfbordado-2019-5-1v1', 'ML-12001', 'ML-12001 | truza clasica corte alto dama ; talla-xl color: blanco', 80, '2019-04-24', 1.00),
(395, 'OC-2019-5-1v2', 'Oconfbordado-2019-5-1v1', 'ML-09002', 'ML-09002 | truza clasica corte alto dama ; talla-s color: crema', 66, '2019-04-24', 1.00),
(396, 'OC-2019-5-1v2', 'Oconfbordado-2019-5-1v1', 'ML-10002', 'ML-10002 | truza clasica corte alto dama ; talla-m color: crema', 66, '2019-04-24', 1.00),
(397, 'OC-2019-5-1v2', 'Oconfbordado-2019-5-1v1', 'ML-11002', 'ML-11002 | truza clasica corte alto dama ; talla-l color: crema', 132, '2019-04-24', 1.00),
(398, 'OC-2019-5-1v2', 'Oconfbordado-2019-5-1v1', 'ML-12002', 'ML-12002 | truza clasica corte alto dama ; talla-xl color: crema', 66, '2019-04-24', 1.00),
(399, 'OC-2019-5-1v1', 'Oconfbordado-2019-5-1v1', 'ML-10006', 'ML-10006 | truza clasica corte alto dama ; talla-m color: verde agua', 110, '2019-04-24', 1.00),
(400, 'OC-2019-5-1v1', 'Oconfbordado-2019-5-1v1', 'ML-12006', 'ML-12006 | truza clasica corte alto dama ; talla-xl color: verde agua', 110, '2019-04-24', 1.00),
(401, 'OC-2019-5-1v3', 'Oconfbordado-2019-5-1v1', 'ML-09007', 'ML-09007 | truza clasica corte alto dama ; talla-s color: rosado', 34, '2019-04-24', 1.00),
(402, 'OC-2019-5-1v3', 'Oconfbordado-2019-5-1v1', 'ML-10007', 'ML-10007 | truza clasica corte alto dama ; talla-m color: rosado', 102, '2019-04-24', 1.00),
(403, 'OC-2019-5-1v3', 'Oconfbordado-2019-5-1v1', 'ML-11007', 'ML-11007 | truza clasica corte alto dama ; talla-l color: rosado', 102, '2019-04-24', 1.00),
(404, 'OC-2019-5-1v3', 'Oconfbordado-2019-5-1v1', 'ML-12007', 'ML-12007 | truza clasica corte alto dama ; talla-xl color: rosado', 34, '2019-04-24', 1.00),
(405, 'OC-2019-5-1v2', 'Oconfbordado-2019-5-1v1', 'ML-09008', 'ML-09008 | truza clasica corte alto dama ; talla-s color: melon', 82, '2019-04-24', 1.00),
(406, 'OC-2019-5-1v2', 'Oconfbordado-2019-5-1v1', 'ML-10008', 'ML-10008 | truza clasica corte alto dama ; talla-m color: melon', 82, '2019-04-24', 1.00),
(407, 'OC-2019-5-1v2', 'Oconfbordado-2019-5-1v1', 'ML-11008', 'ML-11008 | truza clasica corte alto dama ; talla-l color: melon', 164, '2019-04-24', 1.00),
(408, 'OC-2019-5-1v2', 'Oconfbordado-2019-5-1v1', 'ML-12008', 'ML-12008 | truza clasica corte alto dama ; talla-xl color: melon', 82, '2019-04-24', 1.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `enviados_a_servicio`
--
ALTER TABLE `enviados_a_servicio`
  ADD PRIMARY KEY (`alm_corte_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `enviados_a_servicio`
--
ALTER TABLE `enviados_a_servicio`
  MODIFY `alm_corte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=409;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
