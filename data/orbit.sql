-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 27 nov. 2024 à 23:18
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `orbit`
--

-- --------------------------------------------------------

--
-- Structure de la table `planets`
--

CREATE TABLE `planets` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `coord` varchar(255) DEFAULT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `sub_grid_coord` varchar(255) DEFAULT NULL,
  `sub_grid_x` float NOT NULL,
  `sub_grid_y` float NOT NULL,
  `sun_name` varchar(255) DEFAULT NULL,
  `region` varchar(255) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `suns` int(11) NOT NULL,
  `moons` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `distance` float NOT NULL,
  `length_day` float NOT NULL,
  `length_year` float NOT NULL,
  `diameter` float NOT NULL,
  `gravity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ships`
--

CREATE TABLE `ships` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(255) NOT NULL,
  `camp` varchar(255) NOT NULL,
  `speed_kmh` float NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `planet_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `day_of_week` enum('Primeday','Centaxday','Taungsday','Zhellday','Benduday') NOT NULL,
  `destination_planet_id` int(11) NOT NULL,
  `departure_time` time NOT NULL,
  `ship_id` int(11) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `planets`
--
ALTER TABLE `planets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `ships`
--
ALTER TABLE `ships`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trips_planets` (`planet_id`),
  ADD KEY `trips_ships` (`ship_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `planets`
--
ALTER TABLE `planets`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_planets` FOREIGN KEY (`planet_id`) REFERENCES `planets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trips_ships` FOREIGN KEY (`ship_id`) REFERENCES `ships` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
