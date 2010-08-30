CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT INTO `albums` (`id`, `name`) VALUES
(1, 'Album 1'),
(2, 'Album 2'),
(3, 'Album 3');

CREATE TABLE IF NOT EXISTS `albums_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT INTO `albums_categories` (`id`, `id_album`, `name`) VALUES
(1, 1, 'Kategoria 1'),
(2, 2, 'Kategoria 2 '),
(3, 2, 'Kategoria 3'),
(4, 3, 'Kategoria 4');


ALTER TABLE albums_categories add FOREIGN KEY (id_album) REFERENCES albums(id) ON DELETE CASCADE;
