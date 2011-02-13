-- Aggiunti i campi indirizzo e telefono nella scheda utente

ALTER TABLE  `users` ADD  `address` VARCHAR( 255 ) NOT NULL AFTER  `last_name` ,
ADD  `phone` VARCHAR( 255 ) NOT NULL AFTER  `address` ,
ADD  `mobile` VARCHAR( 255 ) NOT NULL AFTER  `phone`