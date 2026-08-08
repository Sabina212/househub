-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2026 at 12:22 PM
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
  `username` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `address` varchar(225) NOT NULL,
  `phone` varchar(225) NOT NULL,
  `about` text NOT NULL,
  `profile_img` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider_profile`
--

INSERT INTO `provider_profile` (`id`, `username`, `profession`, `address`, `phone`, `about`, `profile_img`) VALUES
(1, 'Ramesh', 'Internet and Wifi setup', 'kalanki', '9841326880', 'first try', 'bts.jfif'),
(2, 'Laxman', 'Home Renovation', 'sitapaila', '9845612300', 'second try', 'figma.png'),
(3, 'Ramesh', '', 'kalanki', '9841326880', 'hi this is my first time ', 'bts.jfif');

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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `country` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `country`, `gender`) VALUES
(1, '0', '0', '0', '0', '0'),
(2, 'Admin', 'Xyz@gmail.com', '$2y$10$DP3KMUXfHPK4oZ0nxvTjyeu0pt8/YltZFvoiFCU1CyGVtaR3bwKBi', 'Nepal', 'Female'),
(3, 'Ram', 'Ram@gmail.com', 'Admin@123', 'Nepal', 'Male'),
(4, 'Sita', 'Sita@gmail.com', 'Sita@1234', 'Nepal', 'Female'),
(5, 'Laxman', 'Laxman@gmail.com', 'Abc@1234', 'Nepal', 'Male'),
(6, 'Meghumi', 'Meghumi@gmail.com', '$2y$10$kPpslWjccW42FWU1fTXgp.zGfV6.n6g29UwyWg7NTY55FGX6ITOU6', 'Nepal', 'Female');

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
