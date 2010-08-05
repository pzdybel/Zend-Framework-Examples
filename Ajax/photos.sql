CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL,
  `votes_down` int(11) NOT NULL,
  `votes_up` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `photos`
--

INSERT INTO `photos` (`id`, `votes_down`, `votes_up`) VALUES
(1, 7, 13),
(2, 9, 13);
