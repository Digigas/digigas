ALTER TABLE `ordered_products` 
ADD `option_1` VARCHAR( 255 ) NULL ,
ADD `option_2` VARCHAR( 255 ) NULL ,
ADD `note` TEXT NULL ;

ALTER TABLE `products` 
ADD `option_1` VARCHAR( 255 ) NULL ,
ADD `option_list_1` VARCHAR( 1000 ) NULL ,
ADD `option_2` VARCHAR( 255 ) NULL,
ADD `option_list_2` VARCHAR( 1000 ) NULL ;

