-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2024 at 12:44 PM
-- Server version: 10.11.6-MariaDB-0+deb12u1
-- PHP Version: 8.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kino`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`Id`, `Name`, `Surname`, `Email`) VALUES
(1, 'Jan', 'Kowalski', 'jan.kowalski@example.com'),
(2, 'Anna', 'Nowak', 'anna.nowak@example.com'),
(3, 'Piotr', 'Wiśniewski', 'piotr.wisniewski@example.com'),
(4, 'Maria', 'Wójcik', 'maria.wojcik@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Title` varchar(30) NOT NULL,
  `Director` varchar(30) NOT NULL,
  `Length` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`Id`, `Title`, `Director`, `Length`) VALUES
(1, 'Die Hard', 'John McTiernan', 132),
(2, 'The Godfather', 'Francis Ford Coppola', 175),
(3, 'Superbad', 'Greg Mottola', 113),
(4, 'The Conjuring', 'James Wan', 112);

-- --------------------------------------------------------

--
-- Table structure for table `film_type`
--

CREATE TABLE `film_type` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `film_type`
--

INSERT INTO `film_type` (`Id`, `Name`) VALUES
(1, 'Akcja'),
(2, 'Dramat'),
(3, 'Komedia'),
(4, 'Horror');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Seat_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`Id`, `Seat_count`) VALUES
(1, 100),
(2, 150),
(3, 120),
(4, 80);

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`Id`, `Name`, `Surname`) VALUES
(1, 'Katarzyna', 'Zielińska'),
(2, 'Michał', 'Lewandowski'),
(3, 'Magdalena', 'Szymańska'),
(4, 'Tomasz', 'Kowalczyk');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Term` datetime DEFAULT NULL,
  `Room_Id` bigint(20) UNSIGNED NOT NULL,
  `Film_Id` bigint(20) UNSIGNED NOT NULL,
  `Empty_seat_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`Id`, `Term`, `Room_Id`, `Film_Id`, `Empty_seat_count`) VALUES
(1, '2024-10-25 18:00:00', 1, 1, 50),
(2, '2024-10-25 20:30:00', 2, 2, 70),
(3, '2024-10-26 19:00:00', 3, 3, 60),
(4, '2024-10-26 21:00:00', 4, 4, 40);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Session_Id` bigint(20) UNSIGNED NOT NULL,
  `Seller_Id` bigint(20) UNSIGNED NOT NULL,
  `Client_Id` bigint(20) UNSIGNED NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`Id`, `Session_Id`, `Seller_Id`, `Client_Id`, `Price`) VALUES
(1, 1, 1, 1, 10),
(2, 2, 2, 2, 15),
(3, 3, 3, 3, 12),
(4, 4, 4, 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `type_film`
--

CREATE TABLE `type_film` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Film_Id` bigint(20) UNSIGNED NOT NULL,
  `Type_Id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type_film`
--

INSERT INTO `type_film` (`Id`, `Film_Id`, `Type_Id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `film_type`
--
ALTER TABLE `film_type`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_session_filmid` (`Film_Id`),
  ADD KEY `fk_session_roomid` (`Room_Id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_tickets_sessionid` (`Session_Id`),
  ADD KEY `fk_tickets_clientid` (`Client_Id`),
  ADD KEY `fk_tickets_sellerid` (`Seller_Id`);

--
-- Indexes for table `type_film`
--
ALTER TABLE `type_film`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_type_film_filmid` (`Film_Id`),
  ADD KEY `fk_type_film_typeid` (`Type_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `film_type`
--
ALTER TABLE `film_type`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `type_film`
--
ALTER TABLE `type_film`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_session_filmid` FOREIGN KEY (`Film_Id`) REFERENCES `films` (`Id`),
  ADD CONSTRAINT `fk_session_roomid` FOREIGN KEY (`Room_Id`) REFERENCES `rooms` (`Id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_tickets_clientid` FOREIGN KEY (`Client_Id`) REFERENCES `clients` (`Id`),
  ADD CONSTRAINT `fk_tickets_sellerid` FOREIGN KEY (`Seller_Id`) REFERENCES `sellers` (`Id`),
  ADD CONSTRAINT `fk_tickets_sessionid` FOREIGN KEY (`Session_Id`) REFERENCES `sessions` (`Id`);

--
-- Constraints for table `type_film`
--
ALTER TABLE `type_film`
  ADD CONSTRAINT `fk_type_film_filmid` FOREIGN KEY (`Film_Id`) REFERENCES `films` (`Id`),
  ADD CONSTRAINT `fk_type_film_typeid` FOREIGN KEY (`Type_Id`) REFERENCES `film_type` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
