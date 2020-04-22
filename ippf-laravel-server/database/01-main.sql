DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS migrations;
DROP TABLE IF EXISTS password_resets;


CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`,`name`,`email`,`password`,`updated_at`,`created_at`,`remember_token`) VALUES (2,'francoohd','francoo.hd@gmail.com','$2y$10$yuzsh1wBM0UPQsgnC/.p5u2HR2hwhtnC81A.g1qIFHMsG9s8DFQyy','2016-01-13 00:16:38.000','2015-09-29 14:40:41.000','PGWQY0n83FFxaj3JlO2IXviGi0yrOYuKhGFR0tchTQFfXtWj3RkhfOwgaimC');
INSERT INTO `users` (`id`,`name`,`email`,`password`,`updated_at`,`created_at`,`remember_token`) VALUES (22,'Martin','martin.rabaglia@gmail.com','$2y$10$Y7B4Jqg0Ki9xHO8YXv28j.UNE4antkuM5NjbPUlebwc9lDL2V85aK','2015-12-09 18:25:24.000','2015-12-09 18:25:24.000',NULL);

