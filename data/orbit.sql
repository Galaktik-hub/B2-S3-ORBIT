-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 05 jan. 2025 à 16:29
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
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `user_id` int(11) NOT NULL,
  `departure_planet_id` int(11) UNSIGNED NOT NULL,
  `arrival_planet_id` int(11) UNSIGNED NOT NULL,
  `distance` double NOT NULL,
  `time_of_order` datetime NOT NULL,
  `ship_id` int(11) UNSIGNED NOT NULL,
  `number_of_ticket` int(11) UNSIGNED NOT NULL,
  `order_type` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_type`
--

CREATE TABLE `order_type` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_type`
--

INSERT INTO `order_type` (`id`, `label`) VALUES
(00000000001, 'En cours'),
(00000000002, 'Valide'),
(00000000003, 'Passe');

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
  `pseudo` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `pp` varchar(500) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk` (`user_id`),
  ADD KEY `departure_planet_id_fk` (`departure_planet_id`),
  ADD KEY `arrival_planet_id_fk` (`arrival_planet_id`),
  ADD KEY `ship_id_fk` (`ship_id`),
  ADD KEY `order_type_fk` (`order_type`);

--
-- Index pour la table `order_type`
--
ALTER TABLE `order_type`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_type`
--
ALTER TABLE `order_type`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
