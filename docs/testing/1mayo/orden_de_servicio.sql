-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2019 a las 20:25:11
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
-- Estructura de tabla para la tabla `orden_de_servicio`
--

CREATE TABLE `orden_de_servicio` (
  `orden_servicio_id` int(11) NOT NULL,
  `orden_servicio` varchar(45) NOT NULL,
  `fecha_orden_servicio` date NOT NULL,
  `proveedor` varchar(250) DEFAULT NULL,
  `fecha_envio` date NOT NULL,
  `recibo_fecha_desde` date NOT NULL,
  `recibo_fecha_hasta` date NOT NULL,
  `estado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `orden_de_servicio`
--

INSERT INTO `orden_de_servicio` (`orden_servicio_id`, `orden_servicio`, `fecha_orden_servicio`, `proveedor`, `fecha_envio`, `recibo_fecha_desde`, `recibo_fecha_hasta`, `estado`) VALUES
(145, 'Oconfbordado-2019-5-1v1', '2019-05-01', 'AYDA_EDER', '2019-04-24', '2019-05-02', '2019-05-02', 'enviado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `orden_de_servicio`
--
ALTER TABLE `orden_de_servicio`
  ADD PRIMARY KEY (`orden_servicio_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `orden_de_servicio`
--
ALTER TABLE `orden_de_servicio`
  MODIFY `orden_servicio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
