-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 12:07 AM
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
-- Table structure for table `acte`
--

CREATE TABLE `acte` (
  `id` int(11) NOT NULL,
  `id_hp` bigint(20) DEFAULT NULL,
  `id_doss` int(11) DEFAULT NULL,
  `code_acts` varchar(255) DEFAULT NULL,
  `date` date DEFAULT curdate(),
  `prix` int(20) NOT NULL,
  `id_etab` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acte`
--

INSERT INTO `acte` (`id`, `id_hp`, `id_doss`, `code_acts`, `date`, `prix`, `id_etab`) VALUES
(8, 26, 17, 'consutation', '2025-05-19', 0, 0),
(9, 26, 19, 'consutation', '2025-05-19', 0, 0),
(10, 26, 20, 'consutation', '2025-05-19', 0, 0),
(11, 26, 16, 'consutation', '2025-05-19', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ana_rad`
--

CREATE TABLE `ana_rad` (
  `id` int(11) NOT NULL,
  `id_doss` int(11) DEFAULT NULL,
  `id_hp` bigint(20) DEFAULT NULL,
  `date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assurance`
--

CREATE TABLE `assurance` (
  `id` bigint(20) NOT NULL,
  `patente_assu` bigint(20) DEFAULT NULL,
  `name` char(50) NOT NULL,
  `prv_pub_assu` tinyint(1) NOT NULL,
  `tele_assu` bigint(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile_pic` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assurance`
--

INSERT INTO `assurance` (`id`, `patente_assu`, `name`, `prv_pub_assu`, `tele_assu`, `email`, `password`, `profile_pic`) VALUES
(9, 555555555, 'assu', 0, 212555555555, 'assu362@health.ma', 'd2dd35c38e36c1a4dc701cb26b578e86', '1747600523_test2.png');

-- --------------------------------------------------------

--
-- Table structure for table `assure`
--

CREATE TABLE `assure` (
  `id` bigint(20) NOT NULL,
  `CIN_as` char(8) NOT NULL,
  `RIB_as` bigint(20) NOT NULL,
  `id_assurance` bigint(20) NOT NULL,
  `N_immatriculation_assure` bigint(20) NOT NULL,
  `name` char(50) NOT NULL,
  `prenom_as` char(50) NOT NULL,
  `salaire_as` decimal(20,2) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assure`
--

INSERT INTO `assure` (`id`, `CIN_as`, `RIB_as`, `id_assurance`, `N_immatriculation_assure`, `name`, `prenom_as`, `salaire_as`, `email`, `password`) VALUES
(25, '1452dd3', 14145252, 9, 1747599026209330, '', 'client', 400000.00, '', 'd41d8cd98f00b204e9800998ecf8427e'),
(26, '45555555', 4152, 9, 1747682774180183, 'client', 'client', 400000.00, 'client599@health.ma', 'd2dd35c38e36c1a4dc701cb26b578e86');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaire`
--

CREATE TABLE `beneficiaire` (
  `id` bigint(20) NOT NULL,
  `cin_ben` char(8) DEFAULT NULL,
  `f_name` char(50) NOT NULL,
  `l_name` char(50) NOT NULL,
  `adresse` varchar(120) NOT NULL,
  `birth` date NOT NULL,
  `chronic` tinyint(1) NOT NULL,
  `chronic1` varchar(50) NOT NULL,
  `chronic2` varchar(50) DEFAULT NULL,
  `chronic3` varchar(50) DEFAULT NULL,
  `id_as` bigint(20) NOT NULL,
  `relation` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beneficiaire`
--

INSERT INTO `beneficiaire` (`id`, `cin_ben`, `f_name`, `l_name`, `adresse`, `birth`, `chronic`, `chronic1`, `chronic2`, `chronic3`, `id_as`, `relation`) VALUES
(21, '4111163', 'benifi', 'benifi', '', '2002-12-02', 0, 'Cardiopathy', NULL, NULL, 25, 'Child'),
(22, '', 'benif2', 'benif2', '', '2020-12-03', 0, 'Hypertension', NULL, NULL, 25, 'Spouse');

-- --------------------------------------------------------

--
-- Table structure for table `dossier`
--

CREATE TABLE `dossier` (
  `id` int(11) NOT NULL,
  `id_etab` bigint(20) NOT NULL,
  `id_benef` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `status` enum('pending','reimbursed','refused') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dossier`
--

INSERT INTO `dossier` (`id`, `id_etab`, `id_benef`, `date`, `status`) VALUES
(16, 20, 22, '2025-05-19', 'reimbursed'),
(17, 20, 21, '2025-05-19', 'reimbursed'),
(18, 20, 22, '2025-05-19', 'pending'),
(19, 20, 21, '2025-05-19', 'pending'),
(20, 20, 21, '2025-05-19', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `dossier_hp`
--

CREATE TABLE `dossier_hp` (
  `id_doss` int(11) NOT NULL,
  `id_hp` bigint(20) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dossier_hp`
--

INSERT INTO `dossier_hp` (`id_doss`, `id_hp`, `role`) VALUES
(16, 26, NULL),
(17, 26, NULL),
(17, 28, NULL),
(18, 28, NULL),
(19, 26, NULL),
(19, 28, NULL),
(20, 26, NULL),
(20, 28, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employe`
--

CREATE TABLE `employe` (
  `id` int(11) NOT NULL,
  `id_etab` bigint(20) NOT NULL,
  `id_Hp` bigint(20) NOT NULL,
  `joined_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employe`
--

INSERT INTO `employe` (`id`, `id_etab`, `id_Hp`, `joined_at`) VALUES
(1, 20, 26, '2025-05-19 08:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `etablissement`
--

CREATE TABLE `etablissement` (
  `id` bigint(20) NOT NULL,
  `inpe_etab` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pub_prv_etab` tinyint(1) NOT NULL,
  `type_etab` varchar(50) NOT NULL,
  `tele_etab` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile_pic` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `etablissement`
--

INSERT INTO `etablissement` (`id`, `inpe_etab`, `name`, `pub_prv_etab`, `type_etab`, `tele_etab`, `email`, `password`, `profile_pic`) VALUES
(20, 444444444, 'hopital', 0, 'diagnostic', '+212666666666', 'hopital845@health.ma', 'd2dd35c38e36c1a4dc701cb26b578e86', '1747601447_746814.png'),
(23, 666666666, 'hopital', 0, 'clinic', '+212666665855', 'hopital434@health.ma', 'd2dd35c38e36c1a4dc701cb26b578e86', '');

-- --------------------------------------------------------

--
-- Table structure for table `etablissement_servi`
--

CREATE TABLE `etablissement_servi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_doss` int(11) NOT NULL,
  `service` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `health_professionals`
--

CREATE TABLE `health_professionals` (
  `id` bigint(20) NOT NULL,
  `inpe` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `f_name_hp` char(50) NOT NULL,
  `university_degree` char(50) NOT NULL,
  `degree_year` smallint(6) DEFAULT NULL,
  `specialty` char(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile_pic` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_professionals`
--

INSERT INTO `health_professionals` (`id`, `inpe`, `name`, `f_name_hp`, `university_degree`, `degree_year`, `specialty`, `email`, `type`, `password`, `profile_pic`) VALUES
(26, 111111111, 'doc', 'doc', '', NULL, 'cardiologist', 'doc683@health.ma', 'doctor', 'd2dd35c38e36c1a4dc701cb26b578e86', '1747636557_6069174.png'),
(27, 222222222, 'BRI', 'BRI', '', NULL, 'radiology', 'bri281@health.ma', 'BRI', 'd2dd35c38e36c1a4dc701cb26b578e86', ''),
(28, 333333333, 'pharma', 'pharmacy', '', NULL, 'clinical-pharmacy', 'pharma486@health.ma', 'pharmacy', 'd2dd35c38e36c1a4dc701cb26b578e86', '1747636904_images__1_.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `id` bigint(20) NOT NULL,
  `id_etab` bigint(20) NOT NULL,
  `id_Hp` bigint(20) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invitations`
--

INSERT INTO `invitations` (`id`, `id_etab`, `id_Hp`, `status`, `created_at`, `updated_at`, `message`) VALUES
(21, 16, 17, 'pending', '2025-05-15 20:53:17', '2025-05-15 20:53:17', 'hello'),
(22, 12, 25, 'pending', '2025-05-18 16:50:53', '2025-05-18 16:50:53', 'hello'),
(23, 20, 26, 'accepted', '2025-05-18 22:15:50', '2025-05-19 07:53:38', '');

-- --------------------------------------------------------

--
-- Table structure for table `ordonnance`
--

CREATE TABLE `ordonnance` (
  `id` int(11) NOT NULL,
  `id_doss` int(11) NOT NULL,
  `id_hp` bigint(20) NOT NULL,
  `date_ordonnance` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordonnance`
--

INSERT INTO `ordonnance` (`id`, `id_doss`, `id_hp`, `date_ordonnance`) VALUES
(15, 17, 26, '2025-05-19 15:10:49'),
(16, 19, 26, '2025-05-19 15:11:24'),
(17, 20, 26, '2025-05-19 15:11:51'),
(18, 20, 26, '2025-05-19 15:12:16'),
(19, 16, 26, '2025-05-19 15:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `ordonnance_details`
--

CREATE TABLE `ordonnance_details` (
  `id` int(11) NOT NULL,
  `ordonnance_id` int(11) NOT NULL,
  `medicament` varchar(255) NOT NULL,
  `dose` varchar(50) NOT NULL,
  `unite` varchar(50) NOT NULL,
  `recommendation` text DEFAULT NULL,
  `prix` int(20) NOT NULL,
  `id_hp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordonnance_details`
--

INSERT INTO `ordonnance_details` (`id`, `ordonnance_id`, `medicament`, `dose`, `unite`, `recommendation`, `prix`, `id_hp`) VALUES
(40, 15, 'hello', '20', 'mg', 'matin', 40, 28),
(41, 15, 'dolpipranne', '20', 'mg', 'matin', 200, 28),
(42, 15, 'hello', '20', 'mg', 'matin', 40, 28),
(43, 15, 'hello', '20', 'mg', 'matin', 40, 28),
(44, 15, 'hello', '20', 'mg', 'matin', 40, 28),
(45, 16, 'hello', '20', 'mg', 'matin', 0, 0),
(46, 16, 'hello', '20', 'mg', 'matin', 0, 0),
(47, 16, 'hello', '20', 'mg', 'matin', 0, 0),
(48, 16, 'hello', '20', 'mg', 'matin', 0, 0),
(49, 16, 'hello', '20', 'mg', 'matin', 0, 0),
(50, 17, 'hello', '20', 'mg', 'matin', 50, 28),
(51, 17, 'hello', '20', 'mg', 'matin', 50, 28),
(52, 17, 'hello', '20', 'g', 'matin', 50, 28),
(53, 17, 'hello', '20', 'mg', 'matin', 50, 28),
(54, 18, 'hello', '20', 'mg', 'matin', 15, 28),
(55, 18, 'hello', '20', 'mg', 'matin', 15, 28),
(56, 18, 'hello', '20', 'g', 'matin', 15, 28),
(57, 18, 'hello', '20', 'g', 'matin', 15, 28),
(58, 19, 'hello', '20', 'g', 'matin', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `name`, `email`, `password`, `profile_pic`) VALUES
(16, 'admin', 'admin626@health.ma', 'd2dd35c38e36c1a4dc701cb26b578e86', '1747656308_profile_pic.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acte`
--
ALTER TABLE `acte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_hp` (`id_hp`),
  ADD KEY `fk_id_doss` (`id_doss`);

--
-- Indexes for table `ana_rad`
--
ALTER TABLE `ana_rad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_analyse_doss` (`id_doss`),
  ADD KEY `fk_analyse_hp` (`id_hp`);

--
-- Indexes for table `assurance`
--
ALTER TABLE `assurance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tele_assu` (`tele_assu`),
  ADD UNIQUE KEY `email_assu` (`email`),
  ADD UNIQUE KEY `patente_assu` (`patente_assu`);

--
-- Indexes for table `assure`
--
ALTER TABLE `assure`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CIN_as` (`CIN_as`),
  ADD UNIQUE KEY `RIB_as` (`RIB_as`),
  ADD UNIQUE KEY `N_immatriculation_assure` (`N_immatriculation_assure`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_assure_assurance` (`id_assurance`);

--
-- Indexes for table `beneficiaire`
--
ALTER TABLE `beneficiaire`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cin_ben` (`cin_ben`),
  ADD KEY `beneficiaire_ibfk_1` (`id_as`);

--
-- Indexes for table `dossier`
--
ALTER TABLE `dossier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_etab` (`id_etab`),
  ADD KEY `id_benef` (`id_benef`);

--
-- Indexes for table `dossier_hp`
--
ALTER TABLE `dossier_hp`
  ADD PRIMARY KEY (`id_doss`,`id_hp`),
  ADD KEY `id_hp` (`id_hp`);

--
-- Indexes for table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_etab` (`id_etab`),
  ADD KEY `id_Hp` (`id_Hp`);

--
-- Indexes for table `etablissement`
--
ALTER TABLE `etablissement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inpe_etab` (`inpe_etab`),
  ADD UNIQUE KEY `tele_etab` (`tele_etab`),
  ADD UNIQUE KEY `email_etab` (`email`);

--
-- Indexes for table `etablissement_servi`
--
ALTER TABLE `etablissement_servi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_doss` (`id_doss`);

--
-- Indexes for table `health_professionals`
--
ALTER TABLE `health_professionals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inpe` (`inpe`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_institution_inv` (`id_etab`),
  ADD KEY `fk_user_inv` (`id_Hp`);

--
-- Indexes for table `ordonnance`
--
ALTER TABLE `ordonnance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordonnance_id_hp` (`id_hp`),
  ADD KEY `ordonnance_ibfk_1` (`id_doss`);

--
-- Indexes for table `ordonnance_details`
--
ALTER TABLE `ordonnance_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordonnance_id` (`ordonnance_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_mail` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acte`
--
ALTER TABLE `acte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ana_rad`
--
ALTER TABLE `ana_rad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `assurance`
--
ALTER TABLE `assurance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `assure`
--
ALTER TABLE `assure`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `beneficiaire`
--
ALTER TABLE `beneficiaire`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `dossier`
--
ALTER TABLE `dossier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `employe`
--
ALTER TABLE `employe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `etablissement`
--
ALTER TABLE `etablissement`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `etablissement_servi`
--
ALTER TABLE `etablissement_servi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `health_professionals`
--
ALTER TABLE `health_professionals`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ordonnance`
--
ALTER TABLE `ordonnance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ordonnance_details`
--
ALTER TABLE `ordonnance_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acte`
--
ALTER TABLE `acte`
  ADD CONSTRAINT `fk_id_doss` FOREIGN KEY (`id_doss`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `fk_id_hp` FOREIGN KEY (`id_hp`) REFERENCES `health_professionals` (`id`);

--
-- Constraints for table `ana_rad`
--
ALTER TABLE `ana_rad`
  ADD CONSTRAINT `fk_analyse_doss` FOREIGN KEY (`id_doss`) REFERENCES `dossier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_analyse_hp` FOREIGN KEY (`id_hp`) REFERENCES `health_professionals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assure`
--
ALTER TABLE `assure`
  ADD CONSTRAINT `fk_assure_assurance` FOREIGN KEY (`id_assurance`) REFERENCES `assurance` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `beneficiaire`
--
ALTER TABLE `beneficiaire`
  ADD CONSTRAINT `beneficiaire_ibfk_1` FOREIGN KEY (`id_as`) REFERENCES `assure` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dossier`
--
ALTER TABLE `dossier`
  ADD CONSTRAINT `fk_dossier_beneficiaire` FOREIGN KEY (`id_benef`) REFERENCES `beneficiaire` (`id`);

--
-- Constraints for table `dossier_hp`
--
ALTER TABLE `dossier_hp`
  ADD CONSTRAINT `dossier_hp_ibfk_1` FOREIGN KEY (`id_doss`) REFERENCES `dossier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossier_hp_ibfk_2` FOREIGN KEY (`id_hp`) REFERENCES `health_professionals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`id_etab`) REFERENCES `etablissement` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employe_ibfk_2` FOREIGN KEY (`id_Hp`) REFERENCES `health_professionals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `etablissement_servi`
--
ALTER TABLE `etablissement_servi`
  ADD CONSTRAINT `etablissement_servi_ibfk_1` FOREIGN KEY (`id_doss`) REFERENCES `dossier` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ordonnance`
--
ALTER TABLE `ordonnance`
  ADD CONSTRAINT `fk_ordonnance_id_hp` FOREIGN KEY (`id_hp`) REFERENCES `health_professionals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ordonnance_ibfk_1` FOREIGN KEY (`id_doss`) REFERENCES `dossier` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ordonnance_details`
--
ALTER TABLE `ordonnance_details`
  ADD CONSTRAINT `ordonnance_details_ibfk_1` FOREIGN KEY (`ordonnance_id`) REFERENCES `ordonnance` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
