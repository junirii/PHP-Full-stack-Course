-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        10.8.3-MariaDB - mariadb.org binary distribution
-- 서버 OS:                        Win64
-- HeidiSQL 버전:                  12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- todo 데이터베이스 구조 내보내기
CREATE DATABASE IF NOT EXISTS `todo` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `todo`;

-- 테이블 todo.t_todo 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_todo` (
  `itodo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `todo` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`itodo`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 todo.t_todo:~9 rows (대략적) 내보내기
INSERT IGNORE INTO `t_todo` (`itodo`, `todo`, `created_at`) VALUES
	(73, '1', '2022-07-13 10:17:40'),
	(74, '2', '2022-07-13 10:17:41'),
	(75, '3', '2022-07-13 10:17:41'),
	(76, '4', '2022-07-13 10:17:41'),
	(77, '5', '2022-07-13 10:17:41'),
	(78, '6', '2022-07-13 10:17:42'),
	(79, '7', '2022-07-13 10:17:42'),
	(80, '8', '2022-07-13 10:46:27'),
	(81, '9', '2022-07-13 10:46:28');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
