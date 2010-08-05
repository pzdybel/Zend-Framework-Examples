CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(100) NOT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `news` (`id`, `topic`, `text`) VALUES
(1, 'Pierwszy news', '1: adsfga'),
(2, 'Drugi news', '2: adfga');
