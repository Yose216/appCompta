-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 28 Octobre 2016 à 09:37
-- Version du serveur :  5.7.15-0ubuntu0.16.04.1
-- Version de PHP :  7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `appCompta`
--
CREATE DATABASE IF NOT EXISTS `appCompta` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `appCompta`;

--
-- Contenu de la table `concernes`
--

INSERT INTO `concernes` (`id_depenses`, `id_users`) VALUES
(1, 1),
(2, 2),
(5, 5);

--
-- Contenu de la table `depenses`
--

INSERT INTO `depenses` (`id_depenses`, `montant`, `payeurs`, `date`, `nbConcerne`, `description`) VALUES
(1, 200, 1, '2016-10-02 00:00:00', 3, 'Papier toilette'),
(2, 300, 1, '2016-10-26 00:00:00', 5, 'Teste de l\'edit de depenses'),
(5, 1000, 1, '2016-10-25 00:00:00', 2, 'test edit');

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_color`, `user_role`, `user_pwd`, `user_salt`) VALUES
(1, 'Youness', 'red', 'ROLE_ADMIN', 'facesimplon', ''),
(2, 'Valentin', 'blue', 'ROLE_USER', '', ''),
(3, 'toto', 'green', 'ROLE_USER', '', NULL),
(5, 'titi', 'pink', 'ROLE_USER', '', '');

--
-- Contenu de la table `users_has_user_group`
--

INSERT INTO `users_has_user_group` (`user_id`, `id_user_group`) VALUES
(1, 1),
(2, 1),
(3, 1),
(5, 1);

--
-- Contenu de la table `user_group`
--

INSERT INTO `user_group` (`id_user_group`, `group_name`) VALUES
(1, 'ete 2016');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
