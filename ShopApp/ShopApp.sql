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


-- shop 데이터베이스 구조 내보내기
CREATE DATABASE IF NOT EXISTS `shop` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `shop`;

-- 테이블 shop.t_category 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate1` varchar(100) NOT NULL DEFAULT '',
  `cate2` varchar(100) NOT NULL DEFAULT '',
  `cate3` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 shop.t_category:~6 rows (대략적) 내보내기
INSERT IGNORE INTO `t_category` (`id`, `cate1`, `cate2`, `cate3`) VALUES
	(1, '전자제품', '컴퓨터', '악세사리'),
	(2, '전자제품', '컴퓨터', '노트북'),
	(3, '전자제품', '컴퓨터', '조립식'),
	(4, '전자제품', '가전제품', '텔레비전'),
	(5, '전자제품', '가전제품', '냉장고'),
	(6, '생필품', '주방용품', '조리도구');

-- 테이블 shop.t_product 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) NOT NULL DEFAULT '',
  `product_price` int(11) NOT NULL DEFAULT 0,
  `delivery_price` int(11) NOT NULL DEFAULT 0,
  `add_delivery_price` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(100) DEFAULT NULL,
  `outbound_days` int(11) NOT NULL DEFAULT 5,
  `seller_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `active_yn` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `seller_id` (`seller_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `t_product_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `t_seller` (`id`),
  CONSTRAINT `t_product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `t_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 shop.t_product:~7 rows (대략적) 내보내기
INSERT IGNORE INTO `t_product` (`id`, `product_name`, `product_price`, `delivery_price`, `add_delivery_price`, `tags`, `outbound_days`, `seller_id`, `category_id`, `active_yn`, `created_date`) VALUES
	(2, '조리도구', 1000000, 3000, 3000, '', 3, 1, 6, 'Y', '2022-07-19 10:30:45'),
	(3, '악세사리', 123, 123, 123, '123', 123, 1, 1, 'Y', '2022-07-19 11:07:30'),
	(8, '노트북', 1, 1, 1, '', 1, 1, 2, 'Y', '2022-07-19 11:44:47'),
	(10, '텔레비전', 10000, 3000, 4000, '', 3, 1, 4, 'Y', '2022-07-19 15:05:07'),
	(13, '냉장고', 10000, 3000, 4000, '', 3, 1, 5, 'Y', '2022-07-21 16:04:47');

-- 테이블 shop.t_product_img 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_product_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '1-섬네일, 2-제품이미지, 3-제품설명이미지',
  `path` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `t_product_img_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `t_product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 shop.t_product_img:~18 rows (대략적) 내보내기
INSERT IGNORE INTO `t_product_img` (`id`, `product_id`, `type`, `path`) VALUES
	(27, 2, 1, '62d7b230a5ceb.jpeg'),
	(28, 2, 3, '62d7b2336ada3.jpeg'),
	(35, 3, 1, '62d8c7b857244.webp'),
	(36, 3, 2, '62d8c7ba76254.jpeg'),
	(37, 3, 3, '62d8c7bca635b.png'),
	(44, 8, 1, '62d8d155eb70b.jpeg'),
	(45, 8, 2, '62d8d157518fc.jpeg'),
	(46, 8, 3, '62d8d159ac4e6.jpeg'),
	(50, 10, 1, '62d8d170b362d.jpeg'),
	(51, 10, 2, '62d8d17237eef.png'),
	(52, 10, 3, '62d8d174b03df.webp'),
	(55, 2, 2, '62d8ea1ebc72d.jpeg'),
	(56, 13, 1, '62d8fb1fec426.jpeg'),
	(57, 13, 2, '62d8fb24e10a9.jpeg'),
	(58, 13, 3, '62d8fb28ad162.png');

-- 테이블 shop.t_seller 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_seller` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 shop.t_seller:~0 rows (대략적) 내보내기
INSERT IGNORE INTO `t_seller` (`id`, `NAME`, `email`, `phone`) VALUES
	(1, '김준일', 'ga243@naver.com', '010-2825-2536');

-- 테이블 shop.t_user 구조 내보내기
CREATE TABLE IF NOT EXISTS `t_user` (
  `iuser` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `social_type` int(10) unsigned NOT NULL COMMENT '0-local, 1-kakao, 2-naver, 3-google, 4-github, 5-facebook',
  `email` varchar(50) NOT NULL,
  `TYPE` int(10) unsigned NOT NULL DEFAULT 1 COMMENT '1-buyer, 2-seller',
  `nickname` varchar(50) DEFAULT NULL,
  `PROFILE_img` varchar(100) DEFAULT NULL,
  `thumb_img` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`iuser`),
  UNIQUE KEY `social_type` (`social_type`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 shop.t_user:~7 rows (대략적) 내보내기
INSERT IGNORE INTO `t_user` (`iuser`, `social_type`, `email`, `TYPE`, `nickname`, `PROFILE_img`, `thumb_img`, `created_at`, `updated_at`) VALUES
	(1, 1, 'mic@mic.com', 1, '홍길동', '이미지1', '이미지2', '2022-07-18 10:03:02', '2022-07-18 10:03:03'),
	(3, 1, 'mic1@mic.com', 1, '홍길동', '이미지1', '이미지2', '2022-07-18 10:03:13', '2022-07-18 10:03:38'),
	(5, 1, 'mic2@mic.com', 1, '홍길동', '이미지1', '이미지2', '2022-07-18 10:04:13', '2022-07-18 10:04:13'),
	(6, 1, 'mic3@mic.com', 1, '홍길동', '이미지1', '이미지2', '2022-07-18 10:34:04', '2022-07-18 10:34:05'),
	(7, 1, 'mic4@mic.com', 1, '홍길동', '이미지1', '이미지2', '2022-07-18 10:34:19', '2022-07-18 10:34:19'),
	(8, 1, 'mic5@mic.com', 1, '홍길동', '이미지1', '이미지2', '2022-07-18 11:09:30', '2022-07-18 11:09:30'),
	(9, 1, 'ga243@naver.com', 1, '김준일', 'http://k.kakaocdn.net/dn/IvLj0/btqPEL0Keqj/38cCbS9U9pQR1o8anHJPqK/img_640x640.jpg', 'http://k.kakaocdn.net/dn/IvLj0/btqPEL0Keqj/38cCbS9U9pQR1o8anHJPqK/img_110x110.jpg', '2022-07-18 11:32:21', '2022-07-19 16:59:52');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
