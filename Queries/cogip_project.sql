-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 08 déc. 2023 à 11:57
-- Version du serveur : 8.2.0
-- Version de PHP : 7.4.3-4ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cogip_project`
--

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

CREATE TABLE `companies` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `type_id` int NOT NULL,
  `country` varchar(50) NOT NULL,
  `tva` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`id`, `name`, `type_id`, `country`, `tva`, `created_at`, `updated_at`) VALUES
(1, 'Thomas&Piron', 1, 'Belgique', '21%', '2023-12-05 10:58:02', '2023-12-05 11:31:45'),
(2, 'ABC Corporation', 1, 'USA', '123456789', '2023-12-01 00:00:00', '2023-12-01 00:00:00'),
(3, 'XYZ Ltd.', 2, 'Canada', '987654321', '2023-12-15 00:00:00', '2023-12-15 00:00:00'),
(4, '123 Entreprises', 1, 'France', '456789123', '2023-01-05 00:00:00', '2023-12-15 00:00:00'),
(5, 'Tech Innovations Inc.', 2, 'Germany', '789123456', '2023-01-20 00:00:00', '2023-12-15 00:00:00'),
(6, 'Osushis', 1, 'Japan', '789456123', '2023-12-07 13:35:40', '2023-12-07 13:35:40'),
(7, 'Treats Company', 1, 'USA', '111111111', '2023-01-07 00:00:00', '2023-01-07 00:00:00'),
(8, 'XYZ Company', 1, 'USA', '123456789', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(9, 'Wizard Company', 2, 'USA', '666666666', '2023-12-08 00:00:00', '2023-12-08 00:00:00'),
(10, 'Wizard Company', 2, 'USA', '666666666', '2023-12-08 00:00:00', '2023-12-08 00:00:00'),
(11, 'Wizard Company', 2, 'USA', '666666666', '2023-12-08 00:00:00', '2023-12-08 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `company_id` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `company_id`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Bob', 1, 'Bob.dylan@sing.com', '04523695', '2023-12-05 13:49:37', '2023-12-05 13:49:37'),
(2, 'Brice Glace', 2, 'Brice.glace@fresh.com', '+38426967820', '2023-12-07 12:41:32', '2023-12-07 12:41:32'),
(3, 'Colette Stérole', 1, 'colette.sterole@health.com', '+20436915024', '2023-12-07 12:44:36', '2023-12-07 12:44:36'),
(4, 'John Doe', 1, 'john.doe@example.com', '123-456-7890', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(5, 'Harry Potter', 1, 'harry.potter@wizard.com', '+3263584164', '2023-12-08 00:00:00', '2023-12-08 00:00:00'),
(6, 'Harry Potter', 1, 'harry.potter@wizard.com', '+3263584164', '2023-12-08 00:00:00', '2023-12-08 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `invoices`
--

CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `ref` varchar(50) NOT NULL,
  `id_company` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `invoices`
--

INSERT INTO `invoices` (`id`, `ref`, `id_company`, `created_at`, `updated_at`) VALUES
(1, 'F20220915-001', 1, '2023-12-05 11:40:50', '2023-12-05 11:40:50');

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `created_at`, `updated_at`) VALUES
(1, '2023-12-05 13:51:03', '2023-12-05 13:51:03'),
(2, '2023-12-05 13:53:37', '2023-12-05 13:53:37');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2023-12-05 13:52:16', '2023-12-05 13:52:16'),
(2, 'user', '2023-12-05 13:52:16', '2023-12-05 13:52:16');

-- --------------------------------------------------------

--
-- Structure de la table `roles_permission`
--

CREATE TABLE `roles_permission` (
  `id` int NOT NULL,
  `permission_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `roles_permission`
--

INSERT INTO `roles_permission` (`id`, `permission_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Supplier', '2023-12-05 10:56:06', '0000-00-00 00:00:00'),
(2, 'Client', '2023-12-07 11:39:57', '2023-12-07 11:39:57');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `role_id` int NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `role_id`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'John', 1, 'Doe', 'john.doe@exemple.com', 'test123', '2023-12-05 09:40:04', '0000-00-00 00:00:00'),
(2, 'Hercule', 2, 'Poirot', 'hercule.poirot@detective.com', '1920&33books', '2023-12-06 12:14:31', '2023-12-06 12:14:31');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_companies_type_id` (`type_id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contacts_company_id` (`company_id`);

--
-- Index pour la table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoices_id_company` (`id_company`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles_permission`
--
ALTER TABLE `roles_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_roles_permission_permission_id` (`permission_id`),
  ADD KEY `fk_roles_permission_role_id` (`role_id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_types_name` (`name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `roles_permission`
--
ALTER TABLE `roles_permission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
