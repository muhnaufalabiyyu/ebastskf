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

-- Dumping data for table ebastskf.purchase_order: ~7 rows (approximately)
INSERT INTO `purchase_order` (`origin`, `orno`, `oset`, `pono`, `seqn`, `bpid`, `rcno`, `dnno`, `psno`, `ardt`, `item`, `dqua`, `satuan`, `price`, `baststatus`, `bastdt`, `bastusr`, `rrstatus`, `rrdt`, `rrusr`) VALUES
	('Sales', '2RC000164', 1, 1, 2, '2-0112', 'R70002145', 'KS90000110', 'SJ002934', '2023-08-10', '12201-00906-', 1000, '2000', 4000, 0, '2023-11-16 14:35:25', 'Putri Yolanda', 1, '2023-09-21 00:00:00', 'Abiyyu'),
	('Sales', '2RC000165', 1, 1, 2, '2-0113', 'R70002145', 'KS90000109', 'SJ002934', '2023-08-10', '12201-00908-', 1000, '2000', 2000, 0, '2023-10-09 10:22:45', 'Abiyyu', 1, '2023-09-27 00:00:00', ''),
	('Sales', '2RC000166', 1, 1, 2, '2-0114', 'R70002145', 'KS90000109', 'SJ002934', '2023-08-10', '12201-00909-', 1000, '2000', 2000, 0, '2023-08-28 00:00:00', 'rayhan_a', 1, '2023-09-27 00:00:00', ''),
	('Sales', '2RC000163', 1, 1, 1, '2-0112', 'R70002145', 'KS90000108', 'SJ002934', '2023-08-10', 'Shock Absorber', 1000, 'LOT', 3000, 0, '2023-11-22 19:44:16', 'Putri Yolanda', 2, '2023-10-27 16:34:22', 'Putri Yolanda'),
	('Sales', '2RC000163', 1, 1, 1, '2-0112', 'R70002145', 'KS90000108', 'SJ002934', '2023-08-10', 'SA Damper', 1000, 'LOT', 3000, 0, '2023-11-22 19:44:16', 'Putri Yolanda', 2, '2023-10-27 16:34:22', 'Putri Yolanda'),
	('Sales', '2RC000163', 1, 1, 1, '2-0112', 'R70002145', 'KS90000108', 'SJ002934', '2023-08-10', 'SA Mould', 1000, 'LOT', 3000, 0, '2023-11-22 19:44:16', 'Putri Yolanda', 2, '2023-10-27 16:34:22', 'Putri Yolanda'),
	('Sales', '2RC000163', 1, 1, 1, '2-0112', 'R70002145', 'KS90000108', 'SJ002934', '2023-08-10', 'FF Assy', 1000, 'LOT', 3000, 0, '2023-11-22 19:44:16', 'Putri Yolanda', 2, '2023-10-27 16:34:22', 'Putri Yolanda');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
