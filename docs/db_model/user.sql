CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fb_id` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `f_name` VARCHAR(255) NULL,
  `l_name` VARCHAR(255) NULL,
  `province` VARCHAR(255) NULL,
  `phone` INT UNSIGNED NULL,
  `profession` VARCHAR(255) NULL,
  `profile` VARCHAR(50) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`));
