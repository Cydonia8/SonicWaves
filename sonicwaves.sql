-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-04-2023 a las 13:01:36
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sonicwaves`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album`
--

CREATE TABLE `album` (
  `id` int(4) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL CHECK (`activo` >= 0 and `activo` <= 1),
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `album`
--

INSERT INTO `album` (`id`, `titulo`, `foto`, `activo`, `grupo`) VALUES
(1, 'Nightmare', 'media/img_album/nightmare.jpg', 1, 1),
(2, 'Hello, I Must Be Going!', 'media/img_album/helloimustbegoing.jpg', 1, 4),
(3, 'Revolver', 'media/img_album/revolver.jpg', 1, 2),
(4, 'Pandora\'s Piñata', 'media/img_album/pandoras_pinata.jpg', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancion`
--

CREATE TABLE `cancion` (
  `id` int(4) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `duracion` char(5) DEFAULT NULL,
  `archivo` varchar(100) NOT NULL,
  `estilo` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cancion`
--

INSERT INTO `cancion` (`id`, `titulo`, `duracion`, `archivo`, `estilo`) VALUES
(1, 'Nightmare', '06:15', 'media/audio/a7x/nightmare.mp3', 2),
(2, 'Balrog Boogie', '03:45', 'media/audio/dso/balrog.mp3', 3),
(3, 'Taxman', '02:46', 'media/audio/beatles/taxman.mp3', 4),
(4, 'I Don\'t Care Anymore', '05:05', 'media/audio/phil_collins/idontcareanymore.mp3', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `lista` int(4) NOT NULL,
  `cancion` int(4) NOT NULL,
  `orden` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario`
--

CREATE TABLE `cuestionario` (
  `id` int(4) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `duracion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discografica`
--

CREATE TABLE `discografica` (
  `id` int(4) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `discografica`
--

INSERT INTO `discografica` (`id`, `nombre`, `correo`, `pass`, `activo`) VALUES
(1, 'Universal', 'holymustaine20@gmail.com', 'ss', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estilo`
--

CREATE TABLE `estilo` (
  `id` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `color_característico` char(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estilo`
--

INSERT INTO `estilo` (`id`, `nombre`, `color_característico`) VALUES
(1, 'Pop', NULL),
(2, 'Metal', NULL),
(3, 'Avant-garde', NULL),
(4, 'Rock-pop', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorito`
--

CREATE TABLE `favorito` (
  `usuario` int(4) NOT NULL,
  `album` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_grupo`
--

CREATE TABLE `foto_grupo` (
  `id` int(4) NOT NULL,
  `enlace` varchar(100) NOT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_publicacion`
--

CREATE TABLE `foto_publicacion` (
  `id` int(4) NOT NULL,
  `enlace` varchar(100) NOT NULL,
  `publicacion` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` int(4) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `biografia` varchar(2000) DEFAULT NULL,
  `pass` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `foto` varchar(100) DEFAULT NULL,
  `discografica` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `nombre`, `biografia`, `pass`, `correo`, `activo`, `foto`, `discografica`) VALUES
(1, 'Avenged Sevenfold', '', NULL, NULL, 1, 'media/img_grupo/a7x.jpg', NULL),
(2, 'The Beatles', '', NULL, NULL, 1, 'media/img_grupos/beatles.jpg', NULL),
(3, 'Diablo Swing Orchestra', '', NULL, NULL, 1, 'media/img_grupos/dso.jpg', NULL),
(4, 'Phil Collins', '', NULL, NULL, 1, 'media/img_grupos/philcollins.jpg', NULL),
(6, 'La Sudadera Del Manager', NULL, '22', 'lasuda@gmail.com', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incluye`
--

CREATE TABLE `incluye` (
  `album` int(4) DEFAULT NULL,
  `cancion` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incluye`
--

INSERT INTO `incluye` (`album`, `cancion`) VALUES
(1, 1),
(2, 4),
(4, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista`
--

CREATE TABLE `lista` (
  `id` int(4) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `usuario` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` int(4) NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `fecha` date DEFAULT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `id` int(4) NOT NULL,
  `contenido` varchar(1500) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha` date DEFAULT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibe`
--

CREATE TABLE `recibe` (
  `usuario` int(4) NOT NULL,
  `mensaje` int(4) NOT NULL,
  `estado` tinyint(1) DEFAULT 0 CHECK (`estado` >= 0 and `estado` <= 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseña`
--

CREATE TABLE `reseña` (
  `id` int(4) NOT NULL,
  `contenido` varchar(3000) NOT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` int(4) DEFAULT NULL,
  `album` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responde`
--

CREATE TABLE `responde` (
  `usuario` int(4) NOT NULL,
  `respuesta` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` int(4) NOT NULL,
  `contenido` varchar(100) NOT NULL,
  `cuestionario` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sigue`
--

CREATE TABLE `sigue` (
  `usuario` int(4) NOT NULL,
  `grupo` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(4) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `correo` varchar(50) NOT NULL,
  `f_nac` date DEFAULT NULL,
  `high_shelf_f` float DEFAULT NULL,
  `high_shelf_gain` float DEFAULT NULL,
  `low_shelf_f` float DEFAULT NULL,
  `low_shelf_gain` float DEFAULT NULL,
  `high_pass_f` float DEFAULT NULL,
  `high_pass_q` float DEFAULT NULL,
  `low_pass_f` float DEFAULT NULL,
  `low_pass_q` float DEFAULT NULL,
  `estilo` int(2) DEFAULT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellidos`, `usuario`, `pass`, `foto`, `correo`, `f_nac`, `high_shelf_f`, `high_shelf_gain`, `low_shelf_f`, `low_shelf_gain`, `high_pass_f`, `high_pass_q`, `low_pass_f`, `low_pass_q`, `estilo`, `grupo`) VALUES
(1, 'Alvaro', 'Blanco Lucena', 'cydonia8', 'tt5', NULL, 'holymustaine20@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL),
(3, 'sds', 'sds', ' 74746281F', 'sds', NULL, 'lasuda@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_alb_gru` (`grupo`);

--
-- Indices de la tabla `cancion`
--
ALTER TABLE `cancion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_canc_est` (`estilo`);

--
-- Indices de la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`lista`,`cancion`),
  ADD KEY `ce_cont_canc` (`cancion`);

--
-- Indices de la tabla `cuestionario`
--
ALTER TABLE `cuestionario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_cuest_gru` (`grupo`);

--
-- Indices de la tabla `discografica`
--
ALTER TABLE `discografica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estilo`
--
ALTER TABLE `estilo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD PRIMARY KEY (`usuario`,`album`),
  ADD KEY `ce_fav_alb` (`album`);

--
-- Indices de la tabla `foto_grupo`
--
ALTER TABLE `foto_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_fotgru_gru` (`grupo`);

--
-- Indices de la tabla `foto_publicacion`
--
ALTER TABLE `foto_publicacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_fotpubl_publ` (`publicacion`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_gru_disc` (`discografica`);

--
-- Indices de la tabla `incluye`
--
ALTER TABLE `incluye`
  ADD KEY `ce_inclu_alb` (`album`),
  ADD KEY `ce_inclu_canc` (`cancion`);

--
-- Indices de la tabla `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_list_usu` (`usuario`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_mens_gru` (`grupo`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_publ_gru` (`grupo`);

--
-- Indices de la tabla `recibe`
--
ALTER TABLE `recibe`
  ADD PRIMARY KEY (`usuario`,`mensaje`),
  ADD KEY `ce_rec_mens` (`mensaje`);

--
-- Indices de la tabla `reseña`
--
ALTER TABLE `reseña`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_res_usu` (`usuario`),
  ADD KEY `ce_res_gru` (`album`);

--
-- Indices de la tabla `responde`
--
ALTER TABLE `responde`
  ADD PRIMARY KEY (`usuario`,`respuesta`),
  ADD KEY `ce_respo_cuest` (`respuesta`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_resp_cuest` (`cuestionario`);

--
-- Indices de la tabla `sigue`
--
ALTER TABLE `sigue`
  ADD PRIMARY KEY (`usuario`,`grupo`),
  ADD KEY `ce_sig_gru` (`grupo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `ce_us_est` (`estilo`),
  ADD KEY `ce_us_grup` (`grupo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `album`
--
ALTER TABLE `album`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cancion`
--
ALTER TABLE `cancion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cuestionario`
--
ALTER TABLE `cuestionario`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `discografica`
--
ALTER TABLE `discografica`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estilo`
--
ALTER TABLE `estilo`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `foto_grupo`
--
ALTER TABLE `foto_grupo`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `foto_publicacion`
--
ALTER TABLE `foto_publicacion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `lista`
--
ALTER TABLE `lista`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reseña`
--
ALTER TABLE `reseña`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `ce_alb_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `cancion`
--
ALTER TABLE `cancion`
  ADD CONSTRAINT `ce_canc_est` FOREIGN KEY (`estilo`) REFERENCES `estilo` (`id`);

--
-- Filtros para la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `ce_cont_canc` FOREIGN KEY (`cancion`) REFERENCES `cancion` (`id`),
  ADD CONSTRAINT `ce_cont_list` FOREIGN KEY (`lista`) REFERENCES `lista` (`id`);

--
-- Filtros para la tabla `cuestionario`
--
ALTER TABLE `cuestionario`
  ADD CONSTRAINT `ce_cuest_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `ce_fav_alb` FOREIGN KEY (`album`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `ce_fav_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `foto_grupo`
--
ALTER TABLE `foto_grupo`
  ADD CONSTRAINT `ce_fotgru_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `foto_publicacion`
--
ALTER TABLE `foto_publicacion`
  ADD CONSTRAINT `ce_fotpubl_publ` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`id`);

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `ce_gru_disc` FOREIGN KEY (`discografica`) REFERENCES `discografica` (`id`);

--
-- Filtros para la tabla `incluye`
--
ALTER TABLE `incluye`
  ADD CONSTRAINT `ce_inclu_alb` FOREIGN KEY (`album`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `ce_inclu_canc` FOREIGN KEY (`cancion`) REFERENCES `cancion` (`id`);

--
-- Filtros para la tabla `lista`
--
ALTER TABLE `lista`
  ADD CONSTRAINT `ce_list_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `ce_mens_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `ce_publ_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `recibe`
--
ALTER TABLE `recibe`
  ADD CONSTRAINT `ce_rec_mens` FOREIGN KEY (`mensaje`) REFERENCES `mensaje` (`id`),
  ADD CONSTRAINT `ce_rec_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `reseña`
--
ALTER TABLE `reseña`
  ADD CONSTRAINT `ce_res_gru` FOREIGN KEY (`album`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `ce_res_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `responde`
--
ALTER TABLE `responde`
  ADD CONSTRAINT `ce_respo_cuest` FOREIGN KEY (`respuesta`) REFERENCES `respuesta` (`id`),
  ADD CONSTRAINT `ce_respo_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `ce_resp_cuest` FOREIGN KEY (`cuestionario`) REFERENCES `cuestionario` (`id`);

--
-- Filtros para la tabla `sigue`
--
ALTER TABLE `sigue`
  ADD CONSTRAINT `ce_sig_gru` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `ce_sig_usu` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `ce_us_est` FOREIGN KEY (`estilo`) REFERENCES `estilo` (`id`),
  ADD CONSTRAINT `ce_us_grup` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
