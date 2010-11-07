
--
-- Struttura della tabella `sellers_users`
--

CREATE TABLE `sellers_users` (
  `seller_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE  `users` DROP  `seller_id`;