-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `absensi`
--

DROP TABLE IF EXISTS `absensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `absensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_siswa` bigint unsigned NOT NULL,
  `id_jadwal` bigint unsigned NOT NULL,
  `signature_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_absen` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_waktu_absen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `absensi_id_siswa_foreign` (`id_siswa`),
  KEY `absensi_id_jadwal_foreign` (`id_jadwal`),
  CONSTRAINT `absensi_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_pelajaran` (`id`),
  CONSTRAINT `absensi_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensi`
--

LOCK TABLES `absensi` WRITE;
/*!40000 ALTER TABLE `absensi` DISABLE KEYS */;
INSERT INTO `absensi` VALUES (1,1,1,NULL,'Hadir','2025-04-28 14:40:40',NULL,'2025-04-28 14:40:40','2025-04-28 14:40:40'),(2,2,2,NULL,'Sakit','2025-04-28 14:40:40','Demam','2025-04-28 14:40:40','2025-04-28 14:40:40');
/*!40000 ALTER TABLE `absensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru`
--

DROP TABLE IF EXISTS `guru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_guru` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telpon_guru` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_guru` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru`
--

LOCK TABLES `guru` WRITE;
/*!40000 ALTER TABLE `guru` DISABLE KEYS */;
INSERT INTO `guru` VALUES (1,'1234567890','Ahmad Yani','0811222333','ahmad@example.com','2025-04-28 14:40:40','2025-04-28 14:40:40'),(2,'0987654321','Rina Kusuma','0822333444','rina@example.com','2025-04-28 14:40:40','2025-04-28 14:40:40'),(3,'5555555','Bagus Surya','089509988210','suryabagus@gmail.com','2025-05-19 00:20:48','2025-05-19 00:20:48'),(8,'11112223','Yono Alam','089111222','yonoalam123@gmail.com','2025-05-19 01:43:05','2025-05-22 14:57:12');
/*!40000 ALTER TABLE `guru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal_pelajaran`
--

DROP TABLE IF EXISTS `jadwal_pelajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal_pelajaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `hari` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_guru` bigint unsigned NOT NULL,
  `id_mapel` bigint unsigned NOT NULL,
  `id_kelas` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_pelajaran_id_guru_foreign` (`id_guru`),
  KEY `jadwal_pelajaran_id_mapel_foreign` (`id_mapel`),
  KEY `jadwal_pelajaran_id_kelas_foreign` (`id_kelas`),
  CONSTRAINT `jadwal_pelajaran_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`),
  CONSTRAINT `jadwal_pelajaran_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`),
  CONSTRAINT `jadwal_pelajaran_id_mapel_foreign` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal_pelajaran`
--

LOCK TABLES `jadwal_pelajaran` WRITE;
/*!40000 ALTER TABLE `jadwal_pelajaran` DISABLE KEYS */;
INSERT INTO `jadwal_pelajaran` VALUES (1,'Selasa',1,1,1,'2025-04-28 14:40:40','2025-05-22 12:49:40'),(2,'Selasa',2,2,2,'2025-04-28 14:40:40','2025-04-28 14:40:40'),(3,'Rabu',3,1,2,'2025-05-22 12:01:48','2025-05-22 12:01:48');
/*!40000 ALTER TABLE `jadwal_pelajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` tinyint unsigned NOT NULL,
  `id_guru` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_nama_tingkat_unique` (`nama_kelas`,`tingkat`),
  KEY `kelas_id_guru_foreign` (`id_guru`),
  CONSTRAINT `kelas_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'X IPA 2',11,8,'2025-04-28 14:40:40','2025-05-22 12:54:27'),(2,'X IPS 1',10,2,'2025-04-28 14:40:40','2025-04-28 14:40:40');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mapel`
--

DROP TABLE IF EXISTS `mapel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mapel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapel`
--

LOCK TABLES `mapel` WRITE;
/*!40000 ALTER TABLE `mapel` DISABLE KEYS */;
INSERT INTO `mapel` VALUES (1,'Matematika','2025-04-28 14:40:40','2025-05-22 12:40:56'),(2,'Bahasa Indonesia','2025-04-28 14:40:40','2025-04-28 14:40:40');
/*!40000 ALTER TABLE `mapel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_04_22_044934_create_walimurid_table',1),(2,'2025_04_22_045201_create_guru_table',1),(3,'2025_04_22_045447_create_kelas_table',1),(4,'2025_04_22_052118_create_siswa_table',1),(5,'2025_04_22_053532_create_mapel_table',1),(6,'2025_04_22_061215_create_jadwal_pelajaran_table',1),(7,'2025_04_22_061737_create_absensi_table',1),(8,'2025_04_22_063437_create_notifikasi_table',1),(9,'2025_04_22_064338_create_user_table',1),(10,'2025_04_30_002804_create_sessions_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifikasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_guru` bigint unsigned DEFAULT NULL,
  `id_siswa` bigint unsigned DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci,
  `waktu_kirim` datetime NOT NULL,
  `tujuan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kirim` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifikasi_id_guru_foreign` (`id_guru`),
  KEY `notifikasi_id_siswa_foreign` (`id_siswa`),
  CONSTRAINT `notifikasi_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`),
  CONSTRAINT `notifikasi_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifikasi`
--

LOCK TABLES `notifikasi` WRITE;
/*!40000 ALTER TABLE `notifikasi` DISABLE KEYS */;
INSERT INTO `notifikasi` VALUES (1,1,1,'Siswa Rahmat hadir hari ini.','2025-04-28 14:40:40','Walimurid',1,'2025-04-28 14:40:40','2025-04-28 14:40:40'),(2,2,2,'Siswa Putri sakit.','2025-04-28 14:40:40','Walimurid',0,'2025-04-28 14:40:40','2025-04-28 14:40:40');
/*!40000 ALTER TABLE `notifikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('trl9L1V1TSWxzfMfMrEHjIqCwI7atARIU3XFxzqD',2,'172.20.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnNsbjdEclM5ZjNzUXc4TFRJdEZnV05oRUxxWUpYZHNqcUdobjdUNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvZ3VydS9hdHRlbmRhbmNlP2phZHdhbD0xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',1748312912),('XuPGCXXLvuCzfWJ1ssJ7XCfW9qtxR4BsgYAv8ykZ',2,'172.20.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVUVMdW14VDNSMEFseXZaV3FUR2JJUjhVb3NtMFJoRWdsOHhZc2FEQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly9sb2NhbGhvc3QvZ3VydS9zdHVkZW50cy8yL2VkaXQ/ZGF0ZT0yMDI1LTA1LTI2Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',1748265535);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `siswa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_siswa` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signature_data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat_siswa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp_siswa` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kelas` bigint unsigned DEFAULT NULL,
  `id_walimurid` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_kelas_foreign` (`id_kelas`),
  KEY `siswa_id_walimurid_foreign` (`id_walimurid`),
  CONSTRAINT `siswa_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`),
  CONSTRAINT `siswa_id_walimurid_foreign` FOREIGN KEY (`id_walimurid`) REFERENCES `walimurid` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa`
--

LOCK TABLES `siswa` WRITE;
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
INSERT INTO `siswa` VALUES (1,'22001','Rahmat Hidayah',NULL,'P','2008-01-02','Jl. Mawar No.2','081234567',2,1,'2025-04-28 14:40:40','2025-05-22 12:31:45'),(2,'22002','Putri Aulia',NULL,'P','2008-02-02','Jl. Melati No.2','0819876543',2,2,'2025-04-28 14:40:40','2025-04-28 14:40:40'),(4,'12345','Ilham Raya','signature_data/sig_4_1748312088.png','L','2025-05-21','Jl. Karanganya','0897776665',1,3,'2025-05-21 06:29:30','2025-05-21 06:30:10');
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_siswa` bigint unsigned DEFAULT NULL,
  `id_guru` bigint unsigned DEFAULT NULL,
  `id_walimurid` bigint unsigned DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','guru','siswa','walimurid') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username_unique` (`username`),
  KEY `user_id_siswa_foreign` (`id_siswa`),
  KEY `user_id_guru_foreign` (`id_guru`),
  KEY `user_id_walimurid_foreign` (`id_walimurid`),
  CONSTRAINT `user_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`),
  CONSTRAINT `user_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`),
  CONSTRAINT `user_id_walimurid_foreign` FOREIGN KEY (`id_walimurid`) REFERENCES `walimurid` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,NULL,NULL,'rahmat','$2y$12$U.fKTLtdqUmqbVrCHwoOQOAGAZyXAslSzGxWqyNWBVBY69nN1MI4K','siswa',1,'2025-04-28 14:40:41','2025-04-28 14:40:41'),(2,NULL,1,NULL,'ahmad','$2y$12$VDBGlaNbje9wLLiEqpKFgOyEBLXtjkMDMM/Z7pCCv2nkV1/nlty/e','guru',1,'2025-04-28 14:40:41','2025-04-28 14:40:41'),(3,NULL,NULL,1,'walimurid1','$2y$12$b.mzYFzBCiizEqqaK35jeuyH2YyhDxKjmBFnO2.Cbgw35E8kaxxa6','walimurid',1,'2025-04-28 14:40:41','2025-04-28 14:40:41'),(4,NULL,NULL,NULL,'admin','$2y$12$J6m4VhUiTiIo8zWcN4bTp.bneYjzUMgdRUE2.6RKDsyxWdVbGftO2','admin',1,'2025-04-28 14:40:41','2025-04-28 14:40:41'),(6,NULL,3,NULL,'bagusBanget','$2y$12$4MXXczZL/jJVF0gvr8k8MePSnSpYJspvgSIvecNtrM7uoTIGRY.8i','guru',1,'2025-05-22 11:04:50','2025-05-22 11:04:50'),(7,NULL,NULL,3,'armanSanz','$2y$12$y6QZl3eiMqugTh.Xn4WIbemG7yRdPt.tjuvJZ4YDbnaVD/fpaHpz2','walimurid',1,'2025-05-22 11:07:16','2025-05-22 11:07:16'),(8,4,NULL,NULL,'akuBatman','$2y$12$b4SvRHvnBVf3YVeFBpgao.BnM6581GAYxGeMBhTtAD2ydzjrk0GzG','siswa',1,'2025-05-22 11:07:56','2025-05-22 14:05:29');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `walimurid`
--

DROP TABLE IF EXISTS `walimurid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `walimurid` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_walimurid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telpon_walimurid` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_walimurid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_walimurid` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `walimurid`
--

LOCK TABLES `walimurid` WRITE;
/*!40000 ALTER TABLE `walimurid` DISABLE KEYS */;
INSERT INTO `walimurid` VALUES (1,'Budi Santoso','08123456789','budi@example.com','Jl. Merdeka No.1','2025-04-28 14:40:40','2025-04-28 14:40:40'),(2,'Siti Aminah','08987654321','siti@example.com','Jl. Sudirman No.2','2025-04-28 14:40:40','2025-04-28 14:40:40'),(3,'Arman Santoso','089088765211','armansantoo@gmail.com','Jl. Kenanga','2025-05-14 05:31:19','2025-05-22 14:23:39');
/*!40000 ALTER TABLE `walimurid` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-27  3:15:03
