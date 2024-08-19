-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.38-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table ebastskf.bast
CREATE TABLE IF NOT EXISTS `bast` (
  `id_bast` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `offerno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bastno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bastdt` date DEFAULT NULL,
  `workstart` date DEFAULT NULL,
  `workend` date DEFAULT NULL,
  `workdesc` text COLLATE utf8mb4_unicode_ci,
  `workqty` int(11) DEFAULT NULL,
  `copypofile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reportfile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `offerfile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `createdby` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userappv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_rate` int(11) DEFAULT NULL,
  `userappvdt` datetime DEFAULT NULL,
  `ehsappv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ehsappvdt` datetime DEFAULT NULL,
  `ehsnotes` text COLLATE utf8mb4_unicode_ci,
  `purchappv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchappvdt` datetime DEFAULT NULL,
  `rrusr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rrdt` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_bast`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebastskf.bast: ~2 rows (approximately)
INSERT INTO `bast` (`id_bast`, `pono`, `offerno`, `bastno`, `bastdt`, `workstart`, `workend`, `workdesc`, `workqty`, `copypofile`, `reportfile`, `offerfile`, `status`, `createdby`, `supplier_id`, `to_user`, `userappv`, `user_rate`, `userappvdt`, `ehsappv`, `ehsappvdt`, `ehsnotes`, `purchappv`, `purchappvdt`, `rrusr`, `rrdt`, `created_at`, `updated_at`) VALUES
	(1, 'N2011002721', '192309120391', '001/DRVS/BAST/MTNC/11/2023', '2023-11-28', '2023-11-25', '2023-11-28', 'Renewable Energy', NULL, 'public/files/copypo/example.pdf', 'public/files/reportfile/example (6).pdf', 'public/files/offerfile/example (6).pdf', 5, 'Muhammad Naufal Abiyyu', '2-0215', 'Engineering', 'Athhar Arrosyad', 5, '2023-11-28 21:44:51', 'Mardi Ritonga', '2023-11-28 21:56:10', 'TRIAL EHS NOTES TERBARU', 'Mochrita Lestari', '2023-11-28 22:05:26', 'Fadhlandi Naufan', '2023-11-28 22:10:15', '2023-11-28 14:22:59', '2023-11-28 15:10:15'),
	(2, 'N2011002722', '192309120399', '002/DRVS/BAST/MTNC/11/2023', '2023-11-28', '2023-11-27', '2023-11-28', 'PERBAIKAN AC', NULL, 'public/files/copypo/example (2).pdf', 'public/files/reportfile/example (1).pdf', 'public/files/offerfile/example.pdf', 5, 'Muhammad Naufal Abiyyu', '2-0215', 'HRGA', 'Nur Rachmah', 3, '2023-11-28 22:13:30', 'Mardi Ritonga', '2023-11-28 22:14:08', 'TRIAL EVALUATION HRGA PERBAIKAN AC', 'Mochrita Lestari', '2023-11-28 22:14:54', 'Fadhlandi Naufan', '2023-11-28 22:15:34', '2023-11-28 14:32:18', '2023-11-28 15:15:34');

-- Dumping structure for table ebastskf.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebastskf.migrations: ~1 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2023_10_25_012135_create_bast_table', 1);

-- Dumping structure for table ebastskf.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebastskf.password_resets: ~0 rows (approximately)

-- Dumping structure for table ebastskf.purchase_order
CREATE TABLE IF NOT EXISTS `purchase_order` (
  `no_po` varchar(50) DEFAULT NULL,
  `date_po` date DEFAULT NULL,
  `no_pp` varchar(50) DEFAULT NULL,
  `date_pp` date DEFAULT NULL,
  `date_eta` date DEFAULT NULL,
  `date_send` date DEFAULT NULL,
  `date_delivery_schedule` date DEFAULT NULL,
  `is_send` varchar(10) DEFAULT NULL,
  `notes_po` text,
  `item_code` varchar(50) DEFAULT NULL,
  `item_name` text,
  `item_type` text,
  `item_spec` text,
  `is_no_stock` varchar(10) DEFAULT NULL,
  `qty` decimal(18,2) DEFAULT NULL,
  `qty_remaining` decimal(18,2) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `total` varchar(50) DEFAULT NULL,
  `po_detil_id` varchar(50) DEFAULT NULL,
  `supplier_code` varchar(50) DEFAULT NULL,
  `supplier_name` text,
  `qty_do_created` decimal(18,2) DEFAULT NULL,
  `drawing_number` varchar(50) DEFAULT NULL,
  `drawing_edition` varchar(50) DEFAULT NULL,
  `outstanding_po_info_delivery_schedule` varchar(50) DEFAULT NULL,
  `outstanding_po_info_category` varchar(50) DEFAULT NULL,
  `outstanding_po_info_remark` text,
  `outstanding_po_info_id` varchar(50) DEFAULT NULL,
  `baststatus` int(11) DEFAULT '0',
  `bastusr` varchar(255) DEFAULT NULL,
  `bastdt` datetime DEFAULT NULL,
  `rrstatus` int(11) DEFAULT NULL,
  `rrdt` datetime DEFAULT NULL,
  `rrusr` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ebastskf.purchase_order: ~7 rows (approximately)
INSERT INTO `purchase_order` (`no_po`, `date_po`, `no_pp`, `date_pp`, `date_eta`, `date_send`, `date_delivery_schedule`, `is_send`, `notes_po`, `item_code`, `item_name`, `item_type`, `item_spec`, `is_no_stock`, `qty`, `qty_remaining`, `unit`, `price`, `total`, `po_detil_id`, `supplier_code`, `supplier_name`, `qty_do_created`, `drawing_number`, `drawing_edition`, `outstanding_po_info_delivery_schedule`, `outstanding_po_info_category`, `outstanding_po_info_remark`, `outstanding_po_info_id`, `baststatus`, `bastusr`, `bastdt`, `rrstatus`, `rrdt`, `rrusr`) VALUES
	('N2011002720', '2011-07-25', 'NS20111197', '2011-07-22', '2011-09-30', '2011-09-26', '2011-09-30', 'YES', 'O/A NO.22714 ETD: W43/2011 ETA: W44/2011', '900900160190055', 'GRINDING WHEEL TYROLIT A', 'DIMENSION 20 X 19 X 11 MM', 'TYROLIT AH120K6VCOL80 COLUMBIA', 'YES', 100.00, 100.00, 'PCS', 'EURO 1.20', 'EURO 120.00', '205865', '2-0214', 'DURASIV FAR EAST PTE LTD.', 0.00, '-', '-', '', '***', '', '', 0, NULL, NULL, NULL, NULL, NULL),
	('N2011002720', '2011-07-25', 'NS20111197', '2011-07-22', '2011-09-30', '2011-09-26', '2011-09-30', 'YES', 'O/A NO.22714 ETD: W43/2011 ETA: W44/2011', '900900160190055', 'GRINDING WHEEL TYROLIT B', 'DIMENSION 20 X 15 X 7 MM', 'TYROLIT AH120K6VCOL80 COLUMBIA', 'YES', 100.00, 100.00, 'PCS', 'EURO 1.20', 'EURO 120.00', '205865', '2-0214', 'DURASIV FAR EAST PTE LTD.', 0.00, '-', '-', '', '***', '', '', 0, NULL, NULL, NULL, NULL, NULL),
	('N2011002721', '2011-07-26', 'NS20111198', '2011-07-23', '2011-10-01', '2011-09-27', '2011-10-01', 'NO', 'O/A NO.22715 ETD: W44/2011 ETA: W45/2011', '900900160190056', 'GRINDING WHEEL TYROLIT 2', 'DIMENSION 18 X 17 X 9 MM', 'TYROLIT AH130K7VCOL81 COLUMBIA', 'NO', 120.00, 120.00, 'PCS', 'EURO 1.30', 'EURO 156.00', '205866', '2-0215', 'DURASIV SOUTH PTE LTD.', 20.00, '-', '-', '', '***', '', '', 0, 'Muhammad Naufal Abiyyu', '2023-11-28 00:00:00', NULL, NULL, NULL),
	('N2011002722', '2012-07-26', 'NS20111199', '2011-07-24', '2011-10-02', '2011-09-28', '2011-10-02', 'YES', 'O/A NO.22716 ETD: W45/2011 ETA: W46/2011', '900900160190057', 'GRINDING WHEEL TYROLIT 3', 'DIMENSION 19 X 18 X 10 MM', 'TYROLIT AH140K8VCOL82 COLUMBIA', 'YES', 150.00, 150.00, 'PCS', 'EURO 1.40', 'EURO 210.00', '205867', '2-0215', 'DURASIV SOUTH PTE LTD.', 30.00, '-', '-', '', '***', '', '', 0, 'Muhammad Naufal Abiyyu', '2023-11-28 00:00:00', NULL, NULL, NULL),
	('N2011002723', '2011-07-28', 'NS20111200', '2011-07-25', '2011-10-03', '2011-09-29', '2011-10-03', 'NO', 'O/A NO.22717 ETD: W46/2011 ETA: W47/2011', '900900160190058', 'GRINDING WHEEL TYROLIT 4', 'DIMENSION 20 X 19 X 11 MM', 'TYROLIT AH150K9VCOL83 COLUMBIA', 'NO', 200.00, 200.00, 'PCS', 'EURO 1.50', 'EURO 300.00', '205868', '2-0214', 'DURASIV NORTH PTE LTD.', 40.00, '-', '-', '', '***', '', '', 0, NULL, NULL, NULL, NULL, NULL),
	('N2011002720', '2011-07-25', 'NS20111197', '2011-07-22', '2011-09-30', '2011-09-26', '2011-09-30', 'YES', 'O/A NO.22714 ETD: W43/2011 ETA: W44/2011', '900900160190055', 'GRINDING WHEEL TYROLIT', 'DIMENSION 17 X 16 X 8 MM', 'TYROLIT AH120K6VCOL80 COLUMBIA', 'YES', 100.00, 100.00, 'PCS', 'EURO 1.20', 'EURO 120.00', '205865', '2-0214', 'DURASIV FAR EAST PTE LTD.', 0.00, '-', '-', '', '***', '', '', 0, NULL, NULL, NULL, NULL, NULL),
	('N2011002721', '2011-07-26', 'NS20111198', '2011-07-23', '2011-10-01', '2011-09-27', '2011-10-01', 'NO', 'O/A NO.22716 ETD: W45/2011 ETA: W46/2011', '900900160190057', 'GRINDING WHEEL TYROLIT 3', 'DIMENSION 19 X 18 X 10 MM', 'TYROLIT AH140K8VCOL82 COLUMBIA', 'YES', 150.00, 150.00, 'PCS', 'EURO 1.40', 'EURO 210.00', '205867', '2-0215', 'DURASIV SOUTH PTE LTD.', 30.00, '-', '-', '', '***', '', '', 0, 'Muhammad Naufal Abiyyu', '2023-11-28 00:00:00', NULL, NULL, NULL);

-- Dumping structure for table ebastskf.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `idsp` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` varchar(50) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `aliases` varchar(10) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `local` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`idsp`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table ebastskf.supplier: ~8 rows (approximately)
INSERT INTO `supplier` (`idsp`, `supplier_id`, `nama`, `aliases`, `npwp`, `alamat`, `kontak`, `local`) VALUES
	(1, '2-0112', 'NOK Indonesia', 'NOK', '01.002.832.2-092.000', 'Cibitung', '02183123412', 'Y'),
	(2, '2-0113', 'SUPPLIER XX', 'SPXX', '01.003.123.4-012.001', 'Jakarta', NULL, 'N'),
	(3, '2-0114', 'SUPPLIER X', 'SPX', '01.003.123.4-012.001', 'Jakarta', NULL, 'Y'),
	(4, '2-0115', 'SUPPLIER XXX', 'SXXX', '01.003.123.4-012.001', 'Jakarta', NULL, 'Y'),
	(5, '2-0116', 'TOYOTA ASTRA MOTOR', 'TAM', '01.003.123.4-012.001', 'Jakarta', NULL, 'Y'),
	(6, '2-0117', 'Toyota Motor Manufacturing Indonesia', 'TMMIN', '01.000.099.0092.000', 'Karawang, Jawa Barat', '02109213091', 'Y'),
	(7, '2-0214', 'DURASIV FAR EAST PTE LTD.', 'DRVE', '01.000.099.0102.001', 'China', '02183123412', 'N'),
	(8, '2-0215', 'DURASIV SOUTH PTE LTD.', 'DRVS', '01.000.099.0102.002', 'Hong Kong', '02183123412', 'N');

-- Dumping structure for table ebastskf.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acting` int(11) NOT NULL DEFAULT '0',
  `gol` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebastskf.users: ~17 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `supplier_id`, `dept`, `acting`, `gol`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Muhammad Naufal Abiyyu', 'muhnaufalabiyyu@gmail.com', '2023-10-19 06:59:15', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '2-0215', '', 1, 0, NULL, NULL, NULL),
	(2, 'Putri Yolanda', 'yolandaputri665@gmail.com', '2023-10-19 06:59:15', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '2-0214', '', 1, 0, NULL, NULL, NULL),
	(3, 'Mochrita Lestari', 'mochrita.lestari@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'Purchasing', 2, 3, NULL, '2023-11-28 13:40:07', NULL),
	(4, 'Ika Amalia', 'ika.amalia@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'Purchasing', 2, 3, NULL, '2023-11-28 13:40:07', NULL),
	(5, 'Muhammad Sidik Nur Prasetyo ', 'muhammad.sidik.nur.prasetyo@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'Purchasing', 2, 3, NULL, '2023-11-28 13:40:07', NULL),
	(6, 'Athhar Arrosyad', 'athhar.arrosyad@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'Engineering', 2, 4, NULL, '2023-11-28 13:40:07', NULL),
	(7, 'Hanif K', 'hanif.k@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'Engineering', 2, 4, NULL, '2023-11-28 13:40:07', NULL),
	(8, 'Luthfi Arief', 'luthfi.arief@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'Maintenance', 2, 4, NULL, '2023-11-28 13:40:07', NULL),
	(9, 'Agung Budi', 'agung.budi@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'Maintenance', 2, 4, NULL, '2023-11-28 13:40:07', NULL),
	(10, 'Mardi Ritonga', 'mardi.ritonga@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'EHS', 2, 3, NULL, '2023-11-28 13:40:07', NULL),
	(11, 'Ahmad Gojali', 'ahmad.gojali@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'EHS', 2, 3, NULL, '2023-11-28 13:40:07', NULL),
	(12, 'Aep Nurjaman', 'aep.nurjaman@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'SCWH', 2, 4, NULL, '2023-11-28 13:40:07', NULL),
	(13, 'Achwan restu', 'achwan.restu@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'SCWH', 2, 4, NULL, '2023-11-28 13:40:07', NULL),
	(14, 'Nur Rachmah', 'nur.rachmah@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'HRGA', 2, 4, NULL, '2023-11-28 13:40:07', NULL),
	(15, 'Syiasha Emandha', 'syiasha.emandha@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'HRGA', 2, 4, NULL, '2023-11-28 13:40:07', NULL),
	(16, 'Teguh Prasetyo', 'teguh.prasetyo@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'WH', 2, 3, NULL, '2023-11-28 13:40:07', NULL),
	(17, 'Fadhlandi Naufan', 'fadhlandi.naufan@skf.com', '2023-11-28 13:39:54', '$2y$10$uUK0L/fVODxMTXmes5SfQ.yqYZouiKI021HD4ZiW5jYjlQpVPmrcG', '', 'WH', 2, 3, NULL, '2023-11-28 13:40:07', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

