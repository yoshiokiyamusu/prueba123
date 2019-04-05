-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-02-2019 a las 10:38:09
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
-- Estructura de tabla para la tabla `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `codigo` varchar(25) NOT NULL,
  `categoria` varchar(25) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `estado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `codigo`, `categoria`, `nombre`, `estado`) VALUES
(1, 'sup01', 'taller_confeccion', 'AYDA_EDER', 'activo'),
(2, 'sup02', 'taller_confeccion', 'CIELO_ELTEX', 'activo'),
(3, 'sup03', 'taller_confeccion', 'GRIMALDO_ABBY', 'activo'),
(4, 'sup04', 'taller_confeccion', 'ROSALY_SERVITEX', 'activo'),
(5, 'sup05', 'taller_confeccion', 'HECTOR_ESTAMPADO_ROSA', 'activo'),
(6, 'sup06', 'taller_confeccion', 'TALLER_INTERNO', 'activo'),
(7, 'sup07', 'taller_confeccion', 'TOMAS_SILVA', 'activo'),
(8, 'sup08', 'taller_confeccion', 'SANDRA', 'activo'),
(9, 'sup09', 'taller_confeccion', 'LIDIA_OROZCO', 'activo'),
(10, 'sup10', 'taller_confeccion', 'BORDADO_LUIS_PARIMANGO', 'activo'),
(11, 'sup11', 'taller_confeccion', 'BORDADOS_OSCAR', 'activo'),
(12, 'sup12', 'taller_confeccion', 'ELSA', 'activo'),
(13, 'sup13', 'taller_confeccion', 'JULIO_FABIKEN', 'activo'),
(14, 'sup14', 'taller_confeccion', 'GERONIMO_FLORES', 'activo'),
(15, 'sup15', 'taller_confeccion', 'HUGO_CANALES', 'activo'),
(16, 'sup16', 'taller_confeccion', 'JUANCARLOS', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
