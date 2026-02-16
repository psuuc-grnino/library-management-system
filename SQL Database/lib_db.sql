-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 06:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geraldine_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `year`, `created_at`, `updated_at`, `quantity`, `cover`) VALUES
(10, 'Greedy Monkey', 'Brown Ken', 'Fan Fiction', 2022, '2025-05-23 21:40:34', '2025-05-29 19:12:43', 2, 'covers/6DkAM9Wr46dW38C1KzeAIrD0oi9MaFhSCS89kiRl.jpg'),
(11, 'The Book of Lazaro', 'Justine Karl', 'Fantasy', 2024, '2025-05-23 21:46:46', '2025-05-29 04:59:38', 1, NULL),
(13, 'Hidden Bestowals', 'Purple Tips', 'Fiction', 2013, '2025-05-23 21:58:30', '2025-05-29 04:59:51', 3, NULL),
(14, 'Harry Potter Book 1', 'JK Rowling', 'Fantasy', 2013, '2025-05-23 21:58:57', '2025-05-29 05:00:03', 3, NULL),
(15, 'Origin of the Fusion', 'Purple Tips', 'Fantasy/Thriller', 2022, '2025-05-23 21:59:15', '2025-05-29 20:13:55', 7, 'covers/p6VPASt7UiHetgE9LV6N96u28bAlIcLk7fkTB2pI.jpg'),
(19, 'Digital Portrait Illustration', 'Mayen Artist', 'Arts', 2024, '2025-05-29 19:18:27', '2025-05-29 19:27:50', 10, 'covers/oza7xWnsJQ7YymFQcptWEgzTb59HENmMfkG4z9pu.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `borrowed_at` date NOT NULL DEFAULT '2025-03-21',
  `returned_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`id`, `user_id`, `book_id`, `borrowed_at`, `returned_at`, `created_at`, `updated_at`, `status`) VALUES
(44, 4, 10, '2025-05-24', '2025-05-24', '2025-05-23 22:12:54', '2025-05-23 22:13:30', 'returned'),
(46, 4, 13, '2025-05-24', NULL, '2025-05-23 22:12:57', '2025-05-23 22:12:57', 'pending'),
(48, 4, 14, '2025-05-24', NULL, '2025-05-23 22:13:01', '2025-05-23 22:13:01', 'pending'),
(49, 4, 10, '2025-05-29', NULL, '2025-05-29 06:11:44', '2025-05-29 06:11:44', 'pending'),
(50, 4, 11, '2025-05-29', NULL, '2025-05-29 06:11:46', '2025-05-29 06:11:46', 'pending'),
(51, 4, 15, '2025-05-29', '2025-05-29', '2025-05-29 06:47:08', '2025-05-29 06:48:18', 'returned'),
(52, 4, 15, '2025-05-29', NULL, '2025-05-29 06:51:56', '2025-05-29 06:52:13', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_03_21_020432_create_books_table', 1),
(6, '2014_10_12_100000_create_password_resets_table', 2),
(7, '2025_03_21_024818_create_borrows_table', 2),
(8, '2025_03_21_030955_add_remember_token_to_users_table', 3),
(9, '2025_03_21_115526_add_quantity_to_books_table', 4),
(10, '2025_03_27_001441_add_profile_fields_to_users_table', 5),
(11, '2025_03_28_130440_add_status_to_borrows_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('purpletips2022@gmail.com', '$2y$12$ESXUmzuRPEoOpxtGd7X2QuiMh3jVxq1qUR1csAtXrHfUkJho8yKa6', '2025-05-08 23:54:32');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `psu_status` enum('student','outsider') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `profile_photo`, `student_id`, `address`, `password`, `role`, `created_at`, `updated_at`, `remember_token`, `firstname`, `lastname`, `contact_number`, `psu_status`) VALUES
(1, 'admin@example.com', NULL, NULL, NULL, '$2y$12$Tc3.WFQqp9oleUfwpglzieWFlyXVwmgL/eo5lNMV7WKtGS4fxtKVC', 'admin', '2025-03-20 18:55:20', '2025-03-20 18:55:20', 'XbgBZWD17ymwMomExui2A8mj1hHKenXq9UKQwvEgI9sQuQ64wckkYvAC3UJB', '', '', '', 'student'),
(4, 'purpletips2022@gmail.com', 'profile_photos/GGg8Gz7fj01PlcyC8K1XSnaO8Ih0iMjAmEqzBe25.jpg', '21UR0142', 'San Vicente Urdaneta City, Pangasinan', '$2y$12$7xIYqPnO5oyop3to4vO3Hu1lacUDrHz4JMAwLRJox9YnKrkIoYfHq', 'user', '2025-05-23 17:36:46', '2025-05-29 07:19:23', 'R9KYCANnkaf0ItJMsqsAIsiz5jqXRWjZIFJqb73HKwJy7TObqjiGl8PGsmso', 'Geraldine', 'Nino', '09159432425', 'student'),
(5, 'outsider@example.com', NULL, NULL, NULL, '$2y$12$bae8bJbAC9Mxg9plWboZ1enhL.k2SaQeP72ohmgzxz5hBu0ZA3HUu', 'user', '2025-05-29 05:43:52', '2025-05-29 05:43:52', NULL, 'Astria', 'Bermudez', '09159432428', 'outsider');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrows_user_id_foreign` (`user_id`),
  ADD KEY `borrows_book_id_foreign` (`book_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `borrows_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
