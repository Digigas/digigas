ALTER TABLE `news`
  DROP `parent_id`;
ALTER TABLE `news`
  DROP `user_id`;


ALTER TABLE  `news` ADD  `user_id` INT NOT NULL AFTER  `newscategory_id`;

CREATE TABLE  `comments` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`parent_id` INT NOT NULL ,
`user_id` INT NOT NULL ,
`model` VARCHAR( 50 ) NOT NULL ,
`item_id` INT NOT NULL ,
`text` TEXT NOT NULL ,
`active` TINYINT( 1 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL
) ENGINE = MYISAM ;

ALTER TABLE  `comments` ADD  `url` VARCHAR( 1024 ) NOT NULL AFTER  `item_id`;

