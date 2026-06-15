-- Ruto Store System Database Dump with Data
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `detail_laporan_stok_baku`;
CREATE TABLE `detail_laporan_stok_baku` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `laporan_stok_baku_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned NOT NULL,
  `status` enum('menipis','habis') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_laporan_stok_baku_laporan_stok_baku_id_foreign` (`laporan_stok_baku_id`),
  KEY `detail_laporan_stok_baku_produk_id_foreign` (`produk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `detail_pesanan`;
CREATE TABLE `detail_pesanan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pesanan_pesanan_id_foreign` (`pesanan_id`),
  KEY `detail_pesanan_produk_id_foreign` (`produk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `detail_transaksi`;
CREATE TABLE `detail_transaksi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaksi_id` bigint unsigned NOT NULL,
  `produk_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_transaksi_transaksi_id_foreign` (`transaksi_id`),
  KEY `detail_transaksi_produk_id_foreign` (`produk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kategori` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
('1', 'Perlengkapan', '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('2', 'Bahan Baku', '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('3', 'Bahan Baku Dapur', '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('4', 'Perlengkapan Kamar Mandi', '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('5', 'Signature', '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('6', 'Ice Coffee', '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('7', 'Non Coffee', '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('8', 'Snack', '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('9', 'Food', '2026-06-16 03:53:00', '2026-06-16 03:53:00');

DROP TABLE IF EXISTS `laporan_stok_baku`;
CREATE TABLE `laporan_stok_baku` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_stok_baku_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
('1', '0001_01_01_000000_create_users_table', '1'),
('2', '0001_01_01_000001_create_cache_table', '1'),
('3', '2026_05_19_102731_create_kategori_table', '1'),
('4', '2026_05_19_102741_create_produk_table', '1'),
('5', '2026_05_19_102747_create_transaksi_table', '1'),
('6', '2026_05_19_102752_create_detail_transaksi_table', '1'),
('7', '2026_05_19_102756_create_stok_masuk_table', '1'),
('8', '2026_05_19_103353_add_role_to_users_table', '1'),
('9', '2026_05_23_000000_add_aktif_to_users_table', '1'),
('10', '2026_06_01_033600_add_gambar_to_produk_table', '1'),
('11', '2026_06_02_160000_create_pesanan_table', '1'),
('12', '2026_06_02_160001_create_detail_pesanan_table', '1'),
('13', '2026_06_02_160002_add_sumber_pesanan_to_transaksi_table', '1'),
('14', '2026_06_12_233954_add_tipe_and_cup_id_to_produk_table', '1'),
('15', '2026_06_12_234000_create_laporan_stok_baku_tables', '1');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_pesanan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_identitas` enum('meja','antrian') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_identitas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('menunggu_bayar','dibayar','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_bayar',
  `total_harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pesanan_kode_pesanan_unique` (`kode_pesanan`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint unsigned NOT NULL,
  `cup_id` bigint unsigned DEFAULT NULL,
  `nama_produk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('jual','baku') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jual',
  `harga_modal` decimal(12,2) NOT NULL,
  `harga_jual` decimal(12,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `gambar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produk_kategori_id_foreign` (`kategori_id`),
  KEY `produk_cup_id_foreign` (`cup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `produk` (`id`, `kategori_id`, `cup_id`, `nama_produk`, `tipe`, `harga_modal`, `harga_jual`, `stok`, `status`, `gambar`, `created_at`, `updated_at`) VALUES
('1', '1', NULL, 'Cup Ruto', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('2', '1', NULL, 'Cup Kosong', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('3', '1', NULL, 'Cup Kopi Panas', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('4', '1', NULL, 'Pipet', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('5', '1', NULL, 'Sendok Plastik', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('6', '1', NULL, 'Garpu Plastik', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('7', '1', NULL, 'Kertas Piring', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('8', '1', NULL, 'Tisu', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('9', '1', NULL, 'Kertas Print', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('10', '1', NULL, 'Kantong Sampah', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('11', '1', NULL, 'Tempat Saus', 'baku', '500.00', '0.00', '200', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('12', '2', NULL, 'Susu UHT', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('13', '2', NULL, 'Susu Kental Manis', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('14', '2', NULL, 'Beans', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('15', '2', NULL, 'Bubuk Red Velvet', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('16', '2', NULL, 'Bubuk Milo', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('17', '2', NULL, 'Bubuk Matcha', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('18', '2', NULL, 'Bubuk Taro', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('19', '2', NULL, 'Bubuk Coklat', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('20', '2', NULL, 'Syrup Vanilla', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('21', '2', NULL, 'Syrup Butterscotch', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('22', '2', NULL, 'Syrup Almond', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('23', '2', NULL, 'Syrup Merah', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('24', '2', NULL, 'Syrup Oren', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('25', '2', NULL, 'Syrup Lychee', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('26', '2', NULL, 'Induk Syrup Fruitpunch', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('27', '2', NULL, 'Induk Syrup Citrus', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('28', '2', NULL, 'Sauce Salted Caramel', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('29', '2', NULL, 'Lemon Slice', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('30', '2', NULL, 'Buah Lychee Kaleng', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('31', '2', NULL, 'Yakult', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('32', '2', NULL, 'Sprite', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('33', '2', NULL, 'Coca Cola', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('34', '2', NULL, 'Es Batu', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('35', '2', NULL, 'Lemon', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('36', '2', NULL, 'Galon', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('37', '2', NULL, 'Mineral', 'baku', '2000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('38', '3', NULL, 'Sosis', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('39', '3', NULL, 'Nugget', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('40', '3', NULL, 'Kentang', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('41', '3', NULL, 'Ayam Gunting', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('42', '3', NULL, 'Indomie Goreng', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('43', '3', NULL, 'Indomie Kuah', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('44', '3', NULL, 'Telur', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('45', '3', NULL, 'Minyak Goreng', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('46', '3', NULL, 'Saos Sambal', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('47', '3', NULL, 'Gula', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('48', '3', NULL, 'Teh', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('49', '3', NULL, 'Bumbu Kentang', 'baku', '3000.00', '0.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('50', '4', NULL, 'Sunlight', 'baku', '5000.00', '0.00', '50', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('51', '4', NULL, 'Wipol', 'baku', '5000.00', '0.00', '50', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('52', '4', NULL, 'Pengharum Lantai', 'baku', '5000.00', '0.00', '50', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('53', '5', '1', 'Ruto Coffee', 'jual', '7200.00', '12000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('54', '5', '1', 'Coke-ing Soda', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('55', '5', '1', 'Cream Noir', 'jual', '10200.00', '17000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('56', '6', '2', 'Americano', 'jual', '7200.00', '12000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('57', '6', '2', 'Capuccino', 'jual', '7200.00', '12000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('58', '6', '2', 'Aren', 'jual', '7200.00', '12000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('59', '6', '2', 'Butterscotch', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('60', '6', '2', 'Almond', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('61', '6', '2', 'Vanilla Latte', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('62', '6', '2', 'Ice Latte', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('63', '6', '2', 'Ice Mocha', 'jual', '10800.00', '18000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('64', '6', '2', 'Caramel Machiato', 'jual', '13200.00', '22000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('65', '6', '2', 'Coffee Moktail', 'jual', '13200.00', '22000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('66', '7', NULL, 'Air Mineral', 'jual', '3000.00', '5000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('67', '7', '2', 'Ice Tea', 'jual', '5400.00', '9000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('68', '7', '2', 'Matcha', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('69', '7', '2', 'Taro', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('70', '7', '2', 'Red Velvet', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('71', '7', '2', 'Chocolate', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('72', '7', '2', 'Pinky Monkey', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('73', '7', '2', 'Mango Monkey', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('74', '7', '2', 'Lemon Tea', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('75', '7', '2', 'Milo Monster', 'jual', '10200.00', '17000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('76', '7', '2', 'Lychee Tea', 'jual', '10200.00', '17000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('77', '7', '2', 'Lychee Yakult', 'jual', '10200.00', '17000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('78', '7', '2', 'Lychee Sky Soda', 'jual', '10200.00', '17000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('79', '7', '2', 'Zest Rose Spark', 'jual', '10200.00', '17000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('80', '7', '2', 'Zest Citrus Spark', 'jual', '10200.00', '17000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('81', '8', NULL, 'Kentang Goreng', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('82', '8', NULL, 'Sosis Goreng', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('83', '8', NULL, 'Nugget Goreng', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('84', '8', NULL, 'Perkedel Tahu', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('85', '8', NULL, 'Pisang Cok&Kej', 'jual', '10800.00', '18000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('86', '8', NULL, 'Mix Platter', 'jual', '12000.00', '20000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('87', '8', NULL, 'Chicken Pop', 'jual', '12000.00', '20000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('88', '8', NULL, 'Crispy Bread Roll', 'jual', '10800.00', '18000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('89', '9', NULL, 'Mie Goreng B', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('90', '9', NULL, 'Mie Goreng Jumbo', 'jual', '10800.00', '18000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('91', '9', NULL, 'Mie Rebus B', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('92', '9', NULL, 'Mie Rebus Jumbo', 'jual', '10800.00', '18000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('93', '9', NULL, 'Nasi Goreng B', 'jual', '9000.00', '15000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('94', '9', NULL, 'Nasi Goreng Spesial', 'jual', '13800.00', '23000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00'),
('95', '9', NULL, 'Tokyo Katsu Plate', 'jual', '13800.00', '23000.00', '100', 'aktif', NULL, '2026-06-16 03:53:00', '2026-06-16 03:53:00');

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `stok_masuk`;
CREATE TABLE `stok_masuk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `produk_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stok_masuk_produk_id_foreign` (`produk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` enum('langsung','pesanan_user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'langsung',
  `user_id` bigint unsigned NOT NULL,
  `pesanan_id` bigint unsigned DEFAULT NULL,
  `tanggal` date NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `bayar` decimal(12,2) NOT NULL,
  `kembalian` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaksi_kode_transaksi_unique` (`kode_transaksi`),
  KEY `transaksi_user_id_foreign` (`user_id`),
  KEY `transaksi_pesanan_id_foreign` (`pesanan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','kasir') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kasir',
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `aktif`) VALUES
('1', 'Administrator', 'admin@ruto.store', NULL, '$2y$12$IBZ.sP69I9v.vjgb9X88EO9vVoCrlcVACZZx3uSLNSuTTn0VSrlHu', NULL, '2026-06-16 02:25:19', '2026-06-16 03:52:59', 'admin', '1'),
('2', 'Kasir Utama', 'kasir@ruto.store', NULL, '$2y$12$OkH6lnp.TWuK26KPk5WHmOoAgA52z2sMyjvHLhjtoIKivNqegKKjO', NULL, '2026-06-16 02:25:20', '2026-06-16 03:53:00', 'kasir', '1');

SET FOREIGN_KEY_CHECKS=1;
