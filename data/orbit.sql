-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 08 jan. 2025 à 23:09
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
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `departure_planet_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `arrival_planet_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `distance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `user_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `departure_planet_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `arrival_planet_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `distance` double NOT NULL,
  `time_of_order` datetime NOT NULL,
  `ship_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `number_of_ticket` int(11) UNSIGNED ZEROFILL NOT NULL,
  `order_type` int(11) UNSIGNED ZEROFILL NOT NULL,
  `taxi` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_routes`
--

CREATE TABLE `order_routes` (
  `id` int(11) NOT NULL,
  `order_id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `planet_name` varchar(255) NOT NULL,
  `route_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_type`
--

CREATE TABLE `order_type` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `perturbation`
--

CREATE TABLE `perturbation` (
  `id` int(11) NOT NULL,
  `shipid` int(11) NOT NULL,
  `perturbation` varchar(50) NOT NULL,
  `message` varchar(500) NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `pp` varchar(500) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arrival_planet_id` (`arrival_planet_id`),
  ADD KEY `departure_planet_id` (`departure_planet_id`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arrival_planet_id` (`arrival_planet_id`),
  ADD KEY `departure_planet_id` (`departure_planet_id`),
  ADD KEY `order_type` (`order_type`),
  ADD KEY `ship_id` (`ship_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `order_routes`
--
ALTER TABLE `order_routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Index pour la table `order_type`
--
ALTER TABLE `order_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `perturbation`
--
ALTER TABLE `perturbation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shipid` (`shipid`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cache`
--
ALTER TABLE `cache`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_routes`
--
ALTER TABLE `order_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_type`
--
ALTER TABLE `order_type`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `perturbation`
--
ALTER TABLE `perturbation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cache`
--
ALTER TABLE `cache`
  ADD CONSTRAINT `cache_ibfk_1` FOREIGN KEY (`arrival_planet_id`) REFERENCES `planets` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `cache_ibfk_2` FOREIGN KEY (`departure_planet_id`) REFERENCES `planets` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`arrival_planet_id`) REFERENCES `planets` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`departure_planet_id`) REFERENCES `planets` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`order_type`) REFERENCES `order_type` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`ship_id`) REFERENCES `ships` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `order_routes`
--
ALTER TABLE `order_routes`
  ADD CONSTRAINT `order_routes_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
