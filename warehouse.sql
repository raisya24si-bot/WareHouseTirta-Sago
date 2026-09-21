-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tirta_sago
CREATE DATABASE IF NOT EXISTS `tirta_sago` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tirta_sago`;

-- Dumping structure for table tirta_sago.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.cache: ~0 rows (approximately)

-- Dumping structure for table tirta_sago.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.cache_locks: ~0 rows (approximately)

-- Dumping structure for table tirta_sago.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table tirta_sago.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.jobs: ~0 rows (approximately)

-- Dumping structure for table tirta_sago.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.job_batches: ~0 rows (approximately)

-- Dumping structure for table tirta_sago.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.migrations: ~22 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_08_12_120000_create_master_data_tables', 1),
	(5, '2026_08_13_000001_add_kepala_alamat_to_tbl_master_gudang', 1),
	(6, '2026_08_13_010000_create_stok_lokasi_table', 1),
	(7, '2026_08_13_010100_create_opname_tables', 1),
	(8, '2026_08_18_065039_add_kategori_gudang_and_opname_damage', 1),
	(9, '2026_08_28_072643_add_bio_photo_preferences_to_users_table', 1),
	(10, '2026_08_30_141705_create_sessions_table', 1),
	(11, '2026_08_30_141723_add_phone_address_to_users_table', 1),
	(12, '2026_09_01_012719_create_notifikasi_table', 1),
	(13, '2026_09_02_002251_create_master_status_po_table', 1),
	(14, '2026_09_02_002331_create_po_tables', 1),
	(15, '2026_09_05_000001_add_reject_info_to_tbl_po_table', 1),
	(16, '2026_09_08_011906_create_master_status_penerimaan_barang_table', 2),
	(17, '2026_09_08_012158_create_penerimaan_barang_tables', 3),
	(18, '2026_09_08_142845_add_file_fields_to_penerimaan_barang_bukti_dukung_table', 4),
	(19, '2026_09_09_012251_add_harga_satuan_to_tbl_penerimaan_barang_detail_table', 5),
	(20, '2026_09_10_071613_add_fk_lokasi_karantina_to_tbl_penerimaan_barang_detail_table', 6),
	(21, '2026_09_10_072415_align_status_penerimaan_barang_with_approval_levels', 6),
	(22, '2026_09_10_072449_add_catatan_approval_to_tbl_penerimaan_barang_table', 6);

-- Dumping structure for table tirta_sago.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table tirta_sago.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.sessions: ~3 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('a2c34c2dNXMnTKrWcYifubTFlalhmrfxx6cBvzkl', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', 'eyJfdG9rZW4iOiJOOHRXTjZvazAzeG9BS2g0TklRWTZmMGMyY0FEcGRtM3F0ZWlDV3lRIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wZW5lcmltYWFuXC8xXC92ZXJpZmlrYXNpIiwicm91dGUiOiJwZW5lcmltYWFuLnZlcmlmaWthc2kifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1789054495),
	('kIosiINoLejIslHhAAgRXlFxQn7QfHLwuDpDNa6W', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', 'eyJfdG9rZW4iOiJTb0ljUUZWcWZBclJYMnlYYzRmS3p4WHNoQ1gzYjk4bWtzUTFsRG04IiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wZW5lcmltYWFuIiwicm91dGUiOiJwZW5lcmltYWFuLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1789044266),
	('TCj2DeSUDkZsQvjWL4AW61MD1kKkrTMUpnRDI2VK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.136.1 Chrome/148.0.7778.280 Electron/42.10.0 Safari/537.36', 'eyJfdG9rZW4iOiIwanVxNThneEVJMnJMR0dKeUl2bUJWRHNQMG1sd1ZMWGFnNTBiY2FjIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMCIsInJvdXRlIjoiYmFyYW5nLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1789054363);

-- Dumping structure for table tirta_sago.tbl_master_barang
CREATE TABLE IF NOT EXISTS `tbl_master_barang` (
  `id_master_barang` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_master_barang` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nm_master_barang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_master_barang` text COLLATE utf8mb4_unicode_ci,
  `fk_kategori` bigint unsigned NOT NULL,
  `fk_satuan` bigint unsigned NOT NULL,
  `minimum_stok` int unsigned NOT NULL DEFAULT '0',
  `stok_saat_ini` int unsigned NOT NULL DEFAULT '0',
  `stok_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'HABIS',
  `status_master_barang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_master_barang`),
  UNIQUE KEY `tbl_master_barang_kd_master_barang_unique` (`kd_master_barang`),
  KEY `tbl_master_barang_fk_kategori_index` (`fk_kategori`),
  KEY `tbl_master_barang_fk_satuan_index` (`fk_satuan`),
  KEY `tbl_master_barang_stok_status_index` (`stok_status`),
  KEY `tbl_master_barang_status_master_barang_index` (`status_master_barang`),
  CONSTRAINT `tbl_master_barang_fk_kategori_foreign` FOREIGN KEY (`fk_kategori`) REFERENCES `tbl_master_kategori` (`id_master_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbl_master_barang_fk_satuan_foreign` FOREIGN KEY (`fk_satuan`) REFERENCES `tbl_master_satuan` (`id_master_satuan`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_barang: ~16 rows (approximately)
INSERT INTO `tbl_master_barang` (`id_master_barang`, `kd_master_barang`, `nm_master_barang`, `desc_master_barang`, `fk_kategori`, `fk_satuan`, `minimum_stok`, `stok_saat_ini`, `stok_status`, `status_master_barang`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'BRG-001', 'Pipa PVC 1/2', 'Pipa PVC ukuran 1/2 inch', 1, 4, 10, 50, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(2, 'BRG-002', 'Pipa PVC 3/4', 'Pipa PVC ukuran 3/4 inch', 1, 4, 10, 45, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(3, 'BRG-003', 'Elbow PVC', 'Elbow PVC', 2, 2, 5, 30, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(4, 'BRG-004', 'Tee PVC', 'Tee PVC', 2, 2, 5, 25, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(5, 'BRG-005', 'Kunci Inggris', 'Kunci inggris untuk pekerjaan teknis', 3, 1, 2, 15, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(6, 'BRG-006', 'Tang Kombinasi', 'Tang kombinasi', 3, 1, 2, 12, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(7, 'BRG-007', 'Meter Air', 'Meter air', 4, 1, 3, 20, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(8, 'BRG-008', 'Meteran Digital', 'Meteran digital', 4, 1, 2, 10, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(9, 'BRG-009', 'Pipa PVC 1', 'Pipa PVC ukuran 1 inch', 1, 4, 10, 40, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(10, 'BRG-010', 'Socket PVC', 'Socket PVC', 2, 2, 5, 35, 'NORMAL', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(11, 'BRG-011', 'Palu Besi', 'Palu besi', 3, 1, 2, 2, 'MENIPIS', 'AKTIF', NULL, 1, NULL, '2026-09-06 04:20:22', '2026-09-06 04:59:04', NULL),
	(12, 'BRG-012', 'Barang Kosong', 'Contoh barang dengan stok habis', 3, 1, 2, 0, 'HABIS', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(13, 'BRG-013', 'Kertas A4', 'Kertas 4 pack', 2, 4, 5, 10, 'NORMAL', 'AKTIF', 1, NULL, NULL, '2026-09-06 06:32:26', '2026-09-06 06:32:26', NULL),
	(14, 'BRG-014', 'Meter 1', NULL, 4, 1, 100, 0, 'HABIS', 'AKTIF', 1, NULL, NULL, '2026-09-06 18:05:51', '2026-09-06 18:05:51', NULL),
	(15, 'BRG-015', 'Meter 2', NULL, 4, 1, 100, 0, 'HABIS', 'AKTIF', 1, NULL, NULL, '2026-09-06 18:05:51', '2026-09-06 18:05:51', NULL),
	(16, 'BRG-016', 'Meter 3', NULL, 4, 1, 100, 0, 'HABIS', 'TIDAK AKTIF', 1, NULL, 1, '2026-09-06 18:05:51', '2026-09-08 18:44:08', '2026-09-08 18:44:08');

-- Dumping structure for table tirta_sago.tbl_master_gudang
CREATE TABLE IF NOT EXISTS `tbl_master_gudang` (
  `id_gudang` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_gudang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_gudang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kepala_gudang` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_gudang` text COLLATE utf8mb4_unicode_ci,
  `desc_gudang` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fk_status_gudang` bigint unsigned NOT NULL,
  `fk_kategori_gudang` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_gudang`),
  UNIQUE KEY `tbl_master_gudang_kd_gudang_unique` (`kd_gudang`),
  KEY `tbl_master_gudang_fk_status_gudang_index` (`fk_status_gudang`),
  KEY `tbl_master_gudang_nm_gudang_index` (`nm_gudang`),
  KEY `tbl_master_gudang_fk_kategori_gudang_index` (`fk_kategori_gudang`),
  CONSTRAINT `tbl_master_gudang_fk_kategori_gudang_foreign` FOREIGN KEY (`fk_kategori_gudang`) REFERENCES `tbl_master_kategori_gudang` (`id_kategori_gudang`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbl_master_gudang_fk_status_gudang_foreign` FOREIGN KEY (`fk_status_gudang`) REFERENCES `tbl_master_status_gudang` (`id_status_gudang`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_gudang: ~3 rows (approximately)
INSERT INTO `tbl_master_gudang` (`id_gudang`, `kd_gudang`, `nm_gudang`, `kepala_gudang`, `alamat_gudang`, `desc_gudang`, `fk_status_gudang`, `fk_kategori_gudang`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'GU1', 'Gudang Utama', NULL, NULL, 'Gudang utama penyimpanan barang.', 1, 1, NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(2, 'GU2', 'Gudang Transit', NULL, NULL, 'Gudang untuk barang transit.', 1, 2, NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(3, 'GU3', 'Gudang Rejected', NULL, NULL, 'Gudang barang rusak atau ditolak.', 1, 3, NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL);

-- Dumping structure for table tirta_sago.tbl_master_kategori
CREATE TABLE IF NOT EXISTS `tbl_master_kategori` (
  `id_master_kategori` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_master_kategori` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nm_master_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_master_kategori` text COLLATE utf8mb4_unicode_ci,
  `status_master_kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_master_kategori`),
  UNIQUE KEY `tbl_master_kategori_nm_master_kategori_unique` (`nm_master_kategori`),
  UNIQUE KEY `tbl_master_kategori_kd_master_kategori_unique` (`kd_master_kategori`),
  KEY `tbl_master_kategori_status_master_kategori_index` (`status_master_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_kategori: ~5 rows (approximately)
INSERT INTO `tbl_master_kategori` (`id_master_kategori`, `kd_master_kategori`, `nm_master_kategori`, `desc_master_kategori`, `status_master_kategori`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'KAT-001', 'Pipa', 'Pipa', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(2, 'KAT-002', 'Fitting', 'Fitting', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(3, 'KAT-003', 'Alat', 'Alat', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(4, 'KAT-004', 'Meteran', 'Meteran', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(5, 'KAT-005', 'Aksesoris', 'Aksesoris', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL);

-- Dumping structure for table tirta_sago.tbl_master_kategori_gudang
CREATE TABLE IF NOT EXISTS `tbl_master_kategori_gudang` (
  `id_kategori_gudang` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_kategori_gudang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_kategori_gudang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_kategori_gudang` text COLLATE utf8mb4_unicode_ci,
  `status_kategori_gudang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori_gudang`),
  UNIQUE KEY `tbl_master_kategori_gudang_kd_kategori_gudang_unique` (`kd_kategori_gudang`),
  UNIQUE KEY `tbl_master_kategori_gudang_nm_kategori_gudang_unique` (`nm_kategori_gudang`),
  KEY `tbl_master_kategori_gudang_status_kategori_gudang_index` (`status_kategori_gudang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_kategori_gudang: ~3 rows (approximately)
INSERT INTO `tbl_master_kategori_gudang` (`id_kategori_gudang`, `kd_kategori_gudang`, `nm_kategori_gudang`, `desc_kategori_gudang`, `status_kategori_gudang`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'STORAGE', 'Storage', 'Gudang utama untuk penyimpanan barang.', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:21', '2026-09-06 04:20:21', NULL),
	(2, 'TRANSIT', 'Transit', 'Gudang untuk barang yang sedang dalam proses perpindahan.', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:21', '2026-09-06 04:20:21', NULL),
	(3, 'REJECTED', 'Rejected', 'Gudang untuk barang rusak atau ditolak.', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:21', '2026-09-06 04:20:21', NULL);

-- Dumping structure for table tirta_sago.tbl_master_lokasi
CREATE TABLE IF NOT EXISTS `tbl_master_lokasi` (
  `id_lokasi` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_lokasi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_row` bigint unsigned NOT NULL,
  `bin` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_lokasi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_lokasi`),
  UNIQUE KEY `tbl_master_lokasi_fk_row_bin_unique` (`fk_row`,`bin`),
  UNIQUE KEY `tbl_master_lokasi_kd_lokasi_unique` (`kd_lokasi`),
  KEY `tbl_master_lokasi_fk_row_index` (`fk_row`),
  KEY `tbl_master_lokasi_bin_index` (`bin`),
  KEY `tbl_master_lokasi_status_lokasi_index` (`status_lokasi`),
  CONSTRAINT `tbl_master_lokasi_fk_row_foreign` FOREIGN KEY (`fk_row`) REFERENCES `tbl_master_row` (`id_row`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_lokasi: ~7 rows (approximately)
INSERT INTO `tbl_master_lokasi` (`id_lokasi`, `kd_lokasi`, `fk_row`, `bin`, `status_lokasi`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'GU1.01.01.01', 1, '01', 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:41', '2026-09-08 18:49:41', NULL),
	(2, 'GU1.01.01.02', 1, '02', 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:41', '2026-09-08 18:49:41', NULL),
	(3, 'GU1.01.01.03', 1, '03', 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:41', '2026-09-08 18:49:41', NULL),
	(4, 'GU1.01.01.04', 1, '04', 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:41', '2026-09-08 18:49:41', NULL),
	(5, 'GU1.01.01.05', 1, '05', 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:41:23', '2026-09-10 05:41:23', NULL),
	(6, 'GU1.01.01.06', 1, '06', 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:41:23', '2026-09-10 05:41:23', NULL),
	(7, 'GU1.01.01.07', 1, '07', 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:41:23', '2026-09-10 05:41:23', NULL);

-- Dumping structure for table tirta_sago.tbl_master_rak
CREATE TABLE IF NOT EXISTS `tbl_master_rak` (
  `id_rak` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_rak` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_gudang` bigint unsigned NOT NULL,
  `status_rak` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rak`),
  UNIQUE KEY `tbl_master_rak_kd_rak_unique` (`kd_rak`),
  KEY `tbl_master_rak_fk_gudang_index` (`fk_gudang`),
  KEY `tbl_master_rak_status_rak_index` (`status_rak`),
  CONSTRAINT `tbl_master_rak_fk_gudang_foreign` FOREIGN KEY (`fk_gudang`) REFERENCES `tbl_master_gudang` (`id_gudang`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_rak: ~8 rows (approximately)
INSERT INTO `tbl_master_rak` (`id_rak`, `kd_rak`, `fk_gudang`, `status_rak`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'GU1.01', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:13', '2026-09-08 18:49:13', NULL),
	(2, 'GU1.02', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:13', '2026-09-08 18:49:13', NULL),
	(3, 'GU1.03', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:13', '2026-09-08 18:49:13', NULL),
	(4, 'GU1.04', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:26:59', '2026-09-10 05:26:59', NULL),
	(5, 'GU1.05', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:26:59', '2026-09-10 05:26:59', NULL),
	(6, 'GU1.06', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:26:59', '2026-09-10 05:26:59', NULL),
	(7, 'GU1.07', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:26:59', '2026-09-10 05:26:59', NULL),
	(8, 'GU1.08', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:26:59', '2026-09-10 05:26:59', NULL);

-- Dumping structure for table tirta_sago.tbl_master_row
CREATE TABLE IF NOT EXISTS `tbl_master_row` (
  `id_row` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_row` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_rak` bigint unsigned NOT NULL,
  `status_row` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_row`),
  UNIQUE KEY `tbl_master_row_kd_row_unique` (`kd_row`),
  KEY `tbl_master_row_fk_rak_index` (`fk_rak`),
  KEY `tbl_master_row_status_row_index` (`status_row`),
  CONSTRAINT `tbl_master_row_fk_rak_foreign` FOREIGN KEY (`fk_rak`) REFERENCES `tbl_master_rak` (`id_rak`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_row: ~8 rows (approximately)
INSERT INTO `tbl_master_row` (`id_row`, `kd_row`, `fk_rak`, `status_row`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'GU1.01.01', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:22', '2026-09-08 18:49:22', NULL),
	(2, 'GU1.01.02', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:22', '2026-09-08 18:49:22', NULL),
	(3, 'GU1.01.03', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-08 18:49:22', '2026-09-08 18:49:22', NULL),
	(4, 'GU1.01.04', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:27:11', '2026-09-10 05:27:11', NULL),
	(5, 'GU1.01.05', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:27:11', '2026-09-10 05:27:11', NULL),
	(6, 'GU1.01.06', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:27:11', '2026-09-10 05:27:11', NULL),
	(7, 'GU1.01.07', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:27:11', '2026-09-10 05:27:11', NULL),
	(8, 'GU1.01.08', 1, 'AKTIF', NULL, NULL, NULL, '2026-09-10 05:27:11', '2026-09-10 05:27:11', NULL);

-- Dumping structure for table tirta_sago.tbl_master_satuan
CREATE TABLE IF NOT EXISTS `tbl_master_satuan` (
  `id_master_satuan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_master_satuan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nm_master_satuan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_master_satuan` text COLLATE utf8mb4_unicode_ci,
  `status_master_satuan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_master_satuan`),
  UNIQUE KEY `tbl_master_satuan_nm_master_satuan_unique` (`nm_master_satuan`),
  UNIQUE KEY `tbl_master_satuan_kd_master_satuan_unique` (`kd_master_satuan`),
  KEY `tbl_master_satuan_status_master_satuan_index` (`status_master_satuan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_satuan: ~6 rows (approximately)
INSERT INTO `tbl_master_satuan` (`id_master_satuan`, `kd_master_satuan`, `nm_master_satuan`, `desc_master_satuan`, `status_master_satuan`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'SAT-001', 'Unit', 'Satuan unit barang', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(2, 'SAT-002', 'Pcs', 'Satuan per buah', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(3, 'SAT-003', 'Roll', 'Satuan berbentuk gulungan', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(4, 'SAT-004', 'Batang', 'Satuan berbentuk batang', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(5, 'SAT-005', 'Meter', 'Satuan panjang meter', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(6, 'SAT-006', 'Box', 'Satuan dalam bentuk box', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL);

-- Dumping structure for table tirta_sago.tbl_master_status_gudang
CREATE TABLE IF NOT EXISTS `tbl_master_status_gudang` (
  `id_status_gudang` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_status_gudang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_status_gudang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_status_gudang` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_status_gudang`),
  UNIQUE KEY `tbl_master_status_gudang_kd_status_gudang_unique` (`kd_status_gudang`),
  UNIQUE KEY `tbl_master_status_gudang_nm_status_gudang_unique` (`nm_status_gudang`),
  KEY `tbl_master_status_gudang_nm_status_gudang_index` (`nm_status_gudang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_status_gudang: ~3 rows (approximately)
INSERT INTO `tbl_master_status_gudang` (`id_status_gudang`, `kd_status_gudang`, `nm_status_gudang`, `desc_status_gudang`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'AKTIF', 'Aktif', 'Gudang aktif dan dapat digunakan.', '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(2, 'NONAKTIF', 'Tidak Aktif', 'Gudang tidak sedang digunakan.', '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(3, 'MAINTENANCE', 'Maintenance', 'Gudang sedang dalam proses pemeliharaan.', '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL);

-- Dumping structure for table tirta_sago.tbl_master_status_penerimaan_barang
CREATE TABLE IF NOT EXISTS `tbl_master_status_penerimaan_barang` (
  `id_status_penerimaan_barang` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_status_penerimaan_barang` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_status_penerimaan_barang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` tinyint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_status_penerimaan_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_status_penerimaan_barang: ~12 rows (approximately)
INSERT INTO `tbl_master_status_penerimaan_barang` (`id_status_penerimaan_barang`, `kd_status_penerimaan_barang`, `nm_status_penerimaan_barang`, `urutan`, `created_at`, `updated_at`) VALUES
	(1, 'DRAFT', 'Draft', 1, '2026-09-10 00:26:37', '2026-09-10 00:26:37'),
	(2, 'PENDING_DIREKTUR', 'Menunggu Persetujuan Direktur', 4, '2026-09-10 00:26:37', '2026-09-10 00:26:37'),
	(3, 'PENDING_KABAG', 'Menunggu Persetujuan Kabag', 3, '2026-09-10 00:26:37', '2026-09-10 00:26:37'),
	(5, 'APPROVED', 'Approved', 5, '2026-09-10 00:26:37', '2026-09-10 00:26:37'),
	(6, 'REJECTED', 'Rejected', 6, '2026-09-10 00:26:37', '2026-09-10 00:26:37'),
	(7, 'PENDING_KASUBAG', 'Menunggu Persetujuan Kasubag', 2, '2026-09-10 00:26:37', '2026-09-10 00:26:37'),
	(8, 'DRAFT', 'Draft', 1, '2026-09-10 00:26:44', '2026-09-10 00:26:44'),
	(9, 'SUBMITTED', 'Submitted', 2, '2026-09-10 00:26:44', '2026-09-10 00:26:44'),
	(10, 'APPROVED_KASUBAG', 'Approved Kasubag', 3, '2026-09-10 00:26:44', '2026-09-10 00:26:44'),
	(11, 'APPROVED_KABAG', 'Approved Kabag', 4, '2026-09-10 00:26:44', '2026-09-10 00:26:44'),
	(12, 'APPROVED_DIREKTUR', 'Approved Direktur', 5, '2026-09-10 00:26:44', '2026-09-10 00:26:44'),
	(13, 'REJECTED', 'Rejected', 6, '2026-09-10 00:26:44', '2026-09-10 00:26:44');

-- Dumping structure for table tirta_sago.tbl_master_status_po
CREATE TABLE IF NOT EXISTS `tbl_master_status_po` (
  `id_status_po` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_status_po` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_status_po` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` tinyint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_status_po`),
  UNIQUE KEY `tbl_master_status_po_kd_status_po_unique` (`kd_status_po`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_status_po: ~6 rows (approximately)
INSERT INTO `tbl_master_status_po` (`id_status_po`, `kd_status_po`, `nm_status_po`, `urutan`, `created_at`, `updated_at`) VALUES
	(1, 'APPROVED', 'Approved', 1, '2026-09-06 04:20:22', '2026-09-06 04:20:22'),
	(2, 'REJECTED', 'Rejected', 2, '2026-09-06 04:20:22', '2026-09-06 04:20:22'),
	(3, 'DRAFT', 'Draft', 3, '2026-09-06 04:20:22', '2026-09-06 04:20:22'),
	(4, 'PENDING_KASUBAG', 'Menunggu Persetujuan Kasubag', 4, '2026-09-06 04:20:22', '2026-09-06 04:20:22'),
	(5, 'PENDING_KABAG', 'Menunggu Persetujuan Kabag', 5, '2026-09-06 04:20:22', '2026-09-06 04:20:22'),
	(6, 'PENDING_DIREKTUR', 'Menunggu Persetujuan Direktur', 6, '2026-09-06 04:20:22', '2026-09-06 04:20:22');

-- Dumping structure for table tirta_sago.tbl_master_supplier
CREATE TABLE IF NOT EXISTS `tbl_master_supplier` (
  `id_master_supplier` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_master_supplier` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nm_master_supplier` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_supplier` text COLLATE utf8mb4_unicode_ci,
  `kontak_supplier` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_master_supplier` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_master_supplier`),
  UNIQUE KEY `tbl_master_supplier_nm_master_supplier_unique` (`nm_master_supplier`),
  UNIQUE KEY `tbl_master_supplier_kd_master_supplier_unique` (`kd_master_supplier`),
  KEY `tbl_master_supplier_status_master_supplier_index` (`status_master_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_master_supplier: ~3 rows (approximately)
INSERT INTO `tbl_master_supplier` (`id_master_supplier`, `kd_master_supplier`, `nm_master_supplier`, `alamat_supplier`, `kontak_supplier`, `status_master_supplier`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'SUP-001', 'PT Tirta Material', 'Jl. Industri No. 10', '081234567890', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(2, 'SUP-002', 'CV Sumber Teknik', 'Jl. Raya Utama No. 21', '081298765432', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL),
	(3, 'SUP-003', 'UD Maju Jaya', 'Jl. Perdagangan No. 5', '082112223333', 'AKTIF', NULL, NULL, NULL, '2026-09-06 04:20:22', '2026-09-06 04:20:22', NULL);

-- Dumping structure for table tirta_sago.tbl_notifikasi
CREATE TABLE IF NOT EXISTS `tbl_notifikasi` (
  `id_notifikasi` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tipe` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_barang` bigint unsigned DEFAULT NULL,
  `fk_opname` bigint unsigned DEFAULT NULL,
  `data` json DEFAULT NULL,
  `dibaca_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_notifikasi`),
  KEY `tbl_notifikasi_fk_barang_foreign` (`fk_barang`),
  KEY `tbl_notifikasi_fk_opname_foreign` (`fk_opname`),
  KEY `tbl_notifikasi_tipe_created_at_index` (`tipe`,`created_at`),
  KEY `tbl_notifikasi_dibaca_at_index` (`dibaca_at`),
  CONSTRAINT `tbl_notifikasi_fk_barang_foreign` FOREIGN KEY (`fk_barang`) REFERENCES `tbl_master_barang` (`id_master_barang`) ON DELETE SET NULL,
  CONSTRAINT `tbl_notifikasi_fk_opname_foreign` FOREIGN KEY (`fk_opname`) REFERENCES `tbl_opname` (`id_opname`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_notifikasi: ~0 rows (approximately)

-- Dumping structure for table tirta_sago.tbl_opname
CREATE TABLE IF NOT EXISTS `tbl_opname` (
  `id_opname` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_opname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_gudang` bigint unsigned NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `status_opname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ONGOING',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_opname`),
  UNIQUE KEY `tbl_opname_kd_opname_unique` (`kd_opname`),
  KEY `tbl_opname_fk_gudang_index` (`fk_gudang`),
  KEY `tbl_opname_status_opname_index` (`status_opname`),
  CONSTRAINT `tbl_opname_fk_gudang_foreign` FOREIGN KEY (`fk_gudang`) REFERENCES `tbl_master_gudang` (`id_gudang`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_opname: ~1 rows (approximately)
INSERT INTO `tbl_opname` (`id_opname`, `kd_opname`, `fk_gudang`, `tgl_mulai`, `tgl_selesai`, `status_opname`, `catatan`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'OPN-2026-001', 1, '2026-09-09', '2026-09-09', 'COMPLETED', NULL, 1, 1, NULL, '2026-09-08 18:50:11', '2026-09-08 18:52:02', NULL);

-- Dumping structure for table tirta_sago.tbl_opname_detail
CREATE TABLE IF NOT EXISTS `tbl_opname_detail` (
  `id_opname_detail` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fk_opname` bigint unsigned NOT NULL,
  `fk_lokasi` bigint unsigned NOT NULL,
  `fk_barang` bigint unsigned NOT NULL,
  `stok_sistem` int NOT NULL DEFAULT '0',
  `stok_aktual` int DEFAULT NULL,
  `stok_baik` int unsigned DEFAULT NULL,
  `stok_rusak` int unsigned NOT NULL DEFAULT '0',
  `selisih` int DEFAULT NULL,
  `status_item` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BELUM DIHITUNG',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_opname_detail`),
  UNIQUE KEY `opname_detail_unique` (`fk_opname`,`fk_lokasi`,`fk_barang`),
  KEY `tbl_opname_detail_fk_lokasi_foreign` (`fk_lokasi`),
  KEY `tbl_opname_detail_fk_barang_foreign` (`fk_barang`),
  KEY `tbl_opname_detail_fk_opname_index` (`fk_opname`),
  KEY `tbl_opname_detail_status_item_index` (`status_item`),
  CONSTRAINT `tbl_opname_detail_fk_barang_foreign` FOREIGN KEY (`fk_barang`) REFERENCES `tbl_master_barang` (`id_master_barang`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbl_opname_detail_fk_lokasi_foreign` FOREIGN KEY (`fk_lokasi`) REFERENCES `tbl_master_lokasi` (`id_lokasi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbl_opname_detail_fk_opname_foreign` FOREIGN KEY (`fk_opname`) REFERENCES `tbl_opname` (`id_opname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_opname_detail: ~4 rows (approximately)
INSERT INTO `tbl_opname_detail` (`id_opname_detail`, `fk_opname`, `fk_lokasi`, `fk_barang`, `stok_sistem`, `stok_aktual`, `stok_baik`, `stok_rusak`, `selisih`, `status_item`, `keterangan`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 3, 10, 10, NULL, 0, 0, 'SESUAI', NULL, 1, 1, NULL, '2026-09-08 18:50:23', '2026-09-08 18:51:56', NULL),
	(2, 1, 4, 13, 250, 250, NULL, 0, 0, 'SESUAI', NULL, 1, 1, NULL, '2026-09-08 18:50:38', '2026-09-08 18:51:56', NULL),
	(3, 1, 3, 5, 200, 200, NULL, 0, 0, 'SESUAI', NULL, 1, 1, NULL, '2026-09-08 18:50:47', '2026-09-08 18:51:56', NULL),
	(4, 1, 2, 9, 11, 11, NULL, 0, 0, 'SESUAI', NULL, 1, 1, NULL, '2026-09-08 18:50:55', '2026-09-08 18:51:56', NULL);

-- Dumping structure for table tirta_sago.tbl_opname_lokasi
CREATE TABLE IF NOT EXISTS `tbl_opname_lokasi` (
  `id_opname_lokasi` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fk_opname` bigint unsigned NOT NULL,
  `fk_lokasi` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_opname_lokasi`),
  UNIQUE KEY `tbl_opname_lokasi_fk_opname_fk_lokasi_unique` (`fk_opname`,`fk_lokasi`),
  KEY `tbl_opname_lokasi_fk_lokasi_foreign` (`fk_lokasi`),
  CONSTRAINT `tbl_opname_lokasi_fk_lokasi_foreign` FOREIGN KEY (`fk_lokasi`) REFERENCES `tbl_master_lokasi` (`id_lokasi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbl_opname_lokasi_fk_opname_foreign` FOREIGN KEY (`fk_opname`) REFERENCES `tbl_opname` (`id_opname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_opname_lokasi: ~4 rows (approximately)
INSERT INTO `tbl_opname_lokasi` (`id_opname_lokasi`, `fk_opname`, `fk_lokasi`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, NULL),
	(2, 1, 2, NULL, NULL),
	(3, 1, 3, NULL, NULL),
	(4, 1, 4, NULL, NULL);

-- Dumping structure for table tirta_sago.tbl_penerimaan_barang
CREATE TABLE IF NOT EXISTS `tbl_penerimaan_barang` (
  `id_penerimaan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_penerimaan` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_penerimaan_barang` date NOT NULL,
  `fk_po` bigint unsigned NOT NULL,
  `no_sjinv_supplier` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_penerimaan_barang` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fk_status_penerimaan_barang` bigint unsigned NOT NULL,
  `submit_by` bigint unsigned DEFAULT NULL,
  `submit_at` timestamp NULL DEFAULT NULL,
  `approve_kasubag_by` bigint unsigned DEFAULT NULL,
  `approve_kasubag_at` timestamp NULL DEFAULT NULL,
  `approve_kabag_by` bigint unsigned DEFAULT NULL,
  `approve_kabag_at` timestamp NULL DEFAULT NULL,
  `approve_direktur_by` bigint unsigned DEFAULT NULL,
  `approve_direktur_at` timestamp NULL DEFAULT NULL,
  `catatan_approval` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penerimaan`),
  UNIQUE KEY `tbl_penerimaan_barang_kd_penerimaan_unique` (`kd_penerimaan`),
  KEY `tbl_penerimaan_barang_fk_status_penerimaan_barang_index` (`fk_status_penerimaan_barang`),
  KEY `tbl_penerimaan_barang_fk_po_index` (`fk_po`),
  CONSTRAINT `tbl_penerimaan_barang_fk_po_foreign` FOREIGN KEY (`fk_po`) REFERENCES `tbl_po` (`id_po`),
  CONSTRAINT `tbl_penerimaan_barang_fk_status_penerimaan_barang_foreign` FOREIGN KEY (`fk_status_penerimaan_barang`) REFERENCES `tbl_master_status_penerimaan_barang` (`id_status_penerimaan_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_penerimaan_barang: ~1 rows (approximately)
INSERT INTO `tbl_penerimaan_barang` (`id_penerimaan`, `kd_penerimaan`, `tgl_penerimaan_barang`, `fk_po`, `no_sjinv_supplier`, `desc_penerimaan_barang`, `fk_status_penerimaan_barang`, `submit_by`, `submit_at`, `approve_kasubag_by`, `approve_kasubag_at`, `approve_kabag_by`, `approve_kabag_at`, `approve_direktur_by`, `approve_direktur_at`, `catatan_approval`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'GRN-2026-0001', '2026-09-08', 3, 'k', NULL, 5, 1, '2026-09-10 05:43:27', NULL, NULL, NULL, NULL, 1, '2026-09-10 05:44:23', NULL, 1, 1, NULL, '2026-09-08 09:07:05', '2026-09-10 05:44:23', NULL);

-- Dumping structure for table tirta_sago.tbl_penerimaan_barang_bukti_dukung
CREATE TABLE IF NOT EXISTS `tbl_penerimaan_barang_bukti_dukung` (
  `id_penerimaan_barang_bukti_dukung` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fk_penerimaan_barang` bigint unsigned NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_file` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ukuran_file` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penerimaan_barang_bukti_dukung`),
  KEY `tbl_penerimaan_barang_bukti_dukung_fk_penerimaan_barang_foreign` (`fk_penerimaan_barang`),
  CONSTRAINT `tbl_penerimaan_barang_bukti_dukung_fk_penerimaan_barang_foreign` FOREIGN KEY (`fk_penerimaan_barang`) REFERENCES `tbl_penerimaan_barang` (`id_penerimaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_penerimaan_barang_bukti_dukung: ~2 rows (approximately)
INSERT INTO `tbl_penerimaan_barang_bukti_dukung` (`id_penerimaan_barang_bukti_dukung`, `fk_penerimaan_barang`, `nama_file`, `path_file`, `mime_type`, `ukuran_file`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'hi3.jpg', 'penerimaan-bukti/fodc9ZBLEPz8a7Znh0QEPqkXYxMf9lXwp3bsA8w9.jpg', 'image/jpeg', 63561, 1, 1, NULL, '2026-09-09 00:45:11', '2026-09-09 00:45:11', NULL),
	(2, 1, 'baddie.jpg', 'penerimaan-bukti/10WioUHe1jQGpLOteJaGMxSgRZ1rORa8SFFXIDW5.jpg', 'image/jpeg', 12827, 1, 1, NULL, '2026-09-10 00:34:53', '2026-09-10 00:34:53', NULL);

-- Dumping structure for table tirta_sago.tbl_penerimaan_barang_detail
CREATE TABLE IF NOT EXISTS `tbl_penerimaan_barang_detail` (
  `id_penerimaan_barang_detail` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fk_penerimaan_barang` bigint unsigned NOT NULL,
  `fk_barang` bigint unsigned NOT NULL,
  `fk_lokasi_barang` bigint unsigned DEFAULT NULL,
  `fk_lokasi_karantina` bigint unsigned DEFAULT NULL,
  `qty_request` int unsigned NOT NULL,
  `qty_baik` int unsigned NOT NULL DEFAULT '0',
  `qty_rusak` int unsigned NOT NULL DEFAULT '0',
  `harga_satuan` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penerimaan_barang_detail`),
  KEY `tbl_penerimaan_barang_detail_fk_penerimaan_barang_foreign` (`fk_penerimaan_barang`),
  KEY `tbl_penerimaan_barang_detail_fk_barang_foreign` (`fk_barang`),
  KEY `tbl_penerimaan_barang_detail_fk_lokasi_barang_foreign` (`fk_lokasi_barang`),
  KEY `tbl_penerimaan_barang_detail_fk_lokasi_karantina_foreign` (`fk_lokasi_karantina`),
  CONSTRAINT `tbl_penerimaan_barang_detail_fk_barang_foreign` FOREIGN KEY (`fk_barang`) REFERENCES `tbl_master_barang` (`id_master_barang`),
  CONSTRAINT `tbl_penerimaan_barang_detail_fk_lokasi_barang_foreign` FOREIGN KEY (`fk_lokasi_barang`) REFERENCES `tbl_master_lokasi` (`id_lokasi`) ON DELETE SET NULL,
  CONSTRAINT `tbl_penerimaan_barang_detail_fk_lokasi_karantina_foreign` FOREIGN KEY (`fk_lokasi_karantina`) REFERENCES `tbl_master_lokasi` (`id_lokasi`) ON DELETE SET NULL,
  CONSTRAINT `tbl_penerimaan_barang_detail_fk_penerimaan_barang_foreign` FOREIGN KEY (`fk_penerimaan_barang`) REFERENCES `tbl_penerimaan_barang` (`id_penerimaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_penerimaan_barang_detail: ~3 rows (approximately)
INSERT INTO `tbl_penerimaan_barang_detail` (`id_penerimaan_barang_detail`, `fk_penerimaan_barang`, `fk_barang`, `fk_lokasi_barang`, `fk_lokasi_karantina`, `qty_request`, `qty_baik`, `qty_rusak`, `harga_satuan`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 12, 1, NULL, 4, 4, 0, 30000, 1, 1, NULL, '2026-09-08 09:07:05', '2026-09-10 05:05:39', NULL),
	(2, 1, 14, 5, NULL, 200, 200, 0, 14000, 1, 1, NULL, '2026-09-08 09:07:05', '2026-09-10 05:43:13', NULL),
	(3, 1, 15, 5, NULL, 200, 200, 0, 60000, 1, 1, NULL, '2026-09-08 09:07:05', '2026-09-10 05:43:13', NULL);

-- Dumping structure for table tirta_sago.tbl_po
CREATE TABLE IF NOT EXISTS `tbl_po` (
  `id_po` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_po` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_supplier` bigint unsigned DEFAULT NULL,
  `desc_po` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fk_status_po` bigint unsigned NOT NULL,
  `submit_by` bigint unsigned DEFAULT NULL,
  `submit_at` timestamp NULL DEFAULT NULL,
  `approve_kasubag_by` bigint unsigned DEFAULT NULL,
  `approve_kasubag_at` timestamp NULL DEFAULT NULL,
  `approve_kabag_by` bigint unsigned DEFAULT NULL,
  `apporve_kabag_at` timestamp NULL DEFAULT NULL,
  `approve_direktur_by` bigint unsigned DEFAULT NULL,
  `approve_direktur_at` timestamp NULL DEFAULT NULL,
  `reject_by` bigint unsigned DEFAULT NULL,
  `reject_at` timestamp NULL DEFAULT NULL,
  `reject_level` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reject_note` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_po`),
  UNIQUE KEY `tbl_po_kd_po_unique` (`kd_po`),
  KEY `tbl_po_fk_supplier_foreign` (`fk_supplier`),
  KEY `tbl_po_fk_status_po_index` (`fk_status_po`),
  CONSTRAINT `tbl_po_fk_status_po_foreign` FOREIGN KEY (`fk_status_po`) REFERENCES `tbl_master_status_po` (`id_status_po`),
  CONSTRAINT `tbl_po_fk_supplier_foreign` FOREIGN KEY (`fk_supplier`) REFERENCES `tbl_master_supplier` (`id_master_supplier`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_po: ~4 rows (approximately)
INSERT INTO `tbl_po` (`id_po`, `kd_po`, `fk_supplier`, `desc_po`, `fk_status_po`, `submit_by`, `submit_at`, `approve_kasubag_by`, `approve_kasubag_at`, `approve_kabag_by`, `apporve_kabag_at`, `approve_direktur_by`, `approve_direktur_at`, `reject_by`, `reject_at`, `reject_level`, `reject_note`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'PO-2026-09-1', 1, '-', 2, 1, '2026-09-06 04:22:32', 1, '2026-09-06 04:25:13', NULL, NULL, NULL, NULL, 1, '2026-09-06 04:33:51', 'KABAG', 'tidak memenuhi syarat', 1, 1, NULL, '2026-09-06 04:22:22', '2026-09-06 04:33:51', NULL),
	(2, 'PO-2026-09-2', 2, 'Restock', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-09-06 06:47:11', '2026-09-06 06:47:11', NULL),
	(3, 'PO-2026-09-3', 1, 'Restock kebutuhan bulanan', 1, 1, '2026-09-07 20:31:22', 1, '2026-09-07 20:31:34', 1, '2026-09-07 20:31:41', 1, '2026-09-07 20:31:48', NULL, NULL, NULL, NULL, 1, 1, NULL, '2026-09-07 20:31:06', '2026-09-07 20:31:48', NULL),
	(4, 'PO-2026-09-4', 3, NULL, 5, 1, '2026-09-07 20:35:51', 1, '2026-09-07 20:36:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2026-09-07 20:35:39', '2026-09-09 00:36:37', '2026-09-09 00:36:37');

-- Dumping structure for table tirta_sago.tbl_po_detail
CREATE TABLE IF NOT EXISTS `tbl_po_detail` (
  `id_po_detail` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fk_po` bigint unsigned NOT NULL,
  `fk_barang` bigint unsigned NOT NULL,
  `qty_stok_at_request` int NOT NULL,
  `qty_min_stok_at_request` int NOT NULL,
  `qty_request` int unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_po_detail`),
  UNIQUE KEY `tbl_po_detail_fk_po_fk_barang_unique` (`fk_po`,`fk_barang`),
  KEY `tbl_po_detail_fk_barang_foreign` (`fk_barang`),
  CONSTRAINT `tbl_po_detail_fk_barang_foreign` FOREIGN KEY (`fk_barang`) REFERENCES `tbl_master_barang` (`id_master_barang`),
  CONSTRAINT `tbl_po_detail_fk_po_foreign` FOREIGN KEY (`fk_po`) REFERENCES `tbl_po` (`id_po`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_po_detail: ~6 rows (approximately)
INSERT INTO `tbl_po_detail` (`id_po_detail`, `fk_po`, `fk_barang`, `qty_stok_at_request`, `qty_min_stok_at_request`, `qty_request`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 12, 0, 2, 5, 1, NULL, NULL, '2026-09-06 04:22:22', '2026-09-06 04:22:22', NULL),
	(2, 2, 11, 2, 2, 12, 1, NULL, NULL, '2026-09-06 06:47:11', '2026-09-06 06:47:11', NULL),
	(3, 3, 12, 0, 2, 4, 1, NULL, NULL, '2026-09-07 20:31:06', '2026-09-07 20:31:06', NULL),
	(4, 3, 14, 0, 100, 200, 1, NULL, NULL, '2026-09-07 20:31:06', '2026-09-07 20:31:06', NULL),
	(5, 3, 15, 0, 100, 200, 1, NULL, NULL, '2026-09-07 20:31:06', '2026-09-07 20:31:06', NULL),
	(6, 4, 16, 0, 100, 200, 1, NULL, NULL, '2026-09-07 20:35:39', '2026-09-07 20:35:39', NULL);

-- Dumping structure for table tirta_sago.tbl_stok_lokasi
CREATE TABLE IF NOT EXISTS `tbl_stok_lokasi` (
  `id_stok_lokasi` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fk_barang` bigint unsigned NOT NULL,
  `fk_lokasi` bigint unsigned NOT NULL,
  `qty_stok` int unsigned NOT NULL DEFAULT '0',
  `qty_rusak` int unsigned NOT NULL DEFAULT '0',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_stok_lokasi`),
  UNIQUE KEY `tbl_stok_lokasi_fk_barang_fk_lokasi_unique` (`fk_barang`,`fk_lokasi`),
  KEY `tbl_stok_lokasi_fk_barang_index` (`fk_barang`),
  KEY `tbl_stok_lokasi_fk_lokasi_index` (`fk_lokasi`),
  CONSTRAINT `tbl_stok_lokasi_fk_barang_foreign` FOREIGN KEY (`fk_barang`) REFERENCES `tbl_master_barang` (`id_master_barang`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbl_stok_lokasi_fk_lokasi_foreign` FOREIGN KEY (`fk_lokasi`) REFERENCES `tbl_master_lokasi` (`id_lokasi`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.tbl_stok_lokasi: ~7 rows (approximately)
INSERT INTO `tbl_stok_lokasi` (`id_stok_lokasi`, `fk_barang`, `fk_lokasi`, `qty_stok`, `qty_rusak`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 3, 1, 10, 0, 1, 1, NULL, '2026-09-08 18:52:02', '2026-09-08 18:52:02', NULL),
	(2, 9, 2, 11, 0, 1, 1, NULL, '2026-09-08 18:52:02', '2026-09-08 18:52:02', NULL),
	(3, 5, 3, 200, 0, 1, 1, NULL, '2026-09-08 18:52:02', '2026-09-08 18:52:02', NULL),
	(4, 13, 4, 250, 0, 1, 1, NULL, '2026-09-08 18:52:02', '2026-09-08 18:52:02', NULL),
	(5, 12, 1, 4, 0, 1, 1, NULL, '2026-09-10 05:44:23', '2026-09-10 05:44:23', NULL),
	(6, 14, 5, 200, 0, 1, 1, NULL, '2026-09-10 05:44:23', '2026-09-10 05:44:23', NULL),
	(7, 15, 5, 200, 0, 1, 1, NULL, '2026-09-10 05:44:23', '2026-09-10 05:44:23', NULL);

-- Dumping structure for table tirta_sago.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferences` json DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tirta_sago.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `bio`, `photo_url`, `phone`, `address`, `preferences`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Raisya', 'raisya@tirtasago.id', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$Js544vsQxdD5zZu9Baxlqe//QajaoDAucFD6bsGFAJL/y2fbToYLS', '3kz42oGKa9T4jvq8YbQGWD9Cyr43b0pfvKDKZBwFCER4oRxS5iyKosv5qT6G', '2026-09-06 04:20:22', '2026-09-08 09:02:09');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
