-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2016 a las 15:34:34
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `donde`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `clase` varchar(45) NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `horario` varchar(100) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `web_url` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `comentarios` varchar(500) DEFAULT NULL,
  `habilitado` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `idPlaces` int(11) DEFAULT NULL,
  `hidden` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre_pais` varchar(45) DEFAULT NULL,
  `habilitado` tinyint(4) DEFAULT NULL,
  `zoom` int(2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `id` int(11) NOT NULL,
  `nombre_partido` varchar(45) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT NULL,
  `zoom` int(2) DEFAULT NULL,
  `idProvincia` int(11) DEFAULT NULL,
  `idPais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `places`
--

CREATE TABLE `places` (
  `placeId` int(11) NOT NULL,
  `establecimiento` varchar(255) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `calle` varchar(50) DEFAULT NULL,
  `altura` varchar(50) DEFAULT NULL,
  `piso_dpto` varchar(50) DEFAULT NULL,
  `cruce` varchar(300) DEFAULT NULL,
  `barrio_localidad` varchar(300) DEFAULT NULL,
  `idPartido` int(11) DEFAULT NULL,
  `idProvincia` int(11) DEFAULT NULL,
  `idPais` int(11) DEFAULT NULL,
  `aprobado` tinyint(4) DEFAULT NULL,
  `observacion` varchar(1000) DEFAULT NULL,
  `formattedAddress` varchar(200) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `confidence` float DEFAULT NULL,
  `fail` varchar(200) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `habilitado` tinyint(4) DEFAULT NULL,
  `vacunatorio` tinyint(4) DEFAULT NULL,
  `infectologia` tinyint(4) DEFAULT NULL,
  `condones` tinyint(4) DEFAULT NULL,
  `prueba` tinyint(4) DEFAULT NULL,
  `tel_testeo` varchar(50) DEFAULT NULL,
  `mail_testeo` varchar(50) DEFAULT NULL,
  `horario_testeo` varchar(100) DEFAULT NULL,
  `responsable_testeo` varchar(100) DEFAULT NULL,
  `web_testeo` varchar(100) DEFAULT NULL,
  `ubicacion_testeo` varchar(100) DEFAULT NULL,
  `observaciones_testeo` varchar(500) DEFAULT NULL,
  `tel_distrib` varchar(50) DEFAULT NULL,
  `mail_distrib` varchar(50) DEFAULT NULL,
  `horario_distrib` varchar(100) DEFAULT NULL,
  `responsable_distrib` varchar(100) DEFAULT NULL,
  `web_distrib` varchar(100) DEFAULT NULL,
  `ubicacion_distrib` varchar(100) DEFAULT NULL,
  `comentarios_distrib` varchar(500) DEFAULT NULL,
  `tel_infectologia` varchar(50) DEFAULT NULL,
  `mail_infectologia` varchar(50) DEFAULT NULL,
  `horario_infectologia` varchar(100) DEFAULT NULL,
  `responsable_infectologia` varchar(100) DEFAULT NULL,
  `web_infectologia` varchar(100) DEFAULT NULL,
  `ubicacion_infectologia` varchar(100) DEFAULT NULL,
  `comentarios_infectologia` varchar(500) DEFAULT NULL,
  `tel_vac` varchar(50) DEFAULT NULL,
  `mail_vac` varchar(50) DEFAULT NULL,
  `horario_vac` varchar(100) DEFAULT NULL,
  `responsable_vac` varchar(100) DEFAULT NULL,
  `web_vac` varchar(100) DEFAULT NULL,
  `ubicacion_vac` varchar(100) DEFAULT NULL,
  `comentarios_vac` varchar(500) DEFAULT NULL,
  `mac` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `id` int(11) NOT NULL,
  `nombre_provincia` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `habilitado` tinyint(4) DEFAULT NULL,
  `zoom` int(2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `peso` int(11) DEFAULT '0',
  `idPais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `updated_at`, `created_at`, `remember_token`) VALUES
(2, 'francoohd', 'francoo.hd@gmail.com', '$2y$10$yuzsh1wBM0UPQsgnC/.p5u2HR2hwhtnC81A.g1qIFHMsG9s8DFQyy', '2016-09-30 23:09:50', '2015-09-29 14:40:41', '31qojC6qg3nrQYLO4slSEVKdaTe3fPMqkGrYcFnKdePzvKByRo65m3oktsQb'),
(22, 'Martin', 'martin.rabaglia@gmail.com', '$2y$10$Y7B4Jqg0Ki9xHO8YXv28j.UNE4antkuM5NjbPUlebwc9lDL2V85aK', '2015-12-09 18:25:24', '2015-12-09 18:25:24', NULL),
(23, 'Jony', 'jona_lord@protonmail.com', '$2y$10$rAQFkZ4X1BBEqpKFoq2LluQTlsxf95HGw2d/yWJaHRBgD87AZ37iO', '2016-06-23 22:16:27', '2016-06-23 22:16:13', '6iurWeFIWslHMLFqzjT29deiaaYA3c6TWxKsG5Co1dQJlGaUA7pPX0E4iOGo'),
(24, 'Franco Test', 'funciona@gmail.com', '$2y$10$rz9XOsj4nG25GW6qyLue1ex7AgVcfh/Pg/oq1fCte8t5PId2W4C.6', '2016-06-23 22:21:17', '2016-06-23 22:21:17', NULL),
(25, 'Guadalupe López', 'guadalupelopezt@gmail.com', '$2y$10$Zy5Eya4rImJSgYVxIQPT8uN/T9a5qTZ5Mmh8bH0G5ARQD6qXKFZTq', '2016-06-24 13:19:52', '2016-06-24 13:19:52', NULL),
(26, 'DONDE', 'donde@huesped.org.ar', '$2y$10$JpqlHjh/6uVHhbuGF1YNIeip29P70myPfpL6fKgLliKg5RJ.Q8ok2', '2016-06-24 13:21:46', '2016-06-24 13:21:46', NULL),
(27, 'Anita Massacane', 'anita.massacane@huesped.org.ar', '$2y$10$dRbtZlukDVHyMpVfgJ9hb.Oec3f0Q7ewLaSa0xm73JuSm6Khob7/6', '2016-06-24 13:22:38', '2016-06-24 13:22:38', NULL),
(28, 'Leandro Kahn', 'leandro.cahn@huesped.org.ar', '$2y$10$3UY5jgKakgqpicm5z.AbVumdg15dFtGXPspQFkhkw5XOSuv8QCaUa', '2016-06-24 13:23:32', '2016-06-24 13:23:32', NULL),
(29, 'Meli', 'melina.masnatta@huesped.org.ar', '$2y$10$j8wbVlF22.0EInJPCzaBFuDAOv7txrOgwQ6Wq3EYv4cHltHmqvFWi', '2016-09-06 17:13:51', '2016-09-06 17:13:27', 'S4BTrdQTEyz30jp6fIG02LPU9VAPBMZKLHvm0x4OEUIoRNL2KQH72WE1ifPb');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_location_feature_idx` (`idPlaces`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_partido_pais_idx` (`idPais`),
  ADD KEY `fk_partido_provincia_idx` (`idProvincia`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indices de la tabla `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`placeId`),
  ADD KEY `fk_provincia_idx` (`idProvincia`),
  ADD KEY `fk_partido_idx` (`idPartido`),
  ADD KEY `fk_pais_idx` (`idPais`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_provincia_pais_idx` (`idPais`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `places`
--
ALTER TABLE `places`
  MODIFY `placeId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `features`
--
ALTER TABLE `features`
  ADD CONSTRAINT `id_location_feature` FOREIGN KEY (`idPlaces`) REFERENCES `places` (`placeId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `fk_partido_pais` FOREIGN KEY (`idPais`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_partido_provincia` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `fk_pais` FOREIGN KEY (`idPais`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_partido` FOREIGN KEY (`idPartido`) REFERENCES `partido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_provincia` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `fk_provincia_pais` FOREIGN KEY (`idPais`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
