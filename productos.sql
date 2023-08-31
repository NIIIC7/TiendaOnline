-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2023 a las 02:29:52
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_online`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` tinyint(3) NOT NULL DEFAULT 0,
  `id_categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `descuento`, `id_categoria`, `activo`) VALUES
(1, ' Casaca sin Capucha Weinbrenner para Hombre', 'Fabricada con materiales de alta calidad, esta casaca ofrece un equilibrio perfecto entre estilo y funcionalidad. Su diseño sin capucha le confiere un aspecto refinado y sofisticado, permitiéndote lucir elegante sin sacrificar comodidad. El color café, que evoca tonos cálidos y terrosos, es ideal para la temporada de Otoño-Invierno, y te mantendrá abrigado sin comprometer tu estilo.', 220.00, 30, 3, 1),
(2, 'tenis bajos Super-Star\r\n\r\n', '<p>\r\n    Parche de estrella, efecto envejecido, parche del logo en la lengüeta, cierre con agujetas en la parte delantera,\r\n    puntera redonda y suela plana de goma.\r\n</p>\r\n<p>\r\n    <strong>Composición:</strong>\r\n    <br>\r\n    Exterior: <em>Piel De Becerro 100%</em>\r\n    <br>\r\n    Suela: <em>Goma 100%</em>\r\n    <br>\r\n    Forro: <em>Tela 100%</em>\r\n</p>\r\n', 150.00, 20, 2, 1),
(3, 'jnce', 'cerrrrrrrr', 152.00, 0, 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
