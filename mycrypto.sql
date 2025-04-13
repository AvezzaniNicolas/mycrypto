-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-04-2025 a las 17:26:32
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
  `logo1` varchar(256) DEFAULT NULL,
  `logo2` varchar(256) DEFAULT NULL,
  `logo3` varchar(256) DEFAULT NULL,
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

INSERT INTO `inventarios` (`idinventario`, `idusuario`, `logo1`, `logo2`, `logo3`, `imagen1`, `imagen2`, `imagen3`, `banner1`, `banner2`, `banner3`, `moneda`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(6, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20),
(8, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(9, 21, NULL, NULL, NULL, 'logos/1.png', 'logos/2.png', NULL, NULL, NULL, NULL, 153),
(10, 22, NULL, NULL, NULL, 'logos/1.png', NULL, NULL, NULL, NULL, NULL, 178),
(11, 29, NULL, NULL, NULL, 'logos/1.png', NULL, NULL, NULL, NULL, NULL, 190),
(12, 30, 'logos/prod_67f87a0aeb361.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1480),
(13, 31, NULL, NULL, NULL, 'marcos/1.jpg', 'marcos/2.png', NULL, NULL, NULL, NULL, 1466),
(14, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(15, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

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
(12, 'modificar tienda'),
(13, 'modificar usuario');

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
(12, 1),
(13, 1);

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
(9, 'Logo 4', 'logos/4.png', 32, 1, 1),
(10, 'logo 12', 'logos/prod_67f87a0aeb361.jpg', 20, 1, 1);

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
(1, 'Logos', 'tienda\\img\\banner_img_01.jpg', 1),
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
(3, 'Axie Inifnity Origin', 'SLP, AXS', '1', 'Axie-Origin-Guide.jpeg', 66, 2, 'Estrategia, Cartas', 'V3', 'Axie Infinity fue lanzado por Sky Mavis en marzo de 2018. Es un juego de batallas de cartas en tiempo real creado en Ronin Network, una cadena lateral vinculada a Ethereum. Todo el metaverso de Axie Infinity está construido alrededor de criaturas de fantasía llamadas Axies', 'https://axieinfinity.com/', 'a', 'value = Axie'),
(4, 'AlienWorlds', 'TLM', '0.15', 'mqdefault.jpg', 56, 1, 'Cartas/Farm', '7.2.3', 'Missions Lease Spacecrafts to send on missions across the Metaverse. Explore Missions, Discover NFTs', 'https://alienworlds.io/', 'RARIT3\r\n', 'Seek'),
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
(33, 'Pinup warlords', 'PNIUP', '1', 'pinu.PNG', 56, 1, 'Cartas', 'Finalizado', 'Factions are made of Soldiers with different classes and officers', 'https://pinupwarlords.com/', 'whitepaper', 'noticias'),
(49, 'Proyecto de Pruebo 4', 'PRO', '0.05', '67fbc7fe6afd4.jpg', 56, 1, 'TESTEO', 'Ongoin', 'Proyecto de testeo', 'www.proyectotesteo.com', 'www.proyectotesteo.comwww.proyectotestwww.proyectotesteo.com', 'www.proyectotesteo.comwww.proyectotesteo.comww.pr');

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
(1, 27),
(2, 28),
(2, 29),
(1, 30),
(2, 33),
(2, 18);

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
(2, 'banners', 'banners_tienda.png', 1, 2),
(3, 'Logos', '', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `fb_id` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `idestado` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `discord_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nickname`, `email`, `contrasenia`, `fb_id`, `foto`, `descripcion`, `twitter`, `instagram`, `facebook`, `idestado`, `nombre`, `apellido`, `discord_id`, `avatar`, `fecha_registro`) VALUES
(1, 'juanito23', 'juanito23@mail.com', 'pass1234', NULL, 'foto1.jpg', 'Amante de los videojuegos', '@juanito', '@juanito23', 'fb.com/juanito23', 1, 'Juan', 'Pérez', 'juan#1234', 'avatar1.png', '2025-04-11 12:19:30'),
(2, 'laura_love', 'laura.love@mail.com', 'secure456', 'fb12345', 'foto2.jpg', 'Diseñadora gráfica', '@laura_love', NULL, 'fb.com/laura.love', 2, 'Laura', 'Gómez', NULL, NULL, '2025-04-11 12:19:30'),
(3, 'dragonX', 'dragonx@mail.com', 'dr4g0n!', NULL, NULL, 'Streamer y gamer', '@dragonx', '@dragonx_gaming', NULL, 1, 'Carlos', 'Ruiz', 'dragonx#9988', 'avatar3.png', '2025-04-11 12:19:30'),
(4, 'nelly98', 'nelly98@mail.com', 'myp@ss987', NULL, 'foto4.jpg', NULL, NULL, NULL, NULL, 3, 'Nelly', 'Fernández', NULL, NULL, '2025-04-11 12:19:30'),
(5, 'tomas_dev', 'tomasdev@mail.com', 'devlife2024', NULL, 'foto5.jpg', 'Desarrollador web', '@tomas_dev', NULL, NULL, 1, 'Tomás', 'López', NULL, NULL, '2025-04-11 12:19:30'),
(6, 'valenrock', 'valenrock@mail.com', 'valenROCK@2023', NULL, NULL, 'Fan del rock clásico', NULL, '@valen.rock', 'fb.com/valenrock', 2, 'Valentina', 'Sánchez', 'valen#3210', NULL, '2025-04-11 12:19:30'),
(7, 'kikogamer', 'kiko@mail.com', 'g@merK1ko', NULL, 'foto7.jpg', NULL, '@kikogamer', NULL, NULL, 1, 'Enrique', 'Martínez', 'kikogamer#123', NULL, '2025-04-11 12:19:30'),
(8, 'luciawrites', 'luciawrites@mail.com', 'escritoraL', NULL, NULL, 'Escritora de cuentos', '@luciawrites', NULL, NULL, 3, 'Lucía', 'Paredes', NULL, 'avatar8.jpg', '2025-04-11 12:19:30'),
(9, 'xavi_art', 'xavi.art@mail.com', 'arteX123', NULL, 'foto9.jpg', 'Pintor digital', '@xaviart', '@xavi.art', NULL, 2, 'Xavier', 'Ortiz', NULL, NULL, '2025-04-11 12:19:30'),
(10, 'dani_musik', 'dani@mail.com', 'musicPass', 'fb8765', 'foto10.jpg', 'Músico independiente', '@danimusic', NULL, 'fb.com/dani.music', 3, 'Daniela', 'Cruz', 'dani#5567', NULL, '2025-04-11 12:19:30'),
(11, 'user11', 'user11@mail.com', 'pass11', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Once', NULL, NULL, '2025-04-11 12:19:30'),
(12, 'user12', 'user12@mail.com', 'pass12', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Doce', NULL, NULL, '2025-04-11 12:19:30'),
(13, 'user13', 'user13@mail.com', 'pass13', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Trece', NULL, NULL, '2025-04-11 12:19:30'),
(14, 'user14', 'user14@mail.com', 'pass14', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Catorce', NULL, NULL, '2025-04-11 12:19:30'),
(15, 'user15', 'user15@mail.com', 'pass15', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Quince', NULL, NULL, '2025-04-11 12:19:30'),
(16, 'user16', 'user16@mail.com', 'pass16', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Dieciséis', NULL, NULL, '2025-04-11 12:19:30'),
(17, 'nico_ave', 'nicolas9244@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 'Contraseña 9244', 'l', '', '', 1, 'Nicolas ', 'Avezzani', NULL, NULL, '2025-04-05 08:20:00'),
(18, 'user18', 'user18@mail.com', '5a032830ea6db6e3f7117e2661968e74331f4f3a', NULL, 'b4698af76ba4918fc1bed1a95281d6ef4fff3cd09c8295b1941d9756e8ac9daf.png', '', NULL, NULL, NULL, 1, 'User', 'Dieciocho A', NULL, NULL, '2025-04-11 12:19:30'),
(19, 'user19', 'user19@mail.com', 'pass19', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Diecinueve', NULL, NULL, '2025-04-11 12:19:30'),
(20, 'user20', 'user20@mail.com', 'pass20', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Veinte', NULL, NULL, '2025-04-11 12:19:30'),
(21, 'ale_rocker', 'ale@mail.com', 'rocky123', NULL, 'ale.jpg', 'Rockeando desde el 2000', NULL, NULL, NULL, 2, 'Alejandro', 'Torres', NULL, 'avatar21.png', '2025-04-11 12:19:30'),
(22, 'maria_fit', 'mariafit@mail.com', 'fit4life', NULL, 'maria.jpg', 'Entrenadora personal', '@mariafit', '@fitmaria', 'fb.com/maria.fit', 3, 'María', 'Alonso', NULL, NULL, '2025-04-11 12:19:30'),
(23, 'gamerpro', 'gamerpro@mail.com', 'g@m3rPr0', NULL, 'gamer.jpg', 'Jugador competitivo', NULL, NULL, NULL, 1, 'Pedro', 'Jiménez', 'gamer#2222', NULL, '2025-04-11 12:19:30'),
(24, 'clau_blog', 'clau@mail.com', 'blogLife23', NULL, NULL, 'Bloguera de estilo de vida', '@clau_blog', NULL, NULL, 2, 'Claudia', 'Morales', NULL, NULL, '2025-04-11 12:19:30'),
(25, 'rafart', 'rafa@mail.com', 'artLove45', NULL, 'rafa.jpg', 'Diseñador UI/UX', NULL, '@rafart', NULL, 3, 'Rafael', 'Aguilar', NULL, NULL, '2025-04-11 12:19:30'),
(26, 'sofi_digital', 'sofi@mail.com', 'd1g1t@l!', NULL, NULL, NULL, NULL, '@sofi.digital', 'fb.com/sofi.digital', 2, 'Sofía', 'Mendoza', NULL, 'avatar26.jpg', '2025-04-11 12:19:30'),
(27, 'ADMINISTRADOR', 'asd@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, '1.jpg', '1234', NULL, NULL, NULL, 1, 'Nicolas Fernando', 'Zoppi', NULL, NULL, '2025-04-05 08:20:00'),
(28, 'lolo', 'lolo@lolo.gov', '8aa40001b9b39cb257fe646a561a80840c806c55', NULL, NULL, NULL, NULL, NULL, NULL, 1, '', '', NULL, NULL, '2025-04-05 08:20:00'),
(29, 'kilo', 'kilo@kilo.com', '8ff8800a239d91c648520ad5aea2d30e76e2850f', NULL, NULL, NULL, NULL, NULL, NULL, 1, '', '', NULL, NULL, '2025-04-05 08:20:00'),
(30, 'pepe', 'pepe@gmail.com', '265392dc2782778664cc9d56c8e3cd9956661bb0', NULL, NULL, NULL, NULL, NULL, NULL, 1, '', '', NULL, NULL, '2025-04-05 08:20:00'),
(33, 'CLIENTE', 'zoppinicolas@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, 'Listo que capo soy.jpg', '1234', NULL, NULL, NULL, 1, 'CLIENTE', 'CLIENTEa', NULL, NULL, '2025-04-05 08:20:00'),
(37, 'leo_code', 'leo@mail.com', 'cod3r2024', NULL, 'leo.png', 'Full-stack dev', '@leo_code', NULL, NULL, 1, 'Leonardo', 'Castro', NULL, NULL, '2025-04-11 12:19:30'),
(38, 'jess_art', 'jess@mail.com', 'pa$$jess', NULL, NULL, 'Ilustradora', NULL, '@jessart', NULL, 3, 'Jessica', 'Herrera', 'jess#1212', NULL, '2025-04-11 12:19:30'),
(39, 'mike_tech', 'mike@mail.com', 'techMike99', NULL, 'mike.jpg', 'Tech reviewer', NULL, NULL, NULL, 1, 'Miguel', 'Reyes', NULL, NULL, '2025-04-11 12:19:30'),
(40, 'andrea_music', 'andrea@mail.com', 'andreamusic1', NULL, NULL, 'Cantante y compositora', '@andreamusic', NULL, NULL, 2, 'Andrea', 'Luna', 'andrea#2323', NULL, '2025-04-11 12:19:30'),
(67, 'user17', 'user17@mail.com', 'pass17', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'User', 'Diecisiete', NULL, NULL, '2025-04-11 12:19:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_favoritos`
--

CREATE TABLE `usuario_favoritos` (
  `idfavorito` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `crypto_id` varchar(50) NOT NULL,
  `crypto_nombre` varchar(100) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_favoritos`
--

INSERT INTO `usuario_favoritos` (`idfavorito`, `idusuario`, `crypto_id`, `crypto_nombre`, `fecha_agregado`) VALUES
(2, 27, 'solana', 'Solana', '2025-04-09 05:34:15'),
(4, 27, 'ronin', 'Ronin', '2025-04-09 05:36:43'),
(8, 27, 'bitcoin', 'Bitcoin', '2025-04-09 05:44:38'),
(10, 27, 'ethereum', 'Ethereum', '2025-04-09 14:26:08'),
(11, 33, 'ronin', 'Ronin', '2025-04-09 14:31:01'),
(14, 27, 'bnc', 'BNC', '2025-04-10 17:08:36'),
(15, 17, 'bitcoin', 'Bitcoin', '2025-04-11 15:10:15'),
(16, 17, 'ripple', 'XRP', '2025-04-11 15:10:36'),
(17, 17, 'polkadot', 'Polkadot', '2025-04-11 15:10:45'),
(18, 33, 'ripple', 'XRP', '2025-04-11 15:11:17'),
(20, 17, 'iota', 'IOTA', '2025-04-11 15:35:20'),
(21, 33, 'the-graph', 'The Graph', '2025-04-11 16:15:44'),
(22, 18, 'superfarm', 'SuperVerse', '2025-04-11 22:55:13'),
(23, 18, 'staked-hype', 'Staked HYPE', '2025-04-11 22:55:22'),
(26, 33, 'bnc', 'BNC', '2025-04-11 23:00:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_redes`
--

CREATE TABLE `usuario_redes` (
  `idred` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_red` varchar(50) NOT NULL,
  `url_red` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_redes`
--

INSERT INTO `usuario_redes` (`idred`, `idusuario`, `tipo_red`, `url_red`, `fecha_creacion`) VALUES
(10, 33, 'Otra', 'https://hacktorrent.to/', '2025-04-03 15:09:43'),
(11, 33, 'Twitter', 'https://hacktorrent.to/', '2025-04-03 15:10:01'),
(17, 27, 'Twitter', 'https://hacktorrent.to/', '2025-04-03 15:32:59'),
(18, 27, 'YouTube', 'https://www.youtube.com/results?search_query=lofi', '2025-04-03 16:00:47'),
(20, 27, 'TikTok', 'https://hacktorrent.to/', '2025-04-09 05:45:04');

--
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`idinventario`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`iditem`),
  ADD KEY `idestado` (`idestado`),
  ADD KEY `idtienda` (`idtienda`);

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
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`);

--
-- Indices de la tabla `productos_categoria`
--
ALTER TABLE `productos_categoria`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `usuario_favoritos`
--
ALTER TABLE `usuario_favoritos`
  ADD PRIMARY KEY (`idfavorito`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuario_redes`
--
ALTER TABLE `usuario_redes`
  ADD PRIMARY KEY (`idred`),
  ADD KEY `idusuario` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `idinventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `iditem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idnoticia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `idproyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `rarezaitem`
--
ALTER TABLE `rarezaitem`
  MODIFY `rareza_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `redes`
--
ALTER TABLE `redes`
  MODIFY `idred` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `usuario_favoritos`
--
ALTER TABLE `usuario_favoritos`
  MODIFY `idfavorito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `usuario_redes`
--
ALTER TABLE `usuario_redes`
  MODIFY `idred` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  ADD CONSTRAINT `FK_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_favoritos`
--
ALTER TABLE `usuario_favoritos`
  ADD CONSTRAINT `usuario_favoritos_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `usuario_redes`
--
ALTER TABLE `usuario_redes`
  ADD CONSTRAINT `usuario_redes_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
