-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2026 at 07:16 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u771257746_argahomes`
--

-- --------------------------------------------------------

--
-- Table structure for table `antreans`
--

CREATE TABLE `antreans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barbershop_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nomor_antrean_seq` smallint(5) UNSIGNED NOT NULL COMMENT 'Sequential queue number per day (01-99)',
  `nama_pelanggan` varchar(25) NOT NULL,
  `layanan_id1` bigint(20) UNSIGNED DEFAULT NULL,
  `layanan_id2` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('menunggu','sedang dilayani','selesai','batal') NOT NULL DEFAULT 'menunggu',
  `is_notified_near` tinyint(1) NOT NULL DEFAULT 0,
  `is_notified_time` tinyint(1) NOT NULL DEFAULT 0,
  `is_booking` tinyint(1) NOT NULL DEFAULT 0,
  `tanggal_booking` date DEFAULT NULL,
  `waktu_booking` time DEFAULT NULL,
  `alasan_batal` text DEFAULT NULL,
  `waktu_masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `batal_oleh` varchar(255) DEFAULT NULL COMMENT 'pelanggan, admin, no_show'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `antreans`
--

INSERT INTO `antreans` (`id`, `barbershop_id`, `user_id`, `nomor_antrean_seq`, `nama_pelanggan`, `layanan_id1`, `layanan_id2`, `status`, `is_notified_near`, `is_notified_time`, `is_booking`, `tanggal_booking`, `waktu_booking`, `alasan_batal`, `waktu_masuk`, `waktu_selesai`, `created_at`, `updated_at`, `batal_oleh`) VALUES
(1, 1, 5, 1, 'Erwin', 4, NULL, 'batal', 0, 0, 0, NULL, NULL, 'awdasd', '2026-06-26 09:40:42', '2026-06-26 09:40:47', '2026-06-26 09:40:42', '2026-06-26 09:40:47', 'pelanggan');

-- --------------------------------------------------------

--
-- Table structure for table `antrean_layanan`
--

CREATE TABLE `antrean_layanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `antrean_id` bigint(20) UNSIGNED NOT NULL,
  `layanan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barbershops`
--

CREATE TABLE `barbershops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `nama_brand` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `alaamat` varchar(255) DEFAULT NULL,
  `kontak` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`kontak`)),
  `email` varchar(255) DEFAULT NULL,
  `warna_primer` varchar(7) NOT NULL DEFAULT '#e8a53a',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `slogan` varchar(255) NOT NULL DEFAULT 'Barber, Coffee & Food',
  `deskripsi_hero` text DEFAULT NULL,
  `gambar_hero` varchar(255) DEFAULT NULL,
  `judul_hero_layanan` varchar(255) NOT NULL DEFAULT 'Daftar Layanan',
  `deskripsi_hero_layanan` text DEFAULT NULL,
  `gambar_hero_layanan` varchar(255) DEFAULT NULL,
  `judul_hero_galeri` varchar(255) NOT NULL DEFAULT 'Galeri Kami',
  `deskripsi_hero_galeri` text DEFAULT NULL,
  `gambar_hero_galeri` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori` varchar(20) NOT NULL DEFAULT 'barbershop'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barbershops`
--

INSERT INTO `barbershops` (`id`, `nama`, `slug`, `alamat`, `telepon`, `deskripsi`, `logo`, `is_active`, `nama_brand`, `favicon`, `alaamat`, `kontak`, `email`, `warna_primer`, `latitude`, `longitude`, `slogan`, `deskripsi_hero`, `gambar_hero`, `judul_hero_layanan`, `deskripsi_hero_layanan`, `gambar_hero_layanan`, `judul_hero_galeri`, `deskripsi_hero_galeri`, `gambar_hero_galeri`, `created_at`, `updated_at`, `kategori`) VALUES
(1, 'Arga Barbershop', 'arga-barbershop', 'Jl. Raya Toba No. 12, Balige', '081234567890', 'Barbershop terbaik di Balige dengan pelayanan ramah dan profesional.', NULL, 1, 'Arga Barbershop', 'assets/images/logo.png', 'Jl.P.Siantar Km 2, Tampubolon, Sibolahotangaso Kec. Balige, Tobasa, Sumatera Utara', '{\"instagram\":\"https:\\/\\/instagram.com\",\"facebook\":\"https:\\/\\/facebook.com\",\"whatsapp\":\"082167893019\",\"map_embed\":\"https:\\/\\/maps.google.com\\/maps?q=2.386130,99.147852&z=15&output=embed\",\"link_map\":\"https:\\/\\/www.google.com\\/maps\\/search\\/?api=1&query=2.386130,99.147852\"}', 'joebarberid@gmail.com', '#e8a53a', 2.38613000, 99.14785200, 'Barber, Coffee & Food', 'Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!', NULL, 'Daftar Layanan', 'Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.', NULL, 'Galeri Arga Barbershop', 'Lihat suasana barbershop, hasil potongan rambut, dan area cafe sebelum datang ke tempat.', NULL, NULL, NULL, 'barbershop'),
(2, 'Toba Salon', 'toba-barbershop', 'Jl. Sisingamangaraja No. 45, Balige', '082198765432', 'Salon premium dengan pelayanan kecantikan dan perawatan rambut terbaik.', NULL, 1, 'Toba Salon', 'assets/images/logo.png', 'Jl. Sisingamangaraja No. 45, Balige', '{\"instagram\":\"https:\\/\\/instagram.com\",\"facebook\":\"https:\\/\\/facebook.com\",\"whatsapp\":\"082198765432\",\"map_embed\":\"https:\\/\\/maps.google.com\\/maps?q=2.383120,99.148810&z=15&output=embed\",\"link_map\":\"https:\\/\\/www.google.com\\/maps\\/search\\/?api=1&query=2.383120,99.148810\"}', 'tobabarber@gmail.com', '#EC4899', 2.38613000, 99.14785200, 'Premium Beauty Experience', 'Nikmati layanan perawatan kecantikan dan rambut premium oleh stylist profesional kami.', NULL, 'Layanan Kami', 'Daftar perawatan kecantikan dan rambut premium untuk penampilan maksimal Anda.', NULL, 'Galeri Toba Salon', 'Dokumentasi visual kenyamanan dan hasil perawatan rambut di Toba Salon.', NULL, NULL, NULL, 'salon'),
(3, 'Laguboti Barbershop', 'laguboti-barbershop', 'Jl. Sisingamangaraja No. 102, Laguboti', '082111223344', 'Barbershop nyaman dengan pelayanan ramah di Laguboti.', NULL, 1, 'Laguboti Barbershop', 'assets/images/logo.png', 'Jl. Sisingamangaraja No. 102, Laguboti', '{\"instagram\":\"https:\\/\\/instagram.com\",\"facebook\":\"https:\\/\\/facebook.com\",\"whatsapp\":\"082111223344\",\"map_embed\":\"https:\\/\\/maps.google.com\\/maps?q=2.378900,99.124500&z=15&output=embed\",\"link_map\":\"https:\\/\\/www.google.com\\/maps\\/search\\/?api=1&query=2.378900,99.124500\"}', 'lagubotibarber@gmail.com', '#0578FB', 2.38613000, 99.14785200, 'Gentlemen Haircut & Cafe', 'Solusi ketampanan pria modern di Laguboti. Cepat, rapi, dan terjangkau.', NULL, 'Pilihan Layanan', 'Kami menyediakan berbagai tipe potongan rambut sesuai gaya terkini.', NULL, 'Galeri Laguboti Barbershop', 'Foto-foto sudut Laguboti Barbershop yang estetik dan hasil pangkas rambut pelanggan.', NULL, NULL, NULL, 'barbershop');

-- --------------------------------------------------------

--
-- Table structure for table `block_histories`
--

CREATE TABLE `block_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-active_layanans_tenant_1', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:9:{i:0;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:1;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Regular\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:60000;s:14:\"estimasi_waktu\";s:2:\"60\";s:9:\"deskripsi\";s:26:\"Haircut, hairwash, styling\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:45:44\";s:10:\"updated_at\";s:19:\"2026-06-11 07:45:44\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:1;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Regular\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:60000;s:14:\"estimasi_waktu\";s:2:\"60\";s:9:\"deskripsi\";s:26:\"Haircut, hairwash, styling\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:45:44\";s:10:\"updated_at\";s:19:\"2026-06-11 07:45:44\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:2;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Premium\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:80000;s:14:\"estimasi_waktu\";s:2:\"90\";s:9:\"deskripsi\";s:60:\"Haircut, hairwash, tonic, hot towel, head massage, cold towe\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:48:21\";s:10:\"updated_at\";s:19:\"2026-06-11 07:48:21\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:2;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Premium\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:80000;s:14:\"estimasi_waktu\";s:2:\"90\";s:9:\"deskripsi\";s:60:\"Haircut, hairwash, tonic, hot towel, head massage, cold towe\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:48:21\";s:10:\"updated_at\";s:19:\"2026-06-11 07:48:21\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:3;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:9:\"Executive\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:100000;s:14:\"estimasi_waktu\";s:3:\"120\";s:9:\"deskripsi\";s:60:\"Haircut, hairwash, black mask, tonic, hot towel, head massag\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:49:48\";s:10:\"updated_at\";s:19:\"2026-06-11 07:49:48\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:3;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:9:\"Executive\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:100000;s:14:\"estimasi_waktu\";s:3:\"120\";s:9:\"deskripsi\";s:60:\"Haircut, hairwash, black mask, tonic, hot towel, head massag\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:49:48\";s:10:\"updated_at\";s:19:\"2026-06-11 07:49:48\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:4;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:4:\"Bald\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:60000;s:14:\"estimasi_waktu\";s:2:\"45\";s:9:\"deskripsi\";s:60:\"Complete head shave using clippers or razor for a smooth fin\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:52:21\";s:10:\"updated_at\";s:19:\"2026-06-11 07:56:36\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:4;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:4:\"Bald\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:60000;s:14:\"estimasi_waktu\";s:2:\"45\";s:9:\"deskripsi\";s:60:\"Complete head shave using clippers or razor for a smooth fin\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:52:21\";s:10:\"updated_at\";s:19:\"2026-06-11 07:56:36\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:5;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Shaving\";s:4:\"ikon\";s:4:\"face\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"20\";s:9:\"deskripsi\";s:43:\"Clean facial shave or precision beard trim.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:52:45\";s:10:\"updated_at\";s:19:\"2026-06-11 07:56:20\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:5;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Shaving\";s:4:\"ikon\";s:4:\"face\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"20\";s:9:\"deskripsi\";s:43:\"Clean facial shave or precision beard trim.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:52:45\";s:10:\"updated_at\";s:19:\"2026-06-11 07:56:20\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:6;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:11:\"Face Facial\";s:4:\"ikon\";s:4:\"face\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"30\";s:9:\"deskripsi\";s:58:\"Refreshing facial treatment, head massage, and cold towel.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:53:24\";s:10:\"updated_at\";s:19:\"2026-06-11 07:58:43\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:6;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:11:\"Face Facial\";s:4:\"ikon\";s:4:\"face\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"30\";s:9:\"deskripsi\";s:58:\"Refreshing facial treatment, head massage, and cold towel.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:53:24\";s:10:\"updated_at\";s:19:\"2026-06-11 07:58:43\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:7;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:24:\"Coloring Basic / Fashion\";s:4:\"ikon\";s:5:\"paint\";s:5:\"harga\";i:100000;s:14:\"estimasi_waktu\";s:2:\"60\";s:9:\"deskripsi\";s:60:\"Professional hair coloring using natural or trendy fashion s\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:55:59\";s:10:\"updated_at\";s:19:\"2026-06-11 07:55:59\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:7;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:24:\"Coloring Basic / Fashion\";s:4:\"ikon\";s:5:\"paint\";s:5:\"harga\";i:100000;s:14:\"estimasi_waktu\";s:2:\"60\";s:9:\"deskripsi\";s:60:\"Professional hair coloring using natural or trendy fashion s\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:55:59\";s:10:\"updated_at\";s:19:\"2026-06-11 07:55:59\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:8;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:16:\"Hairwash & Style\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"20\";s:9:\"deskripsi\";s:56:\"Invigorating hair wash followed by professional styling.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:57:58\";s:10:\"updated_at\";s:19:\"2026-06-11 07:57:58\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:8;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:16:\"Hairwash & Style\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"20\";s:9:\"deskripsi\";s:56:\"Invigorating hair wash followed by professional styling.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:57:58\";s:10:\"updated_at\";s:19:\"2026-06-11 07:57:58\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:9;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:9:\"Bleaching\";s:4:\"ikon\";s:5:\"paint\";s:5:\"harga\";i:200000;s:14:\"estimasi_waktu\";s:2:\"90\";s:9:\"deskripsi\";s:60:\"Professional hair lightening process to prepare for vivid co\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:58:27\";s:10:\"updated_at\";s:19:\"2026-06-15 08:51:30\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:9;s:13:\"barbershop_id\";i:1;s:7:\"user_id\";N;s:4:\"nama\";s:9:\"Bleaching\";s:4:\"ikon\";s:5:\"paint\";s:5:\"harga\";i:200000;s:14:\"estimasi_waktu\";s:2:\"90\";s:9:\"deskripsi\";s:60:\"Professional hair lightening process to prepare for vivid co\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:58:27\";s:10:\"updated_at\";s:19:\"2026-06-15 08:51:30\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1782457307),
('laravel-cache-active_layanans_tenant_2', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:9:{i:0;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:10;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Regular\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:60000;s:14:\"estimasi_waktu\";s:2:\"60\";s:9:\"deskripsi\";s:26:\"Haircut, hairwash, styling\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:45:44\";s:10:\"updated_at\";s:19:\"2026-06-11 07:45:44\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:10;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Regular\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:60000;s:14:\"estimasi_waktu\";s:2:\"60\";s:9:\"deskripsi\";s:26:\"Haircut, hairwash, styling\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:45:44\";s:10:\"updated_at\";s:19:\"2026-06-11 07:45:44\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:11;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Premium\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:80000;s:14:\"estimasi_waktu\";s:2:\"90\";s:9:\"deskripsi\";s:60:\"Haircut, hairwash, tonic, hot towel, head massage, cold towe\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:48:21\";s:10:\"updated_at\";s:19:\"2026-06-11 07:48:21\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:11;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Premium\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:80000;s:14:\"estimasi_waktu\";s:2:\"90\";s:9:\"deskripsi\";s:60:\"Haircut, hairwash, tonic, hot towel, head massage, cold towe\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:48:21\";s:10:\"updated_at\";s:19:\"2026-06-11 07:48:21\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:12;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:9:\"Executive\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:100000;s:14:\"estimasi_waktu\";s:3:\"120\";s:9:\"deskripsi\";s:60:\"Haircut, hairwash, black mask, tonic, hot towel, head massag\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:49:48\";s:10:\"updated_at\";s:19:\"2026-06-11 07:49:48\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:12;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:9:\"Executive\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:100000;s:14:\"estimasi_waktu\";s:3:\"120\";s:9:\"deskripsi\";s:60:\"Haircut, hairwash, black mask, tonic, hot towel, head massag\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:49:48\";s:10:\"updated_at\";s:19:\"2026-06-11 07:49:48\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:13;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:4:\"Bald\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:60000;s:14:\"estimasi_waktu\";s:2:\"45\";s:9:\"deskripsi\";s:60:\"Complete head shave using clippers or razor for a smooth fin\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:52:21\";s:10:\"updated_at\";s:19:\"2026-06-11 07:56:36\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:13;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:4:\"Bald\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:60000;s:14:\"estimasi_waktu\";s:2:\"45\";s:9:\"deskripsi\";s:60:\"Complete head shave using clippers or razor for a smooth fin\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:52:21\";s:10:\"updated_at\";s:19:\"2026-06-11 07:56:36\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:14;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Shaving\";s:4:\"ikon\";s:4:\"face\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"20\";s:9:\"deskripsi\";s:43:\"Clean facial shave or precision beard trim.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:52:45\";s:10:\"updated_at\";s:19:\"2026-06-11 07:56:20\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:14;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:7:\"Shaving\";s:4:\"ikon\";s:4:\"face\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"20\";s:9:\"deskripsi\";s:43:\"Clean facial shave or precision beard trim.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:52:45\";s:10:\"updated_at\";s:19:\"2026-06-11 07:56:20\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:15;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:11:\"Face Facial\";s:4:\"ikon\";s:4:\"face\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"30\";s:9:\"deskripsi\";s:58:\"Refreshing facial treatment, head massage, and cold towel.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:53:24\";s:10:\"updated_at\";s:19:\"2026-06-11 07:58:43\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:15;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:11:\"Face Facial\";s:4:\"ikon\";s:4:\"face\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"30\";s:9:\"deskripsi\";s:58:\"Refreshing facial treatment, head massage, and cold towel.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:53:24\";s:10:\"updated_at\";s:19:\"2026-06-11 07:58:43\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:16;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:24:\"Coloring Basic / Fashion\";s:4:\"ikon\";s:5:\"paint\";s:5:\"harga\";i:100000;s:14:\"estimasi_waktu\";s:2:\"60\";s:9:\"deskripsi\";s:60:\"Professional hair coloring using natural or trendy fashion s\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:55:59\";s:10:\"updated_at\";s:19:\"2026-06-11 07:55:59\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:16;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:24:\"Coloring Basic / Fashion\";s:4:\"ikon\";s:5:\"paint\";s:5:\"harga\";i:100000;s:14:\"estimasi_waktu\";s:2:\"60\";s:9:\"deskripsi\";s:60:\"Professional hair coloring using natural or trendy fashion s\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:55:59\";s:10:\"updated_at\";s:19:\"2026-06-11 07:55:59\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:17;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:16:\"Hairwash & Style\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"20\";s:9:\"deskripsi\";s:56:\"Invigorating hair wash followed by professional styling.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:57:58\";s:10:\"updated_at\";s:19:\"2026-06-11 07:57:58\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:17;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:16:\"Hairwash & Style\";s:4:\"ikon\";s:8:\"scissors\";s:5:\"harga\";i:30000;s:14:\"estimasi_waktu\";s:2:\"20\";s:9:\"deskripsi\";s:56:\"Invigorating hair wash followed by professional styling.\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:57:58\";s:10:\"updated_at\";s:19:\"2026-06-11 07:57:58\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:18:\"App\\Models\\Layanan\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"layanans\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:18;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:9:\"Bleaching\";s:4:\"ikon\";s:5:\"paint\";s:5:\"harga\";i:200000;s:14:\"estimasi_waktu\";s:2:\"90\";s:9:\"deskripsi\";s:60:\"Professional hair lightening process to prepare for vivid co\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:58:27\";s:10:\"updated_at\";s:19:\"2026-06-15 08:51:30\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:18;s:13:\"barbershop_id\";i:2;s:7:\"user_id\";N;s:4:\"nama\";s:9:\"Bleaching\";s:4:\"ikon\";s:5:\"paint\";s:5:\"harga\";i:200000;s:14:\"estimasi_waktu\";s:2:\"90\";s:9:\"deskripsi\";s:60:\"Professional hair lightening process to prepare for vivid co\";s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-06-11 07:58:27\";s:10:\"updated_at\";s:19:\"2026-06-15 08:51:30\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:4:\"nama\";i:1;s:5:\"harga\";i:2;s:14:\"estimasi_waktu\";i:3;s:9:\"deskripsi\";i:4;s:4:\"ikon\";i:5;s:9:\"is_active\";i:6;s:7:\"user_id\";i:7;s:13:\"barbershop_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1782450971);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeris`
--

CREATE TABLE `galeris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barbershop_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(30) NOT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `gambar` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incompatibilities`
--

CREATE TABLE `incompatibilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id_a` bigint(20) UNSIGNED NOT NULL,
  `service_id_b` bigint(20) UNSIGNED NOT NULL,
  `deskripsi_konflik` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanans`
--

CREATE TABLE `layanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barbershop_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(25) NOT NULL,
  `ikon` varchar(255) DEFAULT NULL,
  `harga` mediumint(9) NOT NULL,
  `estimasi_waktu` varchar(10) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanans`
--

INSERT INTO `layanans` (`id`, `barbershop_id`, `user_id`, `nama`, `ikon`, `harga`, `estimasi_waktu`, `deskripsi`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Regular', 'scissors', 60000, '60', 'Haircut, hairwash, styling', 1, '2026-06-11 07:45:44', '2026-06-11 07:45:44'),
(2, 1, NULL, 'Premium', 'scissors', 80000, '90', 'Haircut, hairwash, tonic, hot towel, head massage, cold towe', 1, '2026-06-11 07:48:21', '2026-06-11 07:48:21'),
(3, 1, NULL, 'Executive', 'scissors', 100000, '120', 'Haircut, hairwash, black mask, tonic, hot towel, head massag', 1, '2026-06-11 07:49:48', '2026-06-11 07:49:48'),
(4, 1, NULL, 'Bald', 'scissors', 60000, '45', 'Complete head shave using clippers or razor for a smooth fin', 1, '2026-06-11 07:52:21', '2026-06-11 07:56:36'),
(5, 1, NULL, 'Shaving', 'face', 30000, '20', 'Clean facial shave or precision beard trim.', 1, '2026-06-11 07:52:45', '2026-06-11 07:56:20'),
(6, 1, NULL, 'Face Facial', 'face', 30000, '30', 'Refreshing facial treatment, head massage, and cold towel.', 1, '2026-06-11 07:53:24', '2026-06-11 07:58:43'),
(7, 1, NULL, 'Coloring Basic / Fashion', 'paint', 100000, '60', 'Professional hair coloring using natural or trendy fashion s', 1, '2026-06-11 07:55:59', '2026-06-11 07:55:59'),
(8, 1, NULL, 'Hairwash & Style', 'scissors', 30000, '20', 'Invigorating hair wash followed by professional styling.', 1, '2026-06-11 07:57:58', '2026-06-11 07:57:58'),
(9, 1, NULL, 'Bleaching', 'paint', 200000, '90', 'Professional hair lightening process to prepare for vivid co', 1, '2026-06-11 07:58:27', '2026-06-15 08:51:30'),
(10, 2, NULL, 'Regular', 'scissors', 60000, '60', 'Haircut, hairwash, styling', 1, '2026-06-11 07:45:44', '2026-06-11 07:45:44'),
(11, 2, NULL, 'Premium', 'scissors', 80000, '90', 'Haircut, hairwash, tonic, hot towel, head massage, cold towe', 1, '2026-06-11 07:48:21', '2026-06-11 07:48:21'),
(12, 2, NULL, 'Executive', 'scissors', 100000, '120', 'Haircut, hairwash, black mask, tonic, hot towel, head massag', 1, '2026-06-11 07:49:48', '2026-06-11 07:49:48'),
(13, 2, NULL, 'Bald', 'scissors', 60000, '45', 'Complete head shave using clippers or razor for a smooth fin', 1, '2026-06-11 07:52:21', '2026-06-11 07:56:36'),
(14, 2, NULL, 'Shaving', 'face', 30000, '20', 'Clean facial shave or precision beard trim.', 1, '2026-06-11 07:52:45', '2026-06-11 07:56:20'),
(15, 2, NULL, 'Face Facial', 'face', 30000, '30', 'Refreshing facial treatment, head massage, and cold towel.', 1, '2026-06-11 07:53:24', '2026-06-11 07:58:43'),
(16, 2, NULL, 'Coloring Basic / Fashion', 'paint', 100000, '60', 'Professional hair coloring using natural or trendy fashion s', 1, '2026-06-11 07:55:59', '2026-06-11 07:55:59'),
(17, 2, NULL, 'Hairwash & Style', 'scissors', 30000, '20', 'Invigorating hair wash followed by professional styling.', 1, '2026-06-11 07:57:58', '2026-06-11 07:57:58'),
(18, 2, NULL, 'Bleaching', 'paint', 200000, '90', 'Professional hair lightening process to prepare for vivid co', 1, '2026-06-11 07:58:27', '2026-06-15 08:51:30'),
(19, 3, NULL, 'Regular', 'scissors', 60000, '60', 'Haircut, hairwash, styling', 1, '2026-06-11 07:45:44', '2026-06-11 07:45:44'),
(20, 3, NULL, 'Premium', 'scissors', 80000, '90', 'Haircut, hairwash, tonic, hot towel, head massage, cold towe', 1, '2026-06-11 07:48:21', '2026-06-11 07:48:21'),
(21, 3, NULL, 'Executive', 'scissors', 100000, '120', 'Haircut, hairwash, black mask, tonic, hot towel, head massag', 1, '2026-06-11 07:49:48', '2026-06-11 07:49:48'),
(22, 3, NULL, 'Bald', 'scissors', 60000, '45', 'Complete head shave using clippers or razor for a smooth fin', 1, '2026-06-11 07:52:21', '2026-06-11 07:56:36'),
(23, 3, NULL, 'Shaving', 'face', 30000, '20', 'Clean facial shave or precision beard trim.', 1, '2026-06-11 07:52:45', '2026-06-11 07:56:20'),
(24, 3, NULL, 'Face Facial', 'face', 30000, '30', 'Refreshing facial treatment, head massage, and cold towel.', 1, '2026-06-11 07:53:24', '2026-06-11 07:58:43'),
(25, 3, NULL, 'Coloring Basic / Fashion', 'paint', 100000, '60', 'Professional hair coloring using natural or trendy fashion s', 1, '2026-06-11 07:55:59', '2026-06-11 07:55:59'),
(26, 3, NULL, 'Hairwash & Style', 'scissors', 30000, '20', 'Invigorating hair wash followed by professional styling.', 1, '2026-06-11 07:57:58', '2026-06-11 07:57:58'),
(27, 3, NULL, 'Bleaching', 'paint', 200000, '90', 'Professional hair lightening process to prepare for vivid co', 1, '2026-06-11 07:58:27', '2026-06-15 08:51:30');

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
(1, '2026_03_05_000000_create_users_table', 1),
(2, '2026_03_06_024003_create_galeris_table', 1),
(3, '2026_03_06_024003_create_layanans_table', 1),
(4, '2026_03_06_025809_create_antrians_table', 1),
(5, '2026_04_17_023206_create_cache_table', 1),
(6, '2026_04_22_000001_create_antrian_layanan_table', 1),
(7, '2026_04_22_075757_create_permission_tables', 1),
(8, '2026_06_02_084900_create_settings_table', 1),
(9, '2026_06_10_212741_add_role_id_to_users_table', 1),
(10, '2026_06_15_225348_create_barbershops_table', 1),
(11, '2026_06_16_203000_create_service_combinations_tables', 1),
(12, '2026_06_17_000000_create_barbershops_and_add_tenant_columns', 1),
(13, '2026_06_17_204857_add_notification_flags_to_antrean_table', 1),
(14, '2026_06_18_160357_add_kategori_to_barbershops_table', 1),
(15, '2026_06_18_161045_add_warna_sekunder_to_barbershops_table', 1),
(16, '2026_06_20_000000_add_block_columns_to_users_table', 1),
(17, '2026_06_20_000001_add_batal_oleh_column_to_antreans_table', 1),
(18, '2026_06_20_000002_create_block_histories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- Table structure for table `package_service`
--

CREATE TABLE `package_service` (
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(15) NOT NULL,
  `guard_name` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(15) NOT NULL,
  `guard_name` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2026-06-26 09:39:30', '2026-06-26 09:39:30'),
(2, 'admin', 'web', '2026-06-26 09:39:30', '2026-06-26 09:39:30'),
(3, 'user', 'web', '2026-06-26 09:39:30', '2026-06-26 09:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9qDkR26L8cu6nZxEBxdbegPlIvkfkym3uGgygYD2', 6, '103.167.217.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiWE1EQnNBMFV6TngzVjh1MDFNYURmcFlsVDNiRUNkQm53bnFwbDBBbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vYXJnYWhvbWVzLmQ0dHJwbC1pdGRlbC5pZC9wcm9maWxlIjtzOjU6InJvdXRlIjtzOjEzOiJwcm9maWxlLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoyMToiY3VycmVudF9iYXJiZXJzaG9wX2lkIjtpOjE7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX3NsdWciO3M6MTU6ImFyZ2EtYmFyYmVyc2hvcCI7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX25hbWEiO3M6MTU6IkFyZ2EgQmFyYmVyc2hvcCI7czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7fQ==', 1782447772),
('MbOhT3Cs5VasuhSMAfbSIatSx5JKXCftStYy0CuH', 5, '114.5.144.192', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoibE9NdGxpUkJMN21LMU9JMmNKN1NPQW1LeVJaQ2plUE92TkJVTzJ4ZCI7czoyMToiY3VycmVudF9iYXJiZXJzaG9wX2lkIjtpOjE7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX3NsdWciO3M6MTU6ImFyZ2EtYmFyYmVyc2hvcCI7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX25hbWEiO3M6MTU6IkFyZ2EgQmFyYmVyc2hvcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHBzOi8vYXJnYWhvbWVzLmQ0dHJwbC1pdGRlbC5pZC9hcmdhLWJhcmJlcnNob3AvYW50cmVhbiI7czo1OiJyb3V0ZSI7czo3OiJhbnRyZWFuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1782441647),
('oXUOzfG5ZmbZ2pchl4lQdsSEQb44uFvSiWlrGJwr', 2, '103.167.217.200', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiSWVBaG02T25lU2V1UlRDZ0hGbE1nNHJNTUk3Nzl0a01abmtrQVE4UyI7czoyMToiY3VycmVudF9iYXJiZXJzaG9wX2lkIjtpOjI7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX3NsdWciO3M6MTU6InRvYmEtYmFyYmVyc2hvcCI7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX25hbWEiO3M6MTA6IlRvYmEgU2Fsb24iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ3OiJodHRwczovL2FyZ2Fob21lcy5kNHRycGwtaXRkZWwuaWQvYWRtaW4vbGF5YW5hbiI7czo1OiJyb3V0ZSI7czoxOToiYWRtaW4ubGF5YW5hbi5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1782454055),
('R0fIcVBycI6ycBbN6ZaVAMOsDcGHwtLSUilr8LHa', NULL, '103.167.217.200', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiOFhobDJIN2RNSGV5Q0RZZmhVdVpTU3h3TFExMDVxRUxYM1hQb2s0OCI7czoyMToiY3VycmVudF9iYXJiZXJzaG9wX2lkIjtpOjE7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX3NsdWciO3M6MTU6ImFyZ2EtYmFyYmVyc2hvcCI7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX25hbWEiO3M6MTU6IkFyZ2EgQmFyYmVyc2hvcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vYXJnYWhvbWVzLmQ0dHJwbC1pdGRlbC5pZC9hcmdhLWJhcmJlcnNob3AiO3M6NToicm91dGUiO3M6MTU6ImJhcmJlcnNob3AuaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1782456422),
('r9gKp9DgjUAWGWnKLgo3YQUQwenzC6iU24ZPYc4p', 2, '114.5.144.192', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibnJBWkU3eEJ2ZlBTbWt2RVUxSzFyT2pqY21ldHFmU0hBQk5mM3hTTyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ4OiJodHRwczovL2FyZ2Fob21lcy5kNHRycGwtaXRkZWwuaWQvYWRtaW4vbW9kZXJhc2kiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLm1vZGVyYXNpLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1782441644),
('yEFKMTfynHcG9Z2fZCZsz2tbLeZypR8DgDeT02dJ', 7, '114.10.82.88', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoieWtNalp4dXZHajduUVNUcDY2MTQySGkzWTVaVUthR2MxR2hFSW1OYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vYXJnYWhvbWVzLmQ0dHJwbC1pdGRlbC5pZC9hcmdhLWJhcmJlcnNob3AvcmVrb21lbmRhc2kiO3M6NToicm91dGUiO3M6MTc6InJla29tZW5kYXNpLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7czoyMToiY3VycmVudF9iYXJiZXJzaG9wX2lkIjtpOjE7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX3NsdWciO3M6MTU6ImFyZ2EtYmFyYmVyc2hvcCI7czoyMzoiY3VycmVudF9iYXJiZXJzaG9wX25hbWEiO3M6MTU6IkFyZ2EgQmFyYmVyc2hvcCI7fQ==', 1782453928);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barbershop_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `key` varchar(20) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `barbershop_id`, `user_id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'queue_latitude', '2.386130', '2026-06-01 18:58:17', '2026-06-13 10:48:46'),
(2, 1, NULL, 'queue_longitude', '99.147852', '2026-06-01 18:58:17', '2026-06-13 10:48:46'),
(3, 1, NULL, 'queue_radius_meters', '1000', '2026-06-01 18:58:17', '2026-06-26 09:40:30'),
(4, 1, NULL, 'queue_jam_buka', '08:00', '2026-06-10 08:11:40', '2026-06-11 18:16:20'),
(5, 1, NULL, 'queue_jam_tutup', '21:00', '2026-06-10 08:11:40', '2026-06-11 18:16:05'),
(6, 2, NULL, 'queue_latitude', '2.386130', '2026-06-01 18:58:17', '2026-06-13 10:48:46'),
(7, 2, NULL, 'queue_longitude', '99.147852', '2026-06-01 18:58:17', '2026-06-13 10:48:46'),
(8, 2, NULL, 'queue_radius_meters', '360', '2026-06-01 18:58:17', '2026-06-15 01:50:01'),
(9, 2, NULL, 'queue_jam_buka', '08:00', '2026-06-10 08:11:40', '2026-06-11 18:16:20'),
(10, 2, NULL, 'queue_jam_tutup', '21:00', '2026-06-10 08:11:40', '2026-06-11 18:16:05'),
(11, 3, NULL, 'queue_latitude', '2.386130', '2026-06-01 18:58:17', '2026-06-13 10:48:46'),
(12, 3, NULL, 'queue_longitude', '99.147852', '2026-06-01 18:58:17', '2026-06-13 10:48:46'),
(13, 3, NULL, 'queue_radius_meters', '360', '2026-06-01 18:58:17', '2026-06-15 01:50:01'),
(14, 3, NULL, 'queue_jam_buka', '08:00', '2026-06-10 08:11:40', '2026-06-11 18:16:20'),
(15, 3, NULL, 'queue_jam_tutup', '21:00', '2026-06-10 08:11:40', '2026-06-11 18:16:05'),
(16, 1, NULL, 'queue_libur_note', 'libur', '2026-06-26 09:40:30', '2026-06-26 09:40:30'),
(17, 1, NULL, 'is_booking_enabled', '1', '2026-06-26 09:40:30', '2026-06-26 09:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barbershop_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(35) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_whatsapp` varchar(20) DEFAULT NULL,
  `firebase_uid` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `blocked_reason` text DEFAULT NULL,
  `blocked_at` timestamp NULL DEFAULT NULL,
  `reset_risk_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `barbershop_id`, `name`, `email`, `no_whatsapp`, `firebase_uid`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `is_blocked`, `blocked_reason`, `blocked_at`, `reset_risk_at`) VALUES
(1, NULL, 'Super Admin', 'superadmin@gmail.com', NULL, NULL, 'superadmin', NULL, '$2y$12$Qjsa/NSzxVGvfCOBSmzhl./f.2RDnNG8MKJvTPl5XIRJq74wrI6LG', NULL, '2026-06-26 09:39:30', '2026-06-26 09:39:30', NULL, 0, NULL, NULL, NULL),
(2, 1, 'Arga Admin', 'arga@gmail.com', NULL, NULL, 'argaadmin', NULL, '$2y$12$PM8S5hcPr9.uGwBjo/A.ROIVBmNRRCZQmDG16s4bcMNpNy7pOnGjy', NULL, '2026-06-26 09:39:31', '2026-06-26 09:39:31', NULL, 0, NULL, NULL, NULL),
(3, 2, 'Toba Admin', 'tobaadmin@gmail.com', NULL, NULL, 'tobaadmin', NULL, '$2y$12$GEsRV5NZeafRj9S/KWlA7.AV4oqwD3ysl5JOOTIhTy71MrM1irSwy', NULL, '2026-06-26 09:39:31', '2026-06-26 09:39:31', NULL, 0, NULL, NULL, NULL),
(4, 3, 'Laguboti Admin', 'lagubotiadmin@gmail.com', NULL, NULL, 'lagubotiadmin', NULL, '$2y$12$nsUXe0oY.MNyk/QAn8amvOyxVBnplySiGy1V6gcM.F.gd4xnThNK6', NULL, '2026-06-26 09:39:31', '2026-06-26 09:39:31', NULL, 0, NULL, NULL, NULL),
(5, NULL, 'Erwin Sianturi', 'erwinjsianturi@gmail.com', '081139899903', 'uNrt1xooPMfelM34vkWqXxuqlEA2', 'Erwin', NULL, '$2y$12$3MQoA8CclTEOs9SFUAgVFe/Fmex4NcKFrsXu3p8veURHgdLuZWZ12', NULL, '2026-06-26 09:40:04', '2026-06-26 09:40:17', NULL, 0, NULL, NULL, NULL),
(6, NULL, 'Flora Nainggolan', 'floranainggolan1009@gmail.com', '0895612219676', '86LfGvw8omNvrA24mbauVKKS1cC2', 'Flora', NULL, '$2y$12$5/fFshUdqnxaWuPvdJLMLeFsypl9TN8rXB26aDE6rfKU.cghOyoBm', NULL, '2026-06-26 11:17:42', '2026-06-26 11:17:48', NULL, 0, NULL, NULL, NULL),
(7, NULL, 'Fernando Parhusip', 'fernandophsp@gmail.com', '089502370751', 'wOEnq4pioNWrDJUtfBechsvrsI33', 'nando', NULL, '$2y$12$cA6CFmPRI/L/8DUHWRGNiO3rhoTi6enDaCEkJ/Phbq8RyKA3EqwGe', NULL, '2026-06-26 13:01:33', '2026-06-26 13:01:43', NULL, 0, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antreans`
--
ALTER TABLE `antreans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `antreans_user_id_foreign` (`user_id`),
  ADD KEY `antreans_layanan_id1_foreign` (`layanan_id1`),
  ADD KEY `antreans_layanan_id2_foreign` (`layanan_id2`),
  ADD KEY `antreans_created_at_index` (`created_at`),
  ADD KEY `antreans_updated_at_index` (`updated_at`),
  ADD KEY `antreans_nama_pelanggan_index` (`nama_pelanggan`),
  ADD KEY `antreans_status_index` (`status`),
  ADD KEY `antreans_barbershop_id_foreign` (`barbershop_id`);

--
-- Indexes for table `antrean_layanan`
--
ALTER TABLE `antrean_layanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `antrean_layanan_antrean_id_layanan_id_unique` (`antrean_id`,`layanan_id`),
  ADD KEY `antrean_layanan_layanan_id_foreign` (`layanan_id`);

--
-- Indexes for table `barbershops`
--
ALTER TABLE `barbershops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barbershops_slug_unique` (`slug`);

--
-- Indexes for table `block_histories`
--
ALTER TABLE `block_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_histories_user_id_foreign` (`user_id`),
  ADD KEY `block_histories_admin_id_foreign` (`admin_id`);

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
-- Indexes for table `galeris`
--
ALTER TABLE `galeris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galeris_user_id_foreign` (`user_id`),
  ADD KEY `galeris_barbershop_id_foreign` (`barbershop_id`);

--
-- Indexes for table `incompatibilities`
--
ALTER TABLE `incompatibilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `incompatibilities_service_id_a_service_id_b_unique` (`service_id_a`,`service_id_b`),
  ADD KEY `incompatibilities_service_id_b_foreign` (`service_id_b`);

--
-- Indexes for table `layanans`
--
ALTER TABLE `layanans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layanans_user_id_foreign` (`user_id`),
  ADD KEY `layanans_barbershop_id_foreign` (`barbershop_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `package_service`
--
ALTER TABLE `package_service`
  ADD PRIMARY KEY (`package_id`,`service_id`),
  ADD KEY `package_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_barbershop_id_key_unique` (`barbershop_id`,`key`),
  ADD KEY `settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_firebase_uid_unique` (`firebase_uid`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_barbershop_id_foreign` (`barbershop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antreans`
--
ALTER TABLE `antreans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `antrean_layanan`
--
ALTER TABLE `antrean_layanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barbershops`
--
ALTER TABLE `barbershops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `block_histories`
--
ALTER TABLE `block_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galeris`
--
ALTER TABLE `galeris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incompatibilities`
--
ALTER TABLE `incompatibilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layanans`
--
ALTER TABLE `layanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antreans`
--
ALTER TABLE `antreans`
  ADD CONSTRAINT `antreans_barbershop_id_foreign` FOREIGN KEY (`barbershop_id`) REFERENCES `barbershops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `antreans_layanan_id1_foreign` FOREIGN KEY (`layanan_id1`) REFERENCES `layanans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `antreans_layanan_id2_foreign` FOREIGN KEY (`layanan_id2`) REFERENCES `layanans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `antreans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `antrean_layanan`
--
ALTER TABLE `antrean_layanan`
  ADD CONSTRAINT `antrean_layanan_antrean_id_foreign` FOREIGN KEY (`antrean_id`) REFERENCES `antreans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `antrean_layanan_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `block_histories`
--
ALTER TABLE `block_histories`
  ADD CONSTRAINT `block_histories_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `block_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galeris`
--
ALTER TABLE `galeris`
  ADD CONSTRAINT `galeris_barbershop_id_foreign` FOREIGN KEY (`barbershop_id`) REFERENCES `barbershops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `galeris_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incompatibilities`
--
ALTER TABLE `incompatibilities`
  ADD CONSTRAINT `incompatibilities_service_id_a_foreign` FOREIGN KEY (`service_id_a`) REFERENCES `layanans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incompatibilities_service_id_b_foreign` FOREIGN KEY (`service_id_b`) REFERENCES `layanans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `layanans`
--
ALTER TABLE `layanans`
  ADD CONSTRAINT `layanans_barbershop_id_foreign` FOREIGN KEY (`barbershop_id`) REFERENCES `barbershops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `layanans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `package_service`
--
ALTER TABLE `package_service`
  ADD CONSTRAINT `package_service_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_barbershop_id_foreign` FOREIGN KEY (`barbershop_id`) REFERENCES `barbershops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_barbershop_id_foreign` FOREIGN KEY (`barbershop_id`) REFERENCES `barbershops` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
