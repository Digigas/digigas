ALTER TABLE `news` CHANGE `created` `created` DATETIME NOT NULL ,
CHANGE `modified` `modified` DATETIME NOT NULL ;

ALTER TABLE `news` ADD `user_id` INT NULL ;

ALTER TABLE `news` ADD `parent_id` INT NULL 