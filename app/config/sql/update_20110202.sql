CREATE TABLE `rss_sources` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 500 ) NOT NULL ,
`website_name` VARCHAR( 500 ) NOT NULL ,
`url` VARCHAR( 1024 ) NOT NULL ,
`active` TINYINT( 1 ) NOT NULL ,
`created` DATE NOT NULL ,
`modified` DATE NOT NULL
) ENGINE = MYISAM ;

ALTER TABLE  `rss_sources` ADD  `weight` TINYINT( 2 ) NOT NULL AFTER  `url`;