-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-04-2016 a las 13:47:37
-- Versión del servidor: 5.6.28-1
-- Versión de PHP: 5.6.17-3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_ipu`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_idiomas`
--

CREATE TABLE `tb_idiomas` (
  `pk_idioma` varchar(3) NOT NULL,
  `nombre_idioma` varchar(60) NOT NULL,
  `status_idioma` varchar(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tb_idiomas`
--

INSERT INTO `tb_idiomas` (`pk_idioma`, `nombre_idioma`, `status_idioma`) VALUES
('en', 'Ingles', 'A'),
('es', 'Español', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_multimedia`
--

CREATE TABLE `tb_multimedia` (
  `fk_pk_publicacion` int(11) NOT NULL,
  `url_archivo` varchar(200) NOT NULL,
  `tipo_archivo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_paginas`
--

CREATE TABLE `tb_paginas` (
  `pk_pagina` int(11) NOT NULL,
  `pagina` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `descripcion` varchar(260) NOT NULL,
  `abrir` varchar(6) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A',
  `fk_idioma` varchar(3) DEFAULT NULL,
  `pk_pagina_padre` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tb_paginas`
--

INSERT INTO `tb_paginas` (`pk_pagina`, `pagina`, `url`, `titulo`, `descripcion`, `abrir`, `status`, `fk_idioma`, `pk_pagina_padre`) VALUES
(1, 'Inicio', 'inicio', 'Inicio', 'as dasd asd dasd', '', 'A', 'es', 0),
(7, 'Ministerios', 'ministerios', 'Ministerios', 'Conoce los deferentes ministerios que operan en la ipu', '', 'A', 'es', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_publicaciones`
--

CREATE TABLE `tb_publicaciones` (
  `pk_publicacion` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `url` varchar(400) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `fk_pk_pagina` int(11) NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_user`
--

CREATE TABLE `tb_user` (
  `pk_user` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `status` varchar(1) DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `tb_user`
--

INSERT INTO `tb_user` (`pk_user`, `name`, `login`, `pass`, `status`) VALUES
(2, 'Administrador', 'admin', '169fbcab2bba2cdcea26821c9e02de185e7cdc25', 'A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_idiomas`
--
ALTER TABLE `tb_idiomas`
  ADD PRIMARY KEY (`pk_idioma`);

--
-- Indices de la tabla `tb_multimedia`
--
ALTER TABLE `tb_multimedia`
  ADD PRIMARY KEY (`fk_pk_publicacion`);

--
-- Indices de la tabla `tb_paginas`
--
ALTER TABLE `tb_paginas`
  ADD PRIMARY KEY (`pk_pagina`),
  ADD KEY `fk_idioma` (`fk_idioma`);

--
-- Indices de la tabla `tb_publicaciones`
--
ALTER TABLE `tb_publicaciones`
  ADD PRIMARY KEY (`pk_publicacion`,`titulo`),
  ADD KEY `index2` (`titulo`),
  ADD KEY `indx3` (`fk_pk_pagina`);

--
-- Indices de la tabla `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`pk_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_paginas`
--
ALTER TABLE `tb_paginas`
  MODIFY `pk_pagina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `tb_publicaciones`
--
ALTER TABLE `tb_publicaciones`
  MODIFY `pk_publicacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `pk_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_multimedia`
--
ALTER TABLE `tb_multimedia`
  ADD CONSTRAINT `fk_publicacion` FOREIGN KEY (`fk_pk_publicacion`) REFERENCES `tb_publicaciones` (`pk_publicacion`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tb_paginas`
--
ALTER TABLE `tb_paginas`
  ADD CONSTRAINT `fk_idiomas` FOREIGN KEY (`fk_idioma`) REFERENCES `tb_idiomas` (`pk_idioma`) ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tb_publicaciones`
--
ALTER TABLE `tb_publicaciones`
  ADD CONSTRAINT `fk_tb_publicaciones` FOREIGN KEY (`fk_pk_pagina`) REFERENCES `tb_paginas` (`pk_pagina`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
