-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-03-2025 a las 02:50:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mycrypto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `comentario_id` int(11) NOT NULL,
  `idproyecto` int(11) NOT NULL,
  `parent_comentario_id` int(11) DEFAULT NULL,
  `comment` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `comment_sender_name` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Tabla Comentarios';

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`comentario_id`, `idproyecto`, `parent_comentario_id`, `comment`, `comment_sender_name`, `date`) VALUES
(65, 3, 0, '  Axie Infinity: en qué consiste el juego con el que mucha gente se ha hecho rica y por qué su estilo lo tiene complicado para mantenerte enganchado', 'nico9244', '2022-10-29 00:17:00'),
(66, 3, 0, '  Cuando entro en Axie Infinity por primera vez, me siento como si hubiera caído en una máquina del tiempo y hubiera viajado a los primeros años de la década de los 2000, una época en la que me sentab', 'Zychsz', '2022-10-29 00:17:34'),
(67, 3, 0, '  Axie Infinity es un universo digital en el que los jugadores pueden criar, combatir e intercambiar estas coloridas criaturas conocidas como Axies.', 'SS', '2022-10-29 00:18:17'),
(68, 3, 0, '  Las batallas suelen tener lugar en la arena, una zona en la que dos jugadores se emparejan entre sí, cada uno de los cuales roba cartas por turnos mientras intenta destruir el equipo del otro jugado', '12345', '2022-10-29 00:31:49'),
(69, 4, 0, '  ol', 'nico_ave', '2023-07-11 01:31:30'),
(70, 4, 0, '  ol', 'nico_ave', '2023-07-11 01:31:30'),
(71, 4, 0, '2', 'nico_ave', '2023-07-11 01:31:38'),
(72, 4, 0, '2', 'nico_ave', '2023-07-11 01:31:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos`
--

CREATE TABLE `elementos` (
  `idelemento` int(11) NOT NULL,
  `nombre_elemento` varchar(255) DEFAULT NULL,
  `precio_elemento` varchar(255) DEFAULT NULL,
  `imagen_elemento` varchar(255) DEFAULT NULL,
  `idtienda` int(11) NOT NULL,
  `idestado` int(11) NOT NULL,
  `tier` varchar(255) NOT NULL,
  `estado_elemento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idestado` int(11) NOT NULL,
  `descripcion` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idestado`, `descripcion`) VALUES
(1, 'Habilitado'),
(2, 'Deshabilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `idusuario` int(11) NOT NULL,
  `idred` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `idinventario` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `imagen1` varchar(255) DEFAULT NULL,
  `imagen2` varchar(255) DEFAULT NULL,
  `imagen3` varchar(255) DEFAULT NULL,
  `banner1` varchar(255) DEFAULT NULL,
  `banner2` varchar(255) DEFAULT NULL,
  `banner3` varchar(255) DEFAULT NULL,
  `moneda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventarios`
--

INSERT INTO `inventarios` (`idinventario`, `idusuario`, `imagen1`, `imagen2`, `imagen3`, `banner1`, `banner2`, `banner3`, `moneda`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(2, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, 4, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 16, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 17, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(6, 18, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 19, NULL, NULL, NULL, NULL, NULL, NULL, 20),
(8, 20, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(9, 21, 'logos/1.png', 'logos/2.png', NULL, NULL, NULL, NULL, 153),
(10, 22, 'logos/1.png', NULL, NULL, NULL, NULL, NULL, 178),
(0, 27, NULL, NULL, NULL, NULL, NULL, NULL, 188);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `iditem` int(11) NOT NULL,
  `nombre_item` varchar(255) NOT NULL,
  `idestado` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `imagen_item` varchar(255) NOT NULL,
  `idtienda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`iditem`, `nombre_item`, `idestado`, `precio`, `imagen_item`, `idtienda`) VALUES
(20, 'Banner_1', 0, 500, 'Banner 1.png', 2),
(21, 'Banner_2', 0, 500, 'Banner 2.png', 2),
(30, ' un marco de perfil', 0, 60, 'perfil.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `megusta_nomegusta`
--

CREATE TABLE `megusta_nomegusta` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `comentario_id` int(11) NOT NULL,
  `like_unlike` int(2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `megusta_nomegusta`
--

INSERT INTO `megusta_nomegusta` (`id`, `member_id`, `comentario_id`, `like_unlike`, `date`) VALUES
(2, 1, 3, 1, '2018-03-23 02:09:56'),
(3, 1, 5, 0, '2022-10-11 23:17:19'),
(4, 1, 4, 0, '2022-10-11 22:38:29'),
(5, 1, 6, 1, '2022-04-26 01:37:04'),
(6, 1, 7, 0, '2022-09-30 23:41:22'),
(7, 1, 8, 1, '2022-09-30 23:41:17'),
(8, 1, 14, 0, '2022-10-01 00:03:20'),
(9, 1, 13, 0, '2022-09-30 23:37:50'),
(10, 1, 12, 1, '2022-09-30 23:41:13'),
(11, 1, 10, 1, '2022-09-30 23:41:08'),
(12, 1, 11, 0, '2022-09-30 23:41:11'),
(13, 1, 15, 1, '2022-09-30 23:41:29'),
(14, 1, 16, 1, '2022-09-30 23:41:39'),
(15, 1, 32, 0, '2022-10-11 23:33:00'),
(16, 1, 31, 0, '2022-10-11 23:33:00'),
(17, 1, 39, 0, '2022-10-11 23:32:59'),
(18, 1, 46, 0, '2022-10-15 00:16:58'),
(19, 1, 47, 1, '2022-10-15 00:17:08'),
(20, 1, 43, 1, '2022-10-15 00:17:09'),
(21, 1, 50, 0, '2022-10-23 01:13:22'),
(22, 1, 52, 0, '2022-10-26 20:08:50'),
(23, 1, 51, 1, '2022-10-26 20:08:21'),
(24, 1, 54, 0, '2022-10-26 20:08:50'),
(25, 1, 58, 0, '2022-10-26 20:22:57'),
(26, 1, 63, 1, '2022-10-28 19:05:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idnoticia` int(11) NOT NULL,
  `nombre_noticia` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `idproyecto` int(11) NOT NULL,
  `idestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermiso` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermiso`, `descripcion`) VALUES
(1, 'alta red'),
(2, 'modificar red'),
(3, 'baja red'),
(4, 'alta proyecto'),
(5, 'modificar proyecto'),
(6, 'baja proyecto'),
(7, 'alta item'),
(8, 'baja item'),
(9, 'modificar item'),
(10, 'alta tienda'),
(11, 'baja tienda'),
(12, 'modificar tienda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_roles`
--

CREATE TABLE `permiso_roles` (
  `idpermiso` int(11) NOT NULL,
  `idrol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permiso_roles`
--

INSERT INTO `permiso_roles` (`idpermiso`, `idrol`) VALUES
(4, 1),
(1, 1),
(6, 1),
(3, 1),
(5, 1),
(2, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `precio` int(11) NOT NULL,
  `idestado` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `nombre_producto`, `imagen`, `precio`, `idestado`, `idcategoria`) VALUES
(1, 'Logo 1', 'logos/1.png', 10, 1, 1),
(2, 'Logo 2', 'logos/2.png', 25, 1, 1),
(3, 'Logo 3', 'logos/3.png', 30, 1, 1),
(4, 'Marco 1', 'marcos/1.jpg', 12, 1, 2),
(5, 'Marco 2', 'marcos/2.png', 22, 1, 2),
(6, 'Banner 1', 'banners/1.jpg', 23, 1, 3),
(7, 'Banner 2', 'banners/2.jpg', 17, 1, 3),
(8, 'Marco 3', 'marcos/3.png', 20, 1, 3),
(9, 'Logo 4', 'logos/4.png', 32, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_categoria`
--

CREATE TABLE `productos_categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_categoria`
--

INSERT INTO `productos_categoria` (`id`, `nombre`, `url`, `activo`) VALUES
(1, 'Logos', './tienda/img/category_img_01.jpg', 1),
(2, 'Marcos', './tienda/img/category_img_02.jpg', 1),
(3, 'Banners', './tienda/img/category_img_03.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `idproyecto` int(11) NOT NULL,
  `nombre_proyecto` varchar(255) DEFAULT NULL,
  `moneda_proyecto` varchar(255) DEFAULT NULL,
  `precio_proyecto` varchar(255) DEFAULT NULL,
  `imagen_proyecto` varchar(255) DEFAULT NULL,
  `idred` int(11) NOT NULL,
  `idestado` int(11) NOT NULL,
  `tipo_proyecto` varchar(255) NOT NULL,
  `estado_proyecto` varchar(255) NOT NULL,
  `descripcion_proyecto` varchar(999) NOT NULL,
  `pagina_proyecto` varchar(255) NOT NULL,
  `whitepaper_proyecto` varchar(255) NOT NULL,
  `descripcion2_proyecto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`idproyecto`, `nombre_proyecto`, `moneda_proyecto`, `precio_proyecto`, `imagen_proyecto`, `idred`, `idestado`, `tipo_proyecto`, `estado_proyecto`, `descripcion_proyecto`, `pagina_proyecto`, `whitepaper_proyecto`, `descripcion2_proyecto`) VALUES
(3, 'Axie Inifnity Origin', 'SLP, AXS', '1', 'Axie-Origin-Guide.jpeg', 66, 1, 'Estrategia, Cartas', 'V3', 'Axie Infinity fue lanzado por Sky Mavis en marzo de 2018. Es un juego de batallas de cartas en tiempo real creado en Ronin Network, una cadena lateral vinculada a Ethereum. Todo el metaverso de Axie Infinity está construido alrededor de criaturas de fantasía llamadas Axies', 'https://axieinfinity.com/', '', 'Axie'),
(4, 'AlienWorlds', 'TLM', '0.15', 'mqdefault.jpg', 56, 1, 'Cartas/Farm', '7.2.3', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'https://alienworlds.io/', 'RARITY', 'Seek'),
(5, 'Avegotchi', 'GHST', '0.54', 'ave.PNG', 56, 1, 'Aventura', 'Finalizado', 'Aavegotchi is a DeFi-enabled crypto collectibles game developed by Singapore-based Pixelcraft Studios that allows players to stake Non-fungible tokens (NFTs) avatars with interest-generating tokens and interact with the Aavegotchi metaverse. It is a unique combination of Decentralized Finance (DeFi) and NFTs.', 'https://www.aavegotchi.com/', 'To level up their Aavegotchis, players can participate in a variety of activities including mini-games, governance, and meetups. Aavegotchis can also increase their rarity level by equipping in-game wearables and leveling up.', 'noticias'),
(6, 'Crypto Cars', 'CARS', '1', 'cryptocars1.png', 67, 1, 'Simulador', 'Finalizado', 'Proyecto Cerrado: La economía de todo el metaverso Cryto City quebró por mala administración del equipo desarrollador. Se habla de un “rugpull” sigiloso o una quiebra planificada, según testimonios de algunos moderadores.  Crypto Cars es un juego NFT del género de racing con ciertas características del RPG que presenta al jugador la modalidad de juego de simulación de carreras y eventualmente lanzarán una forma de PVP para competir contra otros jugadores. Este título junto a Crypto Planes y Crypto Guards forman parte del metaverso Crypto City creado por los mismos desarrolladores.', 'https://www.nftgamearena.com/play-to-earn/racing/crypto-cars/', 'whitepaper', 'noticias'),
(7, 'Crypto Cars Worlds', 'CARS', '0.03', 'cryptocars.png', 67, 1, 'Carreras', 'Abandonado', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'Proyecto Caido', 'whitepaper', 'noticias'),
(8, 'Alienship', 'ALS', '2.2', 'alienship.jpg', 56, 1, 'Disparos', 'Finalizado', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'http://ww62.alienships.io/', 'aily', 'To'),
(9, 'Plant Vs Undead', 'PVU', '0.01', 'PVU.jpeg', 67, 1, 'Farming', 'Finalizado', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'https://es-la.facebook.com/pages/category/Video-Game/PvUNFTGarden/posts/', 'aily Trilium Allocation to Planets (DTAP)Every 24 hours a Planet may call the Federation contract once to get its new supply of Trilium.The amount of Trilium each Planet can claim is given by:TLM due to NFT componentplusTLM due to staked componentWhere:TL', 'Seek your fortune Find NFTs you can use to connect and play with others. Earn Trilium that gives you power in the Planet Decentralised Autonomous Organizations (Planet DAOs) – where much of the action happens.'),
(10, 'Pegaxy', 'PEGA', '0.03', 'pegaxy.PNG', 68, 1, 'Simulador', 'Finalizado', 'Pegaxy is a play-to-earn PVP style horse racing game where players compete for top 3 placement against 14 other racers. Each race has randomised elemental variables which include wind, water, fire, speed and more. Using strategic upgrades, food and skill, players must place in the top 3 to earn the platforms utility token, VIS (Vigorus).  Within the game, players are able to breed, merge, rent, sell, and of course race their Pega to earn VIS tokens. This system has proven to be a sound long-term economic approach when building an NFT/Blockchain based game as it enables teams to build large guilds, scholarship programs, and even provides solo players the opportunity to earn in game tokens through daily racing.', 'https://pegaxy.io/', 'The', 'The'),
(11, 'Mir4', 'M4', '2.2', 'mira.jpeg', 56, 1, 'MMORPG', '2022.10.23', 'Enfrenta a jefes más poderosos con hasta 15 miembros de tu clan en los asaltos infernales. Participa y obtén las mejores recompensas. ¡Mejores serán las recompensas mientras más participantes haya!', 'https://mir4global.com/?lang=es', 'RARITY', 'Seek'),
(12, 'The Sandbox', 'SAND', '100', 'The-Sandbox.jpg', 56, 1, 'Aventura', 'Finalizado', 'The Sandbox is a community-driven platform where creators can monetize voxel ASSETS and gaming experiences on the blockchain', 'https://www.sandbox.game/en/', 'To level up their Aavegotchis, players can participate in a variety of activities including mini-games, governance, and meetups. Aavegotchis can also increase their rarity level by equipping in-game wearables and leveling up.', 'Seek your fortune Find NFTs you can use to connect and play with others. Earn Trilium that gives you power in the Planet Decentralised Autonomous Organizations (Planet DAOs) – where much of the action happens.'),
(13, 'Splinterlands', 'SPLi', '0.03', 'splinterlands_logo.png', 56, 1, 'Cartas', 'Finalizado', 'Since the days of the Splintering, the face of the world has been shaped by blood and power. As factions battle for control, primal energies are harnessed and unleashed.', 'https://splinterlands.com/', 'whitepaper', 'noticias'),
(14, 'CropBytes', 'CBX', '1.07', 'copp.png', 65, 1, 'Cartas/Farm', 'CropBytes is a game of business based on real world farming. You can play the game to own assets and increase your farm’s output, or trade them with other players for returns in crypto.', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'https://www.cropbytes.com/', 'whitepaper', 'Seek your fortune Find NFTs you can use to connect and play with others. Earn Trilium that gives you power in the Planet Decentralised Autonomous Organizations (Planet DAOs) – where much of the action happens.'),
(15, 'Dragonary', 'CYT', '0.02', 'dragonary.jpg', 67, 1, 'Simulador', 'Finalizado', 'Dragonary es un juego y como tal, cualquiera puede jugarlo, tenga o no, conocimientos sobre criptomonedas y blockchain. No necesitas descargar ningún software adicional. No necesitas sincronizar una billetera virtual, ni utilizar aplicaciones de terceros para jugarlo. Descarga y juega.', 'https://dragonary.com/es/', 'whitepaper', 'noticias'),
(16, 'Thetan Arena', 'THT', '0.15', 'Thetan-Arena_Imagen-Destacada1.jpg', 67, 1, 'MOBA', 'Finalizado', 'Thetan Arena can not embrace such impressive milestones without the non-stop companionship and support from our distinguished Backers and Investors. Guilds, communities, and KOLs & Ambassadors are also crucial cornerstones in our ecosystem', 'https://thetanarena.com/#backers', 'whitepaper', 'noticias'),
(17, 'Sorare', 'SOR', '1', 'Sorare.jpg', 67, 1, 'Futbol', '0.4', 'SO5 is organized by SORARE SAS, a French company registered in the Créteil Trade and Companies Register under the number 844 355 727, domiciled at 5, avenue du Général-de-Gaulle 94160 SAINT-MANDE, which operates a service of issuance and exchange of collectible digital cards on blockchain. As part of this activity, it organizes a promotional game for its users, governed by these Rules.  The game, entitled \"SO5\", is based on a virtual tournament that tracks the real performance of players on the field, accessible from a dedicated area (\"Gaming Arena\") on the Website.  These Rules are applicable to the Game made available to Users of the Service. It does not exempt Participants from complying with the Terms and Conditions of the Service.', 'https://sorare.com/', 'whitepaper', 'noticias'),
(18, 'League of Kingdoms', 'LOK', '0.54', 'league of ki.jpeg', 68, 1, 'MMO', '7.2.4', 'Build a strong kingdom and armies to overpower other kingdoms and monsters. Display your valor on the battlefield and secure your hegemony on the continent!', 'https://www.leagueofkingdoms.com/', 'whitepaper', 'noticias'),
(19, 'Bomb Crypto', 'BCOIN', '2.2', 'bombchaincover wpp gitbook.png', 56, 1, 'Aventura', '0.2.5.34', 'BCOIN token is the main in-game currency. It will be used to buy Bomber hero, Upgrade Bomber level, mainly in the first phase.', 'https://bombcrypto.io/', 'whitepaper', 'noticias'),
(20, 'Crypto Blades', 'SKILL', '336', 'cryptoblades.png', 67, 1, 'Simulador', 'Finalizado', 'Earn $SKILL tokens by defeating enemies, winning on PVP, and staking your gains.', 'https://www.cryptoblades.io/', 'whitepaper', 'noticias'),
(21, 'Rising Star', 'HIVE', '0.000004', 'rising.jpg', 65, 1, 'Simulador', 'Finalizado', 'Start as a lowly busker and work your way up to a global mega star!', 'https://www.risingstargame.com/', 'whitepaper', 'noticias'),
(22, 'Zombies Factory', 'ZFA', '0.15', 'UK-Zombie-Experience-Battles.png', 67, 1, 'Simulador', 'SCAM', 'heffield has fallen. The epidemic has swept through the city leaving just a few pockets that provide safe havens – a select few buildings that are the only hope for the authorities to regroup and retake Sheffield. But now one such outpost has been sabotaged & thousands of infected have breached the quarantine sector…', 'http://zombieexperiences.co.uk/zombie-factory/', 'whitepaper', 'noticias'),
(23, 'CRYPTO VILLAGES', 'DDD', '0.03', 'village.PNG', 67, 1, 'Simulador', '7.2.4', 'We are currently restoring full website functionality. In the interim, we have enabled building purchases to allow interested investors the chance to purchase buildings for the game. We thank you for your support, and appreciate your patience as we optimize the website!', 'https://www.youtube.com/redirect?event=video_description&redir_token=QUFFLUhqbGFKdi1SbWNpMUhuTmFJU09DOU1oZmlhbDZkZ3xBQ3Jtc0trZFZyUDVybnpRSW1nczJ3MWcwSGdlX015SGtsQWRwUjVFX2pHS1BDZFRJQUMxM20yRmZ3YTc3MmNOOGFra3J6T3h2VVZBTmFxM1cyMlJGZXpneDdWaTRhMERiMGdacG4xVz', 'whitepaper', 'noticias'),
(24, 'Age of Holders', 'AHG', '0.1', 'age of holders.png', 67, 1, '', '', 'Contrye tu ejercito, mejoralo y derrota a tus enemigos......', 'https://ageofholders.com/', 'whitepaper', 'noticias'),
(25, 'Ev.IO', 'EVIO', '1', 'ev io.PNG', 70, 1, 'Disparos', 'On Going', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'https://ev.io/', 'whitepaper', 'noticias'),
(26, '3Speak', '3S', '1', '3s.PNG', 65, 1, 'Red Social', 'Finalizado', '3Speak', 'https://3speak.tv/', 'whitepaper', 'noticias'),
(27, 'GEMLAND', 'GEM', '1.3', 'gemland.PNG', 56, 1, 'Cartas', '7.2.4', 'Gemland is an economic NFT game on the WAX blockchain. Mine resources, build trade relationships, explore new skills and opportunities in this world, control dragons, build ships, get paid for owning land, play and earn!', 'https://gemland.world/', 'whitepaper', 'noticias'),
(28, 'LEAGUE OF PETS', 'PETS', '0.19', 'pets league.PNG', 65, 1, 'Simulador', 'SCAM', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'https://game.leagueofpets.com/dashboard?referral_code=2037', 'whitepaper', 'noticias'),
(29, 'NBOX', 'NBOX', '0.01', 'NBOX.PNG', 68, 1, 'Cartas', '5.6.32', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'https://www.nbox.io/HIKrQ', 'whitepaper', 'noticias'),
(30, 'Crypto Legions', 'BLV3', '0.5', 'cryptolegions.PNG', 56, 1, 'Simulador', '7.2.4', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'cryptolegions.app/', 'whitepaper', 'noticias'),
(31, 'Mining Network', 'ASIC', '1', 'minings.PNG', 56, 1, 'Farming', 'Finalizado', 'Mining network is a game on WAX blockchain. It combines FreeToPlay and PlayToEarn models. Every new user gets a free NFT to play and earn immediately after registering in the game.', 'https://miningnetwork.io/?ref=2rdaw.wam', 'whitepaper', 'noticias'),
(32, 'Poly Island', 'POL', '0', 'poly.png', 68, 1, 'Farming', 'SCAM', 'asdoiahdnkjadbnjkasdnajsldkasd', 'https://twitter.com/home', 'whitepaper', 'noticias'),
(33, 'Pinup warlords', 'PNIUP', '1', 'pinu.PNG', 56, 1, 'Cartas', 'Finalizado', 'Factions are made of Soldiers with different classes and officers', 'https://pinupwarlords.com/', 'whitepaper', 'noticias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rarezaitem`
--

CREATE TABLE `rarezaitem` (
  `rareza_item` int(11) NOT NULL,
  `nombre_rareza` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `rarezaitem`
--

INSERT INTO `rarezaitem` (`rareza_item`, `nombre_rareza`) VALUES
(1, 'Diamante'),
(2, 'Platino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes`
--

CREATE TABLE `redes` (
  `idred` int(11) NOT NULL,
  `nombre_red` varchar(255) NOT NULL,
  `moneda_red` varchar(255) NOT NULL,
  `precio_red` varchar(255) NOT NULL,
  `imagen_red` varchar(255) NOT NULL,
  `idestado` int(99) NOT NULL,
  `orden` int(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `redes`
--

INSERT INTO `redes` (`idred`, `nombre_red`, `moneda_red`, `precio_red`, `imagen_red`, `idestado`, `orden`) VALUES
(56, 'WaxP', '', '', 'waxp.png', 1, 1),
(59, 'Avalanche', '', '', 'avalanche-avax.png', 1, 2),
(65, 'Hive', '', '', 'hive.png', 1, 3),
(66, 'Ronin Network', '', '', 'ronin.png', 1, 5),
(67, 'Binance Smart Chain', '', '', 'Binance-Coin-icon.png', 1, 5),
(68, 'Polygon Matic', '', '', 'polygon-matic22.png', 1, 6),
(69, 'Tron', '', '', 'tron-trx.png', 1, 7),
(70, 'Solana', '', '', 'solana.jpg', 1, 8),
(71, 'EOS', '', '', 'eos.png', 1, 8),
(72, 'Ethereum', '', '', 'Ethereum-icon.png', 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_comentarios`
--

CREATE TABLE `reporte_comentarios` (
  `idreporte` int(11) NOT NULL,
  `idcomentario` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `idestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idrol`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuarios`
--

CREATE TABLE `rol_usuarios` (
  `idrol` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_usuarios`
--

INSERT INTO `rol_usuarios` (`idrol`, `idusuario`) VALUES
(1, 17),
(2, 18),
(2, 19),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `idtienda` int(11) NOT NULL,
  `nombre_tienda` varchar(255) NOT NULL,
  `imagen_tienda` varchar(255) NOT NULL,
  `idestado` int(99) NOT NULL,
  `orden` int(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tienda`
--

INSERT INTO `tienda` (`idtienda`, `nombre_tienda`, `imagen_tienda`, `idestado`, `orden`) VALUES
(1, 'Marco Foto de Perfil', 'marco_perfil.png', 1, 1),
(2, 'banners', 'banners_tienda.png', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `idestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nickname`, `email`, `contrasenia`, `imagen`, `descripcion`, `twitter`, `instagram`, `facebook`, `idestado`) VALUES
(17, 'nico_ave', 'nicolas9244@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, 'esto es 9244', 'l', '', '', 1),
(18, 'Zychsz', 'Zoppinicolas4@gmail.com', 'c60ebb3ba7101473428a20617c6092e144164065', NULL, 'adasdasd', 'https://twitter.com/Zoppi03', 'https://www.instagram.com/zoppi.nicolas/', 'No', 1),
(19, 'avenazzi', 'avenazzi@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, NULL, NULL, 1),
(23, 'SS', 'SS@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, NULL, NULL, 1),
(24, '12345', '123456@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, NULL, NULL, 1),
(25, 'Zoppi', 'zoppi@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, NULL, NULL, NULL, NULL, 1),
(26, 'Nico', 'Nico@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, NULL, NULL, NULL, NULL, 1),
(27, 'ASDZZZZZ', 'asd@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, NULL, NULL, NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`comentario_id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`idusuario`,`idred`),
  ADD KEY `idred` (`idred`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`iditem`),
  ADD KEY `idestado` (`idestado`),
  ADD KEY `idtienda` (`idtienda`);

--
-- Indices de la tabla `megusta_nomegusta`
--
ALTER TABLE `megusta_nomegusta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idnoticia`),
  ADD KEY `idproyecto` (`idproyecto`),
  ADD KEY `idestado` (`idestado`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `permiso_roles`
--
ALTER TABLE `permiso_roles`
  ADD KEY `idpermiso` (`idpermiso`),
  ADD KEY `idrol` (`idrol`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`idproyecto`),
  ADD KEY `idred` (`idred`),
  ADD KEY `idestado` (`idestado`);

--
-- Indices de la tabla `rarezaitem`
--
ALTER TABLE `rarezaitem`
  ADD PRIMARY KEY (`rareza_item`);

--
-- Indices de la tabla `redes`
--
ALTER TABLE `redes`
  ADD PRIMARY KEY (`idred`),
  ADD KEY `redes_ibfk_1` (`idestado`);

--
-- Indices de la tabla `reporte_comentarios`
--
ALTER TABLE `reporte_comentarios`
  ADD PRIMARY KEY (`idreporte`),
  ADD KEY `idcomentario` (`idcomentario`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `FK_estado` (`idestado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `rol_usuarios`
--
ALTER TABLE `rol_usuarios`
  ADD KEY `FK_rol` (`idrol`),
  ADD KEY `FK_usuario` (`idusuario`);

--
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`idtienda`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `comentario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `iditem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `megusta_nomegusta`
--
ALTER TABLE `megusta_nomegusta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idnoticia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `idproyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `rarezaitem`
--
ALTER TABLE `rarezaitem`
  MODIFY `rareza_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `redes`
--
ALTER TABLE `redes`
  MODIFY `idred` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `reporte_comentarios`
--
ALTER TABLE `reporte_comentarios`
  MODIFY `idreporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `FK_idusuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`),
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`idred`) REFERENCES `redes` (`idred`);

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_2` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`);

--
-- Filtros para la tabla `permiso_roles`
--
ALTER TABLE `permiso_roles`
  ADD CONSTRAINT `permiso_roles_ibfk_1` FOREIGN KEY (`idpermiso`) REFERENCES `permisos` (`idpermiso`),
  ADD CONSTRAINT `permiso_roles_ibfk_2` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`idred`) REFERENCES `redes` (`idred`),
  ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`);

--
-- Filtros para la tabla `redes`
--
ALTER TABLE `redes`
  ADD CONSTRAINT `redes_ibfk_1` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`);

--
-- Filtros para la tabla `rol_usuarios`
--
ALTER TABLE `rol_usuarios`
  ADD CONSTRAINT `FK_rol` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`),
  ADD CONSTRAINT `FK_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
