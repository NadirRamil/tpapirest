-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2022 a las 06:19:12
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tpespecial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistas`
--

CREATE TABLE `artistas` (
  `artista_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `nacionalidad` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `artistas`
--

INSERT INTO `artistas` (`artista_id`, `nombre`, `nacionalidad`) VALUES
(2, 'Daddy Yankee', 'Puerto Rico'),
(3, 'Duki', 'Argentina'),
(4, 'Coldplay', 'Inglaterra'),
(5, 'Harry Styles', 'Inglaterra'),
(6, 'Michael Buble', 'Canada'),
(7, 'Tini Stoessel', 'Argentina'),
(8, 'Diego Torres', 'Argentina'),
(9, 'Eros Ramazzotti', 'Italia'),
(10, 'Ricky Martin', 'Puerto Rico'),
(11, 'Andres Calamaro', 'Argentina'),
(12, 'Bad Bunny', 'Puerto Rico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recitales`
--

CREATE TABLE `recitales` (
  `fecha` date NOT NULL,
  `lugar` varchar(45) NOT NULL,
  `artista_id` int(11) NOT NULL,
  `id_recital` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recitales`
--

INSERT INTO `recitales` (`fecha`, `lugar`, `artista_id`, `id_recital`) VALUES
('2022-10-01', 'Estadio José Amalfitani', 2, 4),
('2022-10-06', 'Estadio José Amalfitani', 3, 5),
('2022-11-08', 'Estadio Antonio Vespucio Liberti', 4, 11),
('2022-12-03', 'Estadio Antonio Vespucio Liberti', 5, 12),
('2022-11-12', 'Movistar Arena', 6, 13),
('2022-11-05', 'Estadio UNO Jorge Luis Hirschi ', 7, 14),
('2022-10-23', 'Teatro Gran Rex', 8, 15),
('2022-12-02', 'Movistar Arena', 9, 16),
('2022-11-24', 'Movistar Arena', 10, 17),
('2022-11-06', 'Movistar Arena', 11, 18),
('2022-11-04', 'Estadio Antonio Vespucio Liberti', 12, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'nadirramil92@gmail.com', '$2a$12$QImiY.a8wYpYPd.6k4xuwejBcsDW37dMIerW.uSe5Jd1JauG/onl6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artistas`
--
ALTER TABLE `artistas`
  ADD PRIMARY KEY (`artista_id`),
  ADD KEY `artista_id` (`artista_id`);

--
-- Indices de la tabla `recitales`
--
ALTER TABLE `recitales`
  ADD PRIMARY KEY (`id_recital`),
  ADD KEY `artista_id` (`artista_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `artistas`
--
ALTER TABLE `artistas`
  MODIFY `artista_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `recitales`
--
ALTER TABLE `recitales`
  MODIFY `id_recital` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `recitales`
--
ALTER TABLE `recitales`
  ADD CONSTRAINT `recitales_ibfk_1` FOREIGN KEY (`artista_id`) REFERENCES `artistas` (`artista_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
