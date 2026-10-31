-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2026 at 06:47 AM
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
-- Database: `library_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'kamal', 'k@gmail.com', 'hello', '2026-10-27 13:12:35'),
(2, 'amna', 'a@gmail.com', 'Hello', '2026-10-27 13:28:48'),
(3, 'amna', 'amna@gmail.com', 'Hello', '2026-10-27 13:34:00'),
(4, 'amna', 'ab@gmail.com', 'hii', '2026-10-27 15:32:17'),
(5, 'KAML', 'kam@gmail.com', 'helooo', '2026-10-30 06:51:36'),
(6, 'KML', 'kml@gmail.com', 'helloo', '2026-10-30 07:24:13'),
(7, 'Asna', 'asna@gmail.com', 'hiiiii how are you', '2026-10-30 10:19:39'),
(8, 'ASNA', 'asn@gmail.com', 'hellllloooo', '2026-10-30 10:31:28'),
(9, 'NIMAL', 'n@gmail.com', 'heloooooooooo', '2026-10-30 10:39:32'),
(10, 'HASNA', 'hasna1@gmail.com', 'hellooooooooo', '2026-10-30 18:06:36'),
(11, 'ASHIF', 'ashif@gmail.com', 'helooooooooooo', '2026-10-30 18:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `name`, `email`, `phone`, `created_at`) VALUES
(10, 'ZARA', 'zara@gmail.com', '0760000000', '2026-10-30 06:05:27'),
(14, 'HAMNA', 'hamna@mail.com', '0767900000', '2026-10-30 10:34:22'),
(15, 'KAMAL', 'kamal@gmail.com', '0761212123', '2026-10-30 10:34:42'),
(17, 'NIMAL', 'n3@gmail.com', '0789999991', '2026-10-30 17:57:48'),
(18, 'AMNA', 'amna@gmail.com', '0768888888', '2026-10-30 17:58:11'),
(20, 'HASNA', 'hasna1@gmail.com', '0768989899', '2026-10-30 18:06:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'ADMIN', 'admin@library.com', '$2y$10$Ly184SJrREvVDqMXatnoguWiYHT0z1agPFRi5Zh0f5bnSICAxg6Ti', 'admin'),
(2, 'USER', 'user@library.com', '$2y$10$AwFgYWY.0wONXA6CijwWgen/TVm6tZU9wgIOQdyEunJEhpAdPW9kO', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
