-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-03-2022 a las 13:03:22
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `warhammer`
--
CREATE DATABASE IF NOT EXISTS `warhammer` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `warhammer`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `army`
--

DROP TABLE IF EXISTS `army`;
CREATE TABLE `army` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE `game` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `player1_id` int(10) UNSIGNED NOT NULL,
  `player2_id` int(10) UNSIGNED NOT NULL,
  `result` enum('1-0','0-1','TIE') DEFAULT NULL,
  `player1_elo_after` int(11) DEFAULT NULL,
  `player2_elo_after` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `game_type_id` int(10) UNSIGNED DEFAULT NULL,
  `game_size_id` int(10) UNSIGNED DEFAULT NULL,
  `player1_army_id` int(10) UNSIGNED DEFAULT NULL,
  `player2_army_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `game`
--
DROP TRIGGER IF EXISTS `check_game_insert`;
DELIMITER $$
CREATE TRIGGER `check_game_insert` BEFORE INSERT ON `game` FOR EACH ROW BEGIN 
	IF NEW.`player1_id` = NEW.`player2_id` THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Player 1 and 2 must be different';
	ELSEIF NEW.`result` IS NOT NULL AND (NEW.`player1_elo_after` IS NULL OR NEW.`player2_elo_after` IS NULL) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Elo scores must be introduced if the game has a result';
	ELSEIF NEW.`result` IS NULL THEN 
		SET NEW.`player1_elo_after` = NULL;
		SET NEW.`player2_elo_after` = NULL;
	END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `check_game_update`;
DELIMITER $$
CREATE TRIGGER `check_game_update` BEFORE UPDATE ON `game` FOR EACH ROW BEGIN 
	IF NEW.`player1_id` = NEW.`player2_id` THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Player 1 and 2 must be different';
	ELSEIF NEW.`result` IS NOT NULL AND (NEW.`player1_elo_after` IS NULL OR NEW.`player2_elo_after` IS NULL) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Elo scores must be introduced if the game has a result';
	ELSEIF NEW.`result` IS NULL THEN
		SET NEW.`player1_elo_after` = NULL;
		SET NEW.`player2_elo_after` = NULL;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game_size`
--

DROP TABLE IF EXISTS `game_size`;
CREATE TABLE `game_size` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game_type`
--

DROP TABLE IF EXISTS `game_type`;
CREATE TABLE `game_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `key` varchar(20) NOT NULL,
  `value` varchar(20) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `setting`
--

INSERT INTO `setting` (`key`, `value`, `description`, `type`) VALUES
('base_elo', '1000', 'El rating Elo inicial para nuevos jugadores.', 'number'),
('k_factor', '24', 'El factor K usando en la fórmula Elo.', 'number'),
('smtp_email', NULL, 'Dirección de email para enviar emails', 'email'),
('smtp_host', NULL, 'Host para enviar emails', 'text'),
('smtp_password', NULL, 'Contraseña para enviar emails', 'password'),
('smtp_port', NULL, 'Puerto para enviar emails', 'number'),
('user_autoregister', '0', 'Permite que los usuarios se registren sin necesidad de activación por parte de un administrador.', 'checkbox');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `army`
--
ALTER TABLE `army`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_FK_game_size` (`game_size_id`),
  ADD KEY `game_FK_game_type` (`game_type_id`),
  ADD KEY `game_FK_player1_army` (`player1_army_id`),
  ADD KEY `game_FK_player1` (`player1_id`),
  ADD KEY `game_FK_player2` (`player2_id`),
  ADD KEY `game_FK_player2_army` (`player2_army_id`);

--
-- Indices de la tabla `game_size`
--
ALTER TABLE `game_size`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `game_type`
--
ALTER TABLE `game_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unique_email` (`email`),
  ADD UNIQUE KEY `user_unique_display_name` (`display_name`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `army`
--
ALTER TABLE `army`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `game`
--
ALTER TABLE `game`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `game_size`
--
ALTER TABLE `game_size`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `game_type`
--
ALTER TABLE `game_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_FK_game_size` FOREIGN KEY (`game_size_id`) REFERENCES `game_size` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_FK_game_type` FOREIGN KEY (`game_type_id`) REFERENCES `game_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_FK_player1` FOREIGN KEY (`player1_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `game_FK_player1_army` FOREIGN KEY (`player1_army_id`) REFERENCES `army` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_FK_player2` FOREIGN KEY (`player2_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `game_FK_player2_army` FOREIGN KEY (`player2_army_id`) REFERENCES `army` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
