-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2022 at 12:14 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ntpacc`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(2) DEFAULT NULL,
  `country` varchar(44) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `country`) VALUES
(1, 'AF', 'Avganistan'),
(2, 'AX', 'Alandska ostrva'),
(3, 'AL', 'Albanija'),
(4, 'DZ', 'Alžir'),
(5, 'AS', 'Američka Samoa'),
(6, 'AD', 'Andora'),
(7, 'AO', 'Angola'),
(8, 'AI', 'Angvila'),
(9, 'AQ', 'Antarktika'),
(10, 'AG', 'Antigva i Barbuda'),
(11, 'AR', 'Argentina'),
(12, 'AM', 'Jermenija'),
(13, 'AW', 'Aruba'),
(14, 'AU', 'Australija'),
(15, 'AT', 'Austrija'),
(16, 'AZ', 'Azerbejdžan'),
(17, 'BS', 'Bahami'),
(18, 'BH', 'Bahrein'),
(19, 'BD', 'Bangladeš'),
(20, 'BB', 'Barbados'),
(21, 'BY', 'Belorusija'),
(22, 'BE', 'Belgija'),
(23, 'BZ', 'Belize'),
(24, 'BJ', 'Benin'),
(25, 'BM', 'Bermuda'),
(26, 'BT', 'Butan'),
(27, 'BO', 'Bolivija'),
(28, 'BQ', 'Bonaire #  Sint Eustatius i Saba'),
(29, 'BA', 'Bosna i Hercegovina'),
(30, 'BW', 'Bocvana'),
(31, 'BV', 'Ostrvo Bouvet'),
(32, 'BR', 'Brazil'),
(33, 'IO', 'Britanska teritorija Indijskog okeana'),
(34, 'BN', 'Brunej'),
(35, 'BG', 'Bugarska'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'KH', 'Kambodža'),
(39, 'CM', 'Kamerun'),
(40, 'CA', 'Kanada'),
(41, 'CV', 'Zelenortska Ostrva'),
(42, 'KY', 'Kajmanska ostrva'),
(43, 'CF', 'Centralna Afrička Republika'),
(44, 'TD', 'Čad'),
(45, 'CL', 'Čile'),
(46, 'CN', 'Kina'),
(47, 'CX', 'Božićno ostrvo'),
(48, 'CC', 'Kokosova (Kiling) ostrva'),
(49, 'CO', 'Kolumbija'),
(50, 'KM', 'Komori'),
(51, 'CG', 'Kongo'),
(52, 'CD', 'Kongo  #  Demokratska Republika Kongo'),
(53, 'CK', 'Kukova ostrva'),
(54, 'CR', 'Kostarika'),
(55, 'CI', 'Obala Slonovače'),
(56, 'HR', 'Hrvatska'),
(57, 'CU', 'Kuba'),
(58, 'CW', 'Curacao'),
(59, 'CY', 'Kipar'),
(60, 'CZ', 'Češka'),
(61, 'DK', 'Danska'),
(62, 'DJ', 'Džibuti'),
(63, 'DM', 'Dominika'),
(64, 'DO', 'Dominikanska republika'),
(65, 'EC', 'Ekvador'),
(66, 'EG', 'Egipat'),
(67, 'SV', 'El Salvador'),
(68, 'GQ', 'Ekvatorijalna Gvineja'),
(69, 'ER', 'Eritreja'),
(70, 'EE', 'Estonija'),
(71, 'ET', 'Etiopija'),
(72, 'FK', 'Foklandska ostrva (Malvinas)'),
(73, 'FO', 'Farska Ostrva'),
(74, 'FJ', 'Fidži'),
(75, 'FI', 'Finska'),
(76, 'FR', 'Francuska'),
(77, 'GF', 'Francuska Gvajana'),
(78, 'PF', 'Francuska Polinezija'),
(79, 'TF', 'Francuske južne teritorije'),
(80, 'GA', 'Gabon'),
(81, 'GM', 'Gambija'),
(82, 'GE', 'Georgia'),
(83, 'DE', 'Nemačka'),
(84, 'GH', 'Gana'),
(85, 'GI', 'Gibraltar'),
(86, 'GR', 'Grčka'),
(87, 'GL', 'Grenland'),
(88, 'GD', 'Grenada'),
(89, 'GP', 'Guadeloupe'),
(90, 'GU', 'Guam'),
(91, 'GT', 'Gvatemala'),
(92, 'GG', 'Guernsei'),
(93, 'GN', 'Gvineja'),
(94, 'GW', 'Gvineja Bisau'),
(95, 'GY', 'Gvajana'),
(96, 'HT', 'Haiti'),
(97, 'HM', 'Ostrvo Heard i ostrva McDonald'),
(98, 'VA', 'Sveta Stolica (država Vatikan)'),
(99, 'HN', 'Honduras'),
(100, 'HK', 'Hong Kong'),
(101, 'HU', 'Mađarska'),
(102, 'IS', 'Island'),
(103, 'IN', 'Indija'),
(104, 'ID', 'Indonezija'),
(105, 'IR', 'Iran  #  Islamska Republika'),
(106, 'IQ', 'Irak'),
(107, 'IE', 'Irska'),
(108, 'IM', 'Ostrvo Man'),
(109, 'IL', 'Izrael'),
(110, 'IT', 'Italija'),
(111, 'JM', 'Jamajka'),
(112, 'JP', 'Japan'),
(113, 'JE', 'Jersei'),
(114, 'JO', 'Jordan'),
(115, 'KZ', 'Kazahstan'),
(116, 'KE', 'Kenija'),
(117, 'KI', 'Kiribati'),
(118, 'KP', 'Koreja  #  Demokratska Narodna Republika'),
(119, 'KR', 'Koreja  #  Republika'),
(120, 'XK', 'Kosovo'),
(121, 'KW', 'Kuvajt'),
(122, 'KG', 'Kirgistan'),
(123, 'LA', 'Lao Narodna Demokratska Republika'),
(124, 'LV', 'Letonija'),
(125, 'LB', 'Libanon'),
(126, 'LS', 'Lesoto'),
(127, 'LR', 'Liberija'),
(128, 'LY', 'Libijska Arapska Džamahirija'),
(129, 'LI', 'Lihtenštajn'),
(130, 'LT', 'Litvanija'),
(131, 'LU', 'Luksemburg'),
(132, 'MO', 'Makao'),
(133, 'MK', 'Makedonija  #  Bivša Jugoslovenska Republika'),
(134, 'MG', 'Madagaskar'),
(135, 'MW', 'Malavi'),
(136, 'MY', 'Malezija'),
(137, 'MV', 'Maldivi'),
(138, 'ML', 'Mali'),
(139, 'MT', 'Malta'),
(140, 'MH', 'Maršalska ostrva'),
(141, 'MQ', 'Martinikue'),
(142, 'MR', 'Mauritanija'),
(143, 'MU', 'Mauricijus'),
(144, 'YT', 'Maiotte'),
(145, 'MX', 'Meksiko'),
(146, 'FM', 'Mikronezija  #  Federativne Države'),
(147, 'MD', 'Moldavija  #  Republika'),
(148, 'MC', 'Monako'),
(149, 'MN', 'Mongolija'),
(150, 'ME', 'Crna Gora'),
(151, 'MS', 'Montserrat'),
(152, 'MA', 'Maroko'),
(153, 'MZ', 'Mozambik'),
(154, 'MM', 'Mjanmar'),
(155, 'NA', 'Namibija'),
(156, 'NR', 'Nauru'),
(157, 'NP', 'Nepal'),
(158, 'NL', 'Nizozemska'),
(159, 'AN', 'Holandski Antili'),
(160, 'NC', 'Nova Kaledonija'),
(161, 'NZ', 'Novi Zeland'),
(162, 'NI', 'Nikaragva'),
(163, 'NE', 'Niger'),
(164, 'NG', 'Nigerija'),
(165, 'NU', 'Niue'),
(166, 'NF', 'Ostrvo Norfolk'),
(167, 'MP', 'Severna Marijanska ostrva'),
(168, 'NO', 'Norveška'),
(169, 'OM', 'Oman'),
(170, 'PK', 'Pakistan'),
(171, 'PW', 'Palau'),
(172, 'PS', 'Palestinska teritorija  #  okupirana'),
(173, 'PA', 'Panama'),
(174, 'PG', 'Papua Nova Gvineja'),
(175, 'PY', 'Paragvaj'),
(176, 'PE', 'Peru'),
(177, 'PH', 'Filipini'),
(178, 'PN', 'Pitcairn'),
(179, 'PL', 'Poljska'),
(180, 'PT', 'Portugal'),
(181, 'PR', 'Portoriko'),
(182, 'QA', 'Katar'),
(183, 'RE', 'Reunion'),
(184, 'RO', 'Rumunija'),
(185, 'RU', 'Ruska Federacija'),
(186, 'RW', 'Ruanda'),
(187, 'BL', 'Sveti Bartelemi'),
(188, 'SH', 'Sveta Jelena'),
(189, 'KN', 'Sent Kits i Nevis'),
(190, 'LC', 'Sveta Lucija'),
(191, 'MF', 'Sveti Martin'),
(192, 'PM', 'Sveti Pjer i Mikelon'),
(193, 'VC', 'Sveti Vinsent i Grenadini'),
(194, 'WS', 'Samoa'),
(195, 'SM', 'San-Marino'),
(196, 'ST', 'Sao Tome i Principe'),
(197, 'SA', 'Saudijska Arabija'),
(198, 'SN', 'Senegal'),
(199, 'RS', 'Srbija'),
(200, 'CS', 'Srbija i Crna Gora'),
(201, 'SC', 'Sejšeli'),
(202, 'SL', 'Sijera Leone'),
(203, 'SG', 'Singapur'),
(204, 'SX', 'Sveti Martin'),
(205, 'SK', 'Slovačka'),
(206, 'SI', 'Slovenija'),
(207, 'SB', 'Solomonska ostrva'),
(208, 'SO', 'Somalija'),
(209, 'ZA', 'Južna Afrika'),
(210, 'GS', 'Južna Džordžija i Južna Sendvič ostrva'),
(211, 'SS', 'Južni Sudan'),
(212, 'ES', 'Španija'),
(213, 'LK', 'Šri Lanka'),
(214, 'SD', 'Sudan'),
(215, 'SR', 'Surinam'),
(216, 'SJ', 'Svalbard i Jan Maien'),
(217, 'SZ', 'Svazilend'),
(218, 'SE', 'Švedska'),
(219, 'CH', 'Švajcarska'),
(220, 'SY', 'Sirijska Arapska Republika'),
(221, 'TW', 'Tajvan#  provincija Kina'),
(222, 'TJ', 'Tadžikistana'),
(223, 'TZ', 'Tanzanija#  Ujedinjena Republika'),
(224, 'TH', 'Tajland'),
(225, 'TL', 'Timor-Leste'),
(226, 'TG', 'Da ide'),
(227, 'TK', 'Tokelau'),
(228, 'TO', 'Tonga'),
(229, 'TT', 'Trinidad i Tobago'),
(230, 'TN', 'Tunis'),
(231, 'TR', 'Turska'),
(232, 'TM', 'Turkmenistan'),
(233, 'TC', 'Ostrva Turks i Kaikos'),
(234, 'TV', 'Tuvalu'),
(235, 'UG', 'Uganda'),
(236, 'UA', 'Ukrajina'),
(237, 'AE', 'Ujedinjeni arapski Emirati'),
(238, 'GB', 'Velika Britanija'),
(239, 'US', 'Amerika'),
(240, 'UM', 'Mala udaljena ostrva Sjedinjenih Država'),
(241, 'UY', 'Urugvaj'),
(242, 'UZ', 'Uzbekistan'),
(243, 'VU', 'Vanuatu'),
(244, 'VE', 'Venezuela'),
(245, 'VN', 'Vijetnam'),
(246, 'VG', 'Devičanska ostrva  #  Britanski'),
(247, 'VI', 'Devičanska ostrva  #  U.s.'),
(248, 'WF', 'Vallis i Futuna'),
(249, 'EH', 'zapadna Sahara'),
(250, 'YE', 'Jemen'),
(251, 'ZM', 'Zambija'),
(252, 'ZW', 'Zimbabve'),
(253, '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
