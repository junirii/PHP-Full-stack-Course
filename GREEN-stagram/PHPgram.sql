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


-- phpgram 데이터베이스 구조 내보내기
CREATE DATABASE IF NOT EXISTS `phpgram` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `phpgram`;

-- 테이블 phpgram.t_dm 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_dm` (
  `idm` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `regdt` datetime DEFAULT current_timestamp(),
  `lastmsg` varchar(200) NOT NULL,
  `lastdt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idm`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_dm:~4 rows (대략적) 내보내기
INSERT IGNORE INTO `t_dm` (`idm`, `regdt`, `lastmsg`, `lastdt`) VALUES
	(1, '2022-07-08 13:03:26', '', '2022-07-08 13:03:26'),
	(2, '2022-07-08 13:05:56', '', '2022-07-08 13:05:56'),
	(3, '2022-07-08 13:11:35', '', '2022-07-08 13:11:35'),
	(4, '2022-07-08 13:12:26', '', '2022-07-08 13:12:26'),
	(5, '2022-07-08 15:44:12', '', '2022-07-08 15:44:12');

-- 테이블 phpgram.t_dm_msg 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_dm_msg` (
  `idm` int(10) unsigned NOT NULL,
  `seq` int(10) unsigned NOT NULL,
  `iuser` int(10) unsigned DEFAULT NULL,
  `msg` varchar(200) NOT NULL,
  `regdt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idm`,`seq`),
  KEY `iuser` (`iuser`),
  CONSTRAINT `t_dm_msg_ibfk_1` FOREIGN KEY (`idm`) REFERENCES `t_dm` (`idm`),
  CONSTRAINT `t_dm_msg_ibfk_2` FOREIGN KEY (`iuser`) REFERENCES `t_user` (`iuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_dm_msg:~255 rows (대략적) 내보내기
INSERT IGNORE INTO `t_dm_msg` (`idm`, `seq`, `iuser`, `msg`, `regdt`) VALUES
	(1, 1, 6, 'ㅁㄴㅇ', '2022-07-08 13:03:29'),
	(1, 2, 6, 'ㅋㅋ', '2022-07-08 13:03:32'),
	(1, 3, 6, 'ㅋㅋㅋㅋㅋㅋㅋ', '2022-07-08 13:03:34'),
	(1, 4, 6, 'ㅎㅇ', '2022-07-08 13:03:38'),
	(1, 5, 6, 'qwe', '2022-07-08 14:29:21'),
	(1, 6, 6, 'zxc', '2022-07-08 14:29:42'),
	(1, 7, 6, 'zzz', '2022-07-08 14:29:50'),
	(1, 8, 6, 'qwe', '2022-07-08 14:29:53'),
	(2, 1, 6, 'zz', '2022-07-08 13:06:14'),
	(2, 2, 6, 'gd', '2022-07-08 13:06:17'),
	(2, 3, 6, 'asdqwf', '2022-07-08 13:12:12'),
	(2, 4, 6, 'asdwq', '2022-07-08 13:12:26'),
	(2, 5, 6, 'asd', '2022-07-08 13:12:30'),
	(2, 6, 6, 'ㅂㅂㅂ', '2022-07-08 14:28:48'),
	(2, 7, 6, 'zz', '2022-07-08 14:29:17'),
	(2, 8, 6, 'asd', '2022-07-08 14:29:18'),
	(2, 9, 6, 'asd', '2022-07-08 15:05:37'),
	(2, 10, 6, 'qwe', '2022-07-08 15:05:42'),
	(2, 11, 6, 'zxc', '2022-07-08 15:05:44'),
	(2, 12, 6, 'ggg', '2022-07-08 15:05:54'),
	(3, 1, 6, 'qwe', '2022-07-08 14:29:12'),
	(3, 2, 6, 'qwe', '2022-07-08 15:05:59'),
	(3, 3, 6, 'zxc', '2022-07-08 15:06:01'),
	(3, 4, 17, 'dsdsdsdsd', '2022-07-08 15:23:58'),
	(3, 5, 17, 'sadsdsd', '2022-07-08 15:24:02'),
	(3, 6, 17, 'sdsd', '2022-07-08 15:24:05'),
	(3, 7, 17, 'asdsd', '2022-07-08 15:24:06'),
	(3, 8, 17, 'sdsdsd', '2022-07-08 15:24:08'),
	(3, 9, 17, 'aaaa', '2022-07-08 15:24:09'),
	(3, 10, 17, 'gd', '2022-07-08 15:24:11'),
	(3, 11, 17, 'ㅎㅇ', '2022-07-08 15:24:12'),
	(3, 12, 17, '준일쿤', '2022-07-08 15:24:14'),
	(3, 13, 17, '안녕', '2022-07-08 15:24:15'),
	(3, 14, 17, '사랑해', '2022-07-08 15:24:17'),
	(3, 15, 17, '준일쿤.....', '2022-07-08 15:24:24'),
	(3, 16, 17, '아이시떼루', '2022-07-08 15:24:31'),
	(3, 17, 17, '현민쿤', '2022-07-08 15:24:59'),
	(3, 18, 17, '예아', '2022-07-08 15:25:02'),
	(3, 19, 17, 'ㅇㅇ', '2022-07-08 15:26:54'),
	(3, 20, 17, '안녕?', '2022-07-08 15:27:26'),
	(3, 21, 17, '모행', '2022-07-08 15:27:29'),
	(3, 22, 17, '喝', '2022-07-08 15:27:59'),
	(3, 23, 17, '꾸짖을 갈 !喝', '2022-07-08 15:28:05'),
	(3, 24, 17, '꾸짖을 喝 !!!', '2022-07-08 15:28:19'),
	(3, 25, 17, 'ㅁㄴㅇ', '2022-07-08 15:29:46'),
	(3, 26, 17, 'ㄷㄱㅇㄹ', '2022-07-08 15:32:32'),
	(3, 27, 17, '도키도키 시데타', '2022-07-08 15:32:35'),
	(3, 28, 17, '오하요~', '2022-07-08 15:32:42'),
	(3, 29, 17, '준일쿤 무스비다', '2022-07-08 15:32:51'),
	(3, 30, 6, 'ㅎㅇㅎㅇ', '2022-07-08 15:33:11'),
	(3, 31, 6, 'ㅋㅋ', '2022-07-08 15:33:14'),
	(3, 32, 6, 'ㄴㅁㅇ', '2022-07-08 15:33:15'),
	(3, 33, 6, 'ㅈㅂㄱㄹㅈㄱㄹ', '2022-07-08 15:33:16'),
	(3, 34, 6, 'ㄴㅁㄹ', '2022-07-08 15:33:16'),
	(3, 35, 6, 'ㅇㄴㅎ', '2022-07-08 15:33:16'),
	(3, 36, 6, 'ㅎㅇㄴ', '2022-07-08 15:33:16'),
	(3, 37, 6, 'ㅎ', '2022-07-08 15:33:16'),
	(3, 38, 6, 'ㅇㄴ', '2022-07-08 15:33:16'),
	(3, 39, 6, 'ㅎㅇㄴ', '2022-07-08 15:33:16'),
	(3, 40, 6, 'ㅎㄴㅇㅁㅎ', '2022-07-08 15:33:17'),
	(3, 41, 6, 'ㄴㅇㅁㅎㄴㅇㅁ', '2022-07-08 15:33:17'),
	(3, 42, 6, 'ㅎㅇㄴㅁㅎㄴㅇㅁㅎ', '2022-07-08 15:33:17'),
	(3, 43, 6, 'ㅇㄴㅎ', '2022-07-08 15:33:18'),
	(3, 44, 17, '몬데', '2022-07-08 15:33:18'),
	(3, 45, 17, '오ㅑㅐ', '2022-07-08 15:33:20'),
	(3, 46, 6, '이야', '2022-07-08 15:33:20'),
	(3, 47, 6, '지기노', '2022-07-08 15:33:21'),
	(3, 48, 17, '이야', '2022-07-08 15:33:21'),
	(3, 49, 17, '키야', '2022-07-08 15:33:22'),
	(3, 50, 6, 'ㅅㅅ', '2022-07-08 15:33:22'),
	(3, 51, 6, 'ㅅ', '2022-07-08 15:33:23'),
	(3, 52, 6, 'ㅅ', '2022-07-08 15:33:23'),
	(3, 53, 6, 'ㅅ', '2022-07-08 15:33:23'),
	(3, 54, 6, 'ㅅ', '2022-07-08 15:33:23'),
	(3, 55, 6, 'ㅅ', '2022-07-08 15:33:23'),
	(3, 56, 6, 'ㅅ', '2022-07-08 15:33:23'),
	(3, 57, 17, 'cex', '2022-07-08 15:33:23'),
	(3, 58, 6, 'ㅋㅋ', '2022-07-08 15:33:25'),
	(3, 59, 6, 'ㅋ', '2022-07-08 15:33:25'),
	(3, 60, 6, 'ㅋ', '2022-07-08 15:33:25'),
	(3, 61, 6, 'ㅋ', '2022-07-08 15:33:25'),
	(3, 62, 17, '지리노', '2022-07-08 15:33:25'),
	(3, 63, 6, 'ㅋㅋ', '2022-07-08 15:33:25'),
	(3, 64, 6, 'ㅋ', '2022-07-08 15:33:26'),
	(3, 65, 6, 'ㅋ', '2022-07-08 15:33:26'),
	(3, 66, 6, 'ㅋ', '2022-07-08 15:33:26'),
	(3, 67, 6, 'ㅋㅋ', '2022-07-08 15:33:26'),
	(3, 68, 17, '머지', '2022-07-08 15:33:33'),
	(3, 69, 17, '준일쿤', '2022-07-08 15:33:41'),
	(3, 70, 17, '감동이야...', '2022-07-08 15:33:44'),
	(3, 71, 6, '잠오노....', '2022-07-08 15:33:49'),
	(3, 72, 6, '동휘쿠~~~~우우운', '2022-07-08 15:33:55'),
	(3, 73, 17, '형형형형형혀옇여혀', '2022-07-08 15:33:57'),
	(3, 74, 17, '????!!!!!!!!', '2022-07-08 15:34:00'),
	(3, 75, 17, '1234134532525235235235235', '2022-07-08 15:34:14'),
	(3, 76, 17, '12312312321323232323232323', '2022-07-08 15:34:18'),
	(3, 77, 6, '315235', '2022-07-08 15:34:20'),
	(3, 78, 6, '25', '2022-07-08 15:34:20'),
	(3, 79, 6, '245', '2022-07-08 15:34:20'),
	(3, 80, 6, '42365', '2022-07-08 15:34:20'),
	(3, 81, 6, '43', '2022-07-08 15:34:20'),
	(3, 84, 17, '모여', '2022-07-08 15:34:35'),
	(3, 85, 17, '어이', '2022-07-08 15:34:36'),
	(3, 86, 6, '5252', '2022-07-08 15:34:41'),
	(3, 87, 17, '\\\\\\\\\\\\\\', '2022-07-08 15:34:59'),
	(3, 88, 17, '1', '2022-07-08 15:35:19'),
	(3, 89, 17, '2', '2022-07-08 15:35:19'),
	(3, 90, 17, '3', '2022-07-08 15:35:20'),
	(3, 91, 17, '4', '2022-07-08 15:35:20'),
	(3, 92, 17, '5', '2022-07-08 15:35:21'),
	(3, 93, 17, '6', '2022-07-08 15:35:21'),
	(3, 94, 17, '7', '2022-07-08 15:35:21'),
	(3, 95, 17, '8', '2022-07-08 15:35:22'),
	(3, 96, 17, '9', '2022-07-08 15:35:22'),
	(3, 97, 17, '0', '2022-07-08 15:35:22'),
	(3, 98, 17, 'ㅇㅇㅇ', '2022-07-08 15:36:11'),
	(3, 99, 6, '스크롤', '2022-07-08 15:36:12'),
	(3, 100, 17, '히히히히ㅣ', '2022-07-08 15:36:26'),
	(3, 101, 17, 'zl존준일쨩', '2022-07-08 15:36:37'),
	(3, 102, 17, '슈퍼곱등이준일쿤', '2022-07-08 15:36:52'),
	(3, 103, 6, 'zl존최강파워준일', '2022-07-08 15:36:53'),
	(3, 104, 6, '곱등이요?', '2022-07-08 15:36:55'),
	(3, 105, 17, '슈포곱등이왕', '2022-07-08 15:37:04'),
	(3, 106, 6, '동휘쿤,,,,', '2022-07-08 15:37:08'),
	(3, 107, 17, '메이플 닉넴임', '2022-07-08 15:37:09'),
	(3, 108, 6, 'ㄷㄷ', '2022-07-08 15:37:11'),
	(3, 109, 17, '부캐 연가시 왕', '2022-07-08 15:37:21'),
	(3, 110, 6, '잼민이같노', '2022-07-08 15:37:26'),
	(3, 111, 17, '5학년때 지음', '2022-07-08 15:37:31'),
	(3, 112, 17, 'ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ', '2022-07-08 15:37:32'),
	(3, 113, 6, '잼민이맞노', '2022-07-08 15:37:34'),
	(3, 114, 6, 'ㅋㅋㅋㅋ', '2022-07-08 15:37:35'),
	(3, 115, 17, '헤헤', '2022-07-08 15:38:42'),
	(3, 116, 17, '히히', '2022-07-08 15:38:43'),
	(3, 117, 17, '아', '2022-07-08 15:38:45'),
	(3, 118, 17, '야', '2022-07-08 15:38:45'),
	(3, 119, 17, '어', '2022-07-08 15:38:46'),
	(3, 120, 17, '요', '2022-07-08 15:38:46'),
	(3, 121, 6, 'ㅁㄴㅇ', '2022-07-08 15:39:01'),
	(3, 122, 17, '킥킥', '2022-07-08 15:39:10'),
	(3, 123, 17, '쿡쿡', '2022-07-08 15:39:12'),
	(3, 124, 17, '캬캬', '2022-07-08 15:39:15'),
	(3, 125, 17, '퍄퍄퍄', '2022-07-08 15:39:18'),
	(3, 126, 17, 'wwwwwww', '2022-07-08 15:39:21'),
	(3, 127, 17, '쥐엔장 준일쿤 머냐구~', '2022-07-08 15:39:33'),
	(3, 128, 17, '어', '2022-07-08 15:40:18'),
	(3, 129, 17, '어', '2022-07-08 15:40:18'),
	(3, 130, 17, '어', '2022-07-08 15:40:18'),
	(3, 131, 17, '어', '2022-07-08 15:40:18'),
	(3, 132, 17, '어', '2022-07-08 15:40:18'),
	(3, 133, 17, 'ㅇㅇ', '2022-07-08 15:40:18'),
	(3, 134, 6, 'ㅁㄴㅇ', '2022-07-08 15:40:21'),
	(3, 135, 17, '어', '2022-07-08 15:40:21'),
	(3, 136, 6, 'ㅁㅁㅁㅇㄴㅁㅇ', '2022-07-08 15:40:23'),
	(3, 137, 6, 'ㅇㄴ', '2022-07-08 15:40:23'),
	(3, 138, 17, 'ㅇㄴ', '2022-07-08 15:40:28'),
	(3, 139, 17, 'ㅁㅁㅁ', '2022-07-08 15:40:29'),
	(3, 140, 6, 'ㅁㄴㅇ', '2022-07-08 15:40:36'),
	(3, 141, 17, '낭만이 넘친달까?', '2022-07-08 15:40:38'),
	(3, 142, 17, '너무상심하지마 준일쿤~ 상대가 나잖아~', '2022-07-08 15:40:52'),
	(3, 143, 17, '비가오면 옷이 젖는게 당연하자나', '2022-07-08 15:41:09'),
	(3, 144, 6, 'ㅋㅌㅊ', '2022-07-08 15:41:16'),
	(3, 145, 17, '날 만나면 지는것처럼', '2022-07-08 15:41:16'),
	(3, 146, 17, 'ㅇㅇㅇ', '2022-07-08 15:41:23'),
	(3, 147, 17, 'ㅇㅈㅇㅈㅇㅈ', '2022-07-08 15:41:24'),
	(3, 148, 17, 'ㅇㅈㅇㅈㅇㅈㅇ', '2022-07-08 15:41:25'),
	(3, 149, 17, 'ㅈㅇㅈㅇ', '2022-07-08 15:41:26'),
	(3, 150, 17, 'ㅈㅇㅈㅇ', '2022-07-08 15:41:27'),
	(3, 151, 17, 'ㅇㅈ', '2022-07-08 15:41:27'),
	(3, 152, 17, 'ㅇㅈㅇㅈ', '2022-07-08 15:41:28'),
	(3, 153, 17, 'ㅈㅇ', '2022-07-08 15:41:28'),
	(3, 154, 17, 'ㅂㅈㄷ', '2022-07-08 15:41:28'),
	(3, 155, 17, 'ㅂㅈㄷㅂㅈㅂㄷㄱㅂㅈㄱ', '2022-07-08 15:41:29'),
	(3, 156, 17, 'ㅋㅌ', '2022-07-08 15:41:30'),
	(3, 157, 17, 'ㅌㅊ', '2022-07-08 15:41:30'),
	(3, 158, 17, 'ㅋㅌ', '2022-07-08 15:41:30'),
	(3, 159, 17, '어허', '2022-07-08 15:41:32'),
	(3, 160, 17, '준', '2022-07-08 15:41:35'),
	(3, 161, 17, '일', '2022-07-08 15:41:35'),
	(3, 162, 17, '쿤', '2022-07-08 15:41:36'),
	(3, 163, 17, '지구에서 꺼져라!', '2022-07-08 15:41:45'),
	(3, 164, 6, '카무이~', '2022-07-08 15:41:47'),
	(3, 165, 17, '카무이!', '2022-07-08 15:41:53'),
	(3, 166, 17, '폭발은 예술이다!', '2022-07-08 15:41:58'),
	(3, 167, 17, '갈!!!', '2022-07-08 15:42:00'),
	(3, 168, 17, '신 라  텐 세 !', '2022-07-08 15:43:12'),
	(3, 169, 6, '신', '2022-07-08 15:43:22'),
	(3, 170, 6, '라', '2022-07-08 15:43:23'),
	(3, 171, 6, '천', '2022-07-08 15:43:24'),
	(3, 172, 6, '정', '2022-07-08 15:43:24'),
	(3, 173, 17, '지', '2022-07-08 15:43:27'),
	(3, 174, 17, '폭', '2022-07-08 15:43:27'),
	(3, 175, 17, '천', '2022-07-08 15:43:28'),
	(3, 176, 17, '정', '2022-07-08 15:43:29'),
	(3, 177, 6, '꾸짖을 갈!', '2022-07-08 15:43:31'),
	(3, 178, 17, '갈ㄹㄹㄹㄹ!', '2022-07-08 15:43:35'),
	(3, 179, 17, 'ㅇㅇㅇ', '2022-07-08 15:48:01'),
	(3, 180, 17, 'ㅇㅇㅇ', '2022-07-08 15:48:06'),
	(3, 181, 17, 'ㅇㅇㅇㅇ', '2022-07-08 15:48:08'),
	(3, 182, 17, 'ㄷ힘?', '2022-07-08 15:48:25'),
	(3, 183, 17, 'ㅇㅇ', '2022-07-08 15:48:27'),
	(3, 184, 17, 'ㅇㅇ', '2022-07-08 15:48:28'),
	(3, 185, 17, 'ㅁㄴㅇ', '2022-07-08 15:48:29'),
	(3, 186, 17, 'ㅁㄴㅇ', '2022-07-08 15:48:30'),
	(3, 187, 17, 'ㅂㅈㄷ', '2022-07-08 15:48:31'),
	(3, 188, 17, 'ㅁㄴㅇ', '2022-07-08 15:48:36'),
	(3, 189, 17, 'ㄴㅇㄴㅇ', '2022-07-08 15:48:39'),
	(3, 190, 6, 'ㅇㅇ', '2022-07-08 15:56:51'),
	(3, 191, 6, 'ㅎㅇ', '2022-07-08 15:57:07'),
	(3, 192, 6, 'ㅎㅇ', '2022-07-08 15:57:35'),
	(3, 193, 17, 'ㅇㅇ', '2022-07-08 15:57:53'),
	(3, 194, 17, '키키', '2022-07-08 15:57:56'),
	(3, 195, 17, '미안하다 이거보여주려고 어그로끌었따.....', '2022-07-08 15:58:07'),
	(3, 196, 6, '내가 알던 그 찐따같던 나루토 맞냐?', '2022-07-08 15:59:17'),
	(3, 197, 6, '진짜 가슴이 웅장해진다...', '2022-07-08 15:59:20'),
	(3, 198, 17, '0I 0| 0l ', '2022-07-08 16:00:13'),
	(3, 199, 6, '에에에에에에~~??', '2022-07-08 16:00:57'),
	(3, 200, 6, '도시테?', '2022-07-08 16:00:58'),
	(3, 201, 17, '도키도키 ㅣ데타 퍄퍄퍄', '2022-07-08 16:01:07'),
	(3, 202, 6, '동휘', '2022-07-08 16:01:33'),
	(3, 203, 6, '정인누나 싫나', '2022-07-08 16:01:34'),
	(3, 204, 6, '내라고 해라', '2022-07-08 16:01:44'),
	(3, 205, 17, '내 라고 함', '2022-07-08 16:01:48'),
	(3, 206, 6, '다음 나', '2022-07-08 16:01:51'),
	(3, 207, 17, '다움 도 나라고함', '2022-07-08 16:01:56'),
	(3, 208, 6, '어허', '2022-07-08 16:01:57'),
	(3, 209, 6, '( : : [ ] : : )', '2022-07-08 16:02:07'),
	(3, 210, 17, ';;', '2022-07-08 16:02:10'),
	(3, 211, 17, '-.-', '2022-07-08 16:02:24'),
	(3, 212, 6, 'ㄱ-', '2022-07-08 16:02:29'),
	(3, 213, 6, 'ㅡㅡ\'', '2022-07-08 16:02:32'),
	(3, 214, 17, '_o_', '2022-07-08 16:02:34'),
	(3, 215, 6, 'ㅡㅡ^', '2022-07-08 16:02:36'),
	(3, 216, 17, '^-^', '2022-07-08 16:02:41'),
	(3, 217, 6, 'ㄱ-', '2022-07-08 16:02:43'),
	(3, 218, 6, '-_-^', '2022-07-08 16:02:47'),
	(3, 219, 17, 'ㄱ-', '2022-07-08 16:02:47'),
	(3, 220, 6, 'llorz', '2022-07-08 16:02:52'),
	(3, 221, 17, 'OTL', '2022-07-08 16:02:53'),
	(3, 222, 17, ';;', '2022-07-08 16:02:56'),
	(3, 223, 6, 'llorz', '2022-07-08 16:02:58'),
	(3, 224, 17, 'bitch', '2022-07-08 16:03:17'),
	(3, 225, 17, '이오이', '2022-07-08 16:03:28'),
	(3, 226, 17, '외오이', '2022-07-08 16:03:31'),
	(3, 227, 6, '동휘쿤.....', '2022-07-08 16:03:33'),
	(3, 228, 6, '우마이!', '2022-07-08 16:03:37'),
	(3, 229, 17, '오이오이', '2022-07-08 16:03:38'),
	(3, 230, 6, '5252525252525252525252525252525252525252~~', '2022-07-08 16:03:43'),
	(3, 231, 17, '5252~', '2022-07-08 16:03:47'),
	(3, 232, 6, '야', '2022-07-08 16:03:48'),
	(3, 233, 6, '왜', '2022-07-08 16:03:49'),
	(3, 234, 6, '수영장', '2022-07-08 16:03:50'),
	(3, 235, 17, '??????', '2022-07-08 16:03:53'),
	(3, 236, 17, '드립력 무엇', '2022-07-08 16:04:02'),
	(3, 237, 6, '에에 혼또니', '2022-07-08 16:04:03'),
	(3, 238, 6, '히도이네', '2022-07-08 16:04:06'),
	(3, 239, 17, '수... ㅅ고이!', '2022-07-08 16:04:13'),
	(3, 240, 17, '오이오이...!', '2022-07-08 16:04:25'),
	(3, 241, 17, '준일쿤...?', '2022-07-08 16:04:29'),
	(3, 242, 17, '야루네카', '2022-07-08 16:04:36'),
	(3, 244, 17, '?????', '2022-07-08 16:05:47'),
	(3, 245, 17, '이게모야', '2022-07-08 16:05:51'),
	(4, 1, 3, 'asdasf', '2022-07-08 13:12:51'),
	(4, 2, 3, 'asd', '2022-07-08 13:12:58'),
	(5, 1, 7, '말', '2022-07-08 15:44:15'),
	(5, 2, 6, 'ㅎㅇ', '2022-07-08 15:44:21'),
	(5, 3, 6, 'ㅋㅌ', '2022-07-08 15:44:22'),
	(5, 4, 7, 'ㅎ2', '2022-07-08 15:44:22'),
	(5, 5, 6, 'ㄴㅁ', '2022-07-08 15:44:22'),
	(5, 6, 6, 'ㄹㅁㄹㅁㄹㅇㅁㄹ', '2022-07-08 15:44:23'),
	(5, 7, 7, '아니', '2022-07-08 15:44:24');

-- 테이블 phpgram.t_dm_user 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_dm_user` (
  `idm` int(10) unsigned NOT NULL,
  `iuser` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idm`,`iuser`),
  KEY `iuser` (`iuser`),
  CONSTRAINT `t_dm_user_ibfk_1` FOREIGN KEY (`idm`) REFERENCES `t_dm` (`idm`),
  CONSTRAINT `t_dm_user_ibfk_2` FOREIGN KEY (`iuser`) REFERENCES `t_user` (`iuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_dm_user:~8 rows (대략적) 내보내기
INSERT IGNORE INTO `t_dm_user` (`idm`, `iuser`) VALUES
	(1, 6),
	(1, 16),
	(2, 3),
	(2, 6),
	(3, 6),
	(3, 17),
	(4, 3),
	(4, 17),
	(5, 6),
	(5, 7);

-- 테이블 phpgram.t_feed 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_feed` (
  `ifeed` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location` varchar(20) DEFAULT NULL,
  `ctnt` text DEFAULT NULL,
  `iuser` int(10) unsigned NOT NULL,
  `regdt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`ifeed`),
  KEY `iuser` (`iuser`),
  CONSTRAINT `t_feed_ibfk_1` FOREIGN KEY (`iuser`) REFERENCES `t_user` (`iuser`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_feed:~51 rows (대략적) 내보내기
INSERT IGNORE INTO `t_feed` (`ifeed`, `location`, `ctnt`, `iuser`, `regdt`) VALUES
	(12, '부산', 'ㅇㅇ', 6, '2022-06-28 17:14:22'),
	(13, '서울', 'ㅎㅎ', 6, '2022-06-28 17:14:33'),
	(14, '대구', 'ㅋㅋ', 6, '2022-06-28 18:02:21'),
	(15, '제주', '', 6, '2022-06-30 09:54:21'),
	(16, '456', '123', 3, '2022-07-01 12:46:18'),
	(17, 'ㅁㅇ', 'ㄴㅁㅇㄹ', 3, '2022-07-05 14:47:31'),
	(18, 'ㅂㅈㄱㄹ', 'ㅁㄴㅇ', 3, '2022-07-05 14:50:27'),
	(19, 'ㄴㅇㅁㅎㅁㄴ', 'ㅁㄴㄹ', 3, '2022-07-05 14:50:37'),
	(20, 'ㄴㅇㅁㅎ', 'ㄴㅁㅇㅎㄹ', 3, '2022-07-05 14:50:44'),
	(21, 'ㄴㅇㅁㅎ', 'ㅇㄴㅁㅎ', 3, '2022-07-05 14:50:49'),
	(22, 'ㄴㅇㅁㅎㅍㄴㅁㅇ', 'ㄴㅇㅁㅎㄴㅇㅁㅎ', 3, '2022-07-05 14:50:55'),
	(23, 'ㅇㄴㅁㅍㅎㅁㅇㄴ', 'ㄴㅁㅇㅎㄴㅁㅇ', 3, '2022-07-05 14:51:00'),
	(24, 'ㄴㅇㅎㅍ', 'ㄴㅇㅁㅎ', 3, '2022-07-05 14:51:06'),
	(25, 'ㄴㅇㅍㅊㅇㄴㅊ', 'ㄴㅇㅁㅎㅇㄴㅍㄴㅇㄿㄴㅁㅇ', 3, '2022-07-05 14:51:19'),
	(26, 'ㄴㅇㅁㄻ', 'ㄴㅇㅍㅎ', 3, '2022-07-05 14:51:37'),
	(27, 'ㄹㄴㅇㅁㄹ', 'ㄴㅇㅁㄹ', 3, '2022-07-05 14:51:42'),
	(28, 'ㅇㄴㄹㄴㅇㅁ', 'ㄴㅇㄹㅇㄴㅁ', 3, '2022-07-05 14:51:46'),
	(29, 'ㅇㄴㅁㄹㄴㅁㅇ', 'ㄹㅇㄴㅁㄹㅇㄴ', 3, '2022-07-05 14:51:52'),
	(30, 'ㅇㄴㄹㄴㅁㅇ', 'ㅇㄴㄹ', 3, '2022-07-05 14:51:56'),
	(31, 'ㄴㅇㅁㄹ', 'ㄴㅇㄹ', 3, '2022-07-05 14:52:01'),
	(32, '123123', '123', 6, '2022-07-05 16:26:06'),
	(33, 'asd', 'asd', 6, '2022-07-05 16:29:48'),
	(34, 'afs', 'afe', 6, '2022-07-05 16:33:27'),
	(35, '123', '123', 3, '2022-07-05 16:40:25'),
	(36, '123', '123', 3, '2022-07-05 16:41:21'),
	(37, '213', '123', 3, '2022-07-05 16:41:48'),
	(38, '46', '123', 3, '2022-07-05 16:43:09'),
	(39, '345', '123', 3, '2022-07-05 16:44:06'),
	(40, '3546', '123', 3, '2022-07-05 16:48:00'),
	(41, '456', '123', 3, '2022-07-05 16:49:00'),
	(42, 'zz', 'zz', 3, '2022-07-05 16:49:24'),
	(43, '456', '123', 3, '2022-07-05 17:07:18'),
	(44, '123', '123', 3, '2022-07-05 17:07:35'),
	(45, '123', '11', 6, '2022-07-06 09:37:43'),
	(46, '11', 'test', 6, '2022-07-06 09:47:17'),
	(47, '456', '123', 6, '2022-07-06 09:48:13'),
	(48, '3456', '123', 6, '2022-07-06 09:49:13'),
	(49, '435', '12', 6, '2022-07-06 09:50:26'),
	(50, 'ㄴㅁㅇㅎ', 'ㄴㅁㅇㅎㄹ', 6, '2022-07-06 11:50:03'),
	(51, 'ㄴㅇㅁㅎㄹ', 'ㅁㄹㅇ', 6, '2022-07-06 11:50:47'),
	(52, 'ㄶㅁㄶ', 'ㅁㅇㄴㄻㅇㄴ', 6, '2022-07-06 11:52:23'),
	(53, 'ㄴㅁㅇㅎ', 'ㄴㅇㅁㅎㄹ', 6, '2022-07-06 11:52:28'),
	(54, '나뭇잎', '카무이!', 6, '2022-07-06 12:20:14'),
	(55, '', 'ㅎㅎ', 6, '2022-07-06 12:21:05'),
	(56, '나이스', '오우', 9, '2022-07-06 14:20:47'),
	(57, '', '안녕하세요', 8, '2022-07-06 14:25:24'),
	(58, '짝꿍자리', '이거 동휘쿤아님?', 7, '2022-07-06 14:50:01'),
	(59, '방귀대장', '뿡뿡뿡', 10, '2022-07-06 14:50:15'),
	(60, '마', '자신있나', 13, '2022-07-06 14:54:12'),
	(61, '꺼비슈퍼', '어서와 준일쿤', 7, '2022-07-06 16:21:50'),
	(62, '구리구리 너구리', '너굴맨이 축복했다구!', 15, '2022-07-06 17:19:44'),
	(63, '', '방문했다갑니다~!', 16, '2022-07-06 17:36:18'),
	(64, 'ㅁㄴㅇ', 'ㅂㅈㄷ', 6, '2022-07-07 10:35:38'),
	(65, 'ㅂㅈㄷ', 'ㅁㄴㅇ', 6, '2022-07-08 12:47:16'),
	(66, 'qwe', 'asd', 3, '2022-07-08 13:06:30'),
	(67, '', '우우ㅜ', 17, '2022-07-08 14:22:18');

-- 테이블 phpgram.t_feed_cmt 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_feed_cmt` (
  `icmt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ifeed` int(10) unsigned NOT NULL,
  `iuser` int(10) unsigned NOT NULL,
  `cmt` varchar(200) NOT NULL,
  `regdt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`icmt`),
  KEY `ifeed` (`ifeed`),
  KEY `iuser` (`iuser`),
  CONSTRAINT `t_feed_cmt_ibfk_1` FOREIGN KEY (`ifeed`) REFERENCES `t_feed` (`ifeed`),
  CONSTRAINT `t_feed_cmt_ibfk_2` FOREIGN KEY (`iuser`) REFERENCES `t_user` (`iuser`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_feed_cmt:~27 rows (대략적) 내보내기
INSERT IGNORE INTO `t_feed_cmt` (`icmt`, `ifeed`, `iuser`, `cmt`, `regdt`) VALUES
	(1, 12, 6, 'asfdadsa', '2022-07-04 19:04:50'),
	(12, 12, 6, 'asdafda', '2022-07-04 20:26:56'),
	(13, 12, 6, 'sadgg', '2022-07-04 20:27:06'),
	(14, 16, 6, 'test', '2022-07-04 20:58:52'),
	(15, 16, 6, 'test2', '2022-07-05 09:47:38'),
	(16, 16, 3, 'zz', '2022-07-05 10:44:52'),
	(17, 16, 3, 'asd', '2022-07-05 11:58:33'),
	(18, 16, 3, 'ggggg', '2022-07-05 12:11:53'),
	(19, 16, 3, 'asd', '2022-07-05 12:30:45'),
	(20, 16, 3, 'zzz', '2022-07-05 12:30:51'),
	(21, 16, 3, 'gg', '2022-07-05 12:35:07'),
	(22, 12, 3, '흑형 조아요', '2022-07-05 12:50:16'),
	(23, 16, 3, 'ㅋㅋ', '2022-07-05 14:32:05'),
	(24, 31, 3, 'ㄴㅁㅇ', '2022-07-05 14:52:31'),
	(25, 31, 6, 'zz', '2022-07-05 14:55:46'),
	(26, 34, 6, '수업 종료 20분전', '2022-07-05 17:50:06'),
	(27, 58, 6, '왼쪽이 동휘제?', '2022-07-06 14:50:22'),
	(28, 59, 6, '니누고', '2022-07-06 14:51:57'),
	(29, 59, 10, '뿡뿡뿡', '2022-07-06 14:52:40'),
	(30, 59, 10, '뿡뿡뿡', '2022-07-06 14:52:40'),
	(31, 60, 6, '댐비라', '2022-07-06 14:56:20'),
	(32, 44, 3, '1', '2022-07-06 16:37:13'),
	(33, 44, 3, '2', '2022-07-06 16:37:14'),
	(34, 44, 3, '3', '2022-07-06 16:37:16'),
	(35, 43, 3, 'asd', '2022-07-06 17:05:18'),
	(36, 43, 3, 'q', '2022-07-06 17:05:19'),
	(37, 43, 3, '1', '2022-07-06 17:05:20'),
	(38, 62, 3, 'ㄳㄳ', '2022-07-06 17:28:45'),
	(39, 61, 3, '꺼비슈퍼 좋아요~', '2022-07-06 17:33:32'),
	(40, 64, 6, 'ㅁㄴㅇ', '2022-07-07 14:36:44'),
	(41, 64, 6, 'ㅁㄴ', '2022-07-07 14:36:45'),
	(42, 64, 6, 'ㅂㅈ', '2022-07-07 14:36:45'),
	(43, 65, 6, 'ㅋㅌㅊ', '2022-07-08 12:47:22');

-- 테이블 phpgram.t_feed_fav 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_feed_fav` (
  `ifeed` int(10) unsigned NOT NULL,
  `iuser` int(10) unsigned NOT NULL,
  `regdt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`ifeed`,`iuser`),
  KEY `iuser` (`iuser`),
  CONSTRAINT `t_feed_fav_ibfk_1` FOREIGN KEY (`ifeed`) REFERENCES `t_feed` (`ifeed`),
  CONSTRAINT `t_feed_fav_ibfk_2` FOREIGN KEY (`iuser`) REFERENCES `t_user` (`iuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_feed_fav:~9 rows (대략적) 내보내기
INSERT IGNORE INTO `t_feed_fav` (`ifeed`, `iuser`, `regdt`) VALUES
	(15, 6, '2022-07-05 11:16:03'),
	(16, 3, '2022-07-05 12:14:46'),
	(16, 6, '2022-07-05 11:22:54'),
	(49, 6, '2022-07-06 10:56:58'),
	(54, 3, '2022-07-06 13:12:59'),
	(54, 6, '2022-07-06 14:37:05'),
	(56, 6, '2022-07-06 15:03:35'),
	(57, 6, '2022-07-06 14:37:01'),
	(61, 3, '2022-07-06 17:33:28'),
	(63, 6, '2022-07-07 09:42:50'),
	(63, 16, '2022-07-06 17:36:22'),
	(64, 6, '2022-07-07 14:36:51'),
	(65, 6, '2022-07-08 12:47:20');

-- 테이블 phpgram.t_feed_img 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_feed_img` (
  `ifeed` int(10) unsigned NOT NULL,
  `img` varchar(50) NOT NULL,
  PRIMARY KEY (`ifeed`,`img`),
  CONSTRAINT `t_feed_img_ibfk_1` FOREIGN KEY (`ifeed`) REFERENCES `t_feed` (`ifeed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_feed_img:~53 rows (대략적) 내보내기
INSERT IGNORE INTO `t_feed_img` (`ifeed`, `img`) VALUES
	(12, '0a47e066-9df6-4373-b551-e093a70c0600.jpg'),
	(12, '46b07f02-5414-4cec-acca-79d60f402381.png'),
	(13, 'f59f3d50-2a5c-47a8-b267-dc0bb0c249f7.png'),
	(13, 'ff99c4fb-529a-4047-afbe-a2255cfa1112.jpg'),
	(14, '9f4e3a79-463c-4d35-8d4e-83babd62a2db.png'),
	(14, 'e9548cbe-62eb-4331-a389-852d15927563.jpg'),
	(15, '87647d40-6737-4760-b2bd-66ea9fab0686.png'),
	(15, '8ae5582d-1352-47c6-b50f-0e0822cb40ef.jpg'),
	(15, '8e9d85f4-b7fb-4c5f-86c0-7ee525f80f70.jpg'),
	(15, 'a128a2bf-85ad-483a-b5ac-94c120aa613e.jpg'),
	(16, '36d31024-86a4-4cff-af66-c4b40e85f45e.jpg'),
	(16, 'faa80912-5384-4f75-bf1d-2459972a201a.jpg'),
	(18, '7ff78c1e-7dc0-40ad-b090-13732067d7c3.png'),
	(19, 'ce27712a-419e-4aa0-a797-11d8990b7c62.jpg'),
	(20, '4654a912-a5bb-4dca-b443-fa0338bc7e15.png'),
	(21, '8d39781e-df5b-4d31-962b-38b615c7f9c8.jpg'),
	(22, '275f01eb-69e4-4c9a-bd70-12802ce85878.png'),
	(23, 'd0255956-2ec1-487b-bc03-5cdfc852feee.jpg'),
	(24, 'fb6f3b9c-7b06-435f-bdd6-e62dc30ea253.jpg'),
	(25, 'f05e5080-ab48-40a2-88e1-7e0b4f51c8fc.jpg'),
	(26, '68b22b19-c208-4caf-b913-a5c540379f10.jpg'),
	(27, '969cea6f-c807-4421-9265-17e7f17edf72.jpg'),
	(28, 'c25801cc-c96f-47fe-a54d-1ccc8ec94300.png'),
	(29, '41d12c75-0058-47d5-8917-5c8735b76975.jpg'),
	(30, 'd395db6f-bf62-4fb7-b3ef-16940384af57.jpg'),
	(31, 'a1e85c5c-92ee-463a-8ce7-6bb771e30e5a.jpg'),
	(32, 'e7e69ac8-63de-4c8c-8e76-e8aa1e23e1bc.jpg'),
	(33, 'fc11d657-ce05-45ff-93e5-4d9d9f564ae2.jpg'),
	(34, '04443491-0868-40fa-9dfc-48ba015c838d.jpg'),
	(35, '17bf737f-6228-4cac-bc3e-ded5fc53805f.png'),
	(36, '5afb1d81-c763-4ef6-be0f-6de22a8d9361.png'),
	(37, '88d15340-f4c4-43b4-b3f4-1146a12dd791.jpg'),
	(38, '1802f53b-aca6-45c6-9383-c743f0941591.jpg'),
	(39, 'fc1a8cfd-ab85-433e-90e5-bb5585a12fa4.png'),
	(40, '4de1ac86-cf1b-4061-8b07-0c64ac78942d.png'),
	(40, 'a18c7e64-e9b0-49cd-85c6-2544b95ec2bb.jpg'),
	(41, '2ab66d48-1c22-4253-9519-8fe50df5d649.jpg'),
	(42, '9ec07138-8ed8-41fc-ab14-f05dce16e2b3.jpg'),
	(43, '1e93f446-9c39-4ab4-b066-097c657c4b2a.jpg'),
	(44, 'bb756944-78fa-4cbd-a930-4b4f901ef8dc.png'),
	(45, '254dd90b-db20-43b2-8da9-5c90fa59bae2.jpg'),
	(46, '48f9d6f8-032c-4880-9231-e1acb8f46ad1.jpg'),
	(47, '6eef04d0-32c9-40ea-a884-8902c512b395.jpg'),
	(48, '91ca094a-2938-453e-9922-287b2b88ea8a.jpg'),
	(49, '8d73462a-c5ed-4e3e-920d-04d49d045418.png'),
	(50, 'bfab73b8-ee7d-4ec2-8f01-c7a338136df0.png'),
	(51, '13a521fc-b2db-4578-9a75-0dea74b9d788.jpg'),
	(52, '590032ad-e79b-4910-8e9b-dc14c5444145.jpg'),
	(53, '24b0dad6-ace0-41d8-afe3-113ff40a47a4.png'),
	(54, '2c2b4913-b4b3-46a1-a651-046d52b335cf.jpg'),
	(55, '2e625418-85da-4299-99aa-c0551b4b0201.jpg'),
	(56, 'efec89d2-363a-48a2-ac3d-242c8b04baa7.jpg'),
	(57, '472ca424-496e-4786-b2bd-c5322e8740e4.jpg'),
	(58, 'da7b1a49-f599-4a14-b6d6-26dbe87378ab.gif'),
	(59, 'c473199f-bee5-479b-af77-7c517679edb8.jpg'),
	(60, 'f4a67de7-ac7d-42da-951e-17ecfc43501e.png'),
	(61, 'cdbe6839-67a8-46cd-929b-2ff5257edb9f.jpg'),
	(62, '47eb6826-2d7c-492d-9146-3ebc5d1b43d8.jpg'),
	(63, '355cd536-59d2-46f0-bdb6-a6b1bb8a1d9f.jpg'),
	(64, '1f1abe19-6e99-4b56-a609-f09656fbb83b.jpg'),
	(65, '5631596a-efcd-4f29-adf7-cdb769107442.jpg'),
	(66, '6f16ecc9-21f7-414d-ba2a-83df02f72892.jpg'),
	(67, '51a5638b-afeb-4bf4-afaf-73fd8de89f01.jpg');

-- 테이블 phpgram.t_user 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_user` (
  `iuser` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `pw` varchar(100) DEFAULT NULL,
  `nm` varchar(5) NOT NULL,
  `cmt` varchar(50) DEFAULT '' COMMENT '코멘트',
  `mainimg` varchar(50) DEFAULT NULL,
  `regdt` datetime DEFAULT current_timestamp(),
  `moddt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`iuser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_user:~15 rows (대략적) 내보내기
INSERT IGNORE INTO `t_user` (`iuser`, `email`, `pw`, `nm`, `cmt`, `mainimg`, `regdt`, `moddt`) VALUES
	(1, 'ga243@naver.com', '$2y$10$ItW7usbVOitM3lryTRfUru/GY9RO6RrZ86dVIzJ5N5vwmOh96seSS', '김준일', '', NULL, '2022-06-24 15:41:58', NULL),
	(3, 'ga243@naver.co', '$2y$10$eVUfAul6LfcpMJgFXHlRvOduBjyUbSsxlbH6BSfombtaCjNuq1sLC', '라이언', '어흥~', 'lion.jpg', '2022-06-24 15:43:52', '2022-07-06 17:06:30'),
	(4, 'kdh9345@naver.com', '$2y$10$ItW7usbVOitM3lryTRfUru/GY9RO6RrZ86dVIzJ5N5vwmOh96seSS', 'aad', '', NULL, '2022-06-24 15:44:12', NULL),
	(5, 'ga243@naver.comm', '$2y$10$PDqU0TibkQZduVh.tmeH5unWw53..DIo9Eoe.3N1rMV5oSWyRCg2.', '123', '', 'muji.jpg', '2022-06-27 14:33:02', NULL),
	(6, '123@123', '$2y$10$FTuFQ/vGEO7zVpMzZlzrUOOjpsKsXLJMPq4ogvIw7AJ1gYxBn1jcC', '데이다라', '갈!', 'c81db4cf-c62a-43c2-a18e-29b1550535f9.gif', '2022-06-28 13:16:19', '2022-07-07 17:31:33'),
	(7, 'olnnl5101@gmail.com', '$2y$10$QtZITDUoWBVV96hl2gEmoeqq2oqP/OQ7z7GF.7gyY4E0jBnRizOgO', '정인짱', '', NULL, '2022-07-06 12:19:54', NULL),
	(8, 'test1@test1.com', '$2y$10$gPOPgv/Zo7CpPclgq4fsrOChoIshzLjSxgGcXYkld3adSQEgsymym', '뿌찍빡뿡뽕', '', NULL, '2022-07-06 14:19:22', NULL),
	(9, 'num1@test.com', '$2y$10$AFu13h4drXKe1AqjIeoQ1.SPCYc4CjlFD55A3/hK0KPuch53uCLb6', '올라프', '', NULL, '2022-07-06 14:20:24', NULL),
	(10, 'nn@nn', '$2y$10$Td1yjaGPMbvWrvVKEW/25ePk5DnorerNP6DjDu/VgExpvW4QjkHO6', 'nn', '', NULL, '2022-07-06 14:48:55', NULL),
	(13, 'dgdg@naver.com', '$2y$10$r1wKcBwxCn3fUZYT3gaGC.vKgSPfpU9yQGoTpHx6kiYJDEhFO63/C', '마', '', NULL, '2022-07-06 14:52:15', NULL),
	(14, 'aaa@nnn', '$2y$10$ubmJVMXfZzdeXwHQ3IAzuucKe1T259LvjRhym1Ygh8RZ8FjDb9cIS', 'test', '', NULL, '2022-07-06 15:52:34', '2022-07-06 15:52:34'),
	(15, 'test1@test', '$2y$10$DF5Cd9DN95r0PmZk8AT1WO96WxWqXMVV3iGCdTIOttD5C2sj6x/6W', '하이헬롱', '', NULL, '2022-07-06 17:12:09', '2022-07-06 17:12:09'),
	(16, 'dsda@sndjd.cpm', '$2y$10$Ntz0aPh6Ntuoc6Jy.XX8fuqHwX.QQseRg0f.pOOrTETag7SaNYHGm', '럭키', '', NULL, '2022-07-06 17:35:44', '2022-07-06 17:35:44'),
	(17, 'kkk@kkk', '$2y$10$JDts0/IhY/O.Q4PAdq78h.6atLCape.S6ec/beIzBtO0JCSUlJlwO', '동휘쿤', '', '7c422114-f227-4488-b0ef-05ed4bc84665.jpg', '2022-07-08 13:11:12', '2022-07-08 15:23:41'),
	(18, 'aa@aa.com', '$2y$10$J1BkZng/HGnqQGefrsctZeOKtFJCPaXzdsnp5Vhk.W60J9q90KpZK', 'aa', '', NULL, '2022-07-08 15:17:20', '2022-07-08 15:17:20');

-- 테이블 phpgram.t_user_follow 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_user_follow` (
  `fromiuser` int(10) unsigned NOT NULL,
  `toiuser` int(10) unsigned NOT NULL,
  `regdt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`fromiuser`,`toiuser`) USING BTREE,
  KEY `toiuser` (`toiuser`),
  CONSTRAINT `t_user_follow_ibfk_1` FOREIGN KEY (`fromiuser`) REFERENCES `t_user` (`iuser`),
  CONSTRAINT `t_user_follow_ibfk_2` FOREIGN KEY (`toiuser`) REFERENCES `t_user` (`iuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_user_follow:~3 rows (대략적) 내보내기
INSERT IGNORE INTO `t_user_follow` (`fromiuser`, `toiuser`, `regdt`) VALUES
	(3, 1, '2022-07-01 15:48:04'),
	(3, 6, '2022-07-05 17:16:12'),
	(6, 1, '2022-07-01 14:59:18'),
	(17, 6, '2022-07-08 13:12:00');

-- 테이블 phpgram.t_user_img 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_user_img` (
  `iuser` int(20) unsigned NOT NULL,
  `img` varchar(50) NOT NULL,
  `regdt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`iuser`,`img`),
  CONSTRAINT `t_user_img_ibfk_1` FOREIGN KEY (`iuser`) REFERENCES `t_user` (`iuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 phpgram.t_user_img:~0 rows (대략적) 내보내기

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
