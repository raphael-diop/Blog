-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 22 déc. 2021 à 14:15
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `date` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `article`, `id_utilisateur`, `id_categorie`, `date`) VALUES
(1, 'AAAA', 1, 1, '2021-12-20 23:00:00'),
(2, 'BBBB', 2, 2, '2021-12-20 23:00:00'),
(3, 'CCCC', 3, 3, '2021-12-20 23:00:00'),
(4, 'DDD', 4, 4, '2021-12-20 23:00:00'),
(5, 'EEEE', 5, 5, '2021-12-20 23:00:00'),
(6, 'FFFF', 6, 6, '2021-12-20 23:00:00'),
(7, 'GGGG', 7, 7, '2021-12-20 23:00:00'),
(8, 'HHHH', 8, 8, '2021-12-20 23:00:00'),
(9, 'IIII', 9, 9, '2021-12-20 23:00:00'),
(10, 'JJJJ', 10, 10, '2021-12-20 23:00:00'),
(11, 'KKKK', 11, 11, '2021-12-20 23:00:00'),
(12, 'LLLL', 12, 12, '2021-12-20 23:00:00'),
(13, 'MMMM', 13, 13, '2021-12-20 23:00:00'),
(14, 'NNNN', 14, 14, '2021-12-20 23:00:00'),
(15, 'OOOO', 15, 15, '2021-12-20 23:00:00'),
(16, 'PPPP', 16, 16, '2021-12-20 23:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
