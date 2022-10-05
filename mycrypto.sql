-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2022 a las 19:51:54
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

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
  `parent_comentario_id` int(11) DEFAULT NULL,
  `comment` varchar(200) CHARACTER SET latin1 NOT NULL,
  `comment_sender_name` varchar(40) CHARACTER SET latin1 NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla Comentarios';

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`comentario_id`, `parent_comentario_id`, `comment`, `comment_sender_name`, `date`) VALUES
(4, 0, 'Me fascina la programacion, muy interesante.', 'Luisa Maron', '2018-03-23 07:50:37'),
(5, 0, 'Los lenguajes de programacion nos ayudan a crear plataformas de todo tipo', 'Claudia Guillen', '2018-03-23 08:09:48'),
(6, 0, '  Excelente idea, muchas gracias ', 'Pedro Programador', '2022-04-26 08:36:39'),
(7, 6, '  Por nada a la orden', 'Juan Programador', '2022-04-26 08:37:20'),
(8, 0, '  qwdqwd', 'Ave22', '2022-10-01 04:11:26'),
(9, 4, '3333', 'asdasd', '2022-10-01 04:12:15'),
(10, 0, '  hola', 'juliana', '2022-10-01 04:30:40'),
(11, 10, 'hola', 'juliana2', '2022-10-01 04:30:58'),
(12, 0, 'nashe', 'Avenazi', '2022-10-01 04:32:32'),
(13, 12, 'nasheeeeeeeeee', 'Ave22', '2022-10-01 04:32:40'),
(15, 0, '  sdsd', 'juliana', '2022-10-01 04:41:25'),
(16, 15, 'dsgdsg', 'dgsdgs', '2022-10-01 04:41:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idestado` int(11) NOT NULL,
  `descripcion` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inventarios`
--

INSERT INTO `inventarios` (`idinventario`, `idusuario`, `imagen1`, `imagen2`, `imagen3`, `banner1`, `banner2`, `banner3`, `moneda`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(2, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, 4, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 16, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 17, NULL, NULL, NULL, NULL, NULL, NULL, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `megusta_nomegusta`
--

INSERT INTO `megusta_nomegusta` (`id`, `member_id`, `comentario_id`, `like_unlike`, `date`) VALUES
(2, 1, 3, 1, '2018-03-23 02:09:56'),
(3, 1, 5, 1, '2018-03-23 02:09:52'),
(4, 1, 4, 1, '2022-09-30 23:11:36'),
(5, 1, 6, 1, '2022-04-26 01:37:04'),
(6, 1, 7, 0, '2022-09-30 23:41:22'),
(7, 1, 8, 1, '2022-09-30 23:41:17'),
(8, 1, 14, 0, '2022-10-01 00:03:20'),
(9, 1, 13, 0, '2022-09-30 23:37:50'),
(10, 1, 12, 1, '2022-09-30 23:41:13'),
(11, 1, 10, 1, '2022-09-30 23:41:08'),
(12, 1, 11, 0, '2022-09-30 23:41:11'),
(13, 1, 15, 1, '2022-09-30 23:41:29'),
(14, 1, 16, 1, '2022-09-30 23:41:39');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermiso` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_roles`
--

CREATE TABLE `permiso_roles` (
  `idpermiso` int(11) NOT NULL,
  `idrol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `precio` int(11) NOT NULL,
  `idestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `idestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`idproyecto`, `nombre_proyecto`, `moneda_proyecto`, `precio_proyecto`, `imagen_proyecto`, `idred`, `idestado`) VALUES
(1, 'alien world', NULL, NULL, 'alevi813_midjourney_multiverse_of_eyeball_galaxies_c3f4e7f5-fcd0-4f1f-8530-b04b836859e3.png', 56, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `redes`
--

INSERT INTO `redes` (`idred`, `nombre_red`, `moneda_red`, `precio_red`, `imagen_red`, `idestado`, `orden`) VALUES
(56, 'WaxP', '', '', 'waxp.png', 1, 1),
(59, 'Avalanche', '', '', 'avalanche-avax.png', 1, 2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol_usuarios`
--

INSERT INTO `rol_usuarios` (`idrol`, `idusuario`) VALUES
(2, 2),
(2, 3),
(2, 4),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nickname`, `email`, `contrasenia`, `imagen`, `descripcion`, `twitter`, `instagram`, `facebook`, `idestado`) VALUES
(2, 'FrancoDios95', 'francocolavella1@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', '', '', '', '', 1),
(3, 'Zoppi03', 'zoppinicolas7@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', '', '', '', '', 1),
(4, 'Zoppi034', 'zoppinicolas17@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', '', '', '', '', 1),
(6, 'asdasdasd', 'nicolas.avezzanirc@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 0),
(7, 'nico ave', 'nicolas@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 0),
(8, 'asdasd', 'nicolas11@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 0),
(9, '', '', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 0),
(10, '', 'asduiasd2m@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 0),
(11, '', '123456@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 1),
(12, 'pepesss33', 'pepesss@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 1),
(13, 'asdasd', 'asdassd2@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 1),
(14, 'ttrte', 'asdasdww2@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', '', '', '', 1),
(15, 'brian22', 'brian@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, NULL, NULL, 1),
(16, 'brian123', 'brian12@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, 'esto es una descripcion para brian', 'https://www.facebook.com/brian/', '', '', 1),
(17, 'nico9244', 'nicolas9244@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, 'esto es 9244', '', '', '', 1);

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
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`idinventario`),
  ADD KEY `idusuario` (`idusuario`);

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
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `idestado` (`idestado`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`idproyecto`),
  ADD KEY `idred` (`idred`),
  ADD KEY `idestado` (`idestado`);

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
  MODIFY `comentario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `idinventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `megusta_nomegusta`
--
ALTER TABLE `megusta_nomegusta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `redes`
--
ALTER TABLE `redes`
  MODIFY `idred` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- Filtros para la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `inventarios_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`idproyecto`) REFERENCES `proyectos` (`idproyecto`),
  ADD CONSTRAINT `noticias_ibfk_2` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`);

--
-- Filtros para la tabla `permiso_roles`
--
ALTER TABLE `permiso_roles`
  ADD CONSTRAINT `permiso_roles_ibfk_1` FOREIGN KEY (`idpermiso`) REFERENCES `permisos` (`idpermiso`),
  ADD CONSTRAINT `permiso_roles_ibfk_2` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`);

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
-- Filtros para la tabla `reporte_comentarios`
--
ALTER TABLE `reporte_comentarios`
  ADD CONSTRAINT `FK_estado` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`),
  ADD CONSTRAINT `reporte_comentarios_ibfk_1` FOREIGN KEY (`idcomentario`) REFERENCES `comentarios` (`idcomentario`),
  ADD CONSTRAINT `reporte_comentarios_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);

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
