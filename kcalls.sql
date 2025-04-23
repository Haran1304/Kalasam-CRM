-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 09:20 AM
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
-- Database: `kcalls`
--

-- --------------------------------------------------------

--
-- Table structure for table `billtypetable`
--

CREATE TABLE `billtypetable` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `billtype` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `kstaff_dtls`
--

CREATE TABLE `kstaff_dtls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sname` varchar(255) NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `k_call_registers`
--

CREATE TABLE `k_call_registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` bigint(20) UNSIGNED NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `conperson` varchar(255) NOT NULL,
  `call_date` datetime NOT NULL,
  `work` varchar(255) NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `callallocation` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `serialNo` varchar(255) DEFAULT NULL,
  `Ncalldate` datetime DEFAULT NULL,
  `software` text DEFAULT NULL,
  `billtype` varchar(255) DEFAULT NULL,
  `completeperson` varchar(255) DEFAULT NULL,
  `completeddate` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `k_call_registers`
--

INSERT INTO `k_call_registers` (`id`, `cust_id`, `phoneno`, `conperson`, `call_date`, `work`, `staff_id`, `callallocation`, `status`, `remarks`, `serialNo`, `Ncalldate`, `software`, `billtype`, `completeperson`, `completeddate`, `created_at`, `updated_at`, `order_no`) VALUES
(108, 16, '9876543210', 'Jeeva', '2025-04-21 11:07:12', 'Tally Support', 5, 'Hari', 'Pending', 'jhgfghjghgfcfjhghghk', NULL, '2025-04-21 11:07:00', NULL, 'AMC', NULL, NULL, '2025-04-21 05:37:12', '2025-04-21 05:37:12', '1');

-- --------------------------------------------------------

--
-- Table structure for table `k_customer_registers`
--

CREATE TABLE `k_customer_registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `serialNo` varchar(255) DEFAULT NULL,
  `gstno` varchar(255) DEFAULT NULL,
  `refname` varchar(255) DEFAULT NULL,
  `pack` varchar(255) DEFAULT NULL,
  `billtype` varchar(255) DEFAULT NULL,
  `software` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `k_customer_registers`
--

INSERT INTO `k_customer_registers` (`id`, `comname`, `name`, `phone`, `mobile`, `email`, `serialNo`, `gstno`, `refname`, `pack`, `billtype`, `software`, `created_at`, `updated_at`) VALUES
(16, 'smikpro', 'Jeeva', '9876543210', '9876543210', 'jeeva12@gmail.com', '1234', '12345', 'jeeva1', 'haha', 'AMC', 'Tally', '2025-03-18 10:59:34', '2025-03-18 10:59:34'),
(17, 'smikssss', 'Hari', '9943955953', '09943955953', 'hari.smiksystems@gmail.com', '1234', '12345', 'hari', 'haha', 'AMC', 'Tally', '2025-04-19 10:47:18', '2025-04-19 10:47:18');

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
(5, '2022_01_23_052224_worktable', 1),
(6, '2022_01_23_052235_billtypetable', 1),
(7, '2023_08_06_063459_create_k_customer_registers_table', 1),
(8, '2023_08_06_063538_create_k_call_registers_table', 1),
(9, '2023_08_06_093544_create_kstaff_dtls_table', 1),
(10, '2023_09_13_133630_alter_k_call_registers_table', 1),
(11, '2025_03_08_184717_add_order_no_to_k_call_registers_table', 2),
(14, '2025_03_08_185153_add_order_no_to_k_call_registers_table', 3),
(16, '2025_03_08_185539_order_no', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `confirpassword` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `confirpassword`, `usertype`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hari', 'hari.smiksystems@gmailcom', NULL, '$2y$10$zRt.TAcZd0Mz2Ee2TWjIdeNz1EF.bQBekvDgAcD0WT2cdp5HITOR.', 'hari@123', 'admin', NULL, '2025-03-05 12:10:30', '2025-03-05 12:10:30'),
(5, 'admin', 'hari.san1304@gmail.com', NULL, '$2y$10$h/9qAmE.IT8S38feKlNoGOBCkV0f4OXD3PtYymDMQwfWsNj2gD.ti', 'hari@123', 'Staff', NULL, '2025-04-19 11:01:52', '2025-04-19 11:01:52'),
(6, 'mani', 'mani@gmail.com', NULL, '$2y$10$IUjIDYbrfgQx5z.cEU3.WeyQxlrNVs8wVieBHjT01qy2cUDmC1j4y', 'mani@123', 'Staff', NULL, '2025-04-19 11:19:46', '2025-04-19 11:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `worktable`
--

CREATE TABLE `worktable` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billtypetable`
--
ALTER TABLE `billtypetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kstaff_dtls`
--
ALTER TABLE `kstaff_dtls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `k_call_registers`
--
ALTER TABLE `k_call_registers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `k_call_registers_cust_id_foreign` (`cust_id`),
  ADD KEY `k_call_registers_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `k_customer_registers`
--
ALTER TABLE `k_customer_registers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `worktable`
--
ALTER TABLE `worktable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billtypetable`
--
ALTER TABLE `billtypetable`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kstaff_dtls`
--
ALTER TABLE `kstaff_dtls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `k_call_registers`
--
ALTER TABLE `k_call_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `k_customer_registers`
--
ALTER TABLE `k_customer_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `worktable`
--
ALTER TABLE `worktable`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `k_call_registers`
--
ALTER TABLE `k_call_registers`
  ADD CONSTRAINT `k_call_registers_cust_id_foreign` FOREIGN KEY (`cust_id`) REFERENCES `k_customer_registers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `k_call_registers_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
