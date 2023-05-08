-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2023 a las 16:40:03
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
  `grupo` int(4) DEFAULT NULL,
  `lanzamiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `album`
--

INSERT INTO `album` (`id`, `titulo`, `foto`, `activo`, `grupo`, `lanzamiento`) VALUES
(22, 'Master Of Puppets', '../media/img_grupos/met@gm.com/master of puppets.jpg', 1, 7, '1986-02-13'),
(24, '...And Justice for All', '../media/img_grupos/met@gm.com/and justice for all.jpg', 1, 7, '1988-09-07'),
(29, 'The Works Singles', '../media/img_grupos/Queen_12/the works singles.jpg', 1, 12, '2023-04-01'),
(30, 'Closure/Continuation', '../media/img_grupos/Porcupine Tree_11/closurecontinuation.jpg', 1, 11, '2022-06-03'),
(31, 'Selling England by the Pound', '../media/img_grupos/genesis@genesis.com/selling england by the pound.jpg', 1, 13, '1974-07-19'),
(32, 'Best Of', '../media/img_grupos/met@gm.com/best of.webp', 1, 7, '2023-02-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancion`
--

CREATE TABLE `cancion` (
  `id` int(4) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `duracion` char(5) DEFAULT NULL,
  `archivo` varchar(300) NOT NULL,
  `estilo` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cancion`
--

INSERT INTO `cancion` (`id`, `titulo`, `duracion`, `archivo`, `estilo`) VALUES
(33, 'Battery', '05:12', '../media/audio/met@gm.com/master of puppets/battery.mp3', 2),
(34, 'Master of Puppets', '08:36', '../media/audio/met@gm.com/master of puppets/master of puppets.mp3', 2),
(35, 'The Thing That Should Not Be', '06:36', '../media/audio/met@gm.com/master of puppets/the thing that should not be.mp3', 2),
(36, 'Welcome Home (Sanitarium)', '06:27', '../media/audio/met@gm.com/master of puppets/welcome home sanitarium.mp3', 2),
(37, 'Disposable Heroes', '08:17', '../media/audio/met@gm.com/master of puppets/disposable heroes.mp3', 2),
(38, 'Lepper Mesiah', '05:40', '../media/audio/met@gm.com/master of puppets/lepper messiah.mp3', 2),
(39, 'Orion', '08:27', '../media/audio/met@gm.com/master of puppets/orion.mp3', 2),
(40, 'Damage, Inc.', '05:33', '../media/audio/met@gm.com/master of puppets/damage inc.mp3', 2),
(50, 'Blackened', '06:41', '../media/audio/met@gm.com/and justice for all/blackened.mp3', 9),
(51, '...And Justice for All', '09:47', '../media/audio/met@gm.com/and justice for all/andjusticeforall.mp3', 9),
(52, 'Eye of the Beholder', '06:26', '../media/audio/met@gm.com/and justice for all/eyeofthebeholder.mp3', 9),
(53, 'One', '07:26', '../media/audio/met@gm.com/and justice for all/one.mp3', 9),
(54, 'The Shortest Straw', '06:35', '../media/audio/met@gm.com/and justice for all/theshorteststraw.mp3', 9),
(55, 'Harvester of Sorrow', '05:44', '../media/audio/met@gm.com/and justice for all/harvesterofsorrow.mp3', 9),
(56, 'The Frayed Ends of Sanity', '07:43', '../media/audio/met@gm.com/and justice for all/thefrayedendsofsanity.mp3', 9),
(57, 'To Live is to Die', '09:49', '../media/audio/met@gm.com/and justice for all/toliveistodie.mp3', 9),
(58, 'Dyers Eve', '05:13', '../media/audio/met@gm.com/and justice for all/dyerseve.mp3', 9),
(82, 'Hammer To Fall', '04:26', '../media/audio/Queen_12/the works singles/hammertofall.mp3', 4),
(83, 'Radio Ga Ga', '05:50', '../media/audio/Queen_12/the works singles/radiogaga.mp3', 4),
(84, 'Harridan', '08:08', '../media/audio/Porcupine Tree_11/closurecontinuation/harridan.mp3', 10),
(85, 'Of The New Day', '04:43', '../media/audio/Porcupine Tree_11/closurecontinuation/ofthenewday.mp3', 10),
(86, 'Rats Return', '05:41', '../media/audio/Porcupine Tree_11/closurecontinuation/ratsreturn.mp3', 10),
(87, 'Dignity', '08:23', '../media/audio/Porcupine Tree_11/closurecontinuation/dignity.mp3', 10),
(88, 'Herd Culling', '07:04', '../media/audio/Porcupine Tree_11/closurecontinuation/herdculling.mp3', 10),
(89, 'Walk The Plank', '04:27', '../media/audio/Porcupine Tree_11/closurecontinuation/walktheplank.mp3', 10),
(90, 'Chimera\'s Wreck', '09:41', '../media/audio/Porcupine Tree_11/closurecontinuation/chimeraswreck.mp3', 10),
(91, 'Population Three', '06:52', '../media/audio/Porcupine Tree_11/closurecontinuation/populationthree.mp3', 10),
(92, 'Never Have', '05:09', '../media/audio/Porcupine Tree_11/closurecontinuation/neverhave.mp3', 10),
(93, 'Love In The Past Tense', '05:50', '../media/audio/Porcupine Tree_11/closurecontinuation/loveinthepasttense.mp3', 10),
(94, 'Dancing With the Moonlit Knight', '08:03', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - dancing with the moonlight knight (official audio) (320 kbps).mp3', 10),
(95, 'I Know What I Like (In Your Wardrobe)', '04:11', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - i know what i like (in your wardrobe) [official audio] (128 kbps).mp3', 10),
(96, 'Firth of Fifth', '09:35', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - firth of fifth (official audio) (320 kbps).mp3', 10),
(97, 'More Fool Me', '03:11', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - more fool me (official audio) (320 kbps).mp3', 10),
(98, 'The Battle of Epping Forest', '11:44', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - the battle of epping forest (official audio) (192 kbps).mp3', 10),
(99, 'After the Ordeal', '04:15', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - after the ordeal (official audio) (256 kbps).mp3', 10),
(100, 'The Cinema Show', '10:42', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - the cinema show (official audio) (192 kbps).mp3', 10),
(101, 'Aisle of Plenty', '01:58', '../media/audio/genesis@genesis.com/selling england by the pound/snapsave.io - genesis - aisle of plenty (official audio) (320 kbps).mp3', 10);

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
  `foto_avatar` varchar(150) NOT NULL DEFAULT '../media/image_user_default.png',
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `pendiente_aprobacion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `discografica`
--

INSERT INTO `discografica` (`id`, `nombre`, `correo`, `pass`, `foto_avatar`, `activo`, `pendiente_aprobacion`) VALUES
(0, 'Autogestionado', '', '', '../media/image_user_default.png', 0, 1),
(1, 'Universal', 'universal@gmail.com', 'universal', '../media/img_users/image_user_default.png', 1, 0),
(2, 'Motown', 'ddd@gmail.com', 'fff', '../media/img_users/image_user_default.png', 0, 0),
(3, 'Pollos Hermanos Records', 'pollos@gmail.com', 'pollos', '../media/img_users/image_user_default.png', 1, 0),
(4, 'Montana Records', 'tony@tony.com', 'tony', '../media/image_user_default.png', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estilo`
--

CREATE TABLE `estilo` (
  `id` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `color_caracteristico` char(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estilo`
--

INSERT INTO `estilo` (`id`, `nombre`, `color_caracteristico`) VALUES
(0, 'sin estilo', NULL),
(1, 'Pop', '#a9fc03'),
(2, 'Metal', '#080614'),
(3, 'Avant-garde', '#fc039d'),
(4, 'Rock-pop', '#39e622'),
(5, 'Reggae', '#1b3e14'),
(7, 'Riguiton', '#8f2424'),
(9, 'Thrash metal', '#272525'),
(10, 'Rock progresivo', '#6b329a');

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

--
-- Volcado de datos para la tabla `foto_grupo`
--

INSERT INTO `foto_grupo` (`id`, `enlace`, `grupo`) VALUES
(43, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra43.jpg', 19),
(44, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra44.jpg', 19),
(45, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra45.webp', 19),
(46, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra46.jpg', 19),
(47, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra47.jpg', 19),
(48, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comfotoextra48.jpg', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_publicacion`
--

CREATE TABLE `foto_publicacion` (
  `id` int(4) NOT NULL,
  `enlace` varchar(100) NOT NULL,
  `publicacion` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foto_publicacion`
--

INSERT INTO `foto_publicacion` (`id`, `enlace`, `publicacion`) VALUES
(13, '../media/img_posts/meta@gm.com/foto1post14.jpg', 14),
(14, '../media/img_posts/meta@gm.com/foto2post14.jpg', 14),
(18, '../media/img_posts/pinkfloyd@gmail.com/foto1post16.jpg', 16),
(19, '../media/img_posts/pinkfloyd@gmail.com/foto2post16.jpg', 16),
(20, '../media/img_posts/pinkfloyd@gmail.com/foto3post16.jpg', 16);

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
  `foto` varchar(150) DEFAULT NULL,
  `foto_avatar` varchar(150) NOT NULL DEFAULT '../media/image_user_default.png',
  `discografica` int(4) DEFAULT NULL,
  `pendiente_aprobacion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `nombre`, `biografia`, `pass`, `correo`, `activo`, `foto`, `foto_avatar`, `discografica`, `pendiente_aprobacion`) VALUES
(0, 'sin grupo', NULL, NULL, NULL, 0, NULL, '../media/image_user_default.png', NULL, 1),
(7, 'Metallica', 'Metallica es un grupo estadounidense de thrash metal1​ originario de Los Ángeles, pero con base en San Francisco desde febrero de 1983. Fue fundado en 1981 en Los Ángeles por Lars Ulrich y James Hetfield, a los que se les unirían Dave Mustaine y Ron McGovney. Estos dos músicos fueron después sustituidos por el guitarrista Kirk Hammett y el bajista Cliff Burton respectivamente, Dave Mustaine fue despedido un año después de ingresar en la banda debido a su excesiva adicción al alcohol y su actitud violenta, siendo sustituido por Kirk Hammett (exguitarrista de Exodus).', 'meta', 'meta@gm.com', 1, '../media/img_grupos/met@gm.com/met@gm.com.jpg', '../media/img_grupos/met@gm.com/met@gm.comavatar.jpg', 0, 0),
(11, 'Porcupine Tree', 'wapo', NULL, NULL, 1, '../media/img_grupos/Porcupine Tree_11/Porcupine Tree_11_.jpg', '../media/img_grupos/Porcupine Tree_11/Porcupine Tree_11_avatar.jpg', 1, 0),
(12, 'Queen', 'grupazo', NULL, NULL, 1, '../media/img_grupos/Queen_12/Queen_12_.jpg', '../media/img_grupos/Queen_12/Queen_12_foto.jpg', 3, 0),
(13, 'Genesis', 'genesis to wapo', 'genesis', 'genesis@genesis.com', 1, '../media/img_grupos/genesis@genesis.com/genesis@genesis.com.jpg', '../media/img_grupos/genesis@genesis.com/genesis@genesis.comavatar.jpg', 0, 0),
(15, 'Muse', 'Muse es un grupazo', NULL, NULL, 0, '../media/img_grupos/Muse_15/Muse_15_.jpg', '../media/img_grupos/Muse_15/Muse_15_avatar.jpg', 1, 0),
(17, 'La Sudadera Del Manager', 'La sudaderaaaaa', 'lasudadera', 'lasudadera@gmail.com', 1, '../media/img_grupos/lasudadera@gmail.com/lasudadera@gmail.com.jpg', '../media/img_grupos/lasudadera@gmail.com/lasudadera@gmail.comavatar.jpg', 0, 0),
(18, 'Foo Fighters', NULL, 'fighters', 'fighters@gmail.com', 2, NULL, '../media/image_user_default.png', 0, 0),
(19, 'Pink Floyd', 'Pink Floyd es una banda de rock británica, fundada en Londres en 1965. Considerada un icono cultural del siglo XX y una de las bandas más influyentes, exitosas y aclamadas en la historia de la música popular, obtuvo gran popularidad dentro del circuito underground gracias a su música psicodélica y espacial, que con el paso del tiempo evolucionó hacia el rock progresivo y el rock sinfónico adquiriendo la popularidad con la que hoy son recordados. Es conocida por sus canciones de alto contenido filosófico, a veces de crítica política, junto a la experimentación sonora, las innovadoras portadas de sus discos y sus elaborados espectáculos en vivo. Sus ventas sobrepasan los 280 millones de álbumes vendidos en todo el mundo,​ 97,5 millones de ellos solamente en los Estados Unidos,​ convirtiéndose en una de las bandas con más ventas en la historia.\r\n\r\nInicialmente el grupo estaba formado por el baterista Nick Mason, el tecladista y vocalista Richard Wright, el bajista y vocalista Roger Waters y el guitarrista y vocalista principal Syd Barrett.', 'pinkfloyd', 'pinkfloyd@gmail.com', 1, '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.com.jpg', '../media/img_grupos/pinkfloyd@gmail.com/pinkfloyd@gmail.comavatar.jpg', 0, 0);

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
(22, 33),
(22, 34),
(22, 35),
(22, 36),
(22, 37),
(22, 38),
(22, 39),
(22, 40),
(24, 50),
(24, 51),
(24, 52),
(24, 53),
(24, 54),
(24, 55),
(24, 56),
(24, 57),
(24, 58),
(29, 82),
(29, 83),
(30, 84),
(30, 85),
(30, 86),
(30, 87),
(30, 88),
(30, 89),
(30, 90),
(30, 91),
(30, 92),
(30, 93),
(31, 94),
(31, 95),
(31, 96),
(31, 97),
(31, 98),
(31, 99),
(31, 100),
(31, 101),
(32, 34),
(32, 40),
(32, 52);

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
  `contenido` varchar(5000) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha` date DEFAULT NULL,
  `grupo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`id`, `contenido`, `foto`, `titulo`, `fecha`, `grupo`) VALUES
(14, '72 Seasons es el undécimo álbum de estudio del grupo musical estadounidense de metal Metallica. Fue lanzado el 14 de abril de 2023, por su propio sello Blackened Recordings. El álbum es producido por Greg Fidelman, quien produjo el álbum de estudio anterior de la banda, Hardwired... to Self-Destruct (2016), es el segundo álbum de estudio de la banda que se lanzó a través de Blackened y al igual que su predecesor, todas sus canciones tienen un video musical. Es el álbum, seguido solamente de Load, con mayor minutaje de su carrera, con una duración total de 01:17:13. Tanto críticos musicales como su fanbase afirman que es debido a su complejidad y matices progresivos. El 28 de noviembre de 2022, Metallica anunció el título del nuevo álbum de estudio, la fecha de lanzamiento, la lista de canciones y una gira promocional por Norteamérica y Europa, con Pantera, Five Finger Death Punch, Ice Nine Kills, Greta Van Fleet, Architects, Volbeat y Mammoth WVH. titulado M72 World Tour. Posteriormente, el grupo musical lanzó el primer sencillo del álbum, «Lux Æterna», junto con un video musical.14​El segundo sencillo fue lanzado el 19 de enero de 2023, «Screaming Suicide», junto con su respectivo video musical. El tercer sencillo fue lanzado el 1 de marzo de 2023, «If Darkness Had a Son», junto a su video musical. Su cuarto sencillo «72 Seasons», junto con su video musical, fue lanzado el 30 de marzo de 2023.', '../media/img_posts/meta@gm.com/fotoPrincipalpost14.jpg', '¡Lanzamos 72 Seasons!', '2023-05-17', 7),
(16, 'The box set features a 2023 remaster of The Dark Side of the Moon album by James Guthrie presented on vinyl and CD; a remastered version of The Dark Side of the Moon Live at Wembley 1974 on vinyl and CD; two BDs and a DVD featuring 5.1 surround sound mix (2003), Dolby Atmos mix (2023), and a high-quality version of the stereo mix. Other items featured in the set include a 160-page hardcover book of photographs from the 1973 – 1974 tours by Jill Furmanovsky, Aubrey Powell, Peter Christopherson, and Storm Thorgerson; a 76-page songbook containing sheet music of the original album; two seven-inch singles of \"Money\"/\"Any Colour You Like\" and \"Time\"/\"Us and Them\"; a replica pamphlet and invitation to the album launch event at the London Planetarium on 27 February 1973; and four posters - two of which are replicas of the original posters supplied with the album. The hardcover book and the Wembley live album are also available as standalone editions.[1][2][3][4][5][6] This also marks the first time that The Dark Side of the Moon Live at Wembley 1974 has been available on vinyl and as a standalone release. It was previously available only as part of Immersion and Experience editions of the album (2011).', '../media/img_posts/pinkfloyd@gmail.com/fotoPrincipalpost16.jpg', 'Dark Side of the Moon 50th Anniversary', '2023-05-11', 19);

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
  `foto_avatar` varchar(150) NOT NULL DEFAULT '../media/image_user_default.png',
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

INSERT INTO `usuario` (`id`, `nombre`, `apellidos`, `usuario`, `pass`, `foto_avatar`, `correo`, `f_nac`, `high_shelf_f`, `high_shelf_gain`, `low_shelf_f`, `low_shelf_gain`, `high_pass_f`, `high_pass_q`, `low_pass_f`, `low_pass_q`, `estilo`, `grupo`) VALUES
(0, '', '', 'admin', 'admin', '../media/image_user_default.png', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'Alvaro', 'Blanco Lucena', 'cydonia8', 'cydonia8', '../media/image_user_default.png', 'holymustaine20@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `nombre_2` (`nombre`);

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
  ADD KEY `ce_inclu_canc` (`cancion`),
  ADD KEY `ce_inclu_alb` (`album`);

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `cancion`
--
ALTER TABLE `cancion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `cuestionario`
--
ALTER TABLE `cuestionario`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `discografica`
--
ALTER TABLE `discografica`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estilo`
--
ALTER TABLE `estilo`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `foto_grupo`
--
ALTER TABLE `foto_grupo`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `foto_publicacion`
--
ALTER TABLE `foto_publicacion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
