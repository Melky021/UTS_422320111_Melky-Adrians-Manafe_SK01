-- ============================================================
-- Database : bank_benih  (SK01 Bank Benih Pusaka)
-- Engine   : MySQL 8 / MariaDB 10.4+  (InnoDB, utf8mb4)
-- Cara pakai:
--   1) mysql -u root -e "CREATE DATABASE bank_benih CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
--   2) mysql -u root bank_benih < bank_benih.sql      (atau Import via phpMyAdmin/HeidiSQL)
-- File ini setara dengan hasil `php artisan migrate:fresh --seed`.
-- CATATAN: setelah import, jalankan sekali `php artisan migrate` di project Laravel.
-- Tabel `migrations` sudah memuat 5 migration ini (tidak dibuat ulang), tetapi
-- Laravel juga butuh tabel bawaan (sessions, cache, jobs, users) yang dibuat
-- oleh migrate. Alternatif: set SESSION_DRIVER=file dan CACHE_STORE=file di .env.
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `aksesi_perlakuan`;
DROP TABLE IF EXISTS `asal_pengumpulans`;
DROP TABLE IF EXISTS `aksesi_benihs`;
DROP TABLE IF EXISTS `perlakuan_penyimpanans`;
DROP TABLE IF EXISTS `kelompok_tanamans`;
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kelompok_tanamans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelompok_tanamans_kode_unique` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `perlakuan_penyimpanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `perlakuan_penyimpanans_nama_unique` (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `aksesi_benihs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kelompok_tanaman_id` bigint unsigned NOT NULL,
  `kode_aksesi` varchar(20) NOT NULL,
  `nama_aksesi` varchar(120) NOT NULL,
  `nama_ilmiah` varchar(150) NULL,
  `stok_gram` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` enum('tersimpan','perlu_regenerasi','habis') NOT NULL DEFAULT 'tersimpan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aksesi_benihs_kode_aksesi_unique` (`kode_aksesi`),
  KEY `aksesi_benihs_nama_aksesi_index` (`nama_aksesi`),
  KEY `aksesi_benihs_kelompok_tanaman_id_status_index` (`kelompok_tanaman_id`,`status`),
  CONSTRAINT `aksesi_benihs_kelompok_tanaman_id_foreign` FOREIGN KEY (`kelompok_tanaman_id`) REFERENCES `kelompok_tanamans` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `asal_pengumpulans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aksesi_benih_id` bigint unsigned NOT NULL,
  `desa` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `tanggal_koleksi` date NOT NULL,
  `kolektor` varchar(100) NOT NULL,
  `ketinggian_mdpl` smallint unsigned NULL,
  `catatan` text NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asal_pengumpulans_aksesi_benih_id_unique` (`aksesi_benih_id`),
  KEY `asal_pengumpulans_provinsi_index` (`provinsi`),
  CONSTRAINT `asal_pengumpulans_aksesi_benih_id_foreign` FOREIGN KEY (`aksesi_benih_id`) REFERENCES `aksesi_benihs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `aksesi_perlakuan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aksesi_benih_id` bigint unsigned NOT NULL,
  `perlakuan_penyimpanan_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aksesi_perlakuan_unique` (`aksesi_benih_id`,`perlakuan_penyimpanan_id`),
  KEY `aksesi_perlakuan_perlakuan_penyimpanan_id_foreign` (`perlakuan_penyimpanan_id`),
  CONSTRAINT `aksesi_perlakuan_aksesi_benih_id_foreign` FOREIGN KEY (`aksesi_benih_id`) REFERENCES `aksesi_benihs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `aksesi_perlakuan_perlakuan_penyimpanan_id_foreign` FOREIGN KEY (`perlakuan_penyimpanan_id`) REFERENCES `perlakuan_penyimpanans` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ------------------------- DATA -------------------------
INSERT INTO `migrations` (`migration`,`batch`) VALUES
('2026_11_13_000001_create_kelompok_tanamans_table',1),
('2026_11_13_000002_create_perlakuan_penyimpanans_table',1),
('2026_11_13_000003_create_aksesi_benihs_table',1),
('2026_11_13_000004_create_asal_pengumpulans_table',1),
('2026_11_13_000005_create_aksesi_perlakuan_table',1);

INSERT INTO `kelompok_tanamans` (`id`,`kode`,`nama`,`deskripsi`,`created_at`,`updated_at`) VALUES
(1,'PDI','Padi','Varietas lokal padi sawah dan padi gogo.','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(2,'JGG','Jagung','Jagung pulut, jagung putih, dan jagung manis lokal.','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(3,'KCG','Kacang-kacangan','Kedelai, kacang tunggak, dan kacang lokal lainnya.','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(4,'SYR','Sayuran','Cabai, terong, dan sayuran buah lokal.','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(5,'UMB','Umbi-umbian','Ubi jalar, talas, dan umbi lokal.','2026-11-13 08:00:00','2026-11-13 08:00:00');

INSERT INTO `perlakuan_penyimpanans` (`id`,`nama`,`deskripsi`,`created_at`,`updated_at`) VALUES
(1,'Pengeringan (kadar air 5-8%)','Benih dikeringkan hingga kadar air aman untuk disimpan.','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(2,'Penyimpanan Suhu Dingin 4°C','Disimpan pada ruang pendingin untuk jangka menengah.','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(3,'Penyimpanan Beku -18°C','Disimpan pada freezer untuk jangka panjang (koleksi dasar).','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(4,'Silika Gel','Penyerap kelembapan dalam wadah tertutup.','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(5,'Kemasan Vakum Aluminium Foil','Kemasan kedap udara dan cahaya.','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(6,'Pelindung Hayati (abu/daun nimba)','Perlindungan alami terhadap hama gudang.','2026-11-13 08:00:00','2026-11-13 08:00:00');

INSERT INTO `aksesi_benihs` (`id`,`kelompok_tanaman_id`,`kode_aksesi`,`nama_aksesi`,`nama_ilmiah`,`stok_gram`,`status`,`created_at`,`updated_at`) VALUES
(1,1,'PDI-001','Pandanwangi','Oryza sativa',850.00,'tersimpan','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(2,1,'PDI-002','Rojolele Srinuk','Oryza sativa',620.00,'tersimpan','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(3,1,'PDI-003','Padi Gogo Kerinci','Oryza sativa',90.00,'perlu_regenerasi','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(4,2,'JGG-001','Jagung Pulut Madura','Zea mays',400.00,'tersimpan','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(5,2,'JGG-002','Jagung Putih Gorontalo','Zea mays',0.00,'habis','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(6,3,'KCG-001','Kacang Tunggak Gunungkidul','Vigna unguiculata',310.00,'tersimpan','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(7,3,'KCG-002','Kedelai Hitam Ponorogo','Glycine max',275.50,'tersimpan','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(8,4,'SYR-001','Cabai Rawit Hiyung','Capsicum frutescens',45.25,'perlu_regenerasi','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(9,4,'SYR-002','Terong Ungu Lembang','Solanum melongena',60.00,'tersimpan','2026-11-13 08:00:00','2026-11-13 08:00:00'),
(10,5,'UMB-001','Ubi Jalar Cilembu','Ipomoea batatas',150.00,'tersimpan','2026-11-13 08:00:00','2026-11-13 08:00:00');

INSERT INTO `asal_pengumpulans` (`id`,`aksesi_benih_id`,`desa`,`kecamatan`,`kabupaten`,`provinsi`,`tanggal_koleksi`,`kolektor`,`ketinggian_mdpl`,`catatan`,`created_at`,`updated_at`) VALUES
(1,1,'Warungkondang','Warungkondang','Cianjur','Jawa Barat','2024-03-12','Ahmad Fauzi',450,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(2,2,'Srinuk','Delanggu','Klaten','Jawa Tengah','2024-05-20','Siti Rahayu',160,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(3,3,'Siulak Mukai','Gunung Kerinci','Kerinci','Jambi','2023-08-02','Budi Hartono',1200,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(4,4,'Batuan','Batuan','Sumenep','Jawa Timur','2024-09-15','Hasan Basri',35,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(5,5,'Tilango','Tilango','Gorontalo','Gorontalo','2022-11-10','Rina Pakaya',20,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(6,6,'Semanu','Semanu','Gunungkidul','DI Yogyakarta','2025-02-08','Wahyu Nugroho',180,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(7,7,'Sambit','Sambit','Ponorogo','Jawa Timur','2025-04-21','Lestari Wulan',120,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(8,8,'Hiyung','Tapin Tengah','Tapin','Kalimantan Selatan','2023-12-01','Norhasanah',15,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(9,9,'Cikole','Lembang','Bandung Barat','Jawa Barat','2025-06-30','Dedi Mulyadi',1250,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(10,10,'Cilembu','Pamulihan','Sumedang','Jawa Barat','2025-01-18','Yayat Sudrajat',700,NULL,'2026-11-13 08:00:00','2026-11-13 08:00:00');

INSERT INTO `aksesi_perlakuan` (`aksesi_benih_id`,`perlakuan_penyimpanan_id`,`created_at`,`updated_at`) VALUES
(1,1,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(1,2,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(2,1,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(2,4,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(3,3,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(4,1,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(4,5,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(6,4,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(6,6,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(7,2,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(7,5,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(8,3,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(8,4,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(9,1,'2026-11-13 08:00:00','2026-11-13 08:00:00'),
(10,2,'2026-11-13 08:00:00','2026-11-13 08:00:00');
