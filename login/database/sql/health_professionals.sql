-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 11:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `health_assurance`
--

-- --------------------------------------------------------

--
-- Table structure for table `health_professionals`
--

CREATE TABLE `health_professionals` (
  `id_Hp` bigint(20) NOT NULL,
  `inpe` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `f_name_hp` char(50) NOT NULL,
  `university_degree` char(50) NOT NULL,
  `degree_year` smallint(6) DEFAULT NULL,
  `specialty` char(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_professionals`
--

INSERT INTO `health_professionals` (`id_Hp`, `inpe`, `name`, `f_name_hp`, `university_degree`, `degree_year`, `specialty`, `email`, `type`, `password`) VALUES
(17, 415263748, 'MA', 'nouha', '', NULL, 'pulmonologist', 'ma101@health.ma', 'doctor', 'd41d8cd98f00b204e9800998ecf8427e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `health_professionals`
--
ALTER TABLE `health_professionals`
  ADD PRIMARY KEY (`id_Hp`),
  ADD UNIQUE KEY `inpe` (`inpe`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `health_professionals`
--
ALTER TABLE `health_professionals`
  MODIFY `id_Hp` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
