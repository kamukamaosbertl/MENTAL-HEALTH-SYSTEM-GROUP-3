-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 06:48 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mentalhealthsupportsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `problem` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `name`, `location`, `phone`, `email`, `service_id`, `booking_date`, `problem`, `gender`, `picture`) VALUES
(1, NULL, 'TINDYEBWA IGNATIOUS', 'Mbarara City', '0762560175', '', NULL, '2024-11-09 20:31:57', 'Mentally Ill', 'male', 'uploads/UoPeople.png'),
(2, NULL, 'Tindyebwa Ignatious', 'jjj', '0762560175', '', NULL, '2024-11-09 20:43:17', 'mentally ill', 'male', 'uploads/cap 1.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `community_members`
--

CREATE TABLE `community_members` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `membership_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('member','admin','moderator') DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `community_members`
--

INSERT INTO `community_members` (`id`, `user_id`, `membership_date`, `role`) VALUES
(1, 5, '2024-11-03 09:16:01', 'member'),
(2, 11, '2024-11-03 09:21:09', 'admin'),
(3, 13, '2024-11-03 11:25:10', 'admin'),
(4, 14, '2024-11-03 15:23:02', 'member'),
(5, 17, '2024-11-04 11:25:32', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `description`, `created_at`) VALUES
(1, 'One-on-One Counseling', 'Personalized counseling sessions.', '2024-10-29 20:56:51'),
(2, 'Teletherapy', 'Remote therapy sessions over video or phone.', '2024-10-29 20:56:51'),
(3, 'Support Groups', 'Group sessions to discuss mental health topics.', '2024-10-29 20:56:51'),
(4, 'Mental Health Resources', 'Access to various mental health resources.', '2024-10-29 20:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `fullname` varchar(45) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `created_at`, `fullname`, `role`) VALUES
(1, 'ignatioustindzwell52@gmail.com', '$2y$10$VvuySFt.Gn3OfL6uVUAHEOS34RnZQ6Fw2yHXqGBqT8sgEkXc7YM7i', '2024-10-30 17:09:43', 'Tindyebwa Ignatious', 'user'),
(2, 'ohlivefeza@gmail.com', '$2y$10$n8WAZ25yoBKO5cVtcDnd9u20EspFrfVPwFO5PxLqXLmmXC4nfdx6W', '2024-10-31 10:39:38', 'Tindyebwa Ignatious', 'user'),
(3, 'kush@gmail.com', '$2y$10$qjIeM/1j/OCQqCcsMhSu6OOacQGLDjtn8kvfh2zc8KhIQ959/Al5.', '2024-11-01 14:32:46', 'KUSHABA PATIENCE', 'user'),
(5, 'patiencekushaba1@gmail.com', '$2y$10$ab9RAeEZ1wDGJ2GvbWaGuulMmqCKkZhHyL6ifDXsbk5krnZ2ciOeG', '2024-11-03 09:16:01', 'TINDYEBWA IGNATIOUS', 'user'),
(11, 'kush1@gmail.com', '$2y$10$tt9tEUiWYy4nVXNaO9ghIuGS3APiFpYdE6Hengvw53wXn0mF9.8CK', '2024-11-03 09:21:09', 'KUSHABA k', 'user'),
(13, 'nasasiraJustus@gmail.com', '$2y$10$seoYrtCcaZ8Q0pLuAkuLv.vZS2gkACjPGLwfLyE/ZnCDLOu0DXp9y', '2024-11-03 11:25:10', 'Nasasira Justus', 'user'),
(14, 'kobu@gmail.com', '$2y$10$av6mNibGQ4WkqNBD1Hz7VeqcRgCAuaH73CqqtgaIRbvvMSmj02Bze', '2024-11-03 15:23:02', 'Kobusingye Annah', 'user'),
(15, 'baby@gmail.com', '$2y$10$8M7GVcm2xFGDynuO9OgF5uN6MDmbDYKgk6bQed7rnznmtC3KktNOy', '2024-11-03 15:24:32', 'baby', 'user'),
(17, 'enock@gmail.com', '$2y$10$A/N3vWk3c6pCw84MKrZz8ekjnoRjdu2P4V/1jeVKvl61v9/P97ln.', '2024-11-04 11:25:32', 'enock', 'user'),
(21, 'patie@gmail.com', '$2y$10$CE.TQewTksV.6kzjWrpt8uCPAeKEImHbRiHhMoj/vJUkgGXINeR2a', '2024-11-06 09:50:40', 'patie', 'user'),
(22, 'ignatioustind@gmail.com', '$2y$10$AF6L0Xf1ogKKRAytJuFD9uz1VXGCzx6qNY0Ly68L597wXrezUUyQO', '2024-11-07 08:24:46', 'TINDYEBWA', 'user'),
(23, 'igna@gmail.com', '$2y$10$44MnkZN7jh5bUBgwgKYJBuPqI6Fj5LCt/7B/pJX/0.QcaY1AzboWG', '2024-11-07 08:27:48', 'TINDYEBWA IGNATIOUS', 'user'),
(24, 'kamu@gmail.com', '$2y$10$uYoBHoqyXaNWvvOxkXOsF.Wmk683pFSPwlvHQUisUJnoOzaTXrJvy', '2024-11-07 18:41:46', 'kamukama osbert', 'user'),
(25, 'good@gmail.com', '$2y$10$Ob4Nav5j.qSDBOpIImv81u2uweS.7B0iCyyJk/NbdB6.5/ORCgHwq', '2024-11-08 07:39:54', 'good', 'user'),
(26, 'nelson@gmail.com', '$2y$10$S1hxT1ymzMK8YNsn9K5beO/fOc5LwSqnnoA4ZoCt31VlwvHwmYype', '2024-11-10 04:35:09', 'Nelson A', 'admin'),
(27, 'davis@gmail.com', '$2y$10$HImBVDViQ2/6ZCefimBfEOikESj6Gk1oG2v4bl88CrvyWGTWF7FIe', '2024-11-10 04:45:58', 'Davis', 'admin'),
(28, 'magi@gmail.com', '$2y$10$i4Jl27JoSncQeA.mgY20Eu99I0UgcgR5ZMECj4GZK73FAsnXSOy2G', '2024-11-10 04:59:30', 'Madavi Magi', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `users_reports`
--

CREATE TABLE `users_reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_reports`
--

INSERT INTO `users_reports` (`report_id`, `user_id`, `report_content`, `created_at`) VALUES
(16, 1, 'User reported feeling overwhelmed with work and personal responsibilities. Suggested techniques for stress management were discussed, including mindfulness practices and time management strategies.', '2024-11-04 16:00:21'),
(17, 1, 'User has been experiencing increased anxiety levels due to upcoming exams. Implemented relaxation exercises and encouraged scheduling regular study breaks.', '2024-11-04 16:00:21'),
(18, 1, 'User expressed feelings of sadness and isolation during sessions. Discussed the importance of social support and explored ways to connect with friends and family.', '2024-11-04 16:00:21'),
(19, 1, 'User is making progress in therapy, reporting a better understanding of their triggers and coping mechanisms. Plans to continue focusing on cognitive behavioral techniques.', '2024-11-04 16:00:21'),
(20, 1, 'User shared positive feedback about recent therapy sessions, noting that they feel more in control of their emotions. Recommended journaling as a way to track their mood.', '2024-11-04 16:00:21'),
(21, 1, 'User mentioned difficulties in maintaining a healthy work-life balance. Strategies for setting boundaries and prioritizing self-care were provided.', '2024-11-04 16:00:21'),
(22, 1, 'User expressed interest in group therapy for additional support. Discussed the benefits of shared experiences and offered information on local support groups.', '2024-11-04 16:00:21'),
(23, 1, 'User reported improvements in sleep quality after implementing a nighttime routine. Discussed the importance of sleep hygiene and relaxation techniques before bed.', '2024-11-04 16:00:21'),
(24, 1, 'User articulated concerns about relationship issues. Explored communication skills and conflict resolution strategies to improve interactions with partners.', '2024-11-04 16:00:21'),
(25, 1, 'User displayed motivation towards achieving personal goals. Worked on developing a step-by-step action plan to help them reach their objectives and set realistic milestones.', '2024-11-04 16:00:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `community_members`
--
ALTER TABLE `community_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_reports`
--
ALTER TABLE `users_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `community_members`
--
ALTER TABLE `community_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users_reports`
--
ALTER TABLE `users_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `community_members`
--
ALTER TABLE `community_members`
  ADD CONSTRAINT `community_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users_reports`
--
ALTER TABLE `users_reports`
  ADD CONSTRAINT `users_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
