CREATE TABLE IF NOT EXISTS `readed_threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `unreaded_comments` INT DEFAULT 0,
  PRIMARY KEY (`id`)
)