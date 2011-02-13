DROP TABLE IF EXISTS `config`;
CREATE TABLE `configurators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;