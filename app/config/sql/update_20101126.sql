ALTER TABLE `news`
  DROP `parent_id`;
ALTER TABLE `news`
  DROP `user_id`;


ALTER TABLE  `news` ADD  `user_id` INT NOT NULL AFTER  `newscategory_id`;


--
-- Struttura della tabella `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `pagetitle` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commenti` (`model`,`item_id`,`active`),
  FULLTEXT KEY `ricerca` (`text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `forums`
--

CREATE TABLE `forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'utente proprietario',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'descrizione',
  `access_level` int(11) NOT NULL COMMENT 'visibile solo agli utenti di livello pari o inferiore',
  `active` tinyint(1) NOT NULL,
  `weight` int(11) NOT NULL COMMENT 'campo peso usato per l''ordinamento',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

