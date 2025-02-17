-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 05, 2025 at 03:12 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `battle_nations`
--

-- --------------------------------------------------------

--
-- Table structure for table `pays`
--

CREATE TABLE `pays` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `attaque` int(11) NOT NULL,
  `renforcement` int(11) NOT NULL,
  `bombe_nucleaire` tinyint(1) NOT NULL,
  `pv` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pays`
--

INSERT INTO `pays` (`id`, `nom`, `attaque`, `renforcement`, `bombe_nucleaire`, `pv`, `image`) VALUES
(1, 'États-Unis', 50, 30, 2, 1000, 'https://flagcdn.com/w320/us.png'),
(2, 'Russie', 45, 35, 1, 1000, 'https://flagcdn.com/w320/ru.png'),
(3, 'Chine', 60, 25, 1, 1000, 'https://flagcdn.com/w320/cn.png'),
(4, 'Inde', 40, 40, 0, 1000, 'https://flagcdn.com/w320/in.png'),
(5, 'Royaume-Uni', 35, 25, 1, 1000, 'https://flagcdn.com/w320/gb.png'),
(6, 'France', 30, 30, 1, 1000, 'https://flagcdn.com/w320/fr.png'),
(7, 'Allemagne', 40, 20, 0, 1000, 'https://flagcdn.com/w320/de.png'),
(8, 'Japon', 30, 20, 0, 1000, 'https://flagcdn.com/w320/jp.png'),
(9, 'Israël', 20, 20, 1, 1000, 'https://flagcdn.com/w320/il.png'),
(10, 'Pakistan', 45, 30, 1, 1000, 'https://flagcdn.com/w320/pk.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
