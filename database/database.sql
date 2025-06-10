-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jun 2025 pada 08.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catering_planner_frontend`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('77de68daecd823babbb58edb1c8e14d7106e83bb', 'i:1;', 1745850791),
('77de68daecd823babbb58edb1c8e14d7106e83bb:timer', 'i:1745850791;', 1745850791),
('livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:5;', 1749529730),
('livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1749529730;', 1749529730);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'ficky', 'ficky@gmail.com', '12', 'test', '2025-02-03 10:34:07', '2025-02-03 10:34:07'),
(2, 'ficky2', 'test@gmail.com', '12', 'jl yasmin raya no93', '2025-03-18 22:50:20', '2025-03-18 22:50:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `inventory`
--

CREATE TABLE `inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `quantity`, `unit`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 'Beras', 100, 'kg', 1, '2025-02-09 07:31:32', '2025-02-09 07:31:32'),
(2, 'Daging Ayam', 50, 'kg', 2, '2025-02-09 07:31:32', '2025-02-09 07:31:32'),
(3, 'Bumbu Sate', 30, 'pack', 1, '2025-02-09 07:31:32', '2025-02-09 07:31:32'),
(4, 'Alpukat', 40, 'kg', 2, '2025-02-09 07:31:32', '2025-02-09 07:31:32'),
(5, 'Teh Celup', 100, 'box', 1, '2025-02-09 07:31:32', '2025-02-09 07:31:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `name`, `description`, `price`, `category`, `created_at`, `updated_at`, `is_available`) VALUES
(1, 'Nasi Goreng Spesial', 'Nasi goreng dengan ayam dan telur', 25000.00, 'Makanan', '2025-02-09 07:26:44', '2025-02-09 07:26:44', 1),
(2, 'Ayam Goreng Krispi', 'Ayam goreng dengan tepung renyah', 20000.00, 'Makanan', '2025-02-09 07:26:44', '2025-02-09 07:26:44', 1),
(3, 'Sate Ayam', 'Sate ayam dengan bumbu kacang', 30000.00, 'Makanan', '2025-02-09 07:26:44', '2025-02-09 07:26:44', 1),
(4, 'Jus Alpukat', 'Jus alpukat segar dengan susu coklat', 15000.00, 'Minuman', '2025-02-09 07:26:44', '2025-02-09 07:26:44', 1),
(5, 'Es Teh Manis', 'Teh manis dingin dengan es batu', 8000.00, 'Minuman', '2025-02-09 07:26:44', '2025-02-09 07:26:44', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_03_165325_update_users_table', 2),
(5, '2025_02_03_165326_create_menus_table', 2),
(6, '2025_02_03_165327_create_customers_table', 2),
(7, '2025_02_03_165327_create_orders_table', 2),
(8, '2025_02_03_165950_create_staff_table', 2),
(9, '2025_02_03_165957_create_suppliers_table', 2),
(10, '2025_02_03_170001_create_inventory_table', 2),
(11, '2025_02_03_193338_create_order_items_table', 3),
(13, '2025_02_03_211637_create_packages_table', 5),
(14, '2025_02_03_211638_create_package_items_table', 5),
(15, '2025_02_03_213215_add_subtotal_to_package_items', 6),
(16, '2025_02_03_214029_add_total_price_default_to_orders', 7),
(17, '2025_02_03_214239_create_order_packages_table', 8),
(18, '2025_02_03_220121_add_package_id_to_subscriptions_table', 9),
(19, '2025_02_03_220505_remove_price_from_subscriptions', 10),
(20, '2025_02_03_220657_add_quantity_to_subscriptions', 11),
(21, '2025_02_03_220914_add_price_to_subscriptions', 12),
(23, '2025_02_03_223733_remove_package_name_from_subscriptions', 14),
(24, '2025_02_03_210054_create_subscriptions_table', 15),
(25, '2025_02_03_221543_create_subscription_package_table', 15),
(26, '2025_02_05_000648_create_subscriptions_table', 16),
(27, '2025_02_05_000647_create_subscriptions_table', 17),
(28, '2025_02_05_000646_create_subscriptions_table', 18),
(29, '2025_02_05_000842_create_subscription_package_table', 18),
(30, '2025_02_05_030927_create_package_menu_table', 19),
(31, '2025_02_05_040454_add_subtotal_to_package_menu_table', 20),
(32, '2025_02_05_210223_create_subscriptions_table', 21),
(33, '2025_02_05_210234_create_subscription_package_table', 21),
(34, '2025_02_09_064250_add_is_available_to_menus_table', 22),
(35, '2025_03_19_073758_create_order_staff_table', 23);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Processing','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  `tujuan` varchar(255) NOT NULL,
  `special_request` text DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('transfer_bank','tunai','qris') NOT NULL,
  `down_payment` decimal(10,2) DEFAULT NULL,
  `remaining_payment` decimal(10,2) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `payment_notes` varchar(255) DEFAULT NULL,
  `special_instructions` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `event_type`, `total_price`, `status`, `tujuan`, `special_request`, `scheduled_date`, `discount_amount`, `final_amount`, `payment_method`, `down_payment`, `remaining_payment`, `payment_proof`, `payment_notes`, `special_instructions`, `created_at`, `updated_at`) VALUES
(72, 2, 'Gathering', 250000.00, 'Processing', 'uouh', NULL, '2025-04-19', NULL, NULL, 'transfer_bank', 30000.00, 220000.00, 'payment-proofs/Cuplikan layar 2025-04-16 110839.png', NULL, 'test', '2025-04-15 21:37:05', '2025-06-09 21:38:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `special_request` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `quantity`, `subtotal`, `special_request`, `created_at`, `updated_at`) VALUES
(66, 72, 1, 10, 250000.00, NULL, '2025-04-15 21:37:05', '2025-06-09 21:35:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_packages`
--

CREATE TABLE `order_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_staff`
--

CREATE TABLE `order_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_in_order` varchar(50) DEFAULT NULL,
  `status_pengerjaan` varchar(50) DEFAULT NULL,
  `is_leader` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_staff`
--

INSERT INTO `order_staff` (`id`, `order_id`, `staff_id`, `created_at`, `updated_at`, `role_in_order`, `status_pengerjaan`, `is_leader`) VALUES
(9, 72, 12, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 'Paket Hemat', 'Paket nasi goreng dan es teh manis', 33000.00, '2025-02-09 07:26:44', '2025-02-09 07:26:44'),
(2, 'Paket Lengkap', 'Paket ayam goreng, sate ayam, dan jus alpukat', 65000.00, '2025-02-09 07:26:44', '2025-02-09 07:26:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `package_menu`
--

CREATE TABLE `package_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('uxfoN8CXuJsuOpoZwSaqbTCjYpTg30HfQ8wJ0fOd', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaDRUUWNtQWNwMU5QMXRYVExCT3RKSU44ek5mdGNqaXJ3ODlMdTlNaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdGFmZi8xMi9lZGl0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFlVNTgzSVp5OVFQQTJWeVgycEFKdE9hNGlNYm0vbDB4RW9VdTdnLkE3bnpvWDFlZS9lYTF1IjtzOjg6ImZpbGFtZW50IjthOjA6e319', 1749537330),
('yfZtVzzKGXGEVofznIKVgys0nJQDxlszPLQ4Zqbf', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieXpKSDE3eVg2NlRCV1I4dng3S2owd3ZkSXJEWjgwU3hwa1h2OHNyMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGFmZi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=', 1749529893);

-- --------------------------------------------------------

--
-- Struktur dari tabel `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `position` varchar(255) NOT NULL,
  `assigned_order` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `staff`
--

INSERT INTO `staff` (`id`, `name`, `phone`, `position`, `assigned_order`, `created_at`, `updated_at`, `user_id`, `is_active`) VALUES
(1, 'Ahmad Kusuma', '08121234567', 'Staff', NULL, '2025-02-09 07:28:24', '2025-06-09 23:35:01', NULL, 1),
(2, 'Budi Santoso', '08129876543', 'Kasir', NULL, '2025-02-09 07:28:24', '2025-02-09 07:28:24', NULL, 1),
(3, 'Citra Dewi', '08123334455', 'Waitress', NULL, '2025-02-09 07:28:24', '2025-02-09 07:28:24', NULL, 1),
(4, 'Dimas Pratama', '08127778899', 'Manajer', NULL, '2025-02-09 07:28:24', '2025-02-09 07:28:24', NULL, 1),
(5, 'Eka Rahmawati', '08124455667', 'Chef', NULL, '2025-02-09 07:28:24', '2025-02-09 07:28:24', NULL, 1),
(6, 'Fajar Setiawan', '08125556678', 'Pelayan', NULL, '2025-02-09 07:28:24', '2025-02-09 07:28:24', NULL, 1),
(9, 'ficky3', '087879125248', 'test', NULL, '2025-04-16 00:49:20', '2025-04-16 00:49:20', NULL, 1),
(10, 'ficky5', '087879125248', 'test', NULL, '2025-04-16 01:01:18', '2025-04-16 01:01:18', 7, 1),
(11, 'ficky0', '087879125248', 'test', NULL, '2025-04-16 01:07:39', '2025-04-16 01:07:39', 8, 1),
(12, 'ficky25', '087879125248', 'Staff', NULL, '2025-04-28 07:38:51', '2025-06-09 23:35:22', 9, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `customer_id`, `total_price`, `status`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(17, 1, 65000.00, 'Aktif', '2025-02-01', '2025-02-25', '2025-02-09 00:36:13', '2025-02-09 00:36:13'),
(18, 1, 33000.00, 'Aktif', '2025-02-07', '2025-02-20', '2025-02-11 21:04:39', '2025-02-11 21:04:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subscription_package`
--

CREATE TABLE `subscription_package` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `subscription_package`
--

INSERT INTO `subscription_package` (`id`, `subscription_id`, `package_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(18, 17, 2, 1, 65000.00, '2025-02-09 00:36:13', '2025-02-09 00:36:13'),
(19, 18, 1, 1, 33000.00, '2025-02-11 21:04:39', '2025-02-11 21:04:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_code` varchar(50) DEFAULT NULL,
  `supplier_type` enum('bahan_baku','kemasan','peralatan','jasa','lainnya') DEFAULT 'bahan_baku',
  `status` enum('aktif','tidak_aktif','blacklist') DEFAULT 'aktif',
  `contact` varchar(50) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `npwp` varchar(25) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account` varchar(50) DEFAULT NULL,
  `bank_account_name` varchar(100) DEFAULT NULL,
  `payment_terms` enum('cod','net7','net14','net30','net60') DEFAULT NULL,
  `contract_start_date` date DEFAULT NULL,
  `documents` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `company_code`, `supplier_type`, `status`, `contact`, `contact_person`, `address`, `city`, `province`, `postal_code`, `npwp`, `bank_name`, `bank_account`, `bank_account_name`, `payment_terms`, `contract_start_date`, `documents`, `notes`, `created_at`, `updated_at`, `email`, `website`) VALUES
(1, 'CV Sumber Berkah', NULL, 'bahan_baku', 'aktif', '08123456789', NULL, 'Jl. Raya No.1, Jakarta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-09 07:30:34', '2025-02-09 07:30:34', 'supplier1@email.com', NULL),
(2, 'PT Maju Jaya', NULL, 'bahan_baku', 'aktif', '08198765432', NULL, 'Jl. Merdeka No.10, Bandung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-09 07:30:34', '2025-02-09 07:30:34', 'supplier2@email.com', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','staff(edit)') NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Admin Utama', 'admin@gmail.com', NULL, '$2y$12$xGVHvyr5y/r2VF09fPDZM.SBc9q2AuTcWj7yRIDI4z.gwFqKsGh0u', 'admin', NULL, '2025-02-03 10:03:54', '2025-02-03 10:03:54'),
(4, 'Admin Utama2', 'admin2@gmail.com', NULL, '$2y$12$xGVHvyr5y/r2VF09fPDZM.SBc9q2AuTcWj7yRIDI4z.gwFqKsGh0u', 'staff', NULL, '2025-02-03 10:03:54', '2025-02-03 10:03:54'),
(6, 'ficky3', 'ficky3@gmail.com', NULL, '$2y$12$iPifup5vAY/IlGE/lWoUGuF.zQrz8JTr/26BMmZJluqg9FXNf0y9K', 'staff', NULL, '2025-04-16 00:49:20', '2025-04-16 00:49:20'),
(7, 'ficky5', 'ficky5@gmail.com', NULL, '$2y$12$sxUBkucQ2wOt/vgVdRBFA.rmYkOxM5TFkiMZqPWDZr/PQ9O13Szky', 'staff', NULL, '2025-04-16 01:01:18', '2025-04-16 01:01:18'),
(8, 'ficky0', 'ficky0@gmail.com', NULL, '$2y$12$zGmJYzeeTht7LvjInoAAMOvZbXTvP6y/yjFIZcBmjOh1AL989CEhK', 'staff', NULL, '2025-04-16 01:07:39', '2025-04-16 01:07:39'),
(9, 'ficky25', 'ficky25@gmail.com', NULL, '$2y$12$YU583IZy9QPA2VyX2pAJtOa4iMbm/l0xEoUu7g.A7nzoX1ee/ea1u', 'staff', NULL, '2025-04-28 07:38:51', '2025-04-28 07:38:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_supplier_id_foreign` (`supplier_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `order_packages`
--
ALTER TABLE `order_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_packages_order_id_foreign` (`order_id`),
  ADD KEY `order_packages_package_id_foreign` (`package_id`);

--
-- Indeks untuk tabel `order_staff`
--
ALTER TABLE `order_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_staff_order_id_foreign` (`order_id`),
  ADD KEY `order_staff_staff_id_foreign` (`staff_id`);

--
-- Indeks untuk tabel `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_name_unique` (`name`);

--
-- Indeks untuk tabel `package_menu`
--
ALTER TABLE `package_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_menu_package_id_foreign` (`package_id`),
  ADD KEY `package_menu_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_assigned_order_foreign` (`assigned_order`),
  ADD KEY `fk_staff_user_id` (`user_id`);

--
-- Indeks untuk tabel `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_customer_id_foreign` (`customer_id`);

--
-- Indeks untuk tabel `subscription_package`
--
ALTER TABLE `subscription_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_package_subscription_id_foreign` (`subscription_id`),
  ADD KEY `subscription_package_package_id_foreign` (`package_id`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_code` (`company_code`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT untuk tabel `order_packages`
--
ALTER TABLE `order_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `order_staff`
--
ALTER TABLE `order_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `package_menu`
--
ALTER TABLE `package_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `subscription_package`
--
ALTER TABLE `subscription_package`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_packages`
--
ALTER TABLE `order_packages`
  ADD CONSTRAINT `order_packages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_packages_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_staff`
--
ALTER TABLE `order_staff`
  ADD CONSTRAINT `order_staff_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `package_menu`
--
ALTER TABLE `package_menu`
  ADD CONSTRAINT `package_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_menu_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `fk_staff_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_assigned_order_foreign` FOREIGN KEY (`assigned_order`) REFERENCES `orders` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `subscription_package`
--
ALTER TABLE `subscription_package`
  ADD CONSTRAINT `subscription_package_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscription_package_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
