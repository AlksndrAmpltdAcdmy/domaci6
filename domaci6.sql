-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 01, 2021 at 08:00 AM
-- Server version: 8.0.23
-- PHP Version: 7.3.27-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `domaci6`
--

-- --------------------------------------------------------

--
-- Table structure for table `gradovi`
--

CREATE TABLE `gradovi` (
  `id` int NOT NULL,
  `ime` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gradovi`
--

INSERT INTO `gradovi` (`id`, `ime`) VALUES
(1, 'Podgorica'),
(9, 'Niksic'),
(10, 'Bar'),
(11, 'Herceg Novi'),
(12, 'Pljevlja'),
(13, 'Budva'),
(14, 'Bijelo Polje'),
(15, 'Cetinje'),
(16, 'Kotor'),
(17, 'Berane'),
(19, 'Ulcinj'),
(20, 'Tivat'),
(21, 'Rozaje'),
(22, 'Danilovgrad'),
(23, 'Mojkovac'),
(24, 'Zabljak'),
(25, 'Kolasin'),
(26, 'Gusinje'),
(32, 'Andrijevica');

-- --------------------------------------------------------

--
-- Table structure for table `nekretnine`
--

CREATE TABLE `nekretnine` (
  `id` int NOT NULL,
  `gradovi_id` int DEFAULT NULL,
  `tip_nekretnine_id` int DEFAULT NULL,
  `tip_oglasa_id` int DEFAULT NULL,
  `povrsina` int DEFAULT NULL,
  `cijena` int DEFAULT NULL,
  `godina` year DEFAULT NULL,
  `opis` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prodata` tinyint(1) NOT NULL DEFAULT '0',
  `datum_prodaje` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nekretnine`
--

INSERT INTO `nekretnine` (`id`, `gradovi_id`, `tip_nekretnine_id`, `tip_oglasa_id`, `povrsina`, `cijena`, `godina`, `opis`, `prodata`, `datum_prodaje`) VALUES
(1, 1, 3, 2, 10, 50, 2020, 'moze sluziti kao skladiste... Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse imperdiet urna nulla, id aliquet lectus viverra sit libero...\r\n', 0, NULL),
(29, 17, 1, 1, 100, 850000, 2020, 'Luksuzan duplex u odlicnom stanju.. Centar grada.. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean in porta lorem, id lobortis libero. Aenean tempus nec magna eget iaculis. Curabitur nec mauris erat. Nullam varius, lorem nec aliquam molestie, ante eros commodo mauris, sed sodales arcu elit eu neque. Praesent efficitur magna neque, a scelerisque nunc ornare eleifend.', 1, '2021-03-01'),
(66, 1, 3, 3, 94, 11, 1936, 'Ducimus est est po', 1, '2021-01-21'),
(68, 11, 1, 1, 68, 82, 2021, 'Cupiditate omnis est', 0, NULL),
(70, 9, 3, 1, 420, 420, 2120, 'Distinctio Sint do Distinctio Sint do Distinctio Sint doDistinctio Sint do Distinctio Sint do', 1, '2020-10-08');

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--

CREATE TABLE `slike` (
  `id` int NOT NULL,
  `nekretnina_id` int NOT NULL,
  `url` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `slike`
--

INSERT INTO `slike` (`id`, `nekretnina_id`, `url`) VALUES
(1, 1, 'garaza.jpg'),
(27, 1, 'test.jpg'),
(28, 29, 'stan1.jpg'),
(29, 29, 'stan2.jpg'),
(30, 29, 'stan3.jpg'),
(74, 66, '603c7923dfc0e.jpg'),
(75, 66, '603c7923e0bd6.jpg'),
(76, 66, '603c7923e3280.jpg'),
(78, 68, '603c79475c7a0.jpg'),
(89, 70, '603c8f86a44b7.jpg'),
(90, 70, '603c8f86a4cf5.jpg'),
(93, 70, '603c8fca0c345.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tip_nekretnine`
--

CREATE TABLE `tip_nekretnine` (
  `id` int NOT NULL,
  `tip` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tip_nekretnine`
--

INSERT INTO `tip_nekretnine` (`id`, `tip`) VALUES
(1, 'stan'),
(2, 'kuca'),
(3, 'garaza'),
(4, 'poslovni prostor');

-- --------------------------------------------------------

--
-- Table structure for table `tip_oglasa`
--

CREATE TABLE `tip_oglasa` (
  `id` int NOT NULL,
  `tip` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tip_oglasa`
--

INSERT INTO `tip_oglasa` (`id`, `tip`) VALUES
(1, 'prodaja'),
(2, 'iznajmljivanje'),
(3, 'kompenzacija');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gradovi`
--
ALTER TABLE `gradovi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nekretnine`
--
ALTER TABLE `nekretnine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gradovi_id` (`gradovi_id`),
  ADD KEY `tip_nekretnine_id` (`tip_nekretnine_id`),
  ADD KEY `tip_oglasa_id` (`tip_oglasa_id`);

--
-- Indexes for table `slike`
--
ALTER TABLE `slike`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nekretnina_id` (`nekretnina_id`);

--
-- Indexes for table `tip_nekretnine`
--
ALTER TABLE `tip_nekretnine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tip_oglasa`
--
ALTER TABLE `tip_oglasa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gradovi`
--
ALTER TABLE `gradovi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `nekretnine`
--
ALTER TABLE `nekretnine`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `slike`
--
ALTER TABLE `slike`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `tip_nekretnine`
--
ALTER TABLE `tip_nekretnine`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tip_oglasa`
--
ALTER TABLE `tip_oglasa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nekretnine`
--
ALTER TABLE `nekretnine`
  ADD CONSTRAINT `nekretnine_ibfk_1` FOREIGN KEY (`gradovi_id`) REFERENCES `gradovi` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  ADD CONSTRAINT `nekretnine_ibfk_2` FOREIGN KEY (`tip_nekretnine_id`) REFERENCES `tip_nekretnine` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  ADD CONSTRAINT `nekretnine_ibfk_3` FOREIGN KEY (`tip_oglasa_id`) REFERENCES `tip_oglasa` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `slike`
--
ALTER TABLE `slike`
  ADD CONSTRAINT `slike_ibfk_1` FOREIGN KEY (`nekretnina_id`) REFERENCES `nekretnine` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
