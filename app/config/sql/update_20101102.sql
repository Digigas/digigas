
ALTER TABLE  `products` ADD  `show_note` TINYINT( 1 ) NOT NULL AFTER  `option_list_2`;

ALTER TABLE  `products` ADD  `units` VARCHAR( 100 ) NOT NULL AFTER  `number`;