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
-- Table structure for table `etablissement`
--

CREATE TABLE `etablissement` (
  `id_etab` bigint(20) NOT NULL,
  `inpe_etab` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pub_prv_etab` tinyint(1) NOT NULL,
  `type_etab` varchar(50) NOT NULL,
  `codep_etab` bigint(20) NOT NULL,
  `dele_etab` varchar(50) NOT NULL,
  `com_etab` varchar(50) NOT NULL,
  `reg_etab` varchar(50) NOT NULL,
  `adr_etab` varchar(120) DEFAULT NULL,
  `tele_etab` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `etablissement`
--

INSERT INTO `etablissement` (`id_etab`, `inpe_etab`, `name`, `pub_prv_etab`, `type_etab`, `codep_etab`, `dele_etab`, `com_etab`, `reg_etab`, `adr_etab`, `tele_etab`, `email`, `password`) VALUES
(12, 425914362, 'nouha', 0, 'lab', 0, '', '', '', NULL, '+212 614528495', 'nouha710@health.ma', 'd41d8cd98f00b204e9800998ecf8427e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etablissement`
--
ALTER TABLE `etablissement`
  ADD PRIMARY KEY (`id_etab`),
  ADD UNIQUE KEY `inpe_etab` (`inpe_etab`),
  ADD UNIQUE KEY `adr_etab` (`adr_etab`),
  ADD UNIQUE KEY `tele_etab` (`tele_etab`),
  ADD UNIQUE KEY `email_etab` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etablissement`
--
ALTER TABLE `etablissement`
  MODIFY `id_etab` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
