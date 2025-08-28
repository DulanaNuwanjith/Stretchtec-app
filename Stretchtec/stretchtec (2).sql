-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250718.d42db65a1e
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 27, 2025 at 08:51 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stretchtec`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `color_match_rejects`
--

CREATE TABLE `color_match_rejects` (
  `id` bigint UNSIGNED NOT NULL,
  `orderNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sentDate` datetime DEFAULT NULL,
  `receiveDate` datetime DEFAULT NULL,
  `rejectDate` datetime DEFAULT NULL,
  `rejectReason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_counters`
--

CREATE TABLE `dispatch_counters` (
  `id` bigint UNSIGNED NOT NULL,
  `last_number` bigint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `leftover_yarns`
--

CREATE TABLE `leftover_yarns` (
  `id` bigint UNSIGNED NOT NULL,
  `shade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yarn_received_date` date DEFAULT NULL,
  `tkt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yarn_supplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available_stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2025_06_05_083031_add_two_factor_columns_to_users_table', 1),
(5, '2025_06_05_083041_create_personal_access_tokens_table', 1),
(6, '2025_07_07_024557_create_sample_inquiries_table', 1),
(7, '2025_07_09_033748_create_operatorsand_supervisors_table', 1),
(8, '2025_07_14_045910_create_sample_preparation_rn_d_s_table', 1),
(9, '2025_07_14_155920_add_lock_flags_to_sample_preparation_rnd_table', 1),
(10, '2025_07_16_125133_add_item_discription_to_sample_inquiries_table', 1),
(11, '2025_07_17_104228_add_already_developed_to_sample_preparation_rnd_table', 1),
(12, '2025_07_17_142527_add_yarn_weights_to_sample_preparation_rnd_table', 1),
(13, '2025_07_17_143656_add_yarn_weight_locks_to_sample_preparation_rnd', 1),
(14, '2025_07_17_165858_create_sample_preparation_production_table', 1),
(15, '2025_07_24_084633_add_is_output_locked_to_productions_table', 1),
(16, '2025_07_24_100608_add_dispatched_by_to_sample_preparation_production_table', 1),
(17, '2025_07_24_141444_create_leftover_yarns_table', 1),
(18, '2025_07_25_080142_create_sample_stocks_table', 1),
(19, '2025_07_28_140306_create_color_match_rejects_table', 1),
(20, '2025_07_30_080604_create_product_catalogs_table', 1),
(21, '2025_07_30_121547_add_order_image_to_product_catalogs_table', 1),
(22, '2025_07_30_153834_add_approved_by_and_approval_card_to_product_catalogs_table', 1),
(23, '2025_07_30_162913_add_approval_locked_to_product_catalog_table', 1),
(24, '2025_07_31_110718_create_dispatch_counters_table', 1),
(25, '2025_08_18_155900_create_stores_table', 1),
(26, '2025_08_19_082227_add_pst_no_to_sample_preparation_rnd_table', 1),
(27, '2025_08_21_200259_create_shade_orders_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `operatorsand_supervisors`
--

CREATE TABLE `operatorsand_supervisors` (
  `id` bigint UNSIGNED NOT NULL,
  `empID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_catalogs`
--

CREATE TABLE `product_catalogs` (
  `id` bigint UNSIGNED NOT NULL,
  `sample_preparation_rnd_id` bigint UNSIGNED DEFAULT NULL,
  `sample_inquiry_id` bigint UNSIGNED DEFAULT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_added_date` date NOT NULL,
  `coordinator_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tkt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_card` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved_by_locked` tinyint(1) NOT NULL DEFAULT '0',
  `is_approval_card_locked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sample_inquiries`
--

CREATE TABLE `sample_inquiries` (
  `id` bigint UNSIGNED NOT NULL,
  `orderFile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inquiryReceiveDate` date NOT NULL,
  `customerName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchandiseName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordinatorName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtRef` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sampleQty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerSpecialComment` longtext COLLATE utf8mb4_unicode_ci,
  `customerRequestDate` date DEFAULT NULL,
  `alreadyDeveloped` tinyint(1) NOT NULL DEFAULT '0',
  `sentToSampleDevelopmentDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `developPlannedDate` date DEFAULT NULL,
  `productionStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `referenceNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerDeliveryDate` datetime DEFAULT NULL,
  `rejectNO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dNoteNumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deliveryQty` int DEFAULT NULL,
  `customerDecision` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ItemDiscription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sample_preparation_production`
--

CREATE TABLE `sample_preparation_production` (
  `id` bigint UNSIGNED NOT NULL,
  `sample_preparation_rnd_id` bigint UNSIGNED NOT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `production_deadline` date DEFAULT NULL,
  `order_received_at` datetime DEFAULT NULL,
  `order_start_at` datetime DEFAULT NULL,
  `operator_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_complete_at` datetime DEFAULT NULL,
  `production_output` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `damaged_output` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispatch_to_rnd_at` datetime DEFAULT NULL,
  `dispatched_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_output_locked` tinyint(1) NOT NULL DEFAULT '0',
  `is_damagedOutput_locked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sample_preparation_rnd`
--

CREATE TABLE `sample_preparation_rnd` (
  `id` bigint UNSIGNED NOT NULL,
  `sample_inquiry_id` bigint UNSIGNED NOT NULL,
  `orderNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerRequestDate` date DEFAULT NULL,
  `developPlannedDate` date DEFAULT NULL,
  `is_dev_plan_locked` tinyint(1) NOT NULL DEFAULT '0',
  `colourMatchSentDate` timestamp NULL DEFAULT NULL,
  `colourMatchReceiveDate` timestamp NULL DEFAULT NULL,
  `alreadyDeveloped` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yarnOrderedDate` timestamp NULL DEFAULT NULL,
  `yarnOrderedPONumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_po_locked` tinyint(1) NOT NULL DEFAULT '0',
  `shade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_shade_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tkt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_tkt_locked` tinyint(1) NOT NULL DEFAULT '0',
  `yarnSupplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_supplier_locked` tinyint(1) NOT NULL DEFAULT '0',
  `yarnPrice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yarnReceiveDate` timestamp NULL DEFAULT NULL,
  `pst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productionDeadline` date DEFAULT NULL,
  `is_deadline_locked` tinyint(1) NOT NULL DEFAULT '0',
  `sendOrderToProductionStatus` timestamp NULL DEFAULT NULL,
  `productionStatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `referenceNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_reference_locked` tinyint(1) NOT NULL DEFAULT '0',
  `productionOutput` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yarnOrderedWeight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_yarn_ordered_weight_locked` tinyint(1) NOT NULL DEFAULT '0',
  `yarnLeftoverWeight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_yarn_leftover_weight_locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sample_stocks`
--

CREATE TABLE `sample_stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `reference_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available_stock` int NOT NULL DEFAULT '0',
  `special_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `shade_orders`
--

CREATE TABLE `shade_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `sample_preparation_rnd_id` bigint UNSIGNED NOT NULL,
  `shade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `yarn_receive_date` datetime DEFAULT NULL,
  `pst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `production_output` int DEFAULT NULL,
  `damaged_output` int DEFAULT NULL,
  `dispatched_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivered_date` datetime DEFAULT NULL,
  `production_complete_date` datetime DEFAULT NULL,
  `dispatched_date` datetime DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `color_match_rejects`
--
ALTER TABLE `color_match_rejects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `color_match_rejects_orderno_foreign` (`orderNo`);

--
-- Indexes for table `dispatch_counters`
--
ALTER TABLE `dispatch_counters`
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
-- Indexes for table `leftover_yarns`
--
ALTER TABLE `leftover_yarns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operatorsand_supervisors`
--
ALTER TABLE `operatorsand_supervisors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `operatorsand_supervisors_empid_unique` (`empID`);

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
-- Indexes for table `product_catalogs`
--
ALTER TABLE `product_catalogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_catalogs_sample_preparation_rnd_id_foreign` (`sample_preparation_rnd_id`),
  ADD KEY `product_catalogs_sample_inquiry_id_foreign` (`sample_inquiry_id`);

--
-- Indexes for table `sample_inquiries`
--
ALTER TABLE `sample_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sample_inquiries_orderno_unique` (`orderNo`);

--
-- Indexes for table `sample_preparation_production`
--
ALTER TABLE `sample_preparation_production`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sample_preparation_production_sample_preparation_rnd_id_foreign` (`sample_preparation_rnd_id`);

--
-- Indexes for table `sample_preparation_rnd`
--
ALTER TABLE `sample_preparation_rnd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sample_preparation_rnd_sample_inquiry_id_foreign` (`sample_inquiry_id`);

--
-- Indexes for table `sample_stocks`
--
ALTER TABLE `sample_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shade_orders`
--
ALTER TABLE `shade_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shade_orders_sample_preparation_rnd_id_foreign` (`sample_preparation_rnd_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `color_match_rejects`
--
ALTER TABLE `color_match_rejects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dispatch_counters`
--
ALTER TABLE `dispatch_counters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `leftover_yarns`
--
ALTER TABLE `leftover_yarns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `operatorsand_supervisors`
--
ALTER TABLE `operatorsand_supervisors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_catalogs`
--
ALTER TABLE `product_catalogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sample_inquiries`
--
ALTER TABLE `sample_inquiries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sample_preparation_production`
--
ALTER TABLE `sample_preparation_production`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sample_preparation_rnd`
--
ALTER TABLE `sample_preparation_rnd`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sample_stocks`
--
ALTER TABLE `sample_stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shade_orders`
--
ALTER TABLE `shade_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `color_match_rejects`
--
ALTER TABLE `color_match_rejects`
  ADD CONSTRAINT `color_match_rejects_orderno_foreign` FOREIGN KEY (`orderNo`) REFERENCES `sample_inquiries` (`orderNo`) ON DELETE CASCADE;

--
-- Constraints for table `product_catalogs`
--
ALTER TABLE `product_catalogs`
  ADD CONSTRAINT `product_catalogs_sample_inquiry_id_foreign` FOREIGN KEY (`sample_inquiry_id`) REFERENCES `sample_inquiries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_catalogs_sample_preparation_rnd_id_foreign` FOREIGN KEY (`sample_preparation_rnd_id`) REFERENCES `sample_preparation_rnd` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sample_preparation_production`
--
ALTER TABLE `sample_preparation_production`
  ADD CONSTRAINT `sample_preparation_production_sample_preparation_rnd_id_foreign` FOREIGN KEY (`sample_preparation_rnd_id`) REFERENCES `sample_preparation_rnd` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sample_preparation_rnd`
--
ALTER TABLE `sample_preparation_rnd`
  ADD CONSTRAINT `sample_preparation_rnd_sample_inquiry_id_foreign` FOREIGN KEY (`sample_inquiry_id`) REFERENCES `sample_inquiries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shade_orders`
--
ALTER TABLE `shade_orders`
  ADD CONSTRAINT `shade_orders_sample_preparation_rnd_id_foreign` FOREIGN KEY (`sample_preparation_rnd_id`) REFERENCES `sample_preparation_rnd` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
