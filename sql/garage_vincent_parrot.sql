SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `garage_vincent_parrot`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `rating` int(11) DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_visitor_id` (`visitor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `visitor_id`, `firstname`, `lastname`, `content`, `is_approved`, `rating`, `submitted_at`) VALUES
(48, 57, 'Marc', 'Dupont', 'J\'ai été très satisfait de la réparation de ma voiture. Le personnel était amical et compétent.', 1, 5, '2024-02-17 17:59:46'),
(49, 58, 'Sophie', 'Tremblay', 'Excellent service client! Ils ont réparé ma voiture rapidement et à un prix raisonnable.', 1, 5, '2024-02-17 18:00:28'),
(50, 59, 'Pierre', 'Lefebvre', 'J\'ai eu quelques problèmes mineurs avec la réparation, mais l\'équipe du garage a été très réactive pour les résoudre.', 1, 4, '2024-02-17 18:00:59'),
(51, 60, 'Isabelle', 'Gagnon', 'La réparation a pris plus de temps que prévu, mais le résultat final était satisfaisant.', 1, 3, '2024-02-17 18:01:44'),
(63, 115, 'Jeanne', 'Berry', 'Service exécrable et personnel malpoli ! Ne venez pas dans ce garage', 0, 1, '2024-02-19 22:11:10'),
(64, 116, 'Jeanne', 'Berry', 'Service exécrable et personnel malpoli ! Ne venez pas dans ce garage', 0, 1, '2024-02-19 23:24:24'),
(65, 117, 'Jeanne', 'Berry', 'Service exécrable et personnel malpoli ! Ne venez pas dans ce garage', 0, 1, '2024-02-19 23:25:07'),
(66, 118, 'Jeanne', 'Berry', 'Service exécrable et personnel malpoli ! Ne venez pas dans ce garage', 0, 1, '2024-02-19 23:25:53');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `visitor_id` (`visitor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `visitor_id`, `firstname`, `lastname`, `email`, `phone`, `message`, `created_at`) VALUES
(11, 35, 'Henry', 'Salvador', 'test@test.fr', 'test', 'test', '2024-02-16 22:57:47'),
(52, 113, 'Jean', 'Jacques', 'jean.jacques@test.fr', '0258198181', 'Je suis intéressé par ce véhicule (Renault Twingo III ID du véhicule: 59)', '2024-02-19 20:47:34'),
(53, 114, 'Paul', 'Louis', 'paul.louis@test.fr', '058198168', 'Je suis interessé par ce véhicule (Renault Clio V ID du véhicule: 62)', '2024-02-19 20:48:17');

-- --------------------------------------------------------

--
-- Structure de la table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` varchar(50) NOT NULL,
  `morning_opening_hour` time DEFAULT NULL,
  `morning_closing_hour` time DEFAULT NULL,
  `afternoon_opening_hour` time DEFAULT NULL,
  `afternoon_closing_hour` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `schedules`
--

INSERT INTO `schedules` (`id`, `day`, `morning_opening_hour`, `morning_closing_hour`, `afternoon_opening_hour`, `afternoon_closing_hour`, `created_at`) VALUES
(1, 'Lundi', '08:00:00', '12:00:00', '13:30:00', '17:00:00', '2024-02-06 14:23:36'),
(2, 'Mardi', '08:00:00', '12:00:00', '13:30:00', '17:00:00', '2024-02-06 14:23:36'),
(3, 'Mercredi', '08:00:00', '12:00:00', '13:30:00', '17:00:00', '2024-02-06 14:23:36'),
(4, 'Jeudi', '08:00:00', '12:00:00', '13:30:00', '17:00:00', '2024-02-06 14:23:36'),
(5, 'Vendredi', '08:00:00', '12:00:00', '13:30:00', '17:00:00', '2024-02-06 14:23:36'),
(6, 'Samedi', '08:00:00', '12:00:00', '13:30:00', '15:00:00', '2024-02-06 14:23:36');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `img_service` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `description`, `title`, `img_service`) VALUES
(26, 'Profitez de nos offres d\'entretien', 'Entretien', '../uploads/image_2024-02-17_150514785.png'),
(27, 'Profitez de nos offres de réparation', 'Réparation', '../uploads/image_2024-02-17_150530997.png'),
(28, 'Profitez de la vidange', 'Vidange', '../uploads/image_2024-02-17_150725695.png'),
(29, 'Profitez du nettoyage de votre véhicule', 'Nettoyage', '../uploads/image_2024-02-17_150759210.png'),
(30, 'Profitez d\'un service de dépannage', 'Depannage', '../uploads/image_2024-02-17_150853327.png'),
(31, 'Profitez d\'un service de contrôle technique', 'Contrôle technique', '../uploads/image_2024-02-17_150954977.png');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `job` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `job`, `role`) VALUES
(4, 'Vincent', 'Parrot', 'VincentParrot', 'vincentparrot@test.fr', '$2y$10$6iD8jtXx1BBdFPKfICfsn.uxMcou7xgBQqoV3wzC2Z7SeptNcrgvu', 'Directeur général et gestionnaire', 'admin'),
(5, 'Patrice', 'Dupont', 'patricedupont31', 'patricedupont@test.fr', '$2y$10$8ReE9faSpb/P32qbIlcC9O3L8NuY8UaiEIZGsQsgOjqkScJgmgUpW', 'Mécanicien en chef', 'employee'),
(12, 'Florian', 'Gourinat', 'floriangourinat', 'florian.gourinat@test.fr', '$2y$10$tzRkG72dx5BT4rlbd6qrKO/VrIjeHsgHJbwR1hkzbvKw4VHBHCb7a', 'Directeur communication', 'employee');

-- --------------------------------------------------------

--
-- Structure de la table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `power` int(11) DEFAULT NULL,
  `transmission` varchar(50) DEFAULT NULL,
  `fuel` varchar(50) DEFAULT NULL,
  `consumption` varchar(20) DEFAULT NULL,
  `navigation` tinyint(1) DEFAULT NULL,
  `heated_seats` tinyint(1) DEFAULT NULL,
  `oil_change` varchar(1) DEFAULT NULL,
  `technical_control` varchar(1) DEFAULT NULL,
  `warranty` tinyint(1) DEFAULT NULL,
  `number_doors` int(11) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `vehicles`
--

INSERT INTO `vehicles` (`id`, `brand`, `model`, `year`, `mileage`, `price`, `condition`, `power`, `transmission`, `fuel`, `consumption`, `navigation`, `heated_seats`, `oil_change`, `technical_control`, `warranty`, `number_doors`, `color`, `photo_url`, `created_at`) VALUES
(54, 'Audi', 'Q7 II phase 2', 2023, 1000, 105000.00, 'Comme neuf', 22, 'Automatique', 'Hybride (Essence/Electrique)', '22 kWh', 1, 1, '0', '0', 1, 5, 'Noir', '../uploads/image_2024-02-15_165244563.png', '2024-02-15 15:52:45'),
(55, 'Audi', 'A5 Sportback II phase 2', 2023, 5000, 59000.00, 'Comme neuf', 11, 'Automatique', 'Diesel', '5.2 L', 1, 0, '0', '0', 1, 5, 'Noir', '../uploads/image_2024-02-15_165444536.png', '2024-02-15 15:54:45'),
(56, 'Fiat', '500 II phase 2', 2020, 25000, 12000.00, 'Très bon état', 4, 'Manuelle', 'Essence', '5.8 L', 0, 0, '1', '0', 1, 3, 'Blanche', '../uploads/image_2024-02-15_165753151.png', '2024-02-15 15:57:54'),
(57, 'Kia', 'Sportage III', 2011, 169000, 10000.00, 'Bon état', 6, 'Manuele', 'Diesel', '4.8 L', 0, 0, '1', '1', 0, 5, 'Noir', '../uploads/image_2024-02-15_170041534.png', '2024-02-15 16:00:42'),
(58, 'Volkswagen', 'Polo VI', 2018, 95000, 12500.00, 'Très bon état', 4, 'Manuelle', 'Diesel', '3.7 L', 1, 0, '0', '1', 1, 5, 'Blanche', '../uploads/image_2024-02-15_170257637.png', '2024-02-15 16:04:24'),
(59, 'Renault', 'Twingo III', 2017, 25000, 9000.00, 'Neuf', 4, 'Manuelle', 'Essence', '4.2 L', 0, 0, '0', '0', 1, 5, 'Blanche', '../uploads/image_2024-02-15_170523655.png', '2024-02-15 16:06:17'),
(60, 'Citroen', 'C1 phase 2', 2011, 35000, 7400.00, 'Très bon état', 4, 'Manuelle', 'Essence', '4 L', 0, 0, '1', '0', 1, 3, 'Gris clair', '../uploads/image_2024-02-15_170730283.png', '2024-02-15 16:08:48'),
(61, 'Renault', 'Austral', 2023, 19000, 34000.00, 'Comme neuf', 7, 'Automatique', 'Hybride (Essence/Electrique)', '6.4 L', 1, 0, '0', '0', 1, 5, 'Rouge foncé métal', '../uploads/image_2024-02-15_171020637.png', '2024-02-15 16:12:54'),
(62, 'Renault', 'Clio V', 2021, 33000, 14000.00, 'Très bon état', 5, 'Manuelle', 'Essence', '5.2 L', 1, 0, '1', '0', 1, 5, 'Gris', '../uploads/image_2024-02-15_171519789.png', '2024-02-15 16:15:21'),
(63, 'Citroen', 'DS3 Crossback', 2022, 1000, 34000.00, 'Comme neuf', 4, 'Automatique', 'Electrique rechargeable ', '16 kWh', 1, 0, '0', '0', 1, 5, 'Gris', '../uploads/image_2024-02-15_172047300.png', '2024-02-15 16:20:48'),
(64, 'Mercedes', 'Classe A IV', 2019, 39000, 27000.00, 'Très bon état', 7, 'Automatique', 'Essebce', '5.2 L', 1, 0, '1', '0', 1, 5, 'Jaune', '../uploads/image_2024-02-15_172336925.png', '2024-02-15 16:23:38'),
(65, 'Lamborghini', 'Urus', 2021, 36000, 279000.00, 'Très bon état', 61, 'Automatique', 'Essence', '12.7', 1, 1, '0', '0', 1, 5, 'Gris metal', '../uploads/image_2024-02-15_172609932.png', '2024-02-15 16:27:08'),
(66, 'Audi', 'TT II Roadster phase 2', 2012, 77000, 20000.00, 'Très bon état', 12, 'Manuelle', 'Diesel', '5.4 L', 1, 0, '0', '1', 1, 3, 'Gris', '../uploads/image_2024-02-15_173246606.png', '2024-02-15 16:32:47'),
(67, 'Mini', 'III 3P', 2020, 15000, 25000.00, 'Très bon état', 3, 'Automatique', 'Electrique', '14 kWh', 1, 0, '0', '0', 1, 3, 'Gris', '../uploads/image_2024-02-15_174007894.png', '2024-02-15 16:40:19'),
(68, 'Renault', 'Megane IV', 2018, 113000, 13000.00, 'Bon état', 5, 'Automatique', 'Diesel', '3.5 L', 0, 0, '0', '0', 1, 5, 'Noir', '../uploads/image_2024-02-15_174332523.png', '2024-02-15 16:43:33'),
(69, 'Fiat', '500 III', 2023, 3000, 29000.00, 'Comme neuf', 3, 'Automatique', 'Electrique rechargeable', '14 kWh', 1, 0, '0', '0', 1, 3, 'Noir', '../uploads/image_2024-02-15_174545389.png', '2024-02-15 16:45:46'),
(70, 'Peugeot', '308 II phase 2', 2018, 70000, 13000.00, 'Très bon état', 7, 'Manuelle', 'Essence', '6.7 L', 0, 0, '0', '1', 0, 5, 'Gris', '../uploads/image_2024-02-15_174952757.png', '2024-02-15 16:52:12'),
(71, 'Audi', 'Q2', 2019, 62000, 26000.00, 'Très bon état', 6, 'Automatique', 'Essence', '5.3 L', 1, 0, '1', '0', 1, 5, 'Gris', '../uploads/image_2024-02-15_175529086.png', '2024-02-15 16:55:30');

-- --------------------------------------------------------

--
-- Structure de la table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `visitors`
--

INSERT INTO `visitors` (`id`, `firstname`, `lastname`, `email`) VALUES
(35, 'Henry', 'Salvador', 'test@test.fr'),
(36, 'Test', 'Test', 'tEST@TEST.FR'),
(37, 'Test', 'Test', 'tEST@TEST.FR'),
(38, 'Marie', 'Dubois', 'marie.dubois@test.fr'),
(39, 'Test admin', 'Test admin', 'test@test.fr'),
(40, 'Test admin 2', 'Test', 'Test@test.fr'),
(41, 'Test admin 4', 't', 't@test.fr'),
(42, 'Test', 'Test', 'Test@test.fr'),
(43, 'Test add comment', 'Test', 'Test@test.fr'),
(44, 'Marie', 'Dubois', 'marie.dubois@test.fr'),
(45, 'Jean-Pierre', 'Martin', 'jp.martin@test.fr'),
(46, 'Sophie', 'Leroux', 'sophie.leroux@test.fr'),
(47, 'Antoine', 'Dupont', 'antoine.dupont@test.fr'),
(48, 'Emilie', 'Girard', 'emilie.girard@test.fr'),
(49, 'Pierre', 'Lefebvre', 'pierre.lefebvre@test.fr'),
(50, 'Test', 'Test', 'test@test.fr'),
(51, 'Test 2', 'test', 'ettte@test.fr'),
(52, 'Test', 'Test', 'Test@test.fr'),
(53, 'test', '3', '3@test.fr'),
(54, 'Test', 'Test', 'test@test.fr'),
(55, '2', '2', '22@test.fr'),
(56, 'Test', 'Test', 'Test@test.fr'),
(57, 'Marc', 'Dupont', 'marc.dupont@test.fr'),
(58, 'Sophie', 'Tremblay', 'sophie.tremblay@test.fr'),
(59, 'Pierre', 'Lefebvre', 'pierre.lefebvre@test.fr'),
(60, 'Isabelle', 'Gagnon', 'isabelle.gagnon@test.fr'),
(61, 'Michel', 'Martin', 'michel.martin@test.fr'),
(62, 'Test log', 'Test', 'TEstlog@test.fr'),
(64, 'test', 'test', 'test@test.fr'),
(65, 'Test log 123445', 'Test', 'Tes@test.fr'),
(66, 'Charles', 'Henry', 'test@test.fr'),
(67, 'Test', 'Test', 'Test@test.fr'),
(68, 'Test', 'Test', 'test@test.fr'),
(69, 'Test', 'Test', 'test@test.fr'),
(70, 'Test', 'Test', 'Test@test.fr'),
(71, 't', 't', 't@test.fr'),
(72, 't', 't', 't@t.fr'),
(73, 'ebetbsrgtb', 'qfbdbeq', 'rbqebeb@test.fr'),
(74, 'ebetbsrgtb', 'qfbdbeq', 'rbqebeb@test.fr'),
(75, 'ebetbsrgtb', 'qfbdbeq', 'rbqebeb@test.fr'),
(76, 'ebetbsrgtb', 'qfbdbeq', 'rbqebeb@test.fr'),
(77, 'ebetbsrgtb', 'qfbdbeq', 'rbqebeb@test.fr'),
(78, 'Florian', 'GOURINAT', 'flofloquatrevingtun@gmail.com'),
(79, 'Florian', 'GOURINAT', 'flofloquatrevingtun@gmail.com'),
(80, 'Florian', 'GOURINAT', 'flofloquatrevingtun@gmail.com'),
(81, 'Florian', 'GOURINAT', 'flofloquatrevingtun@gmail.com'),
(82, 'Florian', 'GOURINAT', 'flofloquatrevingtun@gmail.com'),
(83, 'Florian', 'GOURINAT', 'flofloquatrevingtun@gmail.com'),
(84, 'Florian', 'GOURINAT', 'flofloquatrevingtun@gmail.com'),
(85, 'Florian', 'GOURINAT', 'flofloquatrevingtun@gmail.com'),
(86, 't', 't', 't@test.fr'),
(87, 'test', 'test', 'test@test.fr'),
(88, 'Test', 'Test', 'Test@test.fr'),
(89, 'Test', 'Test', 'test@tets.fr'),
(90, 'Jean', 'Paul', 'jeanpaul@test.fr'),
(91, 't', 't', 't@test.fr'),
(92, 't', 't', 't@test.fr'),
(93, '2', '2', '2@test.fr'),
(94, 'test', 'test', 'ets@tets.fr'),
(95, 'Test avis page d&#039;accueil', 'test', 'test@tets.fr'),
(96, 'Test form vehicle detail', 'test', 'test@tets.fr'),
(97, 'test admin vehicule souhaité', 't', 'test@test.fr'),
(98, 'tbeebebe', 't', 't@test.fr'),
(99, 'tbeebebe', 't', 't@test.fr'),
(100, 'tbeebebe', 't', 't@test.fr'),
(101, 'tbeebebe', 't', 't@test.fr'),
(102, 'Jean', 'Pierre', 'jean.pierre@test.fr'),
(103, 'Test', 'Test', 'Test@test.fr'),
(104, 'form page daccueil', 'test', 'test@test.fr'),
(105, 'Test', 'test', 'test@test.fr'),
(106, 'test formcontact', 'Test', 'test@test.fr'),
(107, 'Test', 'Test', 'test@test.fr'),
(108, 'Test', 'Test', 'test@test.fr'),
(109, 'Test', 'Test', 'test@test.fr'),
(110, 'Test', 'Test', 'test@test.fr'),
(111, 'Test', 'Test', 'test@test.fr'),
(112, 'Jean', 'Jacques', 'jean.jacques@test.fr'),
(113, 'Jean', 'Jacques', 'jean.jacques@test.fr'),
(114, 'Paul', 'Louis', 'paul.louis@test.fr'),
(115, 'Jeanne', 'Berry', 'jeanne.berry@test.fr'),
(116, 'Jeanne', 'Berry', 'jeanne.berry@test.fr'),
(117, 'Jeanne', 'Berry', 'jeanne.berry@test.fr'),
(118, 'Jeanne', 'Berry', 'jeanne.berry@test.fr');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_visitor_id` FOREIGN KEY (`visitor_id`) REFERENCES `visitors` (`id`);

--
-- Contraintes pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
