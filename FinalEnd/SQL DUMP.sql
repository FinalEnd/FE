-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. August 2010 um 03:15
-- Server Version: 5.0.51
-- PHP-Version: 5.2.6-1+lenny8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `FINALEND`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_allianz`
--

CREATE TABLE IF NOT EXISTS `tbl_allianz` (
  `i_Id` int(9) NOT NULL auto_increment,
  `s_AllianzName` varchar(90) NOT NULL,
  `t_Description` text NOT NULL,
  `i_FundUserId` int(9) NOT NULL,
  `s_PictureString` varchar(90) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `tbl_allianz`
--

INSERT INTO `tbl_allianz` (`i_Id`, `s_AllianzName`, `t_Description`, `i_FundUserId`, `s_PictureString`) VALUES
(8, 'Die Vernichter', 'bei uns kommt alle unter den Hammer', 52, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_allianzcomment`
--

CREATE TABLE IF NOT EXISTS `tbl_allianzcomment` (
  `i_Id` int(9) NOT NULL auto_increment,
  `t_Comment` text NOT NULL,
  `i_UserId` int(9) NOT NULL,
  `d_CreateDate` datetime NOT NULL,
  `i_TopicId` int(11) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `tbl_allianzcomment`
--

INSERT INTO `tbl_allianzcomment` (`i_Id`, `t_Comment`, `i_UserId`, `d_CreateDate`, `i_TopicId`) VALUES
(13, 'Hier kann man Themen schreiben<br />bau am anfang erstmal dein Haupthaus und metal und kristall aus das brauchst du für schiffe die du später in deiner wertf bauen kannst', 52, '2010-08-04 15:18:24', 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_allianztopic`
--

CREATE TABLE IF NOT EXISTS `tbl_allianztopic` (
  `i_Id` int(9) NOT NULL auto_increment,
  `s_Name` varchar(90) NOT NULL,
  `i_UserId` int(9) NOT NULL,
  `d_CreateDate` datetime NOT NULL,
  `i_AllianzId` int(9) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `tbl_allianztopic`
--

INSERT INTO `tbl_allianztopic` (`i_Id`, `s_Name`, `i_UserId`, `d_CreateDate`, `i_AllianzId`) VALUES
(10, 'Moin', 52, '2010-08-04 15:18:24', 8);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_allianzuser`
--

CREATE TABLE IF NOT EXISTS `tbl_allianzuser` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_AllianzId` int(9) NOT NULL,
  `i_UserId` int(9) NOT NULL,
  `s_MemberState` varchar(255) NOT NULL,
  `d_InsertDate` date NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Daten für Tabelle `tbl_allianzuser`
--

INSERT INTO `tbl_allianzuser` (`i_Id`, `i_AllianzId`, `i_UserId`, `s_MemberState`, `d_InsertDate`) VALUES
(18, 8, 75, 'admin', '2010-08-04'),
(17, 8, 52, 'admin', '2010-08-04');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_battle`
--

CREATE TABLE IF NOT EXISTS `tbl_battle` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_Refresh` varchar(40) NOT NULL,
  `i_X` int(9) NOT NULL,
  `i_Y` int(9) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=139 ;

--
-- Daten für Tabelle `tbl_battle`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_battleunit`
--

CREATE TABLE IF NOT EXISTS `tbl_battleunit` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_BattleId` int(9) NOT NULL,
  `i_UnitId` int(9) NOT NULL,
  `s_JoinTime` varchar(90) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=437 ;

--
-- Daten für Tabelle `tbl_battleunit`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_buildings`
--

CREATE TABLE IF NOT EXISTS `tbl_buildings` (
  `i_Id` int(6) NOT NULL auto_increment,
  `s_Name` varchar(255) NOT NULL,
  `t_Description` text NOT NULL,
  `s_Picture` varchar(60) NOT NULL,
  `f_Multiplicator` float NOT NULL,
  `s_Resource` varchar(50) NOT NULL,
  `i_BuildTime` int(6) NOT NULL,
  `i_BuildCredits` int(6) NOT NULL,
  `i_BuildMetall` int(6) NOT NULL,
  `i_BuildCrystal` int(6) NOT NULL,
  `i_BuildHydrogen` int(6) NOT NULL,
  `i_BuildBioMass` int(6) NOT NULL,
  `i_NeedLevel` int(3) NOT NULL,
  `i_Need` int(3) NOT NULL,
  `i_MaxLevel` int(3) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Daten für Tabelle `tbl_buildings`
--

INSERT INTO `tbl_buildings` (`i_Id`, `s_Name`, `t_Description`, `s_Picture`, `f_Multiplicator`, `s_Resource`, `i_BuildTime`, `i_BuildCredits`, `i_BuildMetall`, `i_BuildCrystal`, `i_BuildHydrogen`, `i_BuildBioMass`, `i_NeedLevel`, `i_Need`, `i_MaxLevel`) VALUES
(1, 'Hauptquartier', 'Dies ist das Hauptgebäude des Planeten, hier werden alle wichtigen Entscheidungen für den Planeten gefällt.\r\nGeneriert Credits.\r\n\r\n', '', 50, 'Credits', 25, 250, 125, 100, 80, 0, 0, 0, 25),
(2, 'Metallmine', 'Diese Metallmine generiert Metall.', '', 70, 'Metall', 15, 250, 280, 0, 0, 0, 0, 0, 25),
(8, 'Deuterium Reaktor', 'Dieses Gebäude versorgt sie mit Deuterium das Sie für Ihre Einheiten und als Treibstoff benötigen.', '', 75, 'Hydrogen', 30, 175, 150, 80, 0, 0, 0, 0, 25),
(4, 'Plantage', 'Eine Plantage versorgt Ihren Planeten und ihre Armee mit Lebensmitteln.', '', 30, 'Biomass', 20, 250, 100, 100, 0, 0, 0, 0, 25),
(5, 'Kristallmine', 'Kristalle werden für die Herstellung  Ihre Schiffe benötigt, Sie sollten immer ausreichende davon auf Lager haben.', '', 45, 'Cristal', 20, 350, 250, 0, 0, 0, 0, 0, 25),
(7, 'Werft', 'Die Werft Wird für den Bau von Schiffen benötigt.', '', 0, 'None', 25, 800, 650, 720, 450, 0, 5, 1, 10),
(18, 'Lager', 'Mithilfe eines Speichers werden Ihrer Ressourcen auf dem Planeten gelagert.\r\n', '', 0, 'None', 13, 250, 250, 250, 0, 0, 0, 0, 30),
(19, 'Labor', 'Wird für ihrer Forschung auf dem Planeten benötigt.', '', 1, 'None', 3500, 10000, 7500, 7500, 7500, 10000, 8, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_groups`
--

CREATE TABLE IF NOT EXISTS `tbl_groups` (
  `i_Id` int(9) NOT NULL auto_increment,
  `s_Name` varchar(80) NOT NULL,
  `i_X` int(13) NOT NULL,
  `i_Y` int(13) NOT NULL,
  `i_Healt` int(13) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tbl_groups`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_invite`
--

CREATE TABLE IF NOT EXISTS `tbl_invite` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_UserId` int(9) NOT NULL,
  `i_Temp` int(9) NOT NULL,
  `d_Date` date NOT NULL,
  `s_Type` varchar(50) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Daten für Tabelle `tbl_invite`
--

INSERT INTO `tbl_invite` (`i_Id`, `i_UserId`, `i_Temp`, `d_Date`, `s_Type`) VALUES
(17, 67, 1, '2010-06-23', 'allianz'),
(20, 73, 1, '2010-08-04', 'allianz');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_message`
--

CREATE TABLE IF NOT EXISTS `tbl_message` (
  `s_Sender` varchar(75) collate latin1_general_ci NOT NULL,
  `s_Resiver` varchar(75) collate latin1_general_ci NOT NULL,
  `t_Text` text collate latin1_general_ci NOT NULL,
  `i_Id` int(9) NOT NULL auto_increment,
  `d_Date` datetime NOT NULL,
  `b_Read` int(1) NOT NULL default '0',
  `s_Header` varchar(60) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1215 ;

--
-- Daten für Tabelle `tbl_message`
--

INSERT INTO `tbl_message` (`s_Sender`, `s_Resiver`, `t_Text`, `i_Id`, `d_Date`, `b_Read`, `s_Header`) VALUES
('DeEMoN', 'faroth ', 'Du bist eine Schwuchtel', 22, '2010-04-30 15:09:12', 0, 'schwuchtel '),
('Ishmael', 'test', 'http://ice-online.de/zoich/kristal.png\r\n', 19, '2010-04-29 00:42:40', 1, 'Kristal'),
('test', 'tset', 'test', 7, '2009-12-01 21:52:48', 0, 'test'),
('Ishmael', 'test', '- man weis nicht wenn die lager voll sind\r\n- kommt kein fertig gestellt bei den Gebäuden\r\n- Kurzbeschreibung der Gebäude währe nich schlecht, man weis \r\n  sonst nicht welches Gebäude für was gut ist\r\n', 16, '2010-04-27 23:34:28', 1, 'Gemecker'),
('test', 'tset', 'tset', 9, '2009-12-01 21:52:56', 0, 'test'),
('Ishmael', 'System', 'Danke für die Nachricht!!!', 24, '2010-05-03 23:07:50', 0, 'Hmm'),
('Ishmael', 'test', 'IST WEG!!!!!!!!!!!!!!!', 20, '2010-04-29 21:51:05', 1, 'Drohne'),
('Ishmael', 'test', 'Wie kann ich meine Schiffe beladen?', 68, '2010-05-04 16:22:27', 1, 'Hör uff'),
('System', 'DeEMoN', 'Die Einheit: Scout 2 hat sein Ziel 9020:3829 Erreicht', 77, '2010-05-04 17:05:26', 1, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: Scout hat sein Ziel 8243:3340 Erreicht', 79, '2010-05-04 17:16:02', 1, 'Einheit hat Position erreicht'),
('Ishmael', 'System', 'Geht Klar', 29, '2010-05-03 23:29:14', 0, 'Nu'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7234.89&amp;Y=2598.04">lkjlö 7234.89:2598.04</a> von Opfer2\r\n									zerstört <br /><br />\r\n									Sie haben 300 Erfahrung erhalten.\r\n									', 807, '2010-05-23 23:16:30', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: Scout 2 hat sein Ziel 9019:3828 Erreicht', 72, '2010-05-04 16:26:51', 1, 'Einheit hat Position erreicht'),
('System', 'Opfer2', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.27&amp;Y=2599"> 7220.27:2599</a>', 814, '2010-05-24 01:35:49', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: Scout hat sein Ziel 8244:3831 Erreicht', 56, '2010-05-04 13:57:12', 1, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: Scout 2 hat sein Ziel 9019:3823 Erreicht', 57, '2010-05-04 13:57:12', 1, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=8273.98&amp;Y=3437.01"> 8273.98:3437.01</a>', 726, '2010-05-20 10:54:44', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: Scout 2 hat sein Ziel 8746:3663 Erreicht', 53, '2010-05-04 13:32:44', 1, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: Scout hat sein Ziel 8239:3831 Erreicht', 74, '2010-05-04 16:27:12', 1, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8394&amp;Y=3529">Ivan hat sein Ziel 8394:3529</a> Erreicht', 773, '2010-05-21 14:05:00', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8240&amp;Y=3420">lvl up 8240:3420</a> wurde zerstört ', 729, '2010-05-20 10:57:02', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('test', 'Ishmael', 'Nachricht über die Karte verschickt', 64, '2010-05-04 16:18:03', 1, 'warnung'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7233&amp;Y=2599">4564 hat sein Ziel 7233:2599</a> Erreicht', 805, '2010-05-23 22:27:24', 0, 'Einheit hat Position erreicht'),
('test', 'Ishmael', 'niemals', 191, '2010-05-07 00:03:37', 1, ':)'),
('Ishmael', 'test', 'Doch', 192, '2010-05-07 00:06:49', 1, ':-8'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7229&amp;Y=2605">10 7229:2605</a> wurde zerstört ', 865, '2010-05-24 15:38:34', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('Ishmael', 'test', 'Lass mich in Ruhe, ahu ab mit deinen Schiffen', 126, '2010-05-05 23:11:57', 1, 'Eh'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3654&amp;Y=2838">test 3654:2838</a> wurde zerstört ', 415, '2010-05-12 16:38:10', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'Opfer2', 'Eine oder mehrere Einheiten sind in einen kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7233.21&amp;Y=2598.79"> 7233.21:2598.79</a>', 809, '2010-05-23 23:16:30', 0, 'Einheit wird angegriffen'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3671.07&amp;Y=2819.63"> 3671.07:2819.63</a>', 428, '2010-05-12 17:07:24', 0, 'Einheit wird angegriffen'),
('System', 'Ishmael', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3837&amp;Y=2782"> 3837:2782</a>', 195, '2010-05-07 00:17:44', 1, 'Einheit wird angegriffen'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3594.16&amp;Y=2997.46">test 3594.16:2997.46</a> wurde zerstört ', 402, '2010-05-12 15:55:05', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'test', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3921.74&amp;Y=2739"> 3921.74:2739</a>', 267, '2010-05-10 20:06:54', 1, 'Einheit wird angegriffen'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7235&amp;Y=2598">lkjlö hat sein Ziel 7235:2598</a> Erreicht', 804, '2010-05-23 22:25:36', 0, 'Einheit hat Position erreicht'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3652.4&amp;Y=2837.97"> 3652.4:2837.97</a>', 416, '2010-05-12 16:41:11', 0, 'Einheit wird angegriffen'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7234.89&amp;Y=2598.04">lkjlö 7234.89:2598.04</a> wurde zerstört ', 808, '2010-05-23 23:16:30', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7224.21&amp;Y=2599.61"> 7224.21:2599.61</a>', 803, '2010-05-23 22:16:40', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7861&amp;Y=4570">Kill Me If U Can hat sein Ziel 7861:4570</a> Erreicht', 723, '2010-05-20 01:20:12', 0, 'Einheit hat Position erreicht'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3669&amp;Y=2821">test 3669:2821</a> wurde zerstört ', 425, '2010-05-12 17:03:53', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('faroth', 'Ishmael', 'jetzt habe ich dich `;..;´', 382, '2010-05-12 12:11:41', 1, ''),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3684.9&amp;Y=2856.52"> 3684.9:2856.52</a>', 403, '2010-05-12 16:14:34', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.27&amp;Y=2599"> 7220.27:2599</a>', 815, '2010-05-24 01:35:49', 0, 'Einheit wird angegriffen'),
('faroth', 'test', 'I can see you', 374, '2010-05-12 09:47:07', 1, 'huhu'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7234&amp;Y=2598">4564 hat sein Ziel 7234:2598</a> Erreicht', 810, '2010-05-23 23:17:42', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8573.53&amp;Y=3540.27">lvl up 8573.53:3540.27</a> von blubb\r\n									zerstört <br /><br />\r\n									Sie haben 500 Erfahrung erhalten.\r\n									', 881, '2010-05-24 19:36:13', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7234&amp;Y=2598">4564 7234:2598</a> von Opfer2\r\n									zerstört <br /><br />\r\n									Sie haben 600 Erfahrung erhalten.\r\n									', 812, '2010-05-24 01:35:04', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7234&amp;Y=2598">4564 7234:2598</a> wurde zerstört ', 813, '2010-05-24 01:35:04', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('Ishmael', 'test', '????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????', 319, '2010-05-11 22:09:30', 1, '????'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.27&amp;Y=2599">bhkjbk 7220.27:2599</a> von Opfer2\r\n									zerstört <br /><br />\r\n									Sie haben 750 Erfahrung erhalten.\r\n									', 816, '2010-05-24 01:49:38', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3589.15&amp;Y=2974.93"> 3589.15:2974.93</a>', 400, '2010-05-12 15:50:30', 0, 'Einheit wird angegriffen'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.27&amp;Y=2599">bhkjbk 7220.27:2599</a> wurde zerstört ', 817, '2010-05-24 01:49:38', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3770.45&amp;Y=3009.36"> 3770.45:3009.36</a>', 410, '2010-05-12 16:30:05', 0, 'Einheit wird angegriffen'),
('System', 'Ishmael', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3869.49&amp;Y=2803.08">DefSupr_1 3869.49:2803.08</a> wurde zerstört ', 364, '2010-05-12 01:13:44', 1, 'Eine Ihrer Einheiten wurde zerstört'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3671&amp;Y=2819">test 3671:2819</a> wurde zerstört ', 430, '2010-05-12 17:10:38', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3690.06&amp;Y=2789.7"> 3690.06:2789.7</a>', 445, '2010-05-12 18:59:51', 0, 'Einheit wird angegriffen'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3688&amp;Y=2789">test 3688:2789</a> wurde zerstört ', 440, '2010-05-12 18:51:34', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7217&amp;Y=2597">Ivan hat sein Ziel 7217:2597</a> Erreicht', 946, '2010-05-26 12:39:06', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7228.91&amp;Y=2603.19"> 7228.91:2603.19</a>', 839, '2010-05-24 15:11:54', 0, 'Einheit wird angegriffen'),
('System', 'Opfer2', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7228.91&amp;Y=2603.19"> 7228.91:2603.19</a>', 840, '2010-05-24 15:11:54', 0, 'Einheit wird angegriffen'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3671&amp;Y=2819">test 3671:2819</a> wurde zerstört ', 427, '2010-05-12 17:06:40', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3652.32&amp;Y=2838.1"> 3652.32:2838.1</a>', 412, '2010-05-12 16:37:02', 0, 'Einheit wird angegriffen'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3681&amp;Y=2857">test 3681:2857</a> wurde zerstört ', 406, '2010-05-12 16:22:32', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3654&amp;Y=2839">test 3654:2839</a> wurde zerstört ', 420, '2010-05-12 16:45:59', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3668&amp;Y=2822">test 3668:2822</a> wurde zerstört ', 422, '2010-05-12 16:56:23', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3671.1&amp;Y=2819.69"> 3671.1:2819.69</a>', 423, '2010-05-12 16:57:54', 0, 'Einheit wird angegriffen'),
('System', 'faroth', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=4291.88&amp;Y=3035.15"> 4291.88:3035.15</a>', 436, '2010-05-12 18:51:25', 0, 'Einheit wird angegriffen'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3690.1&amp;Y=2789.74"> 3690.1:2789.74</a>', 441, '2010-05-12 18:51:51', 0, 'Einheit wird angegriffen'),
('System', '', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3690.55&amp;Y=2790.15"> 3690.55:2790.15</a>', 438, '2010-05-12 18:51:25', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219&amp;Y=2598">BombenSache hat sein Ziel 7219:2598</a> Erreicht', 916, '2010-05-25 17:16:07', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7227&amp;Y=2603">BombenSache hat sein Ziel 7227:2603</a> Erreicht', 876, '2010-05-24 17:44:47', 0, 'Einheit hat Position erreicht'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3688&amp;Y=2789">test 3688:2789</a> wurde zerstört ', 443, '2010-05-12 18:53:00', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', '', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3688&amp;Y=2789">test 3688:2789</a> wurde zerstört ', 448, '2010-05-12 19:00:20', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219&amp;Y=2598">10 hat sein Ziel 7219:2598</a> Erreicht', 843, '2010-05-24 15:17:46', 0, 'Einheit hat Position erreicht'),
('Ishmael', 'test', 'Ah cool das kommt gut aba bestimmt erst sinvoll wenn man 2 planeten hat\r\n\r\n- aba bau mal bitte beim Nachrichtendienst mit ein das wenn man antwortet gleich der Name mit im Empfänger steht weil des Nerv den immer wieder ein zu tragen', 782, '2010-05-21 16:27:27', 1, 'hmm'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7463&amp;Y=2661">BombenSache hat sein Ziel 7463:2661</a> Erreicht', 784, '2010-05-23 16:32:01', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8393&amp;Y=3513">Ivan hat sein Ziel 8393:3513</a> Erreicht', 771, '2010-05-21 12:11:52', 0, 'Einheit hat Position erreicht'),
('Ishmael', 'test', '??????????????????????????????', 772, '2010-05-21 12:16:20', 1, '??????'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8393&amp;Y=3538">lvl up inc 8393:3538</a> von blubb\r\n									zerstört <br /><br />\r\n									Sie haben 200 Erfahrung erhalten.\r\n									', 780, '2010-05-21 16:18:54', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', 'faroth', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=1882&amp;Y=3664">Trapp hat sein Ziel 1882:3664</a> Erreicht', 461, '2010-05-16 13:08:16', 0, 'Einheit hat Position erreicht'),
('System', 'Opfer2', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7224.21&amp;Y=2599.61"> 7224.21:2599.61</a>', 802, '2010-05-23 22:16:40', 0, 'Einheit wird angegriffen'),
('System', 'faroth', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=4291.88&amp;Y=3035.15">Unkaputtbar 4291.88:3035.15</a> wurde zerstört ', 463, '2010-05-16 13:08:16', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8392.95&amp;Y=3525.74">bob 8392.95:3525.74</a> wurde zerstört ', 769, '2010-05-20 22:29:15', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8392&amp;Y=3549">Ivan hat sein Ziel 8392:3549</a> Erreicht', 779, '2010-05-21 16:18:54', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8586&amp;Y=3565">TerrOr hat sein Ziel 8586:3565</a> Erreicht', 866, '2010-05-24 15:49:27', 0, 'Einheit hat Position erreicht'),
('System', 'test', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=2829&amp;Y=5200">Beta Def hat sein Ziel 2829:5200</a> Erreicht', 775, '2010-05-21 15:32:10', 1, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=8426.06&amp;Y=3527.85"> 8426.06:3527.85</a>', 736, '2010-05-20 14:53:43', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219&amp;Y=2597">BombenSache hat sein Ziel 7219:2597</a> Erreicht', 829, '2010-05-24 14:05:06', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8426.06&amp;Y=3527.85">lvl up  8426.06:3527.85</a> wurde zerstört ', 740, '2010-05-20 16:01:45', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7481&amp;Y=2722">BombenSache hat sein Ziel 7481:2722</a> Erreicht', 741, '2010-05-20 16:32:31', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8393&amp;Y=3526">bob hat sein Ziel 8393:3526</a> Erreicht', 763, '2010-05-20 21:23:42', 0, 'Einheit hat Position erreicht'),
('System', 'test', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=2527&amp;Y=5168">Beta Def hat sein Ziel 2527:5168</a> Erreicht', 783, '2010-05-23 15:58:53', 1, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=8393.97&amp;Y=3529.32"> 8393.97:3529.32</a>', 777, '2010-05-21 15:32:31', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=8392.95&amp;Y=3525.74"> 8392.95:3525.74</a>', 765, '2010-05-20 21:24:09', 0, 'Einheit wird angegriffen'),
('System', 'Knarf', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3807&amp;Y=8183">Spioner hat sein Ziel 3807:8183</a> Erreicht', 1152, '2010-07-02 23:32:12', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.26&amp;Y=2600.59"> 7220.26:2600.59</a>', 883, '2010-05-24 19:36:13', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7218&amp;Y=2599">TerrOr hat sein Ziel 7218:2599</a> Erreicht', 917, '2010-05-25 17:16:07', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=8573.53&amp;Y=3540.27"> 8573.53:3540.27</a>', 878, '2010-05-24 19:33:11', 0, 'Einheit wird angegriffen'),
('System', 'Opfer2', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7228.91&amp;Y=2603.19"> 7228.91:2603.19</a>', 841, '2010-05-24 15:11:54', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7228.91&amp;Y=2603.19"> 7228.91:2603.19</a>', 842, '2010-05-24 15:11:54', 0, 'Einheit wird angegriffen'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7229&amp;Y=2605">10 hat sein Ziel 7229:2605</a> Erreicht', 844, '2010-05-24 15:18:02', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7228&amp;Y=2609">Ivan hat sein Ziel 7228:2609</a> Erreicht', 850, '2010-05-24 15:22:53', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7229&amp;Y=2609">BombenSache hat sein Ziel 7229:2609</a> Erreicht', 849, '2010-05-24 15:21:34', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219&amp;Y=2598">10 7219:2598</a> von Opfer2\r\n									zerstört <br /><br />\r\n									Sie haben 1500 Erfahrung erhalten.\r\n									', 863, '2010-05-24 15:38:34', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219&amp;Y=2598">10 7219:2598</a> wurde zerstört ', 864, '2010-05-24 15:38:34', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7216&amp;Y=2606">Ivan hat sein Ziel 7216:2606</a> Erreicht', 921, '2010-05-25 19:37:12', 0, 'Einheit hat Position erreicht'),
('System', 'faroth', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=4070&amp;Y=3442">NichtKapputMachen 4070:3442</a> wurde zerstört ', 683, '2010-05-19 16:02:25', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.26&amp;Y=2600.59"> 7220.26:2600.59</a>', 885, '2010-05-24 19:36:13', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7218&amp;Y=2601">Ivan hat sein Ziel 7218:2601</a> Erreicht', 915, '2010-05-25 16:11:03', 0, 'Einheit hat Position erreicht'),
('System', 'Ishmael', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3845.76&amp;Y=2816.09">Alpha Angriff 2 3845.76:2816.09</a> von test\r\n									zerstört <br /><br />\r\n									Sie haben 18000 Erfahrung erhalten.\r\n									', 577, '2010-05-17 13:44:58', 1, 'Gegnerische Einheiten wurde zerstört'),
('System', 'Narf', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=288.84&amp;Y=7502.3">Alpha 1 288.84:7502.3</a> von test\r\n									zerstört <br /><br />\r\n									Sie haben 15750 Erfahrung erhalten.\r\n									', 1153, '2010-07-02 23:32:13', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', 'Opfer2', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.26&amp;Y=2600.59"> 7220.26:2600.59</a>', 884, '2010-05-24 19:36:13', 0, 'Einheit wird angegriffen'),
('System', 'faroth', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3785.98&amp;Y=3579.6"> 3785.98:3579.6</a>', 550, '2010-05-16 19:05:47', 0, 'Einheit wird angegriffen'),
('System', 'faroth', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=4102.65&amp;Y=3432.35"> 4102.65:3432.35</a>', 541, '2010-05-16 17:47:50', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7221&amp;Y=2600">BombenSache hat sein Ziel 7221:2600</a> Erreicht', 919, '2010-05-25 19:37:12', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8380&amp;Y=6242">Kill Me If U Can hat sein Ziel 8380:6242</a> Erreicht', 911, '2010-05-25 12:17:16', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8189&amp;Y=6406">?! hat sein Ziel 8189:6406</a> Erreicht', 720, '2010-05-19 22:49:46', 0, 'Einheit hat Position erreicht'),
('System', 'faroth', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3784&amp;Y=3579">puttmachen 3784:3579</a> wurde zerstört ', 645, '2010-05-18 21:51:43', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7218&amp;Y=2601">Ivan hat sein Ziel 7218:2601</a> Erreicht', 894, '2010-05-24 19:40:44', 0, 'Einheit hat Position erreicht'),
('System', 'Knarf', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3800.94&amp;Y=7970.55">Leveln 3800.94:7970.55</a> wurde zerstört ', 889, '2010-05-24 19:39:12', 1, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'faroth', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=4051&amp;Y=3459.17"> 4051:3459.17</a>', 656, '2010-05-18 22:27:35', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8224&amp;Y=4808">Kill Me If U Can hat sein Ziel 8224:4808</a> Erreicht', 909, '2010-05-24 20:28:41', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.26&amp;Y=2600.59">jkj 7220.26:2600.59</a> von Opfer2\r\n									zerstört <br /><br />\r\n									Sie haben 1800 Erfahrung erhalten.\r\n									', 897, '2010-05-24 19:59:42', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7220.26&amp;Y=2600.59">jkj 7220.26:2600.59</a> wurde zerstört ', 898, '2010-05-24 19:59:42', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8631&amp;Y=3582">TerrOr hat sein Ziel 8631:3582</a> Erreicht', 899, '2010-05-24 20:15:39', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7234&amp;Y=2597">BombenSache hat sein Ziel 7234:2597</a> Erreicht', 801, '2010-05-23 22:05:19', 0, 'Einheit hat Position erreicht'),
('Ishmael', 'test', 'Loift genau so', 800, '2010-05-23 20:21:00', 1, 'jup'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=6431&amp;Y=4708">Scout hat sein Ziel 6431:4708</a> Erreicht', 798, '2010-05-23 19:56:13', 0, 'Einheit hat Position erreicht'),
('System', 'Ishmael', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3926.54&amp;Y=2864.22">Leveln 3926.54:2864.22</a> von test\r\n									zerstört <br /><br />\r\n									Sie haben 1200 Erfahrung erhalten.\r\n									', 796, '2010-05-23 18:28:38', 1, 'Gegnerische Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7217&amp;Y=2608">TerrOr hat sein Ziel 7217:2608</a> Erreicht', 920, '2010-05-25 19:37:12', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=4115&amp;Y=4708">Scout hat sein Ziel 4115:4708</a> Erreicht', 913, '2010-05-25 12:17:16', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7216&amp;Y=2606">TerrOr hat sein Ziel 7216:2606</a> Erreicht', 914, '2010-05-25 15:43:12', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8240&amp;Y=3420">lvl up hat sein Ziel 8240:3420</a> Erreicht', 721, '2010-05-20 01:03:12', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7219.3&amp;Y=2599.17"> 7219.3:2599.17</a>', 950, '2010-05-26 20:33:14', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7221&amp;Y=2601">BombenSache hat sein Ziel 7221:2601</a> Erreicht', 949, '2010-05-26 20:33:14', 0, 'Einheit hat Position erreicht'),
('System', 'Knarf', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3801.99&amp;Y=7971.02">Leveln 3801.99:7971.02</a> wurde zerstört ', 968, '2010-05-31 21:26:51', 1, 'Eine Ihrer Einheiten wurde zerstört'),
('test', 'DeEMoN', 'test lädt sie in die Allianz DIE STARKEN MÄNNER ein, <br /> um der Allianz Beizutreten klicken Sie <a href="index.php?Section=Allianz&amp;Action=AllianzInvite">hier</a>', 943, '2010-05-26 12:32:58', 0, 'Allianz Einladung'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7217&amp;Y=2599">BombenSache hat sein Ziel 7217:2599</a> Erreicht', 944, '2010-05-26 12:39:06', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7218&amp;Y=2597">TerrOr hat sein Ziel 7218:2597</a> Erreicht', 945, '2010-05-26 12:39:06', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7219.3&amp;Y=2599.17"> 7219.3:2599.17</a>', 951, '2010-05-26 20:33:14', 0, 'Einheit wird angegriffen'),
('System', 'Opfer2', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7219.3&amp;Y=2599.17"> 7219.3:2599.17</a>', 952, '2010-05-26 20:33:14', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7219.3&amp;Y=2599.17"> 7219.3:2599.17</a>', 953, '2010-05-26 20:33:14', 0, 'Einheit wird angegriffen'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219&amp;Y=2605">lvup hat sein Ziel 7219:2605</a> Erreicht', 954, '2010-05-26 21:26:16', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219&amp;Y=2605">lvup 7219:2605</a> von Opfer2\r\n									zerstört <br /><br />\r\n									Sie haben 3450 Erfahrung erhalten.\r\n									', 955, '2010-05-26 21:26:16', 0, 'Gegnerische Einheiten wurde zerstört'),
('System', 'Opfer2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219&amp;Y=2605">lvup 7219:2605</a> wurde zerstört ', 956, '2010-05-26 21:26:16', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=11363&amp;Y=2804">Marlis is immernoch Doof 11363:2804</a> wurde zerstört ', 1026, '2010-06-08 13:02:42', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'faroth', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=1882.75&amp;Y=3667.38"> 1882.75:3667.38</a>', 997, '2010-06-06 22:34:08', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=4126.76&amp;Y=4735.87"> 4126.76:4735.87</a>', 982, '2010-06-06 00:30:08', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8189&amp;Y=6406">?! 8189:6406</a> wurde zerstört ', 1036, '2010-06-14 12:57:50', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=11362.1&amp;Y=2806.2"> 11362.1:2806.2</a>', 1024, '2010-06-08 13:01:27', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=4115&amp;Y=4708">Scout 4115:4708</a> wurde zerstört ', 984, '2010-06-06 00:30:14', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=6228.86&amp;Y=1482.64"> 6228.86:1482.64</a>', 1002, '2010-06-07 14:48:23', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=8191&amp;Y=6412.4"> 8191:6412.4</a>', 1034, '2010-06-14 12:57:41', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8380&amp;Y=6242">Kill Me If U Can 8380:6242</a> wurde zerstört ', 1041, '2010-06-14 20:45:44', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=8381.56&amp;Y=6247.15"> 8381.56:6247.15</a>', 1039, '2010-06-14 20:45:10', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7221.93&amp;Y=2595.67"> 7221.93:2595.67</a>', 1011, '2010-06-08 00:42:00', 0, 'Einheit wird angegriffen'),
('System', 'faroth', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=1882&amp;Y=3664">Trapp 1882:3664</a> wurde zerstört ', 1000, '2010-06-06 22:35:04', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=8699.44&amp;Y=1419.13"> 8699.44:1419.13</a>', 1008, '2010-06-07 23:35:24', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7221.93&amp;Y=2595.67"> 7221.93:2595.67</a>', 1012, '2010-06-08 00:42:00', 0, 'Einheit wird angegriffen'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=6263&amp;Y=1459">Marlis is Doof 6263:1459</a> wurde zerstört ', 1005, '2010-06-07 15:17:44', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=8704&amp;Y=1413">! 8704:1413</a> wurde zerstört ', 1010, '2010-06-07 23:35:34', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7221.93&amp;Y=2595.67"> 7221.93:2595.67</a>', 1014, '2010-06-08 00:42:00', 0, 'Einheit wird angegriffen'),
('System', 'test2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=2381&amp;Y=716">50 hat sein Ziel 2381:716</a> Erreicht', 1191, '2010-08-01 14:53:28', 0, 'Einheit hat Position erreicht'),
('System', 'Narf', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=292.815&amp;Y=7481.04">Spioner 292.815:7481.04</a> wurde zerstört ', 1156, '2010-07-02 23:32:13', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7221.93&amp;Y=2595.67">Hope 7221.93:2595.67</a> von blubb\r\n									zerstört <br /><br />\r\n									Sie haben 9150 Erfahrung erhalten.\r\n									', 1017, '2010-06-08 01:57:13', 0, 'Gegnerische Einheiten wurde zerstört'),
('test', 'Ishmael', 'kannste nöch mal ein paar 2-5 einheiten um den bob platziern\r\n ', 1049, '2010-06-17 02:01:07', 1, ''),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7221&amp;Y=2601">BombenSache 7221:2601</a> wurde zerstört ', 1019, '2010-06-08 01:57:13', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('ReMaker', 'Pate', 'ReMaker lädt sie in die Allianz DIE STARKEN MÄNNER ein, <br /> um der Allianz Beizutreten klicken Sie <a href="index.php?Section=Allianz&amp;Action=AllianzInvite">hier</a>', 1204, '2010-08-04 12:34:44', 0, 'Allianz Einladung'),
('System', 'test2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=2722&amp;Y=693">angriff1 hat sein Ziel 2722:693</a> Erreicht', 1190, '2010-07-31 19:06:10', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7221.81&amp;Y=2599.42">Ivan 7221.81:2599.42</a> wurde zerstört ', 1136, '2010-06-20 21:51:48', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7213.42&amp;Y=2601.05"> 7213.42:2601.05</a>', 1133, '2010-06-20 21:47:25', 0, 'Einheit wird angegriffen'),
('System', 'test2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=2826&amp;Y=552">angriff 2 hat sein Ziel 2826:552</a> Erreicht', 1189, '2010-07-31 19:05:55', 0, 'Einheit hat Position erreicht'),
('System', 'DeEMoN', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=7213.42&amp;Y=2601.05"> 7213.42:2601.05</a>', 1131, '2010-06-20 21:47:25', 0, 'Einheit wird angegriffen'),
('ReMaker', 'Knochen', 'nee danke ich hab schon eine ', 1196, '2010-08-03 23:57:15', 0, 'Re:Allianz Einladung'),
('Zwosen', 'DeEMoN', 'warum haste so nen großen...\r\n\r\n... planet???', 1197, '2010-08-04 09:29:57', 0, 'penis'),
('ReMaker', 'Knochen', 'klar geht das aber probier mal alles aus ist halt noch in der Beta Phase', 1193, '2010-08-03 17:41:30', 0, ''),
('Pate', 'Zwosen', 'Pate lädt sie in die Allianz  ein, <br /> um der Allianz Beizutreten klicken Sie <a href="index.php?Section=Allianz&amp;Action=AllianzInvite">hier</a>', 1198, '2010-08-04 09:32:15', 0, 'Allianz Einladung'),
('Knochen', 'ReMaker', 'Knochen lädt sie in die Allianz  ein, <br /> um der Allianz Beizutreten klicken Sie <a href="index.php?Section=Allianz&amp;Action=AllianzInvite">hier</a>', 1195, '2010-08-03 22:38:28', 1, 'Allianz Einladung'),
('System', 'test2', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=2731&amp;Y=337">angriff 3 hat sein Ziel 2731:337</a> Erreicht', 1188, '2010-07-31 19:03:10', 0, 'Einheit hat Position erreicht'),
('Pate', 'Zwosen', 'soso', 1199, '2010-08-04 09:36:31', 0, '...'),
('Pate', 'Pate', 'ich will mehr geld', 1200, '2010-08-04 09:39:11', 0, '..'),
('Zwosen', 'SilanCer', 'hallo welt', 1201, '2010-08-04 12:02:42', 0, 'penis'),
('ReMaker', 'Pate', 'ReMaker lädt sie in die Allianz DIE STARKEN MÄNNER ein, <br /> um der Allianz Beizutreten klicken Sie <a href="index.php?Section=Allianz&amp;Action=AllianzInvite">hier</a>', 1202, '2010-08-04 12:32:48', 0, 'Allianz Einladung'),
('Revenger', 'Pate', 'ha hab deinen planet gefunden ', 1214, '2010-08-04 23:41:15', 0, ''),
('System', 'Opfer', 'Ihr Planet <a title="zur Karte" href="index.php?Section=Map&amp;X=3631&amp;Y=7954"> knarf test</a> wurde erobert', 1179, '2010-07-17 02:10:49', 0, 'Sie haben einen Planeten verloren'),
('System', 'Opfer', 'Ihr Planet <a title="zur Karte" href="index.php?Section=Map&amp;X=3631&amp;Y=7954"> knarf test</a> wurde erobert', 1174, '2010-07-17 01:42:17', 0, 'Sie haben einen Planeten verloren'),
('test', 'muelli', 'test lädt sie in die Allianz DIE STARKEN MÄNNER ein, <br /> um der Allianz Beizutreten klicken Sie <a href="index.php?Section=Allianz&amp;Action=AllianzInvite">hier</a>', 1144, '2010-06-23 13:43:29', 0, 'Allianz Einladung'),
('System', 'Opfer', 'Ihr Planet <a title="zur Karte" href="index.php?Section=Map&amp;X=3631&amp;Y=7954"> knarf test</a> wurde erobert', 1169, '2010-07-17 01:28:55', 0, 'Sie haben einen Planeten verloren'),
('System', 'DeEMoN', 'Die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=7219.3&amp;Y=2599.17">TerrOr 7219.3:2599.17</a> wurde zerstört ', 1138, '2010-06-20 22:00:44', 0, 'Eine Ihrer Einheiten wurde zerstört'),
('test', 'muelli', 'soll ich dir nen ü im namen machen ?', 1143, '2010-06-23 13:43:25', 0, ''),
('System', 'Opfer', 'Ihr Planet <a title="zur Karte" href="index.php?Section=Map&amp;X=3631&amp;Y=7954"> knarf test</a> wurde erobert', 1171, '2010-07-17 01:29:13', 0, 'Sie haben einen Planeten verloren'),
('System', 'Ishmael', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3993.23&amp;Y=2928.39"> 3993.23:2928.39</a>', 1207, '2010-08-04 17:15:47', 0, 'Einheit wird angegriffen'),
('System', 'Ishmael', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3993.23&amp;Y=2928.39"> 3993.23:2928.39</a>', 1208, '2010-08-04 17:15:47', 0, 'Einheit wird angegriffen'),
('System', 'Ishmael', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3993.23&amp;Y=2928.39"> 3993.23:2928.39</a>', 1209, '2010-08-04 17:15:47', 0, 'Einheit wird angegriffen'),
('System', 'Ishmael', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3993.23&amp;Y=2928.39"> 3993.23:2928.39</a>', 1210, '2010-08-04 17:15:47', 0, 'Einheit wird angegriffen'),
('System', 'Ishmael', 'Eine oder mehrere Einheiten sind in einen Kampf verwickelt <a title="zur Karte" href="index.php?Section=Map&amp;X=3993.23&amp;Y=2928.39"> 3993.23:2928.39</a>', 1211, '2010-08-04 17:15:47', 0, 'Einheit wird angegriffen'),
('System', 'Ishmael', 'Sie haben die Einheit: <a title="zur Karte" href="index.php?Section=Map&amp;X=3993.23&amp;Y=2928.39">Test Einheit 3993.23:2928.39</a> von ReMaker\r\n									zerstört <br /><br />\r\n									Sie haben 14250 Erfahrung erhalten.\r\n									', 1212, '2010-08-04 17:51:20', 0, 'Gegnerische Einheiten wurde zerstört');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_planet`
--

CREATE TABLE IF NOT EXISTS `tbl_planet` (
  `i_Id` int(12) NOT NULL auto_increment,
  `s_Name` varchar(90) NOT NULL,
  `i_UserId` int(9) NOT NULL,
  `i_Size` int(9) NOT NULL,
  `s_Weight` varchar(60) NOT NULL,
  `i_Type` int(2) NOT NULL,
  `s_Picture` varchar(60) NOT NULL,
  `i_RefreshTime` varchar(45) NOT NULL,
  `i_Metal` varchar(45) NOT NULL,
  `i_Hydrogen` varchar(45) NOT NULL,
  `i_Biomass` varchar(45) NOT NULL,
  `i_Crystal` varchar(45) NOT NULL,
  `i_X` int(9) NOT NULL,
  `i_Y` int(9) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Daten für Tabelle `tbl_planet`
--

INSERT INTO `tbl_planet` (`i_Id`, `s_Name`, `i_UserId`, `i_Size`, `s_Weight`, `i_Type`, `s_Picture`, `i_RefreshTime`, `i_Metal`, `i_Hydrogen`, `i_Biomass`, `i_Crystal`, `i_X`, `i_Y`) VALUES
(1, 'Bob', 52, 6400, '5600 *10 <sup>5</sup>', 1, 'Planet52.png', '1280937191.17', '48000', '48000', '45995.0279944', '48000', 3861, 2800),
(2, 'Peter', 52, 9856, '2944 *10<sup>8</sup>', 1, 'Planet2.png', '1280854862.81', '43409.6450321', '21232.304727', '17012.5062688', '22725.012538', 2486, 5185),
(3, 'Unbekannt', 53, 5402, '3315 *10 <sup>15</sup>', 1, 'Planet2.png', '1280598349.1268', '21000', '21000', '21000', '21000', 2407, 543),
(5, 'Gimp', 55, 9422, '6448 *10 <sup>28</sup>', 1, 'Planet6.png', '1278106794.0611', '239.00164425372', '26143.40098655', '45124.300604892', '19653.64391416', 3961, 2900),
(4, 'Neuer Planet', 54, 460, '4384 *10 <sup>35</sup>', 1, 'Planet2.png', '1272294249.76', '2729.78429615', '0', '0', '0', 6265, 2308),
(6, 'Tinchens Planet', 56, 5731, '3036 *10 <sup>13</sup>', 1, 'Planet5.png', '1273682895.62', '12943.061083054', '14150.678940715', '18000', '13427.742391312', 1764, 3587),
(7, 'Unbekannt', 57, 8452, '6539 *10 <sup>22</sup>', 1, 'Planet2.png', '1277332144.9591', '13202.126443235', '16802.278332037', '24000', '15901.366999223', 8136, 3424),
(9, 'Salliys doofer Planet', 59, 318, '6268 *10 <sup>6</sup>', 1, 'Planet5.png', '1274898740.2778', '17168.875870298', '21000', '21000', '9522.9312675888', 8633, 3586),
(8, 'Larsens Planet', 58, 210, '8248 *10 <sup>21</sup>', 1, 'Planet6.png', '1274028470.4911', '8660.9916093423', '11879.208891722', '12000', '11291.367113378', 1620, 6033),
(10, 'Unbekannt', 60, 8788, '3368 *10 <sup>18</sup>', 1, 'Planet8.png', '1278157954.4444', '25250', '25880', '27000', '24423.075184547', 6799, 3943),
(16, 'test 3 planet', 66, 9498, '4993 *10 <sup>20</sup>', 1, 'Planet4.png', '1276818591.5635', '11588.705524254', '14500.566997212', '8331.7267862948', '8085.0901794445', 1249, 1023),
(11, 'Unbekannt', 61, 8746, '1746 *10 <sup>34</sup>', 1, 'Planet1.png', '1277909149.9683', '50587.598016866', '1422.9306636465', '63000', '52992.698306677', 344, 7292),
(12, 'Unbekannt', 62, 2536, '2037 *10 <sup>41</sup>', 1, 'Planet6.png', '1277907211.7411', '56468.843615753', '8.4052880978779', '32220.615372732', '61844.256610126', 3802, 7971),
(14, 'Hans', 52, 2658, '4071 *10 <sup>22</sup>', 1, 'Planet3.png', '1279886041.3864', '3000', '0', '0', '3000', 3631, 7954),
(13, 'Unbekannt', 63, 8708, '3578 *10 <sup>24</sup>', 1, 'Planet11.png', '1275592389.9942', '11828.88972849', '13543.472971867', '0', '11862.083783119', 3219, 2347),
(18, 'Unbekannt', 64, 5709, '9505 *10 <sup>49</sup>', 1, 'Planet34.png', '0', '1500', '1500', '1500', '1500', 8766, 3555),
(17, 'Unbekannt', 67, 3665, '1526 *10 <sup>36</sup>', 1, 'Planet2.png', '1277293146.3797', '3000', '0', '0', '0', 6785, 1737),
(15, 'Unbekannt', 65, 865, '441 *10 <sup>4</sup>', 1, 'Planet0.png', '1274898896.5201', '3937.8142391045', '4250.9836335183', '6541.0028426116', '3367.6160776331', 7219, 2599),
(19, 'Zwosnien', 68, 8452, '6539 *10 <sup>22</sup>', 1, 'Planet34.png', '1280917934.37', '2161.98751235', '2799.42276622', '1514.50417444', '1990.92054367', 9766, 3155),
(20, 'Marco', 52, 2276, '9680 *10 <sup>31</sup>', 1, 'Planet59.png', '1280970729.98', '365.656014549', '4966.5874897', '2465.59757612', '1512.45740406', 100000, 100000),
(21, 'Unbekannt', 71, 5826, '2078 *10 <sup>33</sup>', 1, 'Planet29.png', '1280843999.14', '3000', '1500', '1500', '1500', 100115, 100411),
(22, 'Oritopja', 72, 1987, '7085 *10 <sup>28</sup>', 1, 'Planet24.png', '1280941098.22', '2662.58071128', '3000', '2289.47829897', '1171.92012855', 99935, 99703),
(23, 'Pates HQ', 73, 7423, '663 *10 <sup>27</sup>', 1, 'Planet35.png', '1280932578.83', '2693.75716492', '1780.44200593', '1500', '1353.0447461', 100543, 100443),
(24, 'Hellfire', 74, 3891, '9573 *10 <sup>47</sup>', 1, 'Planet1.png', '1280958140.96', '2843.13932268', '1260', '1500', '816.944600113', 99568, 99539),
(25, 'HaufenElend', 75, 291, '8722 *10 <sup>18</sup>', 1, 'Planet42.png', '1280964366.77', '3258.78777376', '1699.3108675', '1643.06158122', '1262.77640393', 100244, 99699);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_planetbuildings`
--

CREATE TABLE IF NOT EXISTS `tbl_planetbuildings` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_BiuldId` int(9) NOT NULL,
  `i_PlanetId` int(9) NOT NULL,
  `i_Level` int(3) NOT NULL,
  `i_Inbuild` int(11) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=169 ;

--
-- Daten für Tabelle `tbl_planetbuildings`
--

INSERT INTO `tbl_planetbuildings` (`i_Id`, `i_BiuldId`, `i_PlanetId`, `i_Level`, `i_Inbuild`) VALUES
(1, 1, 2, 18, 0),
(2, 2, 2, 11, 0),
(3, 1, 3, 11, 0),
(4, 2, 3, 4, 0),
(6, 4, 2, 6, 0),
(7, 5, 2, 8, 0),
(9, 8, 2, 5, 0),
(10, 18, 2, 15, 0),
(11, 5, 3, 4, 0),
(12, 7, 3, 5, 0),
(13, 18, 3, 6, 0),
(14, 8, 3, 3, 0),
(15, 4, 3, 3, 0),
(16, 19, 2, 7, 0),
(17, 7, 2, 11, 0),
(18, 19, 3, 2, 0),
(19, 1, 4, 1, 0),
(20, 2, 4, 1, 1272294646),
(22, 1, 1, 10, 0),
(23, 8, 1, 9, 0),
(24, 4, 1, 1, 0),
(25, 2, 1, 10, 0),
(26, 5, 1, 7, 0),
(27, 18, 1, 15, 0),
(28, 1, 5, 25, 0),
(29, 2, 5, 25, 0),
(30, 5, 5, 25, 0),
(31, 8, 5, 14, 0),
(32, 1, 6, 15, 0),
(33, 2, 6, 7, 0),
(34, 5, 6, 7, 0),
(35, 8, 6, 5, 0),
(36, 1, 7, 14, 0),
(37, 2, 7, 7, 0),
(38, 18, 5, 25, 0),
(39, 5, 7, 7, 0),
(40, 18, 6, 5, 0),
(42, 4, 6, 5, 0),
(43, 7, 5, 11, 0),
(44, 7, 1, 11, 0),
(45, 1, 8, 2, 1274030843),
(46, 2, 8, 5, 1274032345),
(47, 5, 8, 4, 1274032646),
(48, 8, 7, 7, 0),
(49, 1, 9, 20, 0),
(50, 2, 9, 7, 0),
(51, 5, 9, 5, 0),
(52, 8, 9, 9, 0),
(53, 7, 6, 3, 0),
(54, 4, 5, 1, 0),
(55, 4, 9, 3, 0),
(56, 18, 9, 6, 0),
(57, 19, 5, 2, 0),
(59, 1, 10, 14, 1278178954),
(60, 2, 10, 5, 0),
(61, 5, 10, 4, 0),
(62, 8, 10, 5, 0),
(63, 19, 6, 2, 0),
(65, 18, 7, 7, 0),
(66, 7, 9, 7, 0),
(67, 4, 10, 4, 0),
(68, 18, 10, 8, 0),
(69, 1, 11, 25, 0),
(70, 2, 11, 25, 0),
(71, 5, 11, 22, 0),
(72, 8, 11, 9, 0),
(73, 1, 12, 25, 0),
(74, 2, 12, 25, 0),
(75, 5, 12, 25, 0),
(76, 18, 11, 20, 0),
(77, 8, 12, 12, 0),
(78, 7, 7, 11, 0),
(79, 19, 9, 1, 0),
(80, 18, 12, 25, 0),
(81, 4, 11, 2, 0),
(82, 8, 8, 3, 1274033247),
(83, 4, 8, 3, 1274031448),
(84, 18, 8, 3, 0),
(86, 4, 7, 2, 0),
(87, 7, 11, 10, 0),
(88, 7, 12, 10, 0),
(90, 1, 13, 7, 1275602874),
(91, 2, 13, 6, 0),
(92, 5, 13, 5, 0),
(93, 8, 13, 5, 0),
(94, 18, 13, 4, 1275595507),
(95, 7, 10, 5, 0),
(96, 4, 12, 1, 0),
(98, 19, 11, 1, 0),
(100, 19, 7, 2, 0),
(101, 1, 14, 1, 0),
(102, 2, 14, 2, 0),
(103, 1, 15, 7, 1274909264),
(104, 2, 15, 5, 0),
(105, 5, 15, 4, 0),
(107, 8, 15, 4, 0),
(108, 4, 15, 2, 0),
(109, 18, 15, 2, 0),
(110, 7, 15, 1, 0),
(111, 7, 13, 2, 1275595356),
(113, 19, 10, 3, 0),
(114, 1, 16, 17, 0),
(115, 2, 16, 16, 0),
(116, 18, 16, 16, 0),
(117, 8, 16, 16, 0),
(118, 5, 16, 16, 0),
(119, 4, 16, 16, 0),
(120, 7, 16, 16, 0),
(128, 19, 1, 1, 0),
(122, 19, 16, 16, 0),
(123, 1, 17, 1, 0),
(124, 2, 17, 1, 0),
(125, 5, 14, 1, 0),
(126, 1, 18, 1, 0),
(127, 2, 18, 1, 0),
(129, 1, 68, 1, 0),
(130, 2, 68, 1, 0),
(131, 2, 19, 1, 0),
(132, 8, 19, 1, 0),
(133, 5, 19, 1, 0),
(149, 1, 19, 2, 1280920660),
(135, 1, 69, 1, 0),
(136, 2, 69, 1, 0),
(137, 1, 20, 4, 1280976477),
(138, 2, 20, 4, 1280974083),
(139, 1, 21, 1, 0),
(140, 2, 21, 1, 0),
(141, 1, 22, 4, 0),
(142, 2, 22, 2, 0),
(143, 4, 22, 1, 0),
(144, 8, 22, 2, 0),
(145, 18, 20, 4, 0),
(146, 4, 20, 1, 0),
(147, 8, 20, 3, 0),
(148, 5, 20, 4, 1280975281),
(150, 1, 23, 3, 0),
(151, 2, 23, 1, 0),
(152, 5, 23, 1, 0),
(153, 8, 23, 1, 0),
(154, 4, 19, 1, 0),
(155, 18, 19, 1, 0),
(156, 5, 22, 2, 0),
(157, 1, 24, 3, 0),
(158, 2, 24, 2, 0),
(159, 1, 25, 2, 1280967359),
(160, 2, 25, 2, 0),
(161, 18, 23, 0, 1280932964),
(162, 18, 25, 1, 0),
(163, 5, 25, 1, 0),
(164, 8, 25, 1, 0),
(165, 18, 24, 2, 0),
(166, 4, 25, 1, 0),
(167, 5, 24, 1, 0),
(168, 8, 24, 0, 1280958819);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_planetresearch`
--

CREATE TABLE IF NOT EXISTS `tbl_planetresearch` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_ResearchId` int(9) NOT NULL,
  `i_PlanetId` int(9) NOT NULL,
  `i_Level` int(3) NOT NULL,
  `i_Inbuild` int(11) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Daten für Tabelle `tbl_planetresearch`
--

INSERT INTO `tbl_planetresearch` (`i_Id`, `i_ResearchId`, `i_PlanetId`, `i_Level`, `i_Inbuild`) VALUES
(26, 14, 2, 1, 0),
(25, 13, 2, 1, 0),
(24, 3, 2, 1, 0),
(23, 2, 2, 1, 0),
(22, 1, 2, 1, 1280857817),
(21, 17, 2, 1, 1281154821),
(20, 2, 1, 1, 0),
(17, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_quote`
--

CREATE TABLE IF NOT EXISTS `tbl_quote` (
  `i_Id` int(3) NOT NULL auto_increment,
  `t_Quote` text NOT NULL,
  `s_Autor` varchar(90) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Daten für Tabelle `tbl_quote`
--

INSERT INTO `tbl_quote` (`i_Id`, `t_Quote`, `s_Autor`) VALUES
(1, 'Der Beweis von Heldentum liegt nicht im Gewinnen einer Schlacht, sondern im Ertragen einer Niederlage.', 'David Lloyd George'),
(2, 'Es ist besser, ein einziges kleines Licht  anzuznden, als die Dunkelheit zu verfluchen.', 'Konfuzius'),
(3, 'Die Welt wird nicht bedroht von den Menschen, die böse sind, sondern von denen, die das Böse zulassen.', 'Albert Einstein'),
(4, 'Irrtümer entspringen nicht allein daher, weil man gewisse Dinge nicht weiß, sondern weil man sich zu urteilen unternimmt, obgleich man doch nicht alles weiß, was dazu erfordert wird.', 'Immanuel Kant'),
(5, 'Was du liebst, lass frei. Kommt es zurück, gehört es dir - für immer.', 'Konfuzius'),
(6, 'Du und ich: Wir sind eins. Ich kann dir nicht wehtun, ohne mich zu verletzen.', 'Mahatma Gandhi'),
(7, 'Reich wird man erst durch Dinge, die man nicht begehrt.', 'Mahatma Gandhi'),
(8, 'Wir leben in einem gefährlichen Zeitalter. Der Mensch  beherrscht die Natur, bevor er gelernt hat, sich selbst zu beherrschen.', 'Albert Schweitzer'),
(9, 'Mit dem Wissen wächst der Zweifel.', 'Johann Wolfgang von Goethe'),
(10, 'Sprächen die Menschen nur von Dingen, von denen sie etwas verstehen, die Stille wäre unerträglich.', 'Anonym'),
(11, 'Fantasie haben heißt nicht, sich etwas auszudenken, es heißt, sich aus den Dingen etwas zu machen.', 'Thomas Mann'),
(12, 'Das große Karthago führte drei Kriege. Nach dem ersten war es noch mächtig. Nach dem zweiten war es noch bewohnbar. Nach dem dritten war es nicht mehr zu finden.', 'Bertolt Brecht'),
(13, 'Wenn die anderen glauben, man ist am Ende, so muss man erst richtig anfangen.', 'Konrad Adenauer'),
(14, 'Es gibt keinen Weg zum Frieden, denn Frieden ist der Weg.', 'Mahatma Gandhi'),
(15, 'Je öfter du unterwegs fragst, wie weit du noch zu gehen hast, umso länger wird dir der Weg erscheinen.', 'Australisches Sprichwort'),
(16, 'Auch der längste Weg beginnt mit dem ersten Schritt.', 'Chinesische Weisheit'),
(17, 'Die meisten unserer Fehler erkennen und legen wir erst dann ab, wenn wir sie an anderen entdeckt haben.', 'Karl Gutzkow'),
(18, 'Erfahrung vermehrt unsere Weisheit, verringert aber nicht unsere Torheiten.', 'Josh Billings'),
(19, 'Es ist nicht genug zu wissen  - man muss auch anwenden. Es ist nicht genug zu wollen - man muss auch tun.', 'Johann Wolfgang von Goethe'),
(20, 'Die Erfahrung ist wie eine Laterne im Rücken; sie beleuchtet stets nur das Stück Weg, das wir bereits hinter uns haben.', 'Konfuzius'),
(21, 'Allzu Straff gespannt, zerspringt der Bogen', 'Schiller, Wilhelm Tell'),
(22, 'Trifft dich des Schicksals Schlag, so mach es wie der Ball: / Je stärker man ihn schlägt, je Höher fliegt er all', 'Rückert, Weishei des Brahmanen'),
(23, 'Wer mit dem Leben spielt, Kommt nie zurecht. Wer sich nicht selbst befiehlt, Bleibt immer ein Kencht', 'Goethe, Zahme Xenien'),
(24, 'Begegnet uns jemand, der uns Dank schuldig ist, gleich fällt es uns ein. Wie oft können wir jemandem begegnen. dem wir Dank schuldig sind, ohne daran zu denken.', 'Goethe'),
(25, 'Dankbarkeit gehört zu den Schulden, die jeder Mensch hat, aber nur die wenigsten tragen sie ab.', 'Sprichwort'),
(26, 'Durch Demütigungen habe ich mehr gelernt als durch alle Siege.', 'Kaiser Wilhelm I.'),
(27, 'Man sollte die Dinge so nehmen, wie sie kommen Aber man sollte dafür sorgen, das die Dinge so kommen wie man sie nehmen möchte', 'Curt Goetz'),
(28, 'Der beste Mensch wird manchmal zornig, kein Liebespaar kann immer Kosen- Die schönsten Rosen selbst sind dornig, doch schlimm sind Dornen ohne Rosen.', 'Bodenstedt'),
(29, 'Ehre kannst du nirgends borgen, dafür musst du selber sorgen.', 'Sinnspruch'),
(30, 'Die Einsamkeit ist ein dichter Mantel, und doch friert das Herz darunter.', 'Kolbenbeyer, Amor dei'),
(31, 'Gebildet ist, wer weiß, wo er findet, was er nicht weiß.\r\n', 'Georg Simmel'),
(32, 'Der Krieg hat einen sehr langen Arm. Noch lange, nachdem er vorbei ist, holt er sich seine Opfer', 'Martin Kessel'),
(33, 'Was nützt es einem Menschen wenn er die Ganze Welt gewinnt, sich dabei aber selbst verliert und Schaden nimmt.', ''),
(34, 'Nicht was wir ERLEBEN, sondern wie wir empfinden,was wir erleben, macht unser Schicksal aus.', 'Robert Hamerling'),
(35, 'Fallen ist keine Schande, aber liegen bleiben', 'Sprichwort');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_research`
--

CREATE TABLE IF NOT EXISTS `tbl_research` (
  `i_Id` int(9) NOT NULL auto_increment,
  `s_Name` varchar(90) NOT NULL,
  `t_Desctiprion` text NOT NULL,
  `s_Picture` varchar(90) NOT NULL,
  `i_Type` int(3) NOT NULL,
  `i_BuildTime` int(6) NOT NULL,
  `f_Multiplicator` int(6) NOT NULL,
  `i_BuildCredits` int(6) NOT NULL,
  `i_BuildMetall` int(6) NOT NULL,
  `i_BuildCrystal` int(6) NOT NULL,
  `i_BuildHydrogen` int(6) NOT NULL,
  `i_BuildBioMass` int(6) NOT NULL,
  `i_NeedLevel` int(3) NOT NULL,
  `i_Need` int(3) NOT NULL,
  `i_MaxLevel` int(3) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Daten für Tabelle `tbl_research`
--

INSERT INTO `tbl_research` (`i_Id`, `s_Name`, `t_Desctiprion`, `s_Picture`, `i_Type`, `i_BuildTime`, `f_Multiplicator`, `i_BuildCredits`, `i_BuildMetall`, `i_BuildCrystal`, `i_BuildHydrogen`, `i_BuildBioMass`, `i_NeedLevel`, `i_Need`, `i_MaxLevel`) VALUES
(1, 'Waffensysteme', 'Legt die Grundlage für all ihre zukünftigen Waffen wie z.B. Laser Kanonen, Torpedos oder Partikel Kanonen', '', 1, 100, 25, 100, 200, 200, 200, 200, 0, 0, 5),
(2, 'Analytik', 'Legt den Grundstein für die Entwicklung eines Scanners', '', 1, 1000, 35, 2000, 500, 2000, 5000, 250, 0, 0, 5),
(3, 'Antriebstechnik', 'Die Grundlagen Forschung für die Antriebstechnik', '', 2, 1000, 30, 1500, 500, 1500, 3000, 1500, 0, 0, 5),
(4, 'Laser Technik', 'Beschreibung', '', 3, 15000, 45, 2000, 2000, 2500, 500, 1000, 1, 2, 5),
(5, 'Molekularphysik', 'Beschreibung', '', 3, 1500, 40, 2000, 2000, 2000, 500, 1000, 1, 2, 5),
(6, 'Sprengstofftechnik', 'Beschreibung', '', 3, 15000, 35, 20000, 25000, 15000, 5000, 25000, 1, 2, 5),
(7, 'Laser Kanonen', 'Durch Laser kanonen wird der schaden gegen Einheiten die nicht mit einem Energieschild ausgerüstet sind um 35% erhöht', '', 4, 15920, 35, 20000, 25000, 18000, 2500, 20000, 4, 5, 1),
(8, 'Partikel Kanonen', '25% Schaden auf Einheiten die mit einem Energieschild ausgerüstet sind', '', 4, 1296, 30, 25000, 30000, 15000, 10000, 15000, 5, 5, 1),
(9, 'Torpedos', 'Setzt die Gegnerische Panzerung auf 100 herunter', '', 4, 1728, 35, 25000, 30000, 20000, 15000, 25000, 6, 5, 1),
(10, 'Scanner', 'Mithilfe des Scanners können feindliche getarnte schiffe entdeckt werden', '', 7, 2640, 30, 5000, 1500, 4500, 4000, 0, 2, 10, 1),
(11, 'Triebwerke', 'Einheiten die mit Triebwerken ausgestattet sind fliegen 50% schneller', '', 6, 1296, 45, 5000, 4500, 2500, 7000, 2500, 3, 5, 1),
(13, 'Panzerung', 'Die Panzerung der Einheit wird um 20% Gesteigert', '', 0, 2500, 45, 25000, 50000, 15000, 5000, 10000, 0, 0, 1),
(14, 'Steahlt', 'Ihre Einheiten werden für Einheiten ohne Scanner nicht sichtbar sein', '', 0, 2500, 55, 75000, 5000, 50000, 60000, 50000, 0, 0, 1),
(15, 'Energieschield', 'Ihre Einheit erleidet 25% weniger schaden', '', 0, 2500, 60, 35000, 25000, 30000, 20000, 35000, 0, 0, 1),
(16, 'Bessere Legierung', 'Die Trefferpunkte Ihrer Einheit werden um 30% erhöht', '', 0, 1500, 80, 10000, 15000, 15000, 12000, 15000, 0, 0, 1),
(17, 'Besatzungstrupp', 'Mit dem Besatzungstrupp ist es möglich Feindliche Planeten zu übernehmen. ', '', 0, 10000, 35, 9000, 9000, 9000, 9000, 9000, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_shipplanet`
--

CREATE TABLE IF NOT EXISTS `tbl_shipplanet` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_PlanetId` int(9) NOT NULL,
  `i_ShipId` int(9) NOT NULL,
  `i_Count` int(9) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1426 ;

--
-- Daten für Tabelle `tbl_shipplanet`
--

INSERT INTO `tbl_shipplanet` (`i_Id`, `i_PlanetId`, `i_ShipId`, `i_Count`) VALUES
(1046, 15, 5, 0),
(1297, 5, 4, 0),
(1227, 2, 4, 0),
(1353, 3, 5, 0),
(1226, 2, 3, 0),
(1366, 5, 6, 1),
(429, 6, 3, 0),
(1259, 7, 4, 0),
(431, 6, 5, 0),
(432, 6, 6, 0),
(428, 6, 2, 0),
(1257, 7, 2, 0),
(1258, 7, 3, 0),
(1045, 15, 4, 0),
(1352, 3, 4, 146848),
(852, 2, 7, 4),
(484, 6, 2, 1),
(1400, 5, 6, 20),
(951, 9, 2, 0),
(916, 7, 7, 10),
(1351, 3, 3, 0),
(1350, 3, 2, 950000),
(1088, 9, 6, 2),
(1087, 9, 6, 5),
(1399, 5, 6, 15),
(1367, 5, 6, 129),
(1398, 5, 6, 10),
(1043, 15, 2, 0),
(1397, 5, 6, 120),
(1396, 5, 6, 25),
(509, 10, 6, 0),
(508, 10, 5, 0),
(507, 10, 4, 0),
(506, 10, 3, 0),
(505, 10, 2, 0),
(1411, 12, 4, 0),
(1421, 1, 3, 20),
(1404, 11, 4, 0),
(430, 6, 4, 34),
(1409, 12, 2, 0),
(1391, 5, 6, 25),
(1228, 2, 5, 100),
(1094, 1, 8, 5),
(1422, 1, 4, 0),
(953, 9, 4, 0),
(482, 6, 4, 6),
(1390, 5, 6, 5),
(1295, 5, 2, 0),
(1389, 5, 6, 1),
(1047, 15, 6, 0),
(1403, 11, 3, 0),
(1354, 3, 6, 500000),
(1044, 15, 3, 0),
(1385, 5, 6, 55),
(1423, 1, 5, 0),
(1052, 2, 8, 10),
(955, 9, 6, 0),
(952, 9, 3, 1),
(1402, 11, 2, 0),
(1420, 1, 2, 29),
(1260, 7, 5, 0),
(1296, 5, 3, 0),
(1298, 5, 5, 0),
(1225, 2, 2, 0),
(1410, 12, 3, 0),
(1405, 11, 5, 0),
(954, 9, 5, 0),
(1376, 5, 6, 110),
(1356, 5, 6, 30),
(1355, 5, 6, 1),
(1314, 5, 6, 20),
(1313, 5, 6, 1),
(1312, 5, 6, 20),
(1338, 16, 5, 0),
(1337, 16, 4, 0),
(1335, 16, 2, 0),
(1339, 16, 6, 1),
(1419, 1, 8, 10),
(1407, 11, 6, 7),
(1425, 1, 6, 10),
(1424, 1, 6, 0),
(1416, 1, 8, 1),
(1412, 12, 5, 0),
(1406, 11, 6, 0),
(1415, 1, 7, 1),
(1336, 16, 3, 7850),
(1414, 11, 6, 20),
(1413, 12, 6, 0),
(1299, 5, 6, 93),
(1261, 7, 6, 0),
(1229, 2, 6, 88);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_ships`
--

CREATE TABLE IF NOT EXISTS `tbl_ships` (
  `i_Id` int(6) NOT NULL auto_increment,
  `s_Name` varchar(60) NOT NULL,
  `i_Speed` int(6) NOT NULL,
  `i_Amor` int(6) NOT NULL,
  `i_Dmg` int(6) NOT NULL,
  `i_Health` int(11) NOT NULL,
  `i_Credits` int(6) NOT NULL,
  `i_Metall` int(6) NOT NULL,
  `i_Cristal` int(6) NOT NULL,
  `t_Hydrogen` int(6) NOT NULL,
  `t_Buildtime` int(9) NOT NULL,
  `i_Storage` int(6) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `tbl_ships`
--

INSERT INTO `tbl_ships` (`i_Id`, `s_Name`, `i_Speed`, `i_Amor`, `i_Dmg`, `i_Health`, `i_Credits`, `i_Metall`, `i_Cristal`, `t_Hydrogen`, `t_Buildtime`, `i_Storage`) VALUES
(2, 'Drohne', 1000, 1, 1, 50, 100, 100, 50, 0, 90, 100),
(3, 'Jäger', 250, 50, 25, 150, 150, 200, 150, 200, 120, 50),
(4, 'Schwerer Jäger', 200, 100, 50, 200, 250, 250, 250, 300, 150, 100),
(5, 'Bomber', 200, 100, 150, 100, 450, 350, 250, 350, 240, 450),
(6, 'Kampfschiff', 100, 250, 200, 300, 550, 600, 450, 400, 360, 550),
(7, 'Kleiner Transporter', 200, 1, 10, 50, 200, 200, 150, 200, 150, 500),
(8, 'Großer Transporter', 250, 1, 15, 150, 400, 400, 350, 400, 300, 1000);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_shipsbuild`
--

CREATE TABLE IF NOT EXISTS `tbl_shipsbuild` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_PlanetId` int(9) NOT NULL,
  `i_UnitId` int(9) NOT NULL,
  `i_Count` int(6) NOT NULL,
  `i_StartTime` int(13) NOT NULL,
  `i_BuildTime` int(13) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=657 ;

--
-- Daten für Tabelle `tbl_shipsbuild`
--

INSERT INTO `tbl_shipsbuild` (`i_Id`, `i_PlanetId`, `i_UnitId`, `i_Count`, `i_StartTime`, `i_BuildTime`) VALUES
(152, 6, 4, 8, 1273682891, 150),
(650, 5, 6, 10, 1278106341, 360),
(648, 12, 6, 1, 1277907078, 360),
(630, 7, 6, 18, 1277332129, 360),
(647, 12, 6, 35, 1277907070, 360),
(441, 15, 3, 1, 1274898798, 120),
(440, 15, 3, 10, 1274898782, 120),
(649, 5, 6, 120, 1278106302, 360),
(439, 15, 3, 10, 1274898775, 120);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_union`
--

CREATE TABLE IF NOT EXISTS `tbl_union` (
  `i_Id` int(9) NOT NULL auto_increment,
  `s_Name` varchar(90) NOT NULL,
  `t_Units` text NOT NULL,
  `i_DMG` int(9) NOT NULL,
  `i_Amor` int(9) NOT NULL,
  `i_Speed` int(9) NOT NULL,
  `i_Healts` int(9) NOT NULL,
  `i_UserId` int(9) NOT NULL,
  `i_ExtentionOne` int(3) NOT NULL,
  `i_ExtentionTwo` int(3) NOT NULL,
  `i_X` float NOT NULL,
  `i_Y` float NOT NULL,
  `f_State` float NOT NULL,
  `i_Storage` int(9) NOT NULL,
  `t_Stored` text NOT NULL,
  `i_Experience` int(9) NOT NULL,
  `i_Level` int(2) NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=162 ;

--
-- Daten für Tabelle `tbl_union`
--

INSERT INTO `tbl_union` (`i_Id`, `s_Name`, `t_Units`, `i_DMG`, `i_Amor`, `i_Speed`, `i_Healts`, `i_UserId`, `i_ExtentionOne`, `i_ExtentionTwo`, `i_X`, `i_Y`, `f_State`, `i_Storage`, `t_Stored`, `i_Experience`, `i_Level`) VALUES
(160, 'Spioner', 'd:0;sh:0;hh:0;b:5;bs:448', 90350, 248, 100, 134900, 62, 1, 11, 3765, 2833, 1, 248650, 't:63413.068316881;m:0;b:0;c:0;', 0, 0),
(76, 'LassMichInRuhe', 'd:0;sh:191;hh:0;b:0;bs:16', 7975, 65, 100, 33450, 55, 2, 11, 3960, 2898, 0.727153, 18350, 't:18350;m:0;b:0;c:0;', 85450, 6),
(110, 'HausUndHofHund', 'd:0;sh:41;hh:0;b:6;bs:29', 7725, 130, 100, 15450, 55, 1, 9, 3963, 2897, 0.979001, 20700, 't:4591.8062330775;m:0;b:0;c:0;', 28250, 3),
(21, 'DefSupr_2', 'd:0;sh:0;hh:0;b:0;bs:6', 1200, 250, 100, 1800, 55, 2, 11, 3959, 2898, 0.285638, 3300, 't:3300;m:0;b:0;c:0;', 65200, 6),
(25, 'DefOf', 'd:0;sh:1;hh:0;b:0;bs:1', 225, 150, 200, 450, 55, 1, 11, 3959.45, 2899.04, 0.273532, 600, 't:600;m:0;b:0;c:0;', 65000, 6),
(145, 'Saue', 'd:0;sh:0;hh:0;b:8;bs:771', 155400, 248, 100, 232100, 55, 2, 11, 3964, 2906, 0.971265, 427650, 't:32079.649659031;m:0;b:0;c:0;', 76750, 6),
(102, 'LevelN', 'd:0;sh:46;hh:0;b:26;bs:0', 5050, 68, 200, 9500, 62, 2, 9, 344, 7297, 0.976383, 14000, 't:11855.635380614;m:0;b:0;c:0;', 7050, 2),
(156, '50', 'd:0;sh:0;hh:50;b:0;bs:0', 2500, 100, 200, 10000, 53, 0, 0, 2381, 716, 0.944055, 5000, 't:0;', 0, 0),
(149, 'angriff1', 'd:0;sh:0;hh:1000;b:0;bs:0', 50000, 100, 200, 200000, 53, 5, 10, 2722, 693, 0.7385, 100000, 't:0;', 300000, 11),
(161, 'Lars', 'd:0;sh:0;hh:0;b:0;bs:90', 18250, 210, 100, 29450, 52, 1, 11, 2745.77, 4227.11, 1, 66000, 't:0;', 0, 0),
(106, 'Leveln', 'd:0;sh:9;hh:0;b:34;bs:3', 5925, 100, 100, 5650, 61, 1, 9, 3801.85, 7972.81, 0.706756, 17400, 't:14757.933940381;m:0;b:0;c:0;', 18050, 3),
(88, 'Opfer', 'd:0;sh:67;hh:0;b:0;bs:0', 1675, 50, 250, 10050, 55, 1, 9, 3952, 2903, 0.996012, 3350, 't:3318.5888775909;m:0;b:0;c:0;', 31600, 6),
(150, 'angriff 2', 'd:0;sh:0;hh:1000;b:0;bs:0', 50000, 100, 200, 200000, 53, 5, 8, 2826, 552, 0.698068, 100000, 't:0;', 300000, 11),
(151, 'angriff 3', 'd:0;sh:0;hh:1000;b:0;bs:0', 50000, 100, 200, 200000, 53, 5, 8, 2731, 337, 0.742549, 100000, 't:0;', 300000, 11);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_unittask`
--

CREATE TABLE IF NOT EXISTS `tbl_unittask` (
  `i_Id` int(9) NOT NULL auto_increment,
  `i_X` int(9) NOT NULL,
  `i_Y` int(9) NOT NULL,
  `i_Refresh` double NOT NULL,
  `i_UnitId` int(9) NOT NULL,
  `t_Action` text NOT NULL,
  PRIMARY KEY  (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=730 ;

--
-- Daten für Tabelle `tbl_unittask`
--

INSERT INTO `tbl_unittask` (`i_Id`, `i_X`, `i_Y`, `i_Refresh`, `i_UnitId`, `t_Action`) VALUES
(321, 3943, 2920, 1273616757.2338, 45, 'move'),
(716, 3606, 7976, 1279325473.7291, 142, 'move'),
(571, 3874, 3121, 1274660120.7639, 111, 'move'),
(399, 3922, 2774, 1274011761.4082, 37, 'move'),
(463, 3884, 2762, 1274096722.3377, 59, 'move'),
(396, 3891, 2795, 1274010829.1603, 51, 'move'),
(481, 3943, 2878, 1274127528.5613, 86, 'move'),
(567, 7232, 2599, 1274649414.6805, 112, 'move'),
(728, 331, 7630, 1280970684.48, 161, 'move');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `s_Name` varchar(50) character set latin1 NOT NULL,
  `s_Email` varchar(100) character set latin1 NOT NULL,
  `s_Pass` varchar(50) character set latin1 NOT NULL,
  `i_Login` int(20) NOT NULL,
  `i_Id` int(6) NOT NULL auto_increment,
  `i_Level` int(3) NOT NULL default '0',
  `i_Experience` int(90) NOT NULL,
  `i_Status` int(1) NOT NULL,
  `i_Credits` varchar(45) collate utf8_unicode_ci NOT NULL,
  `i_Refresh` varchar(30) collate utf8_unicode_ci NOT NULL,
  `i_Storage` int(9) NOT NULL,
  PRIMARY KEY  (`i_Id`),
  UNIQUE KEY `S_Name` (`s_Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=76 ;

--
-- Daten für Tabelle `tbl_user`
--

INSERT INTO `tbl_user` (`s_Name`, `s_Email`, `s_Pass`, `i_Login`, `i_Id`, `i_Level`, `i_Experience`, `i_Status`, `i_Credits`, `i_Refresh`, `i_Storage`) VALUES
('Zwosen', 'sne900@hotmail.com', '15b87d63c66c5f5e2cf3c14f2822632a', 0, 68, 1, 0, 0, '160.679823241', '1280917934.37', 0),
('test2', '12345', 'e10adc3949ba59abbe56e057f20f883e', 1280598349, 53, 4, 600, 0, '20000', '1280598349.1265', 0),
('ReMaker', '12345', 'e10adc3949ba59abbe56e057f20f883e', 0, 52, 15, 439600, 0, '71712.8098046', '1280970729.98', 0),
('SilanCer', 'nunu@nu.de', '7ad842ccc92ad8a5ae4e398e69e78939', 1259782627, 54, 1, 0, 0, '501.58665386835', '1259782627.2341', 0),
('Ishmael', 'm@web.de', '9e287991524b84ecb9d256c3fcf3b500', 1278106794, 55, 18, 165950, 0, '18663.230528359', '1278106794.0608', 0),
('faroth', 'faroth_clan@yahoo.de', '577edf131054bd4feb84311fc693298f', 0, 56, 1, 0, 0, '131.94309469062', '1273682895.6198', 0),
('blubb', 'blubb@blubb.de', 'e10adc3949ba59abbe56e057f20f883e', 1277332144, 57, 2, 3500, 0, '103.03734199207', '1277332144.9589', 0),
('Sankeshit', 'Snakeshit4@web.de', '3668988178e35457e6ba3487f9a398ef', 1278157954, 60, 1, 0, 0, '1500', '1278157954.444', 0),
('Bernde', 'hallo@der.de', '7655d0996e32375f18d524e6580bbdf1', 1274028470, 58, 1, 0, 0, '592.28038148747', '1274028470.4909', 0),
('DeEMoN', 'herzi.is.doof@gmx.de', 'a73fb870ad4d37d4c394de34744318f3', 0, 59, 3, 18550, 0, '8031.2197469279', '1274898740.2776', 0),
('DaMischa', 'da.mischa@hotmail.com', 'a40944fd8860e71c77669db6590209ca', 1275592389, 63, 1, 0, 0, '650.29083540042', '1275592389.994', 0),
('Knarf', 'm@m.ru', '9e287991524b84ecb9d256c3fcf3b500', 0, 62, 4, 11550, 0, '247.29363641144', '1277907211.7405', 0),
('Narf', 'm@m.ru', '9e287991524b84ecb9d256c3fcf3b500', 1277909149, 61, 4, 33850, 0, '2852.6977744792', '1277909149.9681', 0),
('Opfer', 'opfer.de', '1c74739428393e4adc7a3f77e9e15ada', 0, 64, 1, 0, 0, '501.5421665046', '1274295507.93', 0),
('Opfer2', 'opfer2.de', '656cb365f1ef2be61fb2c856624f04d3', 0, 65, 1, 0, 0, '109.6015631921', '1274898896.5198', 0),
('Pate', 'patemasters@hotmail.de', 'b36d331451a61eb2d76860e00c347396', 1280932578, 73, 1, 0, 0, '103.985232444', '1280932578.83', 0),
('Knochen', 'robertsiegel@freenet.de', 'fbf298ebb840e62a41c9104c4a794b64', 1280941098, 72, 1, 0, 0, '682.844967221', '1280941098.22', 0),
('muelli', 'misterwurzel@yahoo.de', '827ccb0eea8a706c4c34a16891f84e7b', 1277293146, 67, 1, 0, 0, '2500.33927362495', '1277293146.3794', 0),
('Revenger', 'stephanfromm@gmx.de', '88f16554ffa67fe84c27e08167cbd8e2', 1280958140, 74, 1, 0, 0, '81.041724786', '1280958140.96', 0),
('FreeZa', 'Malarkey22@web.de', '262ef1e165ee74d51f9d6c3bdec69bbc', 0, 75, 1, 0, 0, '19.884883606', '1280964366.77', 0);

CREATE TABLE IF NOT EXISTS `tbl_click` (
  `i_Id` int(9) NOT NULL AUTO_INCREMENT,
  `s_Ip` varchar(45) NOT NULL,
  `d_Date` datetime NOT NULL,
  `t_ParamString` text NOT NULL,
  `i_UserId` int(9) NOT NULL,
  PRIMARY KEY (`i_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5589 ;
