CREATE TABLE `user_answers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `question_id` TINYINT(2) NOT NULL,
  `answer_id` TINYINT(1) NOT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`));
