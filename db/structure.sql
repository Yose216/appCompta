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

-- --------------------------------------------------------

--
-- Structure de la table `concernes`
--

CREATE TABLE `concernes` (
  `id_depenses` int(11) NOT NULL,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `depenses`
--

CREATE TABLE `depenses` (
  `id_depenses` int(11) NOT NULL,
  `montant` float DEFAULT NULL,
  `payeurs` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `nbConcerne` int(11) NOT NULL,
  `description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(45) DEFAULT NULL,
  `user_color` varchar(45) DEFAULT NULL,
  `user_role` enum('ROLE_USER','ROLE_ADMIN') DEFAULT NULL,
  `user_pwd` varchar(100) DEFAULT NULL,
  `user_salt` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users_has_user_group`
--

CREATE TABLE `users_has_user_group` (
  `user_id` int(11) NOT NULL,
  `id_user_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_group`
--

CREATE TABLE `user_group` (
  `id_user_group` int(11) NOT NULL,
  `group_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `concernes`
--
ALTER TABLE `concernes`
  ADD PRIMARY KEY (`id_depenses`,`id_users`),
  ADD KEY `fk_depenses_has_users_users1_idx` (`id_users`),
  ADD KEY `fk_depenses_has_users_depenses1_idx` (`id_depenses`);

--
-- Index pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD PRIMARY KEY (`id_depenses`),
  ADD KEY `fk_depenses_users1_idx` (`payeurs`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `users_has_user_group`
--
ALTER TABLE `users_has_user_group`
  ADD PRIMARY KEY (`user_id`,`id_user_group`),
  ADD KEY `fk_users_has_user_group_user_group1_idx` (`id_user_group`),
  ADD KEY `fk_users_has_user_group_users_idx` (`user_id`);

--
-- Index pour la table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id_user_group`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `depenses`
--
ALTER TABLE `depenses`
  MODIFY `id_depenses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `concernes`
--
ALTER TABLE `concernes`
  ADD CONSTRAINT `fk_depenses_has_users_depenses1` FOREIGN KEY (`id_depenses`) REFERENCES `depenses` (`id_depenses`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_depenses_has_users_users1` FOREIGN KEY (`id_users`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD CONSTRAINT `fk_depenses_users1` FOREIGN KEY (`payeurs`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users_has_user_group`
--
ALTER TABLE `users_has_user_group`
  ADD CONSTRAINT `fk_users_has_user_group_user_group1` FOREIGN KEY (`id_user_group`) REFERENCES `user_group` (`id_user_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_user_group_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
