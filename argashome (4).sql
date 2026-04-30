-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2026 at 05:27 AM
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
-- Database: `argashome`
--

-- --------------------------------------------------------

--
-- Table structure for table `antreans`
--

CREATE TABLE `antreans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_antrean` varchar(255) DEFAULT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `layanan_id1` bigint(20) UNSIGNED DEFAULT NULL,
  `layanan_id2` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('menunggu','sedang dilayani','selesai','batal') NOT NULL DEFAULT 'menunggu',
  `waktu_masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `antreans`
--

INSERT INTO `antreans` (`id`, `nomor_antrean`, `nama_pelanggan`, `layanan_id1`, `layanan_id2`, `status`, `waktu_masuk`, `waktu_selesai`, `created_at`, `updated_at`) VALUES
(32, '01', 'James', 4, NULL, 'selesai', '2026-04-30 01:58:25', '2026-04-30 03:14:38', '2026-04-30 01:58:25', '2026-04-30 03:14:38'),
(33, '02', '2222', 4, NULL, 'selesai', '2026-04-30 03:24:35', '2026-04-30 03:25:53', '2026-04-30 03:24:35', '2026-04-30 03:25:53'),
(34, '03', '2222', 4, NULL, 'menunggu', '2026-04-30 03:25:36', NULL, '2026-04-30 03:25:36', '2026-04-30 03:25:36');

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

--
-- Dumping data for table `antrean_layanan`
--

INSERT INTO `antrean_layanan` (`id`, `antrean_id`, `layanan_id`, `created_at`, `updated_at`) VALUES
(3, 32, 4, '2026-04-30 01:58:25', '2026-04-30 01:58:25'),
(4, 34, 4, '2026-04-30 03:25:36', '2026-04-30 03:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galeris`
--

INSERT INTO `galeris` (`id`, `judul`, `deskripsi`, `gambar`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Logo Arga Home’s', 'Identitas Arga Home’s Barber, Coffee & Food.', 'galeri/HTmdotaGBvAnIDzK8VAinYPIGckygzXdN5jvjWMN.jpg', 1, '2026-04-29 06:34:29', '2026-04-29 06:34:29'),
(2, 'Dokumentasi Pelanggan', 'Momen pelanggan di area Arga Home’s sebagai dokumentasi suasana layanan.', 'galeri/aEA5xx4XjsJfSdVAIAG0mLRigxvgSiDCgtMSnrN8.jpg', 1, '2026-04-29 06:34:48', '2026-04-29 06:34:48'),
(3, 'Pelanggan Arga Home’s', 'Dokumentasi pelanggan setelah mendapatkan layanan di Arga Home’s.', 'galeri/dKFzXV1h7PRhM8qX3wM3blN2mnnGR7WvkD7KRnCG.jpg', 1, '2026-04-29 06:35:30', '2026-04-29 06:35:30'),
(4, 'Contoh hasil potongan rambut dengan gaya casual dan rapi.', 'Potongan Rambut Casual', 'galeri/FKBOYVq9r3XDKL2cv0CLPN3yaStbUL5kgAHG1jqG.jpg', 1, '2026-04-29 06:35:49', '2026-04-29 06:35:49'),
(5, 'Hair Styling Result', 'Contoh hasil styling rambut setelah proses layanan.', 'galeri/LY2JBuP4eSlxiNZIMXSedTszl6oaVkM5RBeVNyAN.jpg', 1, '2026-04-29 06:36:07', '2026-04-29 06:36:07'),
(6, 'Hasil Potongan Samping', 'Dokumentasi potongan rambut dari sisi samping.', 'galeri/mVt9QT80feULThMYBYwhHAM1mL8Hbh8jWPkz3e9I.jpg', 1, '2026-04-29 06:36:27', '2026-04-29 06:36:27'),
(7, 'Tampilan Potongan Belakang', 'Contoh hasil potongan rambut dari arah belakang.', 'galeri/Sqzpyf8Pd27uBj9TEOMJRAdyC5IVJlCbHTMllt7G.jpg', 1, '2026-04-29 06:36:46', '2026-04-29 06:36:46'),
(8, 'Detail Fade Cut', 'Dokumentasi hasil fade cut dari sisi belakang.', 'galeri/SFMwl1or9OBhi7WUMDjBQNG7nPIMKs84kmJT2het.jpg', 1, '2026-04-29 06:37:03', '2026-04-29 06:37:03'),
(9, 'Detail Potongan Belakang', 'Tampilan hasil potongan dari sisi belakang yang terlihat rapi.', 'galeri/nnd6vo2EUUm4Q6oJQSVBK4kncJwHzNO6cASYVuAa.jpg', 1, '2026-04-29 06:37:22', '2026-04-29 06:37:22'),
(10, 'Hasil Potongan Formal', 'Contoh potongan rambut rapi yang cocok untuk tampilan formal.', 'galeri/SQH9ZAdwmMlzLwPY73YK7VEIqTZ3eHS1LiAgbutO.jpg', 1, '2026-04-29 06:37:42', '2026-04-29 06:37:42'),
(11, 'Hasil Haircut Rapi', 'Dokumentasi hasil potongan rambut yang bersih dan tertata.', 'galeri/Pe9A2dkjeA12MchqDQ769GmwptCqAoSulN9dlo1m.jpg', 1, '2026-04-29 06:38:05', '2026-04-29 06:38:05'),
(12, 'Hasil Potongan Fade', 'Contoh hasil potongan rambut dengan tampilan rapi dan modern.', 'galeri/eFnShy7aNv30lBRTwqHIS1P4MpLF5W1tD8Jg9c2x.jpg', 1, '2026-04-29 06:38:31', '2026-04-29 06:38:31'),
(13, 'Menunggu Antrean', 'Pelanggan dapat menunggu antrean dengan suasana yang nyaman.', 'galeri/hIYgFeG7nn3gqR45UxMGjyM4LsuNuNNLVe8vOHZv.jpg', 1, '2026-04-29 06:38:51', '2026-04-29 06:38:51'),
(14, 'Persiapan Layanan', 'Pelanggan sedang berada di kursi barber sebelum proses layanan dimulai.', 'galeri/3ARYf759YPa7ei2Spkbobbf6uEinOdqYw6YMZW0Q.jpg', 1, '2026-04-29 06:39:10', '2026-04-29 06:39:10'),
(15, 'Proses Layanan Haircut', 'Dokumentasi proses pelayanan potong rambut oleh barber.', 'galeri/X8Fc3m7RCENe8W4WxCCiCWufb2rnfCseb8lSPA4C.jpg', 1, '2026-04-29 06:39:27', '2026-04-29 06:39:27'),
(16, 'Suasana Barbershop', 'Dokumentasi ruangan barbershop dengan nuansa unik dan nyaman.', 'galeri/AVxoMOLPfkSVE8YDkLsVwQqr3r1AYSNEBgDJwM8P.jpg', 1, '2026-04-29 06:40:03', '2026-04-29 06:40:03'),
(17, 'Area Layanan Barbershop', 'Tampilan area layanan potong rambut dengan suasana khas Arga Home’s.', 'galeri/U0PPZTqkrhqyqhfLs6xhnKYWlsvu5tuLspu8sNz3.jpg', 1, '2026-04-29 06:40:45', '2026-04-29 06:40:45'),
(18, 'Coffee Corner', 'Dokumentasi mesin kopi dan area penyajian minuman di Arga Home’s.', 'galeri/h0FsPM4ZxRkbia8D0rlVEWuciWlnNsBV68HMIQMe.jpg', 1, '2026-04-29 06:41:05', '2026-04-29 06:41:05'),
(19, 'Interior Arga Home’s', 'Area coffee yang dapat dinikmati pelanggan sambil menunggu antrean.', 'galeri/OcB0LeDSDzLw26AwOTU35vPTXxTLpzWjNcqnrJxs.jpg', 1, '2026-04-29 06:41:25', '2026-04-29 06:41:25'),
(20, 'Area Barbershop & Coffee', 'Suasana ruangan yang nyaman untuk potong rambut, menunggu, dan bersantai.', 'galeri/u8UJZ2wlT6jaE4JCnJvM4ADMUic2V6LXKtisWPo4.jpg', 1, '2026-04-29 06:42:15', '2026-04-29 06:42:15'),
(21, 'Suasana Utama Arga Home’s', 'Tampilan area dalam Arga Home’s yang menggabungkan barbershop dan tempat santai.', 'galeri/AzgKQ64BUHKdj732165iXYC9W5agHfbp6FJkuf2U.jpg', 1, '2026-04-29 06:42:40', '2026-04-29 06:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `layanans`
--

CREATE TABLE `layanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `estimasi_waktu` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanans`
--

INSERT INTO `layanans` (`id`, `nama`, `harga`, `estimasi_waktu`, `deskripsi`, `foto`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Regular', 60000, '45 menit', 'Haircut, hairwash, dan styling standar', 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600', 1, '2026-04-24 11:18:13', '2026-04-24 15:35:00'),
(2, 'Premium', 80000, '60 menit', 'Haircut, hairwash, tonic, hot towel, head massage, cold towel, styling', 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?q=80&w=600&auto=format&fit=crop', 1, '2026-04-24 11:18:13', '2026-04-24 15:35:00'),
(3, 'Executive', 100000, '75 menit', 'Haircut, hairwash, black mask, tonic, hot towel, head massage, cold towel, styling', 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600', 1, '2026-04-24 11:18:13', '2026-04-24 15:35:00'),
(4, 'Bald', 60000, '30 menit', 'Cukur rambut habis (botak) termasuk pembersihan dasar', 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?q=80&w=600&auto=format&fit=crop', 1, '2026-04-24 11:18:13', '2026-04-24 15:35:00'),
(5, 'Shaving', 30000, '20 menit', 'Cukur jenggot/kumis dengan teknik basic', 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600', 1, '2026-04-24 11:18:13', '2026-04-24 15:35:00'),
(6, 'Face Facial', 30000, '30 menit', 'Perawatan wajah ringan dengan head massage dan cold towel', 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?q=80&w=600&auto=format&fit=crop', 1, '2026-04-24 11:18:13', '2026-04-24 15:35:00'),
(7, 'Hairwash & Style', 30000, '25 menit', 'Cuci rambut dan styling tanpa potong', 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600', 1, '2026-04-24 11:18:13', '2026-04-24 15:35:00'),
(8, 'Coloring Basic/Fashion', 100000, '90 menit', 'Pewarnaan rambut basic atau fashion tanpa bleaching', 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?q=80&w=600&auto=format&fit=crop', 1, '2026-04-24 11:18:13', '2026-04-24 15:35:00'),
(9, 'Bleaching', 200000, '120 menit', 'Proses bleaching rambut untuk persiapan warna terang', 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600', 1, '2026-04-24 11:18:13', '2026-04-27 22:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` enum('Minuman','Makanan') NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `nama`, `kategori`, `harga`, `deskripsi`, `foto`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'Double Espresso', 'Minuman', 15000, 'Double Espresso adalah kopi dengan dua shot espresso yang memiliki rasa lebih kuat dan lebih pekat, cocok untuk yang membutuhkan energi ekstra.', 'https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?q=80&w=1200&auto=format&fit=crop', 1, '2026-04-28 05:50:07', '2026-04-28 19:46:46'),
(2, 'Americano', 'Minuman', 15000, 'Americano adalah kopi espresso yang dicampur air panas, menghasilkan rasa kopi yang lebih ringan namun tetap nikmat.', 'menus/20260429094826_9b17871d-9581-4db7-b2d7-7a96a72a1ad9.jpeg', 1, '2026-04-28 05:50:07', '2026-04-28 19:48:27'),
(3, 'Cappuccino', 'Minuman', 20000, 'Cappuccino adalah kopi espresso dengan campuran susu dan busa susu yang lembut, memiliki rasa seimbang dan creamy.', 'menus/20260429095238_ec27b2b4-5e55-4a8b-90b9-fd427beac34b.jpeg', 1, '2026-04-28 05:50:07', '2026-04-28 19:52:38'),
(4, 'Flat White', 'Minuman', 20000, 'Flat White adalah kopi espresso dengan susu hangat yang lembut, memiliki rasa kopi yang lebih kuat dan tekstur halus.', 'menus/20260429095350_5024b33f-d497-435d-a1d7-103731598e14.jpeg', 1, '2026-04-28 05:50:07', '2026-04-28 19:53:50'),
(5, 'Espresso', 'Minuman', 10000, 'Espresso adalah kopi hitam dengan rasa kuat dan aroma khas, disajikan tanpa campuran. Cocok untuk pecinta kopi asli.', 'menus/20260429094550_410af250-ab19-4605-bcf9-678e32e1f6bc.webp', 1, '2026-04-28 18:31:33', '2026-04-28 19:45:51'),
(6, 'Pangsit Babi', 'Makanan', 20000, 'jknsdjknjkdnsjkdn', 'menus/20260429083800_7bd250c5-f06b-4b76-b374-9f1d9107414e.jpeg', 0, '2026-04-28 18:38:00', '2026-04-28 20:44:43'),
(7, 'Latte', 'Minuman', 20000, 'Latte adalah kopi espresso dengan susu yang lebih banyak, menghasilkan rasa lembut dan creamy', 'menus/20260429095545_a9c1a400-9610-44ba-a26a-f689c86f78b1.jpeg', 1, '2026-04-28 19:55:45', '2026-04-28 19:55:45'),
(8, 'V60', 'Minuman', 23000, 'V60 adalah kopi seduh manual yang menghasilkan rasa kopi lebih bersih, ringan, dan aroma yang khas.', 'menus/20260429095839_45c76c3b-4c61-4cde-a2e7-b2474fcd76b6.jpeg', 1, '2026-04-28 19:58:39', '2026-04-28 19:58:39'),
(9, 'Machiato', 'Minuman', 20000, 'Macchiato adalah espresso dengan sedikit busa susu di atasnya, memiliki rasa kopi yang kuat dengan sentuhan lembut dari susu.', 'menus/20260429100011_7096177f-f96f-47b1-8140-9769cc4ca8d5.jpeg', 1, '2026-04-28 20:00:11', '2026-04-28 20:00:11'),
(10, 'Chocolate Latte', 'Minuman', 20000, 'Chocolate Latte adalah perpaduan espresso, susu, dan cokelat yang menghasilkan rasa manis, lembut, dan creamy.', 'menus/20260429100148_b9424115-1a6e-4f18-8153-fef72029ac96.jpeg', 1, '2026-04-28 20:01:48', '2026-04-28 20:01:48'),
(11, 'Matcha Latte', 'Minuman', 20000, 'Matcha Latte adalah minuman teh hijau matcha yang dicampur susu, menghasilkan rasa lembut, segar, dan sedikit manis.', 'menus/20260429100339_626741c3-1077-489c-ad0b-816e1c095741.jpeg', 1, '2026-04-28 20:03:39', '2026-04-28 20:03:39'),
(12, 'Taro Latte', 'Minuman', 20000, 'Taro Latte adalah minuman susu dengan rasa taro yang manis dan lembut, memiliki aroma khas dan warna ungu menarik.', 'menus/20260429100617_e22ff703-e53c-4120-8a76-758b5f343127.jpeg', 1, '2026-04-28 20:06:17', '2026-04-28 20:06:17'),
(13, 'Red Velvet Latte', 'Minuman', 20000, 'Red Velvet Latte adalah minuman susu dengan rasa red velvet yang manis dan lembut, memiliki warna merah khas dan tekstur creamy.', 'menus/20260429100721_44f6b3ef-1740-47d7-8608-560e2a934cad.jpeg', 1, '2026-04-28 20:07:21', '2026-04-28 20:07:21'),
(14, 'Lemon Tea', 'Minuman', 12000, 'Lemon Tea adalah minuman teh segar dengan perpaduan rasa asam lemon dan teh yang ringan serta menyegarkan.', 'menus/20260429100910_1e134344-ed66-49a8-924c-67d7dc17da1f.jpeg', 1, '2026-04-28 20:09:10', '2026-04-28 20:09:10'),
(15, 'Green Tea', 'Minuman', 12000, 'buat lah deskripsi sederhana untuk menu cafe espresso\r\n\r\nBerikut deskripsi sederhana untuk menu Café Espresso:\r\n\r\nEspresso adalah minuman kopi murni yang dibuat dengan mengekstraksi biji kopi pilihan menggunakan tekanan tinggi, menghasilkan rasa kopi yang kuat, pekat, dan aroma yang khas. Cocok dinikmati bagi pecinta kopi yang menyukai cita rasa autentik tanpa campuran.\r\n\r\n\r\nsederhana kan lagi\r\n\r\nEspresso adalah kopi hitam dengan rasa kuat dan aroma khas, disajikan tanpa campuran. Cocok untuk pecinta kopi asli.\r\n\r\n\r\ndeskripsi untuk double espresso sederhana aja\r\n\r\nDouble Espresso adalah kopi dengan dua shot espresso yang memiliki rasa lebih kuat dan lebih pekat, cocok untuk yang membutuhkan energi ekstra.\r\n\r\n\r\ndeskripsi sederhna untuk americano\r\n\r\nAmericano adalah kopi espresso yang dicampur air panas, menghasilkan rasa kopi yang lebih ringan namun tetap nikmat.\r\n\r\n\r\ndeskripsi sederhnahana  utnuk capucino\r\n\r\nCappuccino adalah kopi espresso dengan campuran susu dan busa susu yang lembut, memiliki rasa seimbang dan creamy.\r\n\r\n\r\ndeskripsi untuk flat white\r\n\r\nFlat White adalah kopi espresso dengan susu hangat yang lembut, memiliki rasa kopi yang lebih kuat dan tekstur halus.\r\n\r\n\r\ndeskripsi unuk latte\r\n\r\nLatte adalah kopi espresso dengan susu yang lebih banyak, menghasilkan rasa lembut dan creamy.\r\n\r\n\r\ndeskripsi untuk v60\r\n\r\nV60 adalah kopi seduh manual yang menghasilkan rasa kopi lebih bersih, ringan, dan aroma yang khas.\r\n\r\n\r\nDdeskripsi untuk machiato\r\n\r\nMacchiato adalah espresso dengan sedikit busa susu di atasnya, memiliki rasa kopi yang kuat dengan sentuhan lembut dari susu.\r\n\r\n\r\ndeskripsi chocolate latte\r\n\r\nChocolate Latte adalah perpaduan espresso, susu, dan cokelat yang menghasilkan rasa manis, lembut, dan creamy.\r\n\r\n\r\ndeskripsi matcha latte\r\n\r\nMatcha Latte adalah minuman teh hijau matcha yang dicampur susu, menghasilkan rasa lembut, segar, dan sedikit manis.\r\n\r\n\r\ndeskripsi taro latte\r\n\r\nTaro Latte adalah minuman susu dengan rasa taro yang manis dan lembut, memiliki aroma khas dan warna ungu menarik.\r\n\r\n\r\ndeskripsi redvelvet latte\r\n\r\nRed Velvet Latte adalah minuman susu dengan rasa red velvet yang manis dan lembut, memiliki warna merah khas dan tekstur creamy.\r\n\r\n\r\ndeskripsi lemon tea\r\n\r\nLemon Tea adalah minuman teh segar dengan perpaduan rasa asam lemon dan teh yang ringan serta menyegarkan.\r\n\r\n\r\ndeskripsi green tea\r\n\r\nGreen Tea \r\nbuat lah deskripsi sederhana untuk menu cafe espresso\r\n\r\nBerikut deskripsi sederhana untuk menu Café Espresso:\r\n\r\nEspresso adalah minuman kopi murni yang dibuat dengan mengekstraksi biji kopi pilihan menggunakan tekanan tinggi, menghasilkan rasa kopi yang kuat, pekat, dan aroma yang khas. Cocok dinikmati bagi pecinta kopi yang menyukai cita rasa autentik tanpa campuran.\r\n\r\n\r\nsederhana kan lagi\r\n\r\nEspresso adalah kopi hitam dengan rasa kuat dan aroma khas, disajikan tanpa campuran. Cocok untuk pecinta kopi asli.\r\n\r\n\r\ndeskripsi untuk double espresso sederhana aja\r\n\r\nDouble Espresso adalah kopi dengan dua shot espresso yang memiliki rasa lebih kuat dan lebih pekat, cocok untuk yang membutuhkan energi ekstra.\r\n\r\n\r\ndeskripsi sederhna untuk americano\r\n\r\nAmericano adalah kopi espresso yang dicampur air panas, menghasilkan rasa kopi yang lebih ringan namun tetap nikmat.\r\n\r\n\r\ndeskripsi sederhnahana  utnuk capucino\r\n\r\nCappuccino adalah kopi espresso dengan campuran susu dan busa susu yang lembut, memiliki rasa seimbang dan creamy.\r\n\r\n\r\ndeskripsi untuk flat white\r\n\r\nFlat White adalah kopi espresso dengan susu hangat yang lembut, memiliki rasa kopi yang lebih kuat dan tekstur halus.\r\n\r\n\r\ndeskripsi unuk latte\r\n\r\nLatte adalah kopi espresso dengan susu yang lebih banyak, menghasilkan rasa lembut dan creamy.\r\n\r\n\r\ndeskripsi untuk v60\r\n\r\nV60 adalah kopi seduh manual yang menghasilkan rasa kopi lebih bersih, ringan, dan aroma yang khas.\r\n\r\n\r\nDdeskripsi untuk machiato\r\n\r\nMacchiato adalah espresso dengan sedikit busa susu di atasnya, memiliki rasa kopi yang kuat dengan sentuhan lembut dari susu.\r\n\r\n\r\ndeskripsi chocolate latte\r\n\r\nChocolate Latte adalah perpaduan espresso, susu, dan cokelat yang menghasilkan rasa manis, lembut, dan creamy.\r\n\r\n\r\ndeskripsi matcha latte\r\n\r\nMatcha Latte adalah minuman teh hijau matcha yang dicampur susu, menghasilkan rasa lembut, segar, dan sedikit manis.\r\n\r\n\r\ndeskripsi taro latte\r\n\r\nTaro Latte adalah minuman susu dengan rasa taro yang manis dan lembut, memiliki aroma khas dan warna ungu menarik.\r\n\r\n\r\ndeskripsi redvelvet latte\r\n\r\nRed Velvet Latte adalah minuman susu dengan rasa red velvet yang manis dan lembut, memiliki warna merah khas dan tekstur creamy.\r\n\r\n\r\ndeskripsi lemon tea\r\n\r\nLemon Tea adalah minuman teh segar dengan perpaduan rasa asam lemon dan teh yang ringan serta menyegarkan.\r\n\r\n\r\ndeskripsi green tea\r\n\r\nGreen Tea adalah minuman teh hijau dengan rasa ringan dan segar, cocok dinikmati kapan saja.adalah minuman teh hijau dengan rasa ringan dan segar, cocok dinikmati kapan saja.', 'menus/20260429101039_e49eb1d6-8e39-4ca4-8ff3-16dcbf62d6a2.jpeg', 1, '2026-04-28 20:10:39', '2026-04-28 20:10:39'),
(16, 'Kentang Goreng', 'Makanan', 12000, 'Kentang Goreng adalah kentang renyah di luar dan lembut di dalam, disajikan hangat sebagai camilan favorit.', 'menus/20260429102541_7747951d-4e1d-42e4-8cfb-96d608164b44.jpeg', 1, '2026-04-28 20:25:41', '2026-04-28 20:25:41'),
(17, 'Pisang Goreng', 'Makanan', 12000, 'Pisang Goreng adalah pisang matang yang digoreng hingga keemasan, renyah di luar dan manis di dalam.', 'menus/20260429102644_1ab05ec3-44ea-4822-8913-0e8729f6e200.jpeg', 1, '2026-04-28 20:26:44', '2026-04-28 20:26:44'),
(18, 'Nugget Goreng', 'Makanan', 12000, 'Nugget Goreng adalah nugget ayam yang digoreng hingga renyah di luar dan lembut di dalam.', 'menus/20260429102900_3139411d-3a90-45bc-8bbd-a30bd18d73c8.jpeg', 1, '2026-04-28 20:29:01', '2026-04-28 20:29:01'),
(19, 'Roti Bakar', 'Makanan', 12000, 'Roti Bakar adalah roti yang dipanggang hingga kecokelatan dengan isian manis atau gurih.', 'menus/20260429102929_2c313738-dccd-462f-af4c-ea50f5e441e0.jpeg', 1, '2026-04-28 20:29:18', '2026-04-28 20:29:29'),
(20, 'Nasi Goreng', 'Makanan', 15000, 'Nasi Goreng adalah nasi yang digoreng dengan bumbu khas, menghasilkan rasa gurih dan lezat.', 'menus/20260429102955_b5944fcd-2976-4e1b-9a83-0e990c2378a6.jpeg', 1, '2026-04-28 20:29:55', '2026-04-28 20:29:55'),
(21, 'Mie Goreng', 'Makanan', 15000, 'Mie Goreng adalah mie yang digoreng dengan bumbu gurih dan topping sederhana.', 'menus/20260429103144_190d24fd-beb1-4613-8292-2e82809243de.jpeg', 1, '2026-04-28 20:31:44', '2026-04-28 20:31:44'),
(22, 'Ayam Penyet', 'Makanan', 15000, 'Ayam Penyet adalah ayam goreng yang dipenyet dan disajikan dengan sambal pedas.', 'menus/20260429103210_39c250b2-86cc-48f8-b33f-e4386646e584.jpeg', 1, '2026-04-28 20:32:10', '2026-04-28 20:32:10'),
(23, 'Mie Kuah', 'Makanan', 15000, 'Mie Kuah adalah mie dengan kuah hangat yang gurih dan mengenyangkan.', 'menus/20260429103231_971ea1d5-88c1-4036-8143-00d3e8d3a427.jpeg', 1, '2026-04-28 20:32:31', '2026-04-28 20:32:31');

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
(1, '2026_03_06_024003_create_galeris_table', 1),
(2, '2026_03_06_024003_create_layanans_table', 1),
(3, '2026_03_06_024005_create_menus_table', 1),
(4, '2026_03_06_025809_create_antrians_table', 1),
(5, '2026_03_06_040937_create_users_table', 1),
(6, '2026_04_09_013820_add_firebase_uid_to_users_table', 1),
(7, '2026_04_11_040751_add_username_to_users_table', 1),
(8, '2026_04_17_023206_create_cache_table', 1),
(9, '2026_04_18_045944_change_kategori_column_in_layanans_table', 1),
(10, '2026_04_18_132557_create_pelanggans_table', 1),
(11, '2026_04_22_000001_create_antrian_layanan_table', 1),
(12, '2026_04_22_000002_add_layanan_id1_layanan_id2_to_antrians_table', 1),
(13, '2026_04_22_000003_drop_layanan_id_from_antrians_table', 1),
(14, '2026_04_22_075757_create_permission_tables', 1);

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
(1, 'App\\Models\\User', 1);

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
-- Table structure for table `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `firebase_uid` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-04-22 19:51:13', '2026-04-22 19:51:13'),
(2, 'user', 'web', '2026-04-22 19:51:13', '2026-04-22 19:51:13');

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `firebase_uid` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `firebase_uid`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Arga Admin', NULL, 'arga@gmail.com', NULL, NULL, '$2y$12$wZsdurerIV0MSKDLuMOoV.aFRvFfgkOpz3vSxUBquDz6DF53ifWnG', NULL, '2026-04-22 19:51:13', '2026-04-22 19:51:13'),
(2, 'Erwin Sianturi', 'Erwin', 'erwinjsianturi@gmail.com', 'uNrt1xooPMfelM34vkWqXxuqlEA2', NULL, '$2y$12$gVH1uBgTj9DG7xZd2nhTCub314rKvPlOM1/f1XomeFpXmPMkh7vfe', 'WMWN4Hh3ZkuPf7H41zGTjuunBG36rUIrQLlyxpITP2yH3bNNYIAg0UvxunzM', '2026-04-22 19:55:25', '2026-04-22 19:55:29'),
(3, 'Odelia josephine Simanjuntak', 'lili', 'simanjuntakodelia@gmail.com', 'QTngfbgUGtRGS2mMREihUnIbhfJ3', NULL, '$2y$12$n4fEvAFlDzdrrM3z7b.UW.7VQX0nMHH3WKuDtmbTytQTFZCT.I6Nq', 'dpmLGbLkjatyzo1e11cNdoAnCPDz3YaYLoAvFkxUR3CBgJO31uj5dmKyalUB', '2026-04-24 21:04:47', '2026-04-24 21:04:54'),
(4, 'Smith', 'JAMESSEAWD', 'usingfortrialanderror@gmail.com', 'hNi46hq4jCckNjnGKS72NcuBbT22', NULL, '$2y$12$PO8FsIBZmEqaMsxxLMAfEOcq5/7yE0NCwrjnKpnxV.MKfOmm7Zh8.', 'MHv7NFafr1PRCfYECZjHRlp7iKGXO8MmTmED5tbhsE5KoG2Ddp8MrlWliOsk', '2026-04-24 22:00:03', '2026-04-25 18:42:09'),
(5, 'Daniel Sinambela', 'sinambeladaniel07', 'sinambeladaniel07@gmail.com', 'aH6xaESnIhTLzBLD5vObtbtQqxJ2', NULL, '$2y$12$B5.g/W7lQtvAXhrNGnX4Qe6hRIqByBUSn.NUxHbG2EKOZoaUst.xO', 'kP5ImXVRoR8QQF98othRMbAYu69WJXxUhnEu98RtBiE91wm25GZDKRKIJbl0', '2026-04-27 19:09:38', '2026-04-27 19:09:50'),
(6, 'febri sweeta', 'febri', 'febrisweeta25@gmail.com', 'lfYCxs7iqQZvio2ldWH8hrpgsN23', NULL, '$2y$12$MsKvJtYXD21hr.k1jdYfBe1FgBo41IRlGeirEFQH6GKsep99GeVqS', 'bc70Ghyjrs4HbCUiwHzWWSDM7XSTi9WzWwhkLPpEfjWfDX8F1d4eqTEKl5bD', '2026-04-28 06:04:28', '2026-04-28 06:05:12'),
(7, 'dewa gurusinga', 'dhew', 'dewagurusinga@gmail.com', '6znp0ZTwToTrlhC9mJK6lzy6zWw1', NULL, '$2y$12$zwKHmq9VzGqt9BQGFMcPTO27aap1nsXeoyeEsxyfCxdVkrXAB7quC', '7UcPxeQRst7gcg4cglX3e0Zka30hc5n9wQAjAoCfBw1DYwTaOahAbjF5W1tf', '2026-04-28 06:08:56', '2026-04-28 06:09:13'),
(8, 'Flora Nainggolan', 'florangl', 'floranainggolan1009@gmail.com', '86LfGvw8omNvrA24mbauVKKS1cC2', NULL, '$2y$12$HPDRXrksRNvyQHj/Q6lhqOXZi1Fa0qKkDvLDR47iO4oKNGQxK0eEO', 'mGFIEEZkF919NiqCrUSxZyOyEg1qqkeA4FwPfTXssz6HB6ll7gTyq2rohZjb', '2026-04-28 06:17:29', '2026-04-28 06:24:57'),
(9, 'Febri Sweeta', NULL, 'febrisweeta02@gmail.com', 'OmYP9O7H9rQ1OrKXCjwggWhY2Kw2', NULL, '$2y$12$xAzJ51aWjwGYKXNAbvY.vucLFl7ranwvvVjgENmlE9Ic/qQl1rXM.', 'ibSt6CgtYx8UfjSEm2yQU3MvKt3UIXlapXofcajDTUopwfQVaii1L7U1k8Jo', '2026-04-28 18:34:41', '2026-04-28 18:34:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antreans`
--
ALTER TABLE `antreans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `antrians_layanan_id1_foreign` (`layanan_id1`),
  ADD KEY `antrians_layanan_id2_foreign` (`layanan_id2`);

--
-- Indexes for table `antrean_layanan`
--
ALTER TABLE `antrean_layanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `antrian_layanan_antrian_id_layanan_id_unique` (`antrean_id`,`layanan_id`),
  ADD KEY `antrian_layanan_layanan_id_foreign` (`layanan_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanans`
--
ALTER TABLE `layanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pelanggans_email_unique` (`email`),
  ADD UNIQUE KEY `pelanggans_username_unique` (`username`),
  ADD UNIQUE KEY `pelanggans_firebase_uid_unique` (`firebase_uid`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_firebase_uid_unique` (`firebase_uid`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antreans`
--
ALTER TABLE `antreans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `antrean_layanan`
--
ALTER TABLE `antrean_layanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `galeris`
--
ALTER TABLE `galeris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `layanans`
--
ALTER TABLE `layanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antreans`
--
ALTER TABLE `antreans`
  ADD CONSTRAINT `antrians_layanan_id1_foreign` FOREIGN KEY (`layanan_id1`) REFERENCES `layanans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `antrians_layanan_id2_foreign` FOREIGN KEY (`layanan_id2`) REFERENCES `layanans` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `antrean_layanan`
--
ALTER TABLE `antrean_layanan`
  ADD CONSTRAINT `antrian_layanan_antrian_id_foreign` FOREIGN KEY (`antrean_id`) REFERENCES `antreans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `antrian_layanan_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
