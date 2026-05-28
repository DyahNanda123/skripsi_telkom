-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 28, 2026 at 12:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_telkom`
--

-- --------------------------------------------------------

--
-- Table structure for table `calon_pelanggan`
--

CREATE TABLE `calon_pelanggan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `jenis_pelanggan` enum('Agrikultur','Energi','Sekolah','Ekspedisi','Manufaktur','Puskesmas/RS','SPPG','Media & Komunikasi','Multifinance','Properti','Hotel','Ruko') COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_maps` text COLLATE utf8mb4_unicode_ci,
  `status_langganan` enum('Berlangganan','Belum Berlangganan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Berlangganan',
  `status_visit` enum('Sudah Visit','Belum Visit','Progress','Follow Up') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Visit',
  `wilayah` enum('Magetan','Ngawi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sto` enum('GGR','JGO','KRJ','MGT','NWI','SAR','WKU') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calon_pelanggan`
--

INSERT INTO `calon_pelanggan` (`id`, `nama_pelanggan`, `alamat`, `jenis_pelanggan`, `link_maps`, `status_langganan`, `status_visit`, `wilayah`, `sto`, `created_at`, `updated_at`) VALUES
(1, 'SMAN 3 Magetan', 'Jl Raya Kalang', 'Sekolah', 'https://maps.app.goo.gl/9QXg9Y6KyJmp6BCHA', 'Berlangganan', 'Sudah Visit', 'Magetan', 'MGT', '2026-03-03 08:38:43', '2026-04-14 07:37:54'),
(3, 'Hotel Merah', 'Sarangan', 'Hotel', 'https://maps.app.goo.gl/9QXg9Y6KyJmp6BCHA', 'Berlangganan', 'Sudah Visit', 'Magetan', 'SAR', '2026-03-03 08:45:52', '2026-03-03 08:45:52'),
(6, 'Niskala', 'Jl Raya Magetan', 'Ruko', 'https://maps.app.goo.gl/GtJd7MZ1G2aGr8ke7', 'Berlangganan', 'Sudah Visit', 'Magetan', 'MGT', '2026-03-07 01:13:38', '2026-03-07 01:13:38'),
(7, 'Sate', 'Jl Raya Sarangan', 'Ruko', 'https://maps.app.goo.gl/GtJd7MZ1G2aGr8ke7', 'Berlangganan', 'Sudah Visit', 'Magetan', 'SAR', '2026-03-07 01:13:38', '2026-03-07 01:14:12'),
(8, 'Hotel Villa Merah', 'Jl Raya Sarangan', 'Hotel', 'https://maps.app.goo.gl/GtJd7MZ1G2aGr8ke8', 'Berlangganan', 'Sudah Visit', 'Magetan', 'SAR', '2026-03-07 01:13:38', '2026-03-07 01:15:08'),
(9, 'Arika', 'Plaosan', 'Ruko', NULL, 'Berlangganan', 'Sudah Visit', 'Magetan', 'MGT', '2026-04-01 08:46:27', '2026-04-02 03:24:00'),
(10, 'poltek', 'qqq', 'Energi', NULL, 'Belum Berlangganan', 'Progress', 'Ngawi', 'GGR', '2026-04-22 04:34:01', '2026-04-22 04:44:01'),
(11, 'Fore', '---', 'Ruko', NULL, 'Berlangganan', 'Progress', 'Magetan', 'GGR', '2026-04-25 03:41:56', '2026-04-29 13:18:59'),
(12, 'Kopi Kenangan', '-', 'Multifinance', NULL, 'Belum Berlangganan', 'Progress', 'Magetan', 'JGO', '2026-04-29 13:39:39', '2026-05-01 13:31:19'),
(14, 'Hotel Jaya', 'Maospati', 'Hotel', 'https://www.google.com/maps?q=-7.648182718016588,111.3257932662964', 'Berlangganan', 'Sudah Visit', 'Magetan', 'MGT', '2026-05-14 10:33:55', '2026-05-17 09:19:55');

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
-- Table structure for table `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `calon_pelanggan_id` bigint UNSIGNED NOT NULL,
  `status` enum('Selesai','Progress','Follow Up') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Progress',
  `hasil_kunjungan` enum('Berlangganan','Belum') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kesimpulan` text COLLATE utf8mb4_unicode_ci,
  `bukti_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kebutuhan_utama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `speed_eksisting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_eksisting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagihan_bulanan` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lat_visit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng_visit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kunjungan`
--

INSERT INTO `kunjungan` (`id`, `user_id`, `calon_pelanggan_id`, `status`, `hasil_kunjungan`, `kesimpulan`, `bukti_foto`, `nama_pic`, `no_hp_pic`, `kebutuhan_utama`, `speed_eksisting`, `provider_eksisting`, `tagihan_bulanan`, `created_at`, `updated_at`, `lat_visit`, `lng_visit`) VALUES
(1, 5, 3, 'Selesai', NULL, 'Belum memikirkan untuk upgrade wifi. ', NULL, 'Aca', '0881716543332', 'Wifi yang murah', '20', '30', 200, '2026-03-27 05:49:07', NULL, NULL, NULL),
(2, 5, 6, 'Selesai', 'Berlangganan', 'Mau berlangganan, bisa mulai melakukan pemasangan minggu depan. ', NULL, 'Hari', '0891827192', 'Internet lancar', '50MBPS', '-', 100, '2026-03-29 17:00:00', NULL, NULL, NULL),
(3, 3, 8, 'Selesai', 'Berlangganan', 'Mau', NULL, 'Adit', '0887987886543', 'Cepat', '20MBPS', '-', 100, '2026-03-31 17:00:00', NULL, NULL, NULL),
(4, 3, 1, 'Selesai', 'Berlangganan', 'Mau', NULL, 'Ika', '098762531821', 'Murah', '50MBPS', '-', 200, '2026-03-31 17:00:00', NULL, NULL, NULL),
(6, 9, 9, 'Selesai', 'Berlangganan', 'Mau dipasang minggu depan', '1775125440_6325526812079278414.jpg', 'Ibu Salma', '087654312444578', 'Murah', '50MBPS', 'Indihome', 50000, '2026-04-01 08:52:07', '2026-04-02 03:24:00', NULL, NULL),
(7, 9, 1, 'Selesai', 'Belum', 'Belum mau', '1775301938_6185845215667621418.jpg', 'ana', '0000000000', 'cepat', '10', '-', 2500000, '2026-04-04 11:24:38', '2026-04-04 11:25:38', NULL, NULL),
(8, 9, 1, 'Selesai', 'Berlangganan', 'mau dipasang minggu', '1776152274_WhatsApp Image 2025-12-19 at 16.10.08(1).jpeg', 'Mimis', '087876545334', 'Murah & Cepat', '50MBPS', 'Indihome', 750000, '2026-04-14 06:47:28', '2026-04-14 07:37:54', NULL, NULL),
(9, 9, 10, 'Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-22 04:44:01', '2026-04-22 04:44:01', NULL, NULL),
(10, 9, 11, 'Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 13:18:59', '2026-04-29 13:18:59', NULL, NULL),
(11, 14, 11, 'Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 13:22:21', '2026-04-29 13:22:21', NULL, NULL),
(12, 9, 12, 'Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-01 13:31:19', '2026-05-01 13:31:19', NULL, NULL),
(13, 9, 14, 'Selesai', 'Berlangganan', 'Aman', '1778758138_6185845215667621414.jpg', 'Andreas', '0987654321', 'cepat', '100', 'Indosat', 170000, '2026-05-14 11:21:04', '2026-05-14 11:28:58', '-7.943251787671234', '112.61766370091323');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_02_24_142032_create_calon_pelanggan_table', 1),
(6, '2026_02_24_144511_create_target_sales_table', 1),
(7, '2026_02_24_150548_create_strategi_promosi_table', 1),
(8, '2026_02_24_151459_create_kunjungan_table', 1),
(9, '2026_04_05_210250_create_notifikasis_table', 2),
(10, '2026_04_25_122625_add_kadaluwarsa_to_strategi_promosi_table', 3),
(11, '2026_05_14_175714_add_tracking_to_kunjungan_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasis`
--

INSERT INTO `notifikasis` (`id`, `user_id`, `judul`, `pesan`, `is_read`, `url`, `created_at`, `updated_at`) VALUES
(1, 9, 'Perubahan Target', 'Pimpinan mengubah target Anda.', 1, '/', '2026-04-14 06:03:46', '2026-04-14 06:04:24'),
(2, 8, 'Update Target Sales', 'Pimpinan mengubah target untuk Sales Galih', 1, '/strategi-target', '2026-04-14 06:03:46', '2026-04-14 06:11:58'),
(3, 3, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-14 06:13:51', '2026-04-14 06:13:51'),
(5, 5, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-14 06:13:51', '2026-04-14 06:13:51'),
(6, 8, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-14 06:13:51', '2026-04-14 06:13:51'),
(7, 9, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 1, '/strategi-target', '2026-04-14 06:13:51', '2026-04-14 06:15:04'),
(8, 9, 'Perubahan Target', 'Pimpinan mengubah target Anda.', 1, '/', '2026-04-14 06:41:55', '2026-04-14 06:42:32'),
(9, 8, 'Update Target Sales', 'Pimpinan mengubah target untuk Sales Galih', 0, '/strategi-target', '2026-04-14 06:41:55', '2026-04-14 06:41:55'),
(10, 3, 'Pembaruan Strategi', 'Pimpinan mengubah strategi promosi: Ajaran Baru', 0, '/strategi-target', '2026-04-14 06:42:05', '2026-04-14 06:42:05'),
(12, 5, 'Pembaruan Strategi', 'Pimpinan mengubah strategi promosi: Ajaran Baru', 0, '/strategi-target', '2026-04-14 06:42:05', '2026-04-14 06:42:05'),
(13, 8, 'Pembaruan Strategi', 'Pimpinan mengubah strategi promosi: Ajaran Baru', 0, '/strategi-target', '2026-04-14 06:42:05', '2026-04-14 06:42:05'),
(14, 9, 'Pembaruan Strategi', 'Pimpinan mengubah strategi promosi: Ajaran Baru', 1, '/strategi-target', '2026-04-14 06:42:05', '2026-04-14 06:42:28'),
(15, 8, 'Kunjungan Selesai', 'Galih telah mengisi form kunjungan untuk SMAN 3 Magetan', 0, 'http://localhost/skripsi_telkom/public/kunjungan', '2026-04-14 07:37:54', '2026-04-14 07:37:54'),
(16, 10, 'Kunjungan Selesai', 'Galih telah mengisi form kunjungan untuk SMAN 3 Magetan', 0, 'http://localhost/skripsi_telkom/public/kunjungan', '2026-04-14 07:37:54', '2026-04-14 07:37:54'),
(17, 3, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-04-25 05:06:44', '2026-04-25 05:06:44'),
(18, 5, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-04-25 05:06:44', '2026-04-25 05:06:44'),
(19, 9, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-04-25 05:06:44', '2026-04-25 05:06:44'),
(20, 8, 'Target Sales Diperbarui', 'Pimpinan telah menetapkan target bulanan untuk tim Sales.', 0, '/strategi-target', '2026-04-25 05:06:44', '2026-04-25 05:06:44'),
(21, 3, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 25 PS.', 0, '/', '2026-04-25 05:09:45', '2026-04-25 05:09:45'),
(22, 5, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-04-25 05:09:45', '2026-04-25 05:09:45'),
(23, 9, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-04-25 05:09:45', '2026-04-25 05:09:45'),
(24, 8, 'Target Sales Diperbarui', 'Pimpinan telah menetapkan target bulanan untuk tim Sales.', 0, '/strategi-target', '2026-04-25 05:09:45', '2026-04-25 05:09:45'),
(25, 3, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:30:52', '2026-04-25 05:30:52'),
(26, 5, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:30:52', '2026-04-25 05:30:52'),
(27, 8, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:30:52', '2026-04-25 05:30:52'),
(28, 9, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:30:52', '2026-04-25 05:30:52'),
(29, 11, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:30:52', '2026-04-25 05:30:52'),
(30, 12, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:30:52', '2026-04-25 05:30:52'),
(31, 3, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:49:51', '2026-04-25 05:49:51'),
(32, 5, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:49:51', '2026-04-25 05:49:51'),
(33, 8, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:49:51', '2026-04-25 05:49:51'),
(34, 9, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:49:51', '2026-04-25 05:49:51'),
(35, 11, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:49:51', '2026-04-25 05:49:51'),
(36, 12, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-25 05:49:51', '2026-04-25 05:49:51'),
(37, 3, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-29 14:14:08', '2026-04-29 14:14:08'),
(38, 5, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-29 14:14:08', '2026-04-29 14:14:08'),
(39, 8, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 1, '/strategi-target', '2026-04-29 14:14:08', '2026-04-29 14:15:01'),
(40, 9, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 1, '/strategi-target', '2026-04-29 14:14:08', '2026-04-29 14:14:35'),
(41, 11, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-29 14:14:08', '2026-04-29 14:14:08'),
(42, 12, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-29 14:14:08', '2026-04-29 14:14:08'),
(43, 13, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-29 14:14:08', '2026-04-29 14:14:08'),
(44, 14, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-04-29 14:14:08', '2026-04-29 14:14:08'),
(45, 3, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(46, 5, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(47, 8, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(48, 9, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(49, 11, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(50, 12, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(51, 13, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(52, 14, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(53, 15, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-01 07:03:16', '2026-05-01 07:03:16'),
(54, 3, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:25:05', '2026-05-01 07:25:05'),
(55, 5, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:25:05', '2026-05-01 07:25:05'),
(56, 9, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:25:05', '2026-05-01 07:25:05'),
(57, 14, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:25:05', '2026-05-01 07:25:05'),
(58, 3, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 19 PS.', 0, '/', '2026-05-01 07:26:44', '2026-05-01 07:26:44'),
(59, 5, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:26:44', '2026-05-01 07:26:44'),
(60, 9, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:26:44', '2026-05-01 07:26:44'),
(61, 14, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:26:44', '2026-05-01 07:26:44'),
(62, 3, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:27:14', '2026-05-01 07:27:14'),
(63, 5, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:27:14', '2026-05-01 07:27:14'),
(64, 9, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:27:14', '2026-05-01 07:27:14'),
(65, 14, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:27:15', '2026-05-01 07:27:15'),
(66, 3, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:31:00', '2026-05-01 07:31:00'),
(67, 5, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:31:01', '2026-05-01 07:31:01'),
(68, 9, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:31:01', '2026-05-01 07:31:01'),
(69, 14, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:31:01', '2026-05-01 07:31:01'),
(70, 3, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 19 PS.', 0, '/', '2026-05-01 07:31:10', '2026-05-01 07:31:10'),
(71, 5, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:31:10', '2026-05-01 07:31:10'),
(72, 9, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:31:10', '2026-05-01 07:31:10'),
(73, 14, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-01 07:31:10', '2026-05-01 07:31:10'),
(74, 9, 'Perubahan Target', 'Pimpinan mengubah target Anda.', 0, '/', '2026-05-01 07:38:40', '2026-05-01 07:38:40'),
(75, 8, 'Update Target Sales', 'Pimpinan mengubah target untuk Sales Galih', 0, '/strategi-target', '2026-05-01 07:38:40', '2026-05-01 07:38:40'),
(76, 13, 'Update Target Sales', 'Pimpinan mengubah target untuk Sales Galih', 0, '/strategi-target', '2026-05-01 07:38:40', '2026-05-01 07:38:40'),
(77, 8, 'Kunjungan Selesai', 'Galih telah mengisi form kunjungan untuk Hotel Jaya', 0, 'http://localhost/skripsi_telkom/public/kunjungan', '2026-05-14 11:28:58', '2026-05-14 11:28:58'),
(78, 10, 'Kunjungan Selesai', 'Galih telah mengisi form kunjungan untuk Hotel Jaya', 0, 'http://localhost/skripsi_telkom/public/kunjungan', '2026-05-14 11:28:58', '2026-05-14 11:28:58'),
(79, 13, 'Kunjungan Selesai', 'Galih telah mengisi form kunjungan untuk Hotel Jaya', 0, 'http://localhost/skripsi_telkom/public/kunjungan', '2026-05-14 11:28:58', '2026-05-14 11:28:58'),
(80, 3, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(81, 5, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(82, 8, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(83, 9, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(84, 11, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(85, 12, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(86, 13, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(87, 14, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(88, 15, 'Strategi Promosi Baru', 'Pimpinan menambahkan strategi promosi baru.', 0, '/strategi-target', '2026-05-17 12:14:30', '2026-05-17 12:14:30'),
(89, 3, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-17 12:22:04', '2026-05-17 12:22:04'),
(90, 5, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-17 12:22:04', '2026-05-17 12:22:04'),
(91, 9, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-17 12:22:04', '2026-05-17 12:22:04'),
(92, 14, 'Target Baru', 'Pimpinan menetapkan target baru Anda sebesar 20 PS.', 0, '/', '2026-05-17 12:22:04', '2026-05-17 12:22:04');

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
-- Table structure for table `strategi_promosi`
--

CREATE TABLE `strategi_promosi` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `kategori` enum('brosur','poster','video','presentasi','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_kadaluwarsa` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strategi_promosi`
--

INSERT INTO `strategi_promosi` (`id`, `judul`, `file_path`, `user_id`, `deskripsi`, `kategori`, `tanggal_kadaluwarsa`, `created_at`, `updated_at`) VALUES
(9, 'k', 'uploads/promosi/1777096191_c27b25a4ef7abbfdbdd2092efd996d47.jpg', 10, 'k', 'brosur', '2026-04-27', '2026-04-25 05:49:51', '2026-04-25 05:56:44'),
(10, 'Promo Hari Kartini', 'uploads/promosi/1777472048_foto ijazah 3x4.jpeg', 10, 'Buruan', 'brosur', '2026-04-29', '2026-04-29 14:14:08', '2026-04-29 14:14:08'),
(11, 'ff', 'uploads/promosi/1777618996_SKRIPSI-Copy of ERD.drawio(4).png', 10, 'fffff', 'poster', '2026-05-01', '2026-05-01 07:03:16', '2026-05-01 07:16:53'),
(12, 'Promo Ajaran Baru', 'uploads/promosi/1779020070_telkom-.jpg', 10, 'Spesial untuk sekolah tahun ajaran baru, diskon pemasangan up to 50%.', 'brosur', '2026-06-30', '2026-05-17 12:14:30', '2026-05-17 12:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `target_sales`
--

CREATE TABLE `target_sales` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `bulan` enum('1','2','3','4','5','6','7','8','9','10','11','12') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `jumlah_target` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `target_sales`
--

INSERT INTO `target_sales` (`id`, `user_id`, `bulan`, `tahun`, `jumlah_target`, `created_at`, `updated_at`) VALUES
(5, 9, '4', 2026, 20, '2026-04-03 06:38:31', '2026-04-25 05:06:44'),
(6, 3, '4', 2026, 25, '2026-04-25 05:06:44', '2026-04-25 05:09:45'),
(7, 5, '4', 2026, 20, '2026-04-25 05:06:44', '2026-04-25 05:06:44'),
(12, 3, '5', 2026, 20, '2026-05-01 07:27:14', '2026-05-17 12:22:04'),
(15, 14, '5', 2026, 20, '2026-05-01 07:27:15', '2026-05-01 07:27:15'),
(16, 5, '5', 2026, 20, '2026-05-17 12:22:04', '2026-05-17 12:22:04'),
(17, 9, '5', 2026, 20, '2026-05-17 12:22:04', '2026-05-17 12:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','pimpinan','sales') COLLATE utf8mb4_unicode_ci NOT NULL,
  `wilayah_kerja` enum('ngawi','magetan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `nip`, `password`, `role`, `wilayah_kerja`, `email`, `nomor_hp`, `alamat`, `foto_profil`, `status_aktif`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Bagus', '123454', '$2y$12$Bp4DP3pAsf9hHfbSqxyqveO0VZcqgwkdk/8NH22hmtwx0ZmSS531a', 'sales', 'ngawi', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-02-27 07:29:39', '2026-04-01 07:33:21'),
(5, 'Atmaja', '123452', '$2y$12$XkwrNpFk2pWQUGVfL2F9Cev3pOI/qCxMSk454ZUrcycjaasT2.bFW', 'sales', 'ngawi', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-02-27 07:29:39', '2026-02-27 07:29:39'),
(8, 'Dyah', '1234567', '$2y$12$86EORwaNoqzMyvls5CaTgugtOwTC6YweU6sBwj95cH1N9Gi6V3OKS', 'admin', 'ngawi', 'nandadyah2@gmail.com', '08817140376', 'Magetan', 'profil/3AeJ3tUVWf8kgpsmtqC34iMsFu99OzVRZ0h8imBc.jpg', 1, NULL, NULL, '2026-04-01 07:26:50', '2026-05-01 05:49:05'),
(9, 'Galih', '11111111', '$2y$12$lHk0fFn3QWF1ipPdq3zv6OP0ulM3eEIuWxb1M.pi55UlWrvJvQCxG', 'sales', 'ngawi', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-04-01 07:33:03', '2026-04-01 07:33:03'),
(10, 'Arya', '22222222', '$2y$12$r4noYDBj/IePiy.ccPZ8OO3uoUako5FZqWkJK8S4AmHgD6bVHtRP.', 'pimpinan', 'ngawi', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-04-01 07:33:52', '2026-04-01 07:33:52'),
(11, 'Ayu', '33333333', '$2y$12$X5zBE9n/AUZ68huvM8JLG.Gd3qOsIdL4Hu2OJBCkUrHCqlwHeIpmK', 'sales', 'ngawi', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-25 03:31:00', '2026-04-25 03:32:03'),
(12, 'Ayus', '44444444', '$2y$12$waFSr4gS3sKGxxCm0WIDceZxnK5J/F5lN.u/9XnQ1OEQlS3vQQ2HK', 'sales', 'ngawi', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-25 03:40:21', '2026-04-25 03:42:51'),
(13, 'Arya', '55555555', '$2y$12$ZoncC2p5CGN21Pvo.H6i7elRSbdPmlmL7APWH98nD4fXajAcbiRVq', 'admin', 'magetan', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-04-28 02:49:11', '2026-04-28 02:49:11'),
(14, 'Bima', '66666666', '$2y$12$zozezoph3RhEDot1wesi7OTw6A.nCeSj4RLAGvIpuqx3NvwNWXITq', 'sales', 'ngawi', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-04-29 13:21:51', '2026-04-29 13:21:51'),
(15, 'amira', '101010', '$2y$12$5Zoh8Oy8ZDAOt0nWOU4Ziejj3/Rw1ibHXcp/mCmaGNA1gow.CuEOq', 'sales', 'magetan', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-30 07:24:38', '2026-04-30 07:54:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calon_pelanggan`
--
ALTER TABLE `calon_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunjungan_user_id_foreign` (`user_id`),
  ADD KEY `kunjungan_calon_pelanggan_id_foreign` (`calon_pelanggan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_foreign` (`user_id`);

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
-- Indexes for table `strategi_promosi`
--
ALTER TABLE `strategi_promosi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strategi_promosi_user_id_foreign` (`user_id`);

--
-- Indexes for table `target_sales`
--
ALTER TABLE `target_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_sales_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_nip_unique` (`nip`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calon_pelanggan`
--
ALTER TABLE `calon_pelanggan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strategi_promosi`
--
ALTER TABLE `strategi_promosi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `target_sales`
--
ALTER TABLE `target_sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD CONSTRAINT `kunjungan_calon_pelanggan_id_foreign` FOREIGN KEY (`calon_pelanggan_id`) REFERENCES `calon_pelanggan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kunjungan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strategi_promosi`
--
ALTER TABLE `strategi_promosi`
  ADD CONSTRAINT `strategi_promosi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `target_sales`
--
ALTER TABLE `target_sales`
  ADD CONSTRAINT `target_sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
