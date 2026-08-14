-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2026 at 04:51 AM
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
-- Database: `househub`
--

-- --------------------------------------------------------

--
-- Table structure for table `provider_certificates`
--

CREATE TABLE `provider_certificates` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `certificate_name` varchar(100) NOT NULL,
  `issuing_organization` varchar(100) NOT NULL,
  `issue_date` date NOT NULL,
  `certificate_file` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provider_profile`
--

CREATE TABLE `provider_profile` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `certification_name` varchar(500) NOT NULL,
  `certificate_file` varchar(1000) NOT NULL,
  `issuing_organization` varchar(500) NOT NULL,
  `profile-img` varchar(225) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider_profile`
--

INSERT INTO `provider_profile` (`id`, `provider_id`, `certification_name`, `certificate_file`, `issuing_organization`, `profile-img`, `about`) VALUES
(4, 8, 'Mechanical Engineer', 'certificate_8_f8bf4478021e3486.pdf', 'CTEVT', 'provider_8_2647158187c3e09c.jpg', 'I live in Pokhara. And I have skill in Mechanic, ROcket');

-- --------------------------------------------------------

--
-- Table structure for table `provider_services`
--

CREATE TABLE `provider_services` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `service_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider_services`
--

INSERT INTO `provider_services` (`id`, `provider_id`, `service_type_id`) VALUES
(5, 8, 3),
(6, 8, 4),
(4, 8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `provider_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` varchar(10) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_type`
--

CREATE TABLE `service_type` (
  `id` int(11) NOT NULL,
  `service_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_type`
--

INSERT INTO `service_type` (`id`, `service_name`) VALUES
(1, 'Electrician'),
(2, 'Plumber'),
(3, 'Networking Service Provider'),
(4, 'Washing Machine Repairer'),
(5, 'Painter'),
(6, 'Carpenter'),
(7, 'Automobile Mechanic');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `country` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `role` varchar(500) NOT NULL,
  `city` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `country`, `gender`, `role`, `city`) VALUES
(7, 'Raj Tamang', 'raj@gmail.com', '$2y$10$XHzW1295jYse5YVHmgGTqexG2l.DSEYvZ6Li1vXc8VZW.nfuF0t6.', '', 'Male', 'customer', 'Kathmandu'),
(8, 'Ganga Gurung', 'sonima@gmail.com', '$2y$10$gr88LjndVJRmnMIf1ZUd..mG/t0l.08ZMPxjQIQ4rPAt.IrTDNNr6', '', 'Female', 'provider', 'Pokhara');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `provider_certificates`
--
ALTER TABLE `provider_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider_profile`
--
ALTER TABLE `provider_profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_provider_profile` (`provider_id`);

--
-- Indexes for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_provider_service` (`provider_id`,`service_type_id`),
  ADD KEY `fk_provider_services_service` (`service_type_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_type`
--
ALTER TABLE `service_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `provider_certificates`
--
ALTER TABLE `provider_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provider_profile`
--
ALTER TABLE `provider_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `provider_services`
--
ALTER TABLE `provider_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_type`
--
ALTER TABLE `service_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `provider_profile`
--
ALTER TABLE `provider_profile`
  ADD CONSTRAINT `provider_id` FOREIGN KEY (`provider_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD CONSTRAINT `fk_provider_services_provider` FOREIGN KEY (`provider_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_provider_services_service` FOREIGN KEY (`service_type_id`) REFERENCES `service_type` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
