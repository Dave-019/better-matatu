-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 04:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safiri_salama`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `sacco_id` int(11) DEFAULT NULL,
  `safety_score` int(11) DEFAULT 100 CHECK (`safety_score` between 0 and 100),
  `violation_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `phone`, `license_number`, `sacco_id`, `safety_score`, `violation_count`, `created_at`, `updated_at`) VALUES
(1, 'Kevin Omondi', '0745678901', 'DL12345', 1, 85, 2, '2025-02-12 05:47:35', '2025-02-12 05:47:35'),
(2, 'Lucy Wanjiru', '0756789012', 'DL67890', 2, 95, 0, '2025-02-12 05:47:35', '2025-02-12 05:47:35'),
(3, 'Peter Kamau', '0767890123', 'DL54321', 1, 70, 5, '2025-02-12 05:47:35', '2025-02-12 05:47:35'),
(4, 'john ian', '09457', 'Dlowd', 2, 45, 0, '2025-02-20 10:59:00', '2025-02-20 10:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `fares`
--

CREATE TABLE `fares` (
  `id` int(11) NOT NULL,
  `route_number` varchar(10) NOT NULL,
  `standard_fare` decimal(6,2) NOT NULL,
  `peak_fare` decimal(6,2) NOT NULL,
  `off_peak_fare` decimal(6,2) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fares`
--

INSERT INTO `fares` (`id`, `route_number`, `standard_fare`, `peak_fare`, `off_peak_fare`, `last_updated`) VALUES
(1, '001', 100.00, 120.00, 80.00, '2025-02-12 05:45:45'),
(2, '002', 150.00, 180.00, 130.00, '2025-02-12 05:45:45'),
(3, '003', 200.00, 250.00, 170.00, '2025-02-12 05:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL,
  `passenger_id` int(11) DEFAULT NULL,
  `matatu_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `violation_type` text NOT NULL,
  `description` text NOT NULL,
  `details` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `status` enum('pending','reviewed','resolved') DEFAULT 'pending',
  `reported_by` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`id`, `passenger_id`, `matatu_id`, `driver_id`, `violation_type`, `description`, `details`, `timestamp`, `status`, `reported_by`, `image_path`, `location`) VALUES
(9, 1, 3, NULL, '', 'moderate', 'ewde', '2025-02-20 07:16:16', 'pending', NULL, '../images/WIN_20241103_19_22_33_Pro.jpg', 'sss'),
(10, 1, 3, NULL, '', 'moderate', 'eeeee', '2025-02-20 07:17:55', 'pending', NULL, 'images/WIN_20241103_19_22_37_Pro.jpg', 'sss'),
(11, 1, 3, NULL, '', 'severe', 'qwdqwdw', '2025-02-20 07:20:09', 'pending', NULL, 'images/overcrowedd.jpg', 'sss'),
(12, 1, 3, NULL, '', 'minor', 'qdq', '2025-02-20 07:20:24', 'pending', NULL, 'images/github repo image.jpg', 'sss4'),
(13, 1, 3, NULL, '', 'moderate', 'qadsada', '2025-02-20 07:20:56', 'pending', NULL, 'images/web hosting image.jpg', 'k42'),
(14, 1, 3, 3, '', 'moderate', 'qadsada', '2025-02-20 07:26:05', 'pending', NULL, 'images/web hosting image.jpg', 'k42'),
(15, 1, 3, 3, '', 'moderate', 'wqwqwqw', '2025-02-20 07:26:15', 'pending', NULL, 'images/github repo image.jpg', 'k42'),
(16, 1, 3, 3, '', 'severe', 'qwqwqw', '2025-02-20 07:27:08', 'pending', NULL, 'images/overcrowedd.jpg', 'k4234'),
(17, 1, 3, 3, '', 'severe', 'qwqwqw', '2025-02-20 07:30:25', 'pending', NULL, 'images/overcrowedd.jpg', 'k4234'),
(18, 1, 3, 3, '', 'severe', 'qwqwqw', '2025-02-20 07:30:49', 'pending', NULL, 'images/overcrowedd.jpg', 'k4234'),
(19, 1, 3, 3, '', 'moderate', 'dfgfgdfgdfg', '2025-02-20 07:40:12', 'pending', NULL, 'images/report not serious.jpg', 'dfdfgdfgdfg'),
(20, 1, 3, 3, ' 7edfsdsidfh', 'moderate', 'dfgfgdfgdfg', '2025-02-20 07:44:38', 'pending', NULL, 'images/report not serious.jpg', 'dfdfgdfgdfg'),
(21, 1, 3, 3, 'tttftftf', 'moderate', 'sesesedfce4er', '2025-02-20 07:44:57', 'pending', NULL, 'images/github repo image.jpg', 'dfdfgdfgdfg'),
(22, 1, 3, 3, 'cwerc', 'severe', 'wewetbe', '2025-02-20 07:46:26', 'pending', NULL, 'images/overcrowedd.jpg', 'bwetbqea'),
(25, 13, 4, 4, 'wewerr', 'moderate', 'werwerr', '2025-02-20 12:44:23', 'pending', NULL, 'images/overcrowedd.jpg', 'kiambu'),
(26, 13, 4, 4, 'werwer', 'moderate', 'qweqwe', '2025-02-20 12:48:49', 'pending', NULL, 'images/overcrowedd.jpg', 'kiambu'),
(27, 13, 4, 4, 'akaka', 'minor', 'aaa', '2025-02-20 12:50:57', 'pending', NULL, 'images/github repo image.jpg', 'kiambu'),
(28, 13, 4, 4, 'wewerr', 'moderate', 'werwerr', '2025-02-20 12:54:45', 'pending', NULL, 'images/overcrowedd.jpg', 'kiambu');

-- --------------------------------------------------------

--
-- Table structure for table `matatus`
--

CREATE TABLE `matatus` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `route_number` varchar(10) NOT NULL,
  `seat_capacity` int(11) NOT NULL,
  `sacco_id` int(11) DEFAULT NULL,
  `status` enum('active','under_maintenance','suspended') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reg_num` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matatus`
--

INSERT INTO `matatus` (`id`, `driver_id`, `route_number`, `seat_capacity`, `sacco_id`, `status`, `created_at`, `updated_at`, `reg_num`) VALUES
(1, 1, '105', 14, 1, 'active', '2025-02-16 06:35:28', '2025-02-16 06:35:28', 'KDA 123A'),
(2, 2, '23', 14, 2, 'active', '2025-02-16 06:35:28', '2025-02-16 06:35:28', 'KBC 456B'),
(3, 3, '34B', 33, 3, 'active', '2025-02-16 06:35:28', '2025-02-16 06:35:28', 'KAA 789C'),
(4, 4, '004', 13, 1, 'suspended', '2025-02-20 10:59:59', '2025-02-20 10:59:59', 'KDK 301');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `frequent_routes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`frequent_routes`)),
  `emergency_contact` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`id`, `phone`, `frequent_routes`, `emergency_contact`, `created_at`) VALUES
(13, '09457', '12123', '078', '2025-02-20 11:42:15'),
(14, '09457w', '122', '078', '2025-02-20 11:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `matatu_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `passenger_id`, `matatu_id`, `driver_id`, `rating`, `comment`, `timestamp`) VALUES
(1, 1, 1, 1, 4, 'Good service but could be better.', '2023-10-10 10:00:00'),
(2, 2, 2, 2, 5, 'Excellent service and driver.', '2023-10-11 11:00:00'),
(3, 3, 3, 3, 3, 'Decent service, but the matatu was a bit crowded.', '2023-10-12 12:00:00'),
(4, 1, 2, 2, 4, 'Driver was friendly and the ride was smooth.', '2023-10-13 10:00:00'),
(5, 2, 1, 1, 5, 'Great experience overall!', '2023-10-14 11:00:00'),
(6, 3, 2, 2, 2, 'Service was slow and the driver was not helpful.', '2023-10-15 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE `rides` (
  `id` int(11) NOT NULL,
  `matatu_id` int(11) DEFAULT NULL,
  `start_location` varchar(255) NOT NULL,
  `end_location` varchar(255) NOT NULL,
  `passenger_count` int(11) NOT NULL,
  `fare` decimal(6,2) NOT NULL,
  `start_time` datetime DEFAULT current_timestamp(),
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sacco_cooperatives`
--

CREATE TABLE `sacco_cooperatives` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `route_license` varchar(50) NOT NULL,
  `penalty_points` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sacco_cooperatives`
--

INSERT INTO `sacco_cooperatives` (`id`, `name`, `route_license`, `penalty_points`, `created_at`) VALUES
(1, 'City Express Sacco', 'RL-001', 3, '2025-02-12 05:47:03'),
(2, 'Metro Shuttle', 'RL-002', 1, '2025-02-12 05:47:03'),
(3, 'Highway Travelers', 'RL-003', 5, '2025-02-12 05:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `safety_checks`
--

CREATE TABLE `safety_checks` (
  `id` int(11) NOT NULL,
  `matatu_id` int(11) DEFAULT NULL,
  `inspection_date` date NOT NULL,
  `brakes_status` enum('good','fair','poor') NOT NULL,
  `tire_health` enum('good','fair','poor') NOT NULL,
  `lights_status` enum('working','faulty') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `safety_checks`
--

INSERT INTO `safety_checks` (`id`, `matatu_id`, `inspection_date`, `brakes_status`, `tire_health`, `lights_status`) VALUES
(1, 1, '2025-02-01', 'good', 'fair', 'working'),
(2, 2, '2025-02-05', 'fair', 'good', 'working'),
(3, 3, '2025-02-10', 'poor', 'poor', 'faulty'),
(4, 4, '0000-00-00', 'poor', 'fair', 'working');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('super_admin','sacco_admin','passenger') DEFAULT 'passenger',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sacco_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password_hash`, `role`, `created_at`, `updated_at`, `sacco_id`) VALUES
(13, 'test_user@gmail.com', 'test_user@gmail.com', '0712981502', '$2y$10$rMya9hcWNzk/.ZKZBpe6reYBtnUc8abqp6yXHbgLHcSiW3zLfHZhm', 'passenger', '2025-02-20 11:37:51', '2025-02-20 11:37:51', NULL),
(14, 'test_user1@gmail.com', 'test_user1@gmail.com', '0712981502', '$2y$10$HACNXQrIW/WhdbnMvRfmP.UDJE1Hx8KAr39jdfOkrfPh8K.fVtV8u', 'passenger', '2025-02-20 11:56:21', '2025-02-20 11:56:21', NULL),
(15, 'admin', 'admin@gmail.com', '0712981502', '$2y$10$eRTNxuqqbCtt1Ay0dLcAlOtC9V40hnyPW2noQmkVoGMcbLDonr2CS', 'sacco_admin', '2025-02-20 12:05:03', '2025-02-20 12:05:03', NULL),
(16, 'admin', 'admin1@gmail.com', '0712981502', '$2y$10$Gh65c2bPJqy7p8aQ8MDHTeJzwoZmvzT.qxZS2OmA7tfEJXi/sQ2cu', 'sacco_admin', '2025-02-21 05:21:22', '2025-02-21 05:21:22', NULL);

CREATE TABLE `incident_updates` (
  `id` int(11) NOT NULL,
  `incident_id` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` enum('pending','reviewed','resolved') NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incident_updates`
--

INSERT INTO `incident_updates` (`id`, `incident_id`, `updated_by`, `status`, `comment`, `created_at`) VALUES
(1, 18, 20, 'reviewed', 'the driver was suspended', '2025-03-07 14:27:46'),
(2, 18, 20, 'reviewed', '', '2025-03-07 14:33:12'),
(3, 18, 20, 'resolved', '', '2025-03-07 14:35:32'),
(4, 18, 20, 'pending', '', '2025-03-07 14:35:38'),
(5, 18, 20, 'reviewed', 'the report is recievesd and driver with face the legal action', '2025-03-07 14:37:32');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `license_number` (`license_number`),
  ADD KEY `sacco_id` (`sacco_id`);

--
-- Indexes for table `fares`
--
ALTER TABLE `fares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passenger_id` (`passenger_id`),
  ADD KEY `matatu_id` (`matatu_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `reported_by` (`reported_by`);

--
-- Indexes for table `matatus`
--
ALTER TABLE `matatus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `sacco_id` (`sacco_id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passenger_id` (`passenger_id`),
  ADD KEY `matatu_id` (`matatu_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matatu_id` (`matatu_id`);

--
-- Indexes for table `sacco_cooperatives`
--
ALTER TABLE `sacco_cooperatives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `safety_checks`
--
ALTER TABLE `safety_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matatu_id` (`matatu_id`);

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
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fares`
--
ALTER TABLE `fares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `matatus`
--
ALTER TABLE `matatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sacco_cooperatives`
--
ALTER TABLE `sacco_cooperatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `safety_checks`
--
ALTER TABLE `safety_checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_ibfk_1` FOREIGN KEY (`sacco_id`) REFERENCES `sacco_cooperatives` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `incidents_ibfk_1` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`id`),
  ADD CONSTRAINT `incidents_ibfk_2` FOREIGN KEY (`matatu_id`) REFERENCES `matatus` (`id`),
  ADD CONSTRAINT `incidents_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
  ADD CONSTRAINT `incidents_ibfk_4` FOREIGN KEY (`reported_by`) REFERENCES `admin_users` (`id`);

--
-- Constraints for table `matatus`
--
ALTER TABLE `matatus`
  ADD CONSTRAINT `matatus_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `matatus_ibfk_2` FOREIGN KEY (`sacco_id`) REFERENCES `sacco_cooperatives` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`matatu_id`) REFERENCES `matatus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rides`
--
ALTER TABLE `rides`
  ADD CONSTRAINT `rides_ibfk_1` FOREIGN KEY (`matatu_id`) REFERENCES `matatus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `safety_checks`
--
ALTER TABLE `safety_checks`
  ADD CONSTRAINT `safety_checks_ibfk_1` FOREIGN KEY (`matatu_id`) REFERENCES `matatus` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
