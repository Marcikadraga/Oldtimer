/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50733
Source Host           : localhost:3306
Source Database       : marci

Target Server Type    : MYSQL
Target Server Version : 50733
File Encoding         : 65001

Date: 2022-06-01 12:57:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cars
-- ----------------------------
DROP TABLE IF EXISTS `cars`;
CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `startOfProductionTime` int(11) DEFAULT NULL,
  `endOfProductionTime` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cars
-- ----------------------------
INSERT INTO `cars` VALUES ('8', 'Accusamus ea et quam', 'Nulla ipsa facilis ', '1234', '5678', '2022-05-20 14:42:27', null, '2022-05-20 16:44:27');
INSERT INTO `cars` VALUES ('9', 'Mercedes-Benz', 'TTQP', '1999', '2011', '2022-05-20 21:15:33', null, '2022-05-22 13:20:21');
INSERT INTO `cars` VALUES ('10', 'Mercedes-Benz', 'TTQP', '1999', '2011', '2022-05-20 21:15:48', null, '2022-05-22 13:40:37');
INSERT INTO `cars` VALUES ('11', 'Mercedes-Benz', 'TTQP', '1999', '2010', '2022-05-21 20:28:00', null, '2022-05-22 13:40:38');
INSERT INTO `cars` VALUES ('12', 'Mercedes-Benz', '1234', '1324', '1234', '2022-05-22 11:41:14', null, '2022-05-22 13:42:35');
INSERT INTO `cars` VALUES ('13', 'Béla', '1234', '1324', '1234', '2022-05-22 11:45:32', null, '2022-05-22 20:35:28');
INSERT INTO `cars` VALUES ('14', 'Audi', '1234', '1324', '1234', '2022-05-22 11:45:38', null, '2022-05-22 20:35:29');
INSERT INTO `cars` VALUES ('15', 'Béla', '1234', '1324', '1234', '2022-05-22 11:45:44', null, '2022-05-22 20:35:28');
INSERT INTO `cars` VALUES ('16', 'Béla', '1234', '1324', '1234', '2022-05-22 19:40:13', null, '2022-05-22 21:57:58');
INSERT INTO `cars` VALUES ('17', 'Béla', '1234', '1324', '1234', '2022-05-23 11:16:17', null, '2022-05-23 13:16:22');
INSERT INTO `cars` VALUES ('18', 'Béla', '1234', '1324', '1234', '2022-05-23 11:27:24', null, '2022-05-23 13:28:44');
INSERT INTO `cars` VALUES ('19', 'Béla', '1234', '1324', '1234', '2022-05-23 12:58:19', null, '2022-05-23 15:05:09');
INSERT INTO `cars` VALUES ('20', 'Béla', '1234', '1324', '1234', '2022-05-23 13:05:35', null, '2022-05-23 15:24:30');
INSERT INTO `cars` VALUES ('21', 'Béla', '1234', '1324', '1234', '2022-05-23 13:26:15', null, '2022-05-23 15:26:21');
INSERT INTO `cars` VALUES ('22', 'Béla', '1234', '1324', '1234', '2022-05-23 13:26:35', null, '2022-05-23 15:27:28');
INSERT INTO `cars` VALUES ('23', 'Mercedes-Benz', '1234', '1324', '1234', '2022-05-23 13:26:42', null, '2022-05-23 15:27:35');
INSERT INTO `cars` VALUES ('24', 'Mercedes-Benz', '1234', '1222', '1234', '2022-05-23 13:26:51', null, '2022-05-23 15:27:30');
INSERT INTO `cars` VALUES ('25', 'Béla', '1234', '1324', '1234', '2022-05-23 13:28:29', null, '2022-05-23 15:28:35');
INSERT INTO `cars` VALUES ('26', 'Béla', '1234', '1324', '1234', '2022-05-23 13:29:10', null, '2022-05-23 15:37:45');
INSERT INTO `cars` VALUES ('27', 'Béla', '1234', '1324', '1234', '2022-05-23 13:32:36', null, '2022-05-23 15:37:58');
INSERT INTO `cars` VALUES ('28', 'Mercedes-Benz', '450 SL Lorinser', '1999', '5000', '2022-05-23 13:38:25', '2022-05-30 11:32:15', null);
INSERT INTO `cars` VALUES ('29', 'Béla', '1234', '1324', '1234', '2022-05-23 13:38:52', null, '2022-05-24 10:58:37');
INSERT INTO `cars` VALUES ('30', 'Mercedes-Benz', '1234', '1324', '1234', '2022-05-23 13:39:25', null, '2022-05-23 15:41:01');
INSERT INTO `cars` VALUES ('31', 'Béla', '1234', '1324', '1234', '2022-05-23 13:40:48', null, '2022-05-23 15:40:54');
INSERT INTO `cars` VALUES ('32', 'Audi', 'TTQPMiki', '0', '0', '2022-05-24 08:58:59', '2022-05-26 14:51:21', null);
INSERT INTO `cars` VALUES ('33', 'M&aacute;rk', 'X66', '2018', '2024', '2022-05-24 08:59:05', '2022-05-26 14:42:39', null);
INSERT INTO `cars` VALUES ('34', 'Béla', '1234', '1324', '1234', '2022-05-24 08:59:10', null, '2022-05-24 12:56:53');
INSERT INTO `cars` VALUES ('35', 'Miki', '1234', '1324', '1234', '2022-05-24 11:01:19', null, '2022-05-24 16:09:12');
INSERT INTO `cars` VALUES ('36', 'Mercedes-Benz', '1234', '1324', '1234', '2022-05-24 11:27:09', null, '2022-05-24 14:32:59');
INSERT INTO `cars` VALUES ('37', 'BMW1', 'NY-69', '0', '0', '2022-05-26 10:23:46', '2022-05-26 14:51:10', null);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birth_date` varchar(255) DEFAULT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL,
  `webpage` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `more_address` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `failed_login_counter` int(11) DEFAULT NULL,
  `is_banned` tinyint(1) DEFAULT NULL,
  `banned_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('22', 'Marci', '$2y$10$D7sXKk1zl3p4HmLk267bQeVcn4tNePSvt4C.6yLXnZFnm6ckw3Vja', 'balogh15@hotmail.com', 'Burger', 'asd', 'King', '2022-03-31', '06209999999', '', '1111', 'Budapest', '233', 'Béla u 3', 'guest', '2022-05-18 13:04:32', null, null, '2022-06-01 09:10:00', '0', '0', null);
INSERT INTO `users` VALUES ('23', 'Béla', '$2y$10$7jx2KyRSOUANbk9.xxQ/E..26Y.xj5febCnvrYGo1xBpUnCzschXq', 'bela@gmail.com', 'Burger', 'asd', 'King', '2022-04-28', '06209999999', '', '1111', 'Budapest', '2', 'Béla u 3', 'admin', '2022-05-18 13:04:32', null, null, '2022-06-01 10:29:22', '1', '0', null);
INSERT INTO `users` VALUES ('24', 'Mate', '$2y$10$NoopHC/nkm5LGZmqugM96.d/AjQ..KsBb5NytVRlHoPF.6CG1mfve', 'mate@gmail.com', 'Burger', 'asd', 'King', '2022-04-28', '06209999999', 'https://google.com', '1111', 'Budapest', '2', 'Béla u 3dd', 'guest', '2022-05-18 13:04:32', null, null, null, '0', '0', null);
INSERT INTO `users` VALUES ('25', 'Sanyi', '$2y$10$gd8KciGj4k1cLqGIo.GJ0O5SMYzvp4DSSqsxwMcMEZeRFOhL4Uf.u', 'sanyika@gmail.com', 'Burger', 'asdasd', 'nyad', '2022-04-26', '06209999999', '', '1111', 'Budapest', '2', '1000', 'guest', '2022-05-18 13:04:32', null, null, '2022-06-01 10:42:26', '0', '0', null);
INSERT INTO `users` VALUES ('26', 'Márk', '$2y$10$S3P3BixvnA2XMFhMtmhFbunEA3jva99/NjJ53nDXXFW9h/Pf0Mv5W', 'mark@gmail.com', 'Burger', 'adsa', 'King', '2022-04-27', '06209999999', 'https://google.com', '1111', 'Budapest', '2', 'Béla u 3dd', 'guest', '2022-05-18 13:04:32', null, null, null, '0', '0', null);
INSERT INTO `users` VALUES ('27', 'István', '$2y$10$lc1Ke/XEkE9LVnLgri4gKO2WslWEPEfeTQ4EPp5UQ0R55gg/Vd3pi', 'balogh1510@hotmail.com', 'Burger', 'asd', 'King', '2022-04-27', '06209999999', '', '1111', 'Budapest', '2', '100', 'guest', '2022-05-18 13:04:32', null, null, null, '0', '0', null);
INSERT INTO `users` VALUES ('30', 'Miki', '$2y$10$lSZLOruGVmxc7RAuFpJjw.tRRRbRI6v2VU8MwWScGRbD9kZY7uU3q', 'Miki@gmail.com', 'Burger', 'adsa', 'King', '2022-05-04', '06209999999', '', '1111', 'Budapest', '2', 'Béla u 32', 'guest', '2022-05-18 13:04:32', null, null, '2022-06-01 10:17:02', '0', '0', null);
INSERT INTO `users` VALUES ('31', 'Béla123123', '$2y$10$GMyMgWR3qutRQM.z4VeQU.tfiwgQXEqxIRfU8eEcaMdC1yHzFKAZm', 'Zing@gmail.com', 'Burger', 'asd', 'King', '2022-04-27', '06209999999', 'https://google.com', '1111', 'Budapest', 'Amet laboriosam om', 'Béla u 3', 'guest', '2022-05-18 13:04:32', null, null, null, '0', '0', null);
INSERT INTO `users` VALUES ('32', 'Béla123', '$2y$10$f0k1fAKqqbF1N8AQkVUieeE0gQ/O58HS33VqhW/1EjKMFWtrkGpMG', 'balogh15123@hotmail.com', 'Burger', 'asd', 'King', '2022-05-04', '06209999999', 'https://google.com', '1111', 'Budapest', '2', 'Béla u 3', 'guest', '2022-05-18 13:04:32', null, null, null, '0', '0', null);
INSERT INTO `users` VALUES ('33', 'Marcika', '$2y$10$ML0bQ8YIi4CdJfdmuUk4Gukn4qkOFqm8.szOX8UpYlAUfRSqbOa5a', 'balogh@hotmail.com', 'Burger', 'asd', 'King', '2022-04-27', '06209999999', 'https://google.com', '1111', 'Budapest', '2', 'Béla u 3', 'guest', '2022-05-18 14:45:22', null, null, null, '0', '0', null);
INSERT INTO `users` VALUES ('34', 'Tomi', '$2y$10$FAM8i1frbUxZWZh.o4ZMM.im697pp7crQt8P4/FUUjjSrwue14PbS', 'tomi@gmail.com', 'Burger', 'asd', 'King', '2022-05-05', '06209999999', 'https://google.com', '1111', 'Budapest', '2', 'Béla u 3', 'guest', '2022-05-19 07:37:46', null, null, '2022-05-19 07:39:17', '1', '0', null);
INSERT INTO `users` VALUES ('35', 'Béla12', '$2y$10$2krdlI4JmOsIBKBfdqhCa.OGRrYjN50z9V8rBuWRFmXueIfbonYHO', 'balogh11231235@hotmail.com', 'Burger', 'asd', 'King', '2022-04-28', '06209999999', 'https://google.com', '1111', 'Budapest', '2', 'Béla u 3', 'guest', '2022-05-20 11:59:32', null, null, null, '0', '0', null);
INSERT INTO `users` VALUES ('36', 'Virág', '$2y$10$RuRK6VLZg4WZMkbhu1PEQOXxYdv4NQkt9RKBDoUHgXVZTdYXtZdV2', 'balogh15331@hotmail.com', 'Burger', 'adsa', 'King', '2022-04-27', '06209999999', 'https://google.com', '1111', 'Budapest', '2', 'Béla u 3', 'guest', '2022-05-22 16:25:23', null, null, null, '0', '0', null);
INSERT INTO `users` VALUES ('37', 'Laci', '$2y$10$7jx2KyRSOUANbk9.xxQ/E..26Y.xj5febCnvrYGo1xBpUnCzschXq', 'sanyikajjjj@gmail.com', 'Burger', 'asdasd', 'nyad', '2022-05-02', '209999999', 'https://google.com', '1111', 'Budapest', '2', 'asdf', 'admin', '2022-05-30 14:47:08', null, null, '2022-05-30 14:57:31', '0', '0', null);
SET FOREIGN_KEY_CHECKS=1;
