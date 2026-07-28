-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2026 at 11:55 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'System',
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_name`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 'created', 'Customer', 4, 'Pelanggan baru ditambahkan: \"kucing\" (HP: 085179956922)', '127.0.0.1', '2026-07-28 01:20:38', '2026-07-28 01:20:38'),
(2, 'ADMIN', 'created', 'Transaction', 8, 'Transaksi baru dibuat untuk pelanggan: \"kucing\" (1 paket)', '127.0.0.1', '2026-07-28 01:21:11', '2026-07-28 01:21:11'),
(3, 'ADMIN', 'updated', 'Transaction', 8, 'Status transaksi pelanggan \"kucing\" diubah: proses → selesai', '127.0.0.1', '2026-07-28 01:21:25', '2026-07-28 01:21:25'),
(4, 'ADMIN', 'exported', 'Report', NULL, 'Laporan CSV diekspor untuk periode 2026-07-01 s/d 2026-07-28', '127.0.0.1', '2026-07-28 01:22:18', '2026-07-28 01:22:18'),
(5, 'ADMIN', 'exported', 'Report', NULL, 'Laporan PDF diekspor untuk periode 2026-07-01 s/d 2026-07-28', '127.0.0.1', '2026-07-28 01:22:34', '2026-07-28 01:22:34'),
(6, 'ADMIN', 'exported', 'Report', NULL, 'Laporan PDF diekspor untuk periode 2026-07-01 s/d 2026-07-28', '127.0.0.1', '2026-07-28 01:22:37', '2026-07-28 01:22:37'),
(7, 'ADMIN', 'exported', 'Report', NULL, 'Laporan PDF diekspor untuk periode 2025-08-01 s/d 2026-07-28', '127.0.0.1', '2026-07-28 01:40:02', '2026-07-28 01:40:02'),
(8, 'ADMIN', 'exported', 'Report', NULL, 'Laporan PDF diekspor untuk periode 2025-08-01 s/d 2026-07-28', '127.0.0.1', '2026-07-28 01:40:03', '2026-07-28 01:40:03'),
(9, 'ADMIN', 'created', 'Package', 4, 'Paket baru ditambahkan: \"Paket Cuci Keranda (Satuan)\" (Rp 0)', '127.0.0.1', '2026-07-28 11:42:08', '2026-07-28 11:42:08'),
(10, 'ADMIN', 'updated', 'Package', 1, 'Paket diperbarui: \"Cuci Kering\" (Rp 80.000) → \"Cuci Kering (Kiloan)\" (Rp 80.000)', '127.0.0.1', '2026-07-28 11:42:33', '2026-07-28 11:42:33'),
(11, 'ADMIN', 'updated', 'Transaction', 8, 'Status transaksi pelanggan \"kucing\" diubah: selesai → diambil', '127.0.0.1', '2026-07-28 11:51:32', '2026-07-28 11:51:32');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@laundry.com|127.0.0.1', 'i:1;', 1785238925),
('laravel-cache-admin@laundry.com|127.0.0.1:timer', 'i:1785238925;', 1785238925);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Dimas Adhi Nugroho', '+6281385198382', 'Perumahan Taman Cibinong Asri Blok J6. N018e', '2026-01-29 07:48:03', '2026-01-29 07:48:03'),
(2, 'Yanto', '665565655', 'yuguygiuhohoih', '2026-01-29 08:18:35', '2026-01-29 08:18:35'),
(3, 'Budi Santoso', '08123456789', 'Jl. Merdeka No. 10', '2026-03-18 07:24:53', '2026-03-18 07:24:53'),
(4, 'kucing', '085179956922', 'Perumahan Taman Cibinong Asri Blok J6. No.18e', '2026-07-28 01:20:38', '2026-07-28 01:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_28_141047_create_customers_table', 1),
(5, '2026_01_28_141330_create_packages_table', 1),
(6, '2026_01_28_141436_create_transactions_table', 1),
(7, '2026_01_29_113913_set_default_unit_in_packages_table', 1),
(8, '2026_01_29_114957_create_package_transaction_table', 1),
(9, '2026_07_28_000001_create_activity_logs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `price`, `unit`, `created_at`, `updated_at`) VALUES
(1, 'Cuci Kering (Kiloan)', 80000, 'kg', '2026-01-29 07:48:20', '2026-07-28 11:42:33'),
(2, 'Cuci Motor', 50000, 'kg', '2026-01-29 07:49:09', '2026-01-29 07:49:09'),
(3, 'Cuci Kering Premium', 10000, 'kg', '2026-03-18 07:25:18', '2026-03-18 07:25:18'),
(4, 'Paket Cuci Keranda (Satuan)', 0, 'kg', '2026-07-28 11:42:07', '2026-07-28 11:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `package_transaction`
--

CREATE TABLE `package_transaction` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_transaction`
--

INSERT INTO `package_transaction` (`id`, `transaction_id`, `package_id`, `qty`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 240000, '2026-01-29 07:48:35', '2026-01-29 07:48:35'),
(2, 2, 1, 1, 80000, '2026-01-29 07:51:47', '2026-01-29 07:51:47'),
(3, 3, 1, 1, 80000, '2026-01-29 07:53:27', '2026-01-29 07:53:27'),
(4, 3, 2, 2, 100000, '2026-01-29 07:53:27', '2026-01-29 07:53:27'),
(5, 4, 1, 1, 80000, '2026-01-29 08:19:19', '2026-01-29 08:19:19'),
(6, 4, 2, 2, 100000, '2026-01-29 08:19:19', '2026-01-29 08:19:19'),
(7, 5, 1, 3, 240000, '2026-03-18 07:25:46', '2026-03-18 07:25:46'),
(8, 6, 3, 33, 330000, '2026-03-18 07:28:39', '2026-03-18 07:28:39'),
(9, 7, 1, 1, 80000, '2026-03-18 07:30:34', '2026-03-18 07:30:34'),
(10, 7, 2, 1, 50000, '2026-03-18 07:30:34', '2026-03-18 07:30:34'),
(11, 8, 2, 1, 50000, '2026-07-28 01:21:11', '2026-07-28 01:21:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('b1aPTxm3WTpqhX0FMLWprHsJzVlIqRVhvMsRQm7Y', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUFlJMzFnc204MGxDNUdUa1VwMUZGeVFYaUcyQzdWdndObE1nSml0aCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vbGF1bmRyeS1sYXJhdmVsLnRlc3QvcmVwb3J0cyI7czo1OiJyb3V0ZSI7czoxMzoicmVwb3J0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1785239518);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `status` enum('proses','selesai','diambil') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'proses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `customer_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'selesai', '2026-01-29 07:48:35', '2026-07-28 00:48:19'),
(2, 1, 'proses', '2026-01-29 07:51:47', '2026-01-29 07:51:47'),
(3, 1, 'proses', '2026-01-29 07:53:27', '2026-01-29 07:53:27'),
(4, 2, 'selesai', '2026-01-29 08:19:19', '2026-01-29 08:19:27'),
(5, 1, 'proses', '2026-03-18 07:25:46', '2026-03-18 07:25:46'),
(6, 3, 'proses', '2026-03-18 07:28:39', '2026-03-18 07:28:39'),
(7, 2, 'diambil', '2026-03-18 07:30:34', '2026-03-18 07:30:45'),
(8, 4, 'diambil', '2026-07-28 01:21:11', '2026-07-28 11:51:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Cici', 'kelincipercobaan@gmail.com', NULL, '$2y$12$qCpREgPsShZm7jVqcCHBx.CyJXf80uURIM0aP2.pL0x0Eq6og6Z4.', NULL, '2026-01-29 07:45:45', '2026-01-29 07:45:45'),
(2, 'ADMIN', 'admin@laundry.test', NULL, '$2y$12$SzeHmpSj62WdwsDgdZn4C.mG/G6sax1Ayqp/AHZbnWJYZbDt/vqBq', 'RqC4dqmEluREoEttQiTu1uRLWT1XFNPDS2sBgfXljzH3rTxFhdrVy2Di3nLP', '2026-02-01 10:28:09', '2026-02-01 10:28:09'),
(3, 'Admin Test', 'test@example.com', NULL, '$2y$12$EVKI7u9jsFrmW4/zN65giut2eyFs2k48pYsLKo1LFgkXmXJsEYEF2', NULL, '2026-03-18 07:24:15', '2026-03-18 07:24:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_transaction`
--
ALTER TABLE `package_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_transaction_transaction_id_foreign` (`transaction_id`),
  ADD KEY `package_transaction_package_id_foreign` (`package_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_customer_id_foreign` (`customer_id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `package_transaction`
--
ALTER TABLE `package_transaction`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `package_transaction`
--
ALTER TABLE `package_transaction`
  ADD CONSTRAINT `package_transaction_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
