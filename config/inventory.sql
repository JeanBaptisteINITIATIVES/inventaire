-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Lun 20 Novembre 2017 à 08:14
-- Version du serveur :  5.6.35
-- Version de PHP :  7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données :  `inventaire`
--
CREATE DATABASE IF NOT EXISTS `inventaire` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `inventaire`;

-- --------------------------------------------------------

--
-- Structure de la table `allowed_users`
--

CREATE TABLE `allowed_users` (
  `id` int(11) NOT NULL,
  `alias` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_level` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `allowed_users`
--

INSERT INTO `allowed_users` (`id`, `alias`, `name`, `password`, `user_level`) VALUES
(1, 'lc', 'Laurence Corbin', 'lc0676', 1),
(2, 'bp', 'Bertrand Peye', 'bp0371', 1),
(3, 'dh', 'Dominique Hérault', 'dh0164', 1),
(4, 'dl', 'Dominique Luc', 'dl1166', 1),
(5, 'et', 'Elise Turenne', 'et1172', 1),
(6, 'ht', 'Hervé Triffault', 'ht0980', 1),
(7, 'jl', 'Johnny Lassay', 'jl0182', 1),
(8, 'jb', 'Julien Boulay', 'jb0585', 1),
(9, 'mf', 'Maël Frénéhard', 'mf0588', 1),
(10, 'jbb', 'Jean-Baptiste Belin', 'jbb1084', 3),
(11, 'gl', 'Grégory Le Men', 'gl1282', 1),
(12, 'sr', 'Séverine Rondeau', 'sr0878', 1),
(13, 'rd', 'Romuald Doutre', 'rd1067', 3),
(14, 'if', 'Isabelle Fouqueray', 'if0376', 1),
(15, 'mv', 'Marina Vannier', 'mv1273', 1),
(16, 'ce', 'Christelle Evenisse', 'ce1265', 2),
(17, 'sv', 'Sandra Vacheret', 'sv1188', 2),
(18, 'mr', 'Maryline Raveneau', 'mr0763', 2),
(19, 'pr', 'Philippe Rossi', 'pr0765', 3),
(20, 'test', 'test', 'test00', 3);

-- --------------------------------------------------------

--
-- Structure de la table `free_input`
--

CREATE TABLE `free_input` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `status` varchar(4) NOT NULL,
  `observations` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_create` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `num_location` varchar(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `location`
--

INSERT INTO `location` (`id`, `num_location`) VALUES
(1, '1A01'),
(2, '1A02'),
(3, '1A11'),
(4, '1A12'),
(5, '1A21'),
(6, '1A22'),
(7, '1B01'),
(8, '1B02'),
(9, '1B03'),
(10, '1B11'),
(11, '1B12'),
(12, '1B13'),
(13, '1B21'),
(14, '1B22'),
(15, '1B23'),
(16, '1C01'),
(17, '1C02'),
(18, '1C03'),
(19, '1C11'),
(20, '1C12'),
(21, '1C13'),
(22, '1C21'),
(23, '1C22'),
(24, '1C23'),
(25, '1D01'),
(26, '1D02'),
(27, '1D11'),
(28, '1D12'),
(29, '1D21'),
(30, '1D22'),
(31, '1E01'),
(32, '1E02'),
(33, '1E03'),
(34, '1E11'),
(35, '1E12'),
(36, '1E13'),
(37, '1E21'),
(38, '1E22'),
(39, '1E23'),
(40, '1F01'),
(41, '1F02'),
(42, '1F11'),
(43, '1F12'),
(44, '1F21'),
(45, '1F22'),
(46, '1G01'),
(47, '1G02'),
(48, '1G03'),
(49, '1G11'),
(50, '1G12'),
(51, '1G13'),
(52, '1G21'),
(53, '1G22'),
(54, '1G23'),
(55, '1H01'),
(56, '1H02'),
(57, '1H03'),
(58, '1H11'),
(59, '1H12'),
(60, '1H13'),
(61, '1H21'),
(62, '1H22'),
(63, '1H23'),
(64, '1I01'),
(65, '1I02'),
(66, '1I03'),
(67, '1I11'),
(68, '1I12'),
(69, '1I13'),
(70, '1I21'),
(71, '1I22'),
(72, '1I23'),
(73, '1J01'),
(74, '1J02'),
(75, '1J03'),
(76, '1J11'),
(77, '1J12'),
(78, '1J13'),
(79, '1J21'),
(80, '1J22'),
(81, '1J23'),
(82, '1K01'),
(83, '1K02'),
(84, '1K11'),
(85, '1K12'),
(86, '1K21'),
(87, '1K22'),
(88, '1L01'),
(89, '1L02'),
(90, '1L03'),
(91, '1L04'),
(92, '1L11'),
(93, '1L12'),
(94, '1L13'),
(95, '1L14'),
(96, '1L21'),
(97, '1L22'),
(98, '1L23'),
(99, '1L24'),
(100, '2A01'),
(101, '2A02'),
(102, '2A03'),
(103, '2A11'),
(104, '2A12'),
(105, '2A13'),
(106, '2A21'),
(107, '2A22'),
(108, '2A23'),
(109, '2B01'),
(110, '2B02'),
(111, '2B03'),
(112, '2B11'),
(113, '2B12'),
(114, '2B13'),
(115, '2B21'),
(116, '2B22'),
(117, '2B23'),
(118, '2C01'),
(119, '2C02'),
(120, '2C03'),
(121, '2C11'),
(122, '2C12'),
(123, '2C13'),
(124, '2C21'),
(125, '2C22'),
(126, '2C23'),
(127, '2D01'),
(128, '2D02'),
(129, '2D03'),
(130, '2D11'),
(131, '2D12'),
(132, '2D13'),
(133, '2D21'),
(134, '2D22'),
(135, '2D23'),
(136, '2E01'),
(137, '2E02'),
(138, '2E03'),
(139, '2E11'),
(140, '2E12'),
(141, '2E13'),
(142, '2E21'),
(143, '2E22'),
(144, '2E23'),
(145, '2F01'),
(146, '2F02'),
(147, '2F03'),
(148, '2F11'),
(149, '2F12'),
(150, '2F13'),
(151, '2F21'),
(152, '2F22'),
(153, '2F23'),
(154, '2G01'),
(155, '2G02'),
(156, '2G03'),
(157, '2G11'),
(158, '2G12'),
(159, '2G13'),
(160, '2G21'),
(161, '2G22'),
(162, '2G23'),
(163, '2H01'),
(164, '2H02'),
(165, '2H03'),
(166, '2H11'),
(167, '2H12'),
(168, '2H13'),
(169, '2H21'),
(170, '2H22'),
(171, '2H23'),
(172, '2I01'),
(173, '2I02'),
(174, '2I03'),
(175, '2I11'),
(176, '2I12'),
(177, '2I13'),
(178, '2I21'),
(179, '2I22'),
(180, '2I23'),
(181, '2J01'),
(182, '2J02'),
(183, '2J03'),
(184, '2J11'),
(185, '2J12'),
(186, '2J13'),
(187, '2J21'),
(188, '2J22'),
(189, '2J23'),
(190, '2K01'),
(191, '2K02'),
(192, '2K03'),
(193, '2K11'),
(194, '2K12'),
(195, '2K13'),
(196, '2K21'),
(197, '2K22'),
(198, '2K23'),
(199, '2L01'),
(200, '2L02'),
(201, '2L03'),
(202, '2L04'),
(203, '2L11'),
(204, '2L12'),
(205, '2L13'),
(206, '2L14'),
(207, '2L21'),
(208, '2L22'),
(209, '2L23'),
(210, '2L24'),
(211, '3A01'),
(212, '3A02'),
(213, '3A03'),
(214, '3A11'),
(215, '3A12'),
(216, '3A13'),
(217, '3A21'),
(218, '3A22'),
(219, '3A23'),
(220, '3B01'),
(221, '3B02'),
(222, '3B03'),
(223, '3B11'),
(224, '3B12'),
(225, '3B13'),
(226, '3B21'),
(227, '3B22'),
(228, '3B23'),
(229, '3C01'),
(230, '3C02'),
(231, '3C03'),
(232, '3C11'),
(233, '3C12'),
(234, '3C13'),
(235, '3C21'),
(236, '3C22'),
(237, '3C23'),
(238, '3D01'),
(239, '3D02'),
(240, '3D03'),
(241, '3D11'),
(242, '3D12'),
(243, '3D13'),
(244, '3D21'),
(245, '3D22'),
(246, '3D23'),
(247, '3E01'),
(248, '3E02'),
(249, '3E03'),
(250, '3E11'),
(251, '3E12'),
(252, '3E13'),
(253, '3E21'),
(254, '3E22'),
(255, '3E23'),
(256, '3F01'),
(257, '3F02'),
(258, '3F03'),
(259, '3F11'),
(260, '3F12'),
(261, '3F13'),
(262, '3F21'),
(263, '3F22'),
(264, '3F23'),
(265, '3G01'),
(266, '3G02'),
(267, '3G03'),
(268, '3G11'),
(269, '3G12'),
(270, '3G13'),
(271, '3G21'),
(272, '3G22'),
(273, '3G23'),
(274, '3H01'),
(275, '3H02'),
(276, '3H03'),
(277, '3H11'),
(278, '3H12'),
(279, '3H13'),
(280, '3H21'),
(281, '3H22'),
(282, '3H23'),
(283, '3I01'),
(284, '3I02'),
(285, '3I03'),
(286, '3I11'),
(287, '3I12'),
(288, '3I13'),
(289, '3I21'),
(290, '3I22'),
(291, '3I23'),
(292, '3J01'),
(293, '3J02'),
(294, '3J03'),
(295, '3J11'),
(296, '3J12'),
(297, '3J13'),
(298, '3J21'),
(299, '3J22'),
(300, '3J23'),
(301, '3K01'),
(302, '3K02'),
(303, '3K03'),
(304, '3K11'),
(305, '3K12'),
(306, '3K13'),
(307, '3K21'),
(308, '3K22'),
(309, '3K23'),
(310, '3L01'),
(311, '3L02'),
(312, '3L03'),
(313, '3L04'),
(314, '3L11'),
(315, '3L12'),
(316, '3L13'),
(317, '3L14'),
(318, '3L21'),
(319, '3L22'),
(320, '3L23'),
(321, '3L24'),
(322, '4A01'),
(323, '4A02'),
(324, '4A03'),
(325, '4A11'),
(326, '4A12'),
(327, '4A13'),
(328, '4A21'),
(329, '4A22'),
(330, '4A23'),
(331, '4B01'),
(332, '4B02'),
(333, '4B03'),
(334, '4B11'),
(335, '4B12'),
(336, '4B13'),
(337, '4B21'),
(338, '4B22'),
(339, '4B23'),
(340, '4C01'),
(341, '4C02'),
(342, '4C03'),
(343, '4C11'),
(344, '4C12'),
(345, '4C13'),
(346, '4C21'),
(347, '4C22'),
(348, '4C23'),
(349, '4D01'),
(350, '4D02'),
(351, '4D03'),
(352, '4D11'),
(353, '4D12'),
(354, '4D13'),
(355, '4D21'),
(356, '4D22'),
(357, '4D23'),
(358, '4E01'),
(359, '4E02'),
(360, '4E03'),
(361, '4E11'),
(362, '4E12'),
(363, '4E13'),
(364, '4E21'),
(365, '4E22'),
(366, '4E23'),
(367, '4F01'),
(368, '4F02'),
(369, '4F03'),
(370, '4F11'),
(371, '4F12'),
(372, '4F13'),
(373, '4F21'),
(374, '4F22'),
(375, '4F23'),
(376, '4G01'),
(377, '4G02'),
(378, '4G03'),
(379, '4G11'),
(380, '4G12'),
(381, '4G13'),
(382, '4G21'),
(383, '4G22'),
(384, '4G23'),
(385, '4H01'),
(386, '4H02'),
(387, '4H03'),
(388, '4H11'),
(389, '4H12'),
(390, '4H13'),
(391, '4H21'),
(392, '4H22'),
(393, '4H23'),
(394, '4I01'),
(395, '4I02'),
(396, '4I03'),
(397, '4I11'),
(398, '4I12'),
(399, '4I13'),
(400, '4I21'),
(401, '4I22'),
(402, '4I23'),
(403, '4J01'),
(404, '4J02'),
(405, '4J03'),
(406, '4J11'),
(407, '4J12'),
(408, '4J13'),
(409, '4J21'),
(410, '4J22'),
(411, '4J23'),
(412, '4K01'),
(413, '4K02'),
(414, '4K03'),
(415, '4K11'),
(416, '4K12'),
(417, '4K13'),
(418, '4K21'),
(419, '4K22'),
(420, '4K23'),
(421, '4L01'),
(422, '4L02'),
(423, '4L03'),
(424, '4L04'),
(425, '4L11'),
(426, '4L12'),
(427, '4L13'),
(428, '4L14'),
(429, '4L21'),
(430, '4L22'),
(431, '4L23'),
(432, '4L24'),
(433, '5A01'),
(434, '5A02'),
(435, '5A03'),
(436, '5A11'),
(437, '5A12'),
(438, '5A13'),
(439, '5A21'),
(440, '5A22'),
(441, '5A23'),
(442, '5B01'),
(443, '5B02'),
(444, '5B03'),
(445, '5B11'),
(446, '5B12'),
(447, '5B13'),
(448, '5B21'),
(449, '5B22'),
(450, '5B23'),
(451, '5C01'),
(452, '5C02'),
(453, '5C03'),
(454, '5C11'),
(455, '5C12'),
(456, '5C13'),
(457, '5C21'),
(458, '5C22'),
(459, '5C23'),
(460, '5D01'),
(461, '5D02'),
(462, '5D03'),
(463, '5D11'),
(464, '5D12'),
(465, '5D13'),
(466, '5D21'),
(467, '5D22'),
(468, '5D23'),
(469, '5E01'),
(470, '5E02'),
(471, '5E03'),
(472, '5E11'),
(473, '5E12'),
(474, '5E13'),
(475, '5E21'),
(476, '5E22'),
(477, '5E23'),
(478, '5F01'),
(479, '5F02'),
(480, '5F03'),
(481, '5F11'),
(482, '5F12'),
(483, '5F13'),
(484, '5F21'),
(485, '5F22'),
(486, '5F23'),
(487, '5G01'),
(488, '5G02'),
(489, '5G03'),
(490, '5G11'),
(491, '5G12'),
(492, '5G13'),
(493, '5G21'),
(494, '5G22'),
(495, '5G23'),
(496, '5H01'),
(497, '5H02'),
(498, '5H03'),
(499, '5H11'),
(500, '5H12'),
(501, '5H13'),
(502, '5H21'),
(503, '5H22'),
(504, '5H23'),
(505, '5I01'),
(506, '5I02'),
(507, '5I03'),
(508, '5I11'),
(509, '5I12'),
(510, '5I13'),
(511, '5I21'),
(512, '5I22'),
(513, '5I23'),
(514, '5J01'),
(515, '5J02'),
(516, '5J03'),
(517, '5J11'),
(518, '5J12'),
(519, '5J13'),
(520, '5J21'),
(521, '5J22'),
(522, '5J23'),
(523, '5K01'),
(524, '5K02'),
(525, '5K03'),
(526, '5K11'),
(527, '5K12'),
(528, '5K13'),
(529, '5K21'),
(530, '5K22'),
(531, '5K23'),
(532, '5L01'),
(533, '5L02'),
(534, '5L03'),
(535, '5L04'),
(536, '5L11'),
(537, '5L12'),
(538, '5L13'),
(539, '5L14'),
(540, '5L21'),
(541, '5L22'),
(542, '5L23'),
(543, '5L24'),
(544, '6A01'),
(545, '6A02'),
(546, '6A03'),
(547, '6A11'),
(548, '6A12'),
(549, '6A13'),
(550, '6A21'),
(551, '6A22'),
(552, '6A23'),
(553, '6B01'),
(554, '6B02'),
(555, '6B11'),
(556, '6B12'),
(557, '6B21'),
(558, '6B22'),
(559, '6C01'),
(560, '6C02'),
(561, '6C03'),
(562, '6C11'),
(563, '6C12'),
(564, '6C13'),
(565, '6C21'),
(566, '6C22'),
(567, '6C23'),
(568, '6D01'),
(569, '6D02'),
(570, '6D11'),
(571, '6D12'),
(572, '6D21'),
(573, '6D22'),
(574, '6E01'),
(575, '6E02'),
(576, '6E03'),
(577, '6E11'),
(578, '6E12'),
(579, '6E13'),
(580, '6E21'),
(581, '6E22'),
(582, '6E23'),
(583, '6F01'),
(584, '6F02'),
(585, '6F11'),
(586, '6F12'),
(587, '6F21'),
(588, '6F22'),
(589, '6G01'),
(590, '6G02'),
(591, '6G03'),
(592, '6G11'),
(593, '6G12'),
(594, '6G13'),
(595, '6G21'),
(596, '6G22'),
(597, '6G23'),
(598, '6H01'),
(599, '6H02'),
(600, '6H11'),
(601, '6H12'),
(602, '6H21'),
(603, '6H22'),
(604, '6I01'),
(605, '6I02'),
(606, '6I03'),
(607, '6I11'),
(608, '6I12'),
(609, '6I13'),
(610, '6I21'),
(611, '6I22'),
(612, '6I23'),
(613, '6J01'),
(614, '6J02'),
(615, '6J03'),
(616, '6J04'),
(617, '6J05'),
(618, '6J11'),
(619, '6J12'),
(620, '6J13'),
(621, '6J14'),
(622, '6J15'),
(623, '6J21'),
(624, '6J22'),
(625, '6J23'),
(626, '6J24'),
(627, '6J25'),
(628, '6K01'),
(629, '6K02'),
(630, '6K11'),
(631, '6K12'),
(632, '6K21'),
(633, '6K22'),
(634, '6L01'),
(635, '6L02'),
(636, '6L03'),
(637, '6L04'),
(638, '6L05'),
(639, '6L11'),
(640, '6L12'),
(641, '6L13'),
(642, '6L14'),
(643, '6L15'),
(644, '6L21'),
(645, '6L22'),
(646, '6L23'),
(647, '6L24'),
(648, '6L25'),
(649, '701'),
(650, '702'),
(651, '703'),
(652, '704'),
(653, '705'),
(654, '706'),
(655, '707'),
(656, '708'),
(657, '709'),
(658, '710'),
(659, '711'),
(660, '712'),
(661, '713'),
(662, '714'),
(663, '715'),
(664, '716'),
(665, '717'),
(666, '801'),
(667, '802'),
(668, '803'),
(669, '804'),
(670, '805'),
(671, '806'),
(672, '807'),
(673, '808'),
(674, '809'),
(675, '810'),
(676, '811'),
(677, '812'),
(678, '813'),
(679, '814'),
(680, '901'),
(681, '902'),
(682, '903'),
(683, '904'),
(684, '905'),
(685, '906'),
(686, '907'),
(687, '908'),
(688, '909'),
(689, '910'),
(690, '911'),
(691, '912'),
(692, '913'),
(693, '914'),
(694, '915'),
(695, '916'),
(696, '917'),
(697, '918'),
(698, '919'),
(699, '920'),
(700, '921'),
(701, '922'),
(702, '923'),
(703, '924'),
(704, '925'),
(705, '926'),
(706, '927'),
(707, '928'),
(708, '929'),
(709, '930'),
(710, '931'),
(711, '932'),
(712, '933'),
(713, '934'),
(714, '935'),
(715, '936'),
(716, '937'),
(717, '938'),
(718, '939'),
(719, '940'),
(720, '1001'),
(721, '1002'),
(722, '1003'),
(723, '1004'),
(724, '1005'),
(725, '1006'),
(726, '1007'),
(727, '1008'),
(728, '1009'),
(729, '1010'),
(730, '1011'),
(731, '1012'),
(732, '1013'),
(733, '1014'),
(734, '1015'),
(735, '1016'),
(736, '1017'),
(737, '1018'),
(738, '1019'),
(739, '1020'),
(740, '1021'),
(741, '1022'),
(742, '1023'),
(743, '1024'),
(744, '1025'),
(745, '1026'),
(746, '1027'),
(747, '1028'),
(748, '1029'),
(749, '1030'),
(750, '1031'),
(751, '1032'),
(752, '1033'),
(753, '1034'),
(754, '1035'),
(755, '1036'),
(756, '1037'),
(757, '1038'),
(758, '1039'),
(759, '1040'),
(760, '1101'),
(761, '1102'),
(762, '1103'),
(763, '1104'),
(764, '1105'),
(765, '1106'),
(766, '1107'),
(767, '1108'),
(768, '1109'),
(769, '1110'),
(770, '1111'),
(771, '1112'),
(772, '1113'),
(773, '1114'),
(774, '1115'),
(775, '1116'),
(776, '1117'),
(777, '1118'),
(778, '1119'),
(779, '1120'),
(780, '1121'),
(781, '1122'),
(782, '1123'),
(783, '1124'),
(784, '1125'),
(785, '1126'),
(786, '1127'),
(787, '1128'),
(788, '1129'),
(789, '1130'),
(790, '1131'),
(791, '1132'),
(792, '1133'),
(793, '1134'),
(794, '1135'),
(795, '1136'),
(796, '1137'),
(797, '1138'),
(798, '1139'),
(799, '1140'),
(800, '1201'),
(801, '1202'),
(802, '1203'),
(803, '1204'),
(804, '1205'),
(805, '1206'),
(806, '1207'),
(807, '1208'),
(808, '1209'),
(809, '1210'),
(810, '1211'),
(811, '1212'),
(812, '1213'),
(813, '1214'),
(814, '1215'),
(815, '1216'),
(816, '1217'),
(817, '1218'),
(818, '1219'),
(819, '1220'),
(820, '1221'),
(821, '1222'),
(822, '1223'),
(823, '1224'),
(824, '1225'),
(825, '1226'),
(826, '1227'),
(827, '1228'),
(828, '1229'),
(829, '1230'),
(830, '1231'),
(831, '1232'),
(832, '1233'),
(833, '1234'),
(834, 'ATE'),
(835, 'SAS'),
(836, 'ZONE PREPA'),
(837, 'STOCKAGE'),
(838, 'MASSE'),
(839, 'PLATEFORME STOCKAGE'),
(840, 'PLATEFORME ATE'),
(841, 'AUTRE');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `reference` varchar(20) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `stock` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


--
-- Structure de la table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `code_site` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sites`
--

INSERT INTO `sites` (`id`, `code_site`) VALUES
(1, 'ARS'),
(2, 'AURIC'),
(3, 'BERLIOZ'),
(4, 'BIGOT'),
(5, 'BOUTIQUE'),
(6, 'BRIO'),
(7, 'BURBAN PALETTES'),
(8, 'CATMANOR'),
(9, 'CHERRIER'),
(10, 'DOCAPOST'),
(11, 'ESAT'),
(12, 'FAMAR'),
(13, 'FDL'),
(14, 'GEODIS'),
(15, 'GUETTE MIDI'),
(16, 'HOUARI'),
(17, 'IMAGIN'),
(18, 'LE TERTRE'),
(19, 'PRN'),
(20, 'SCA'),
(21, 'TURC');

-- --------------------------------------------------------

--
-- Structure de la table `stock_input`
--

CREATE TABLE `stock_input` (
  `id` int(11) NOT NULL,
  `location_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `quantity` int(11) UNSIGNED NOT NULL,
  `status` varchar(2) NOT NULL,
  `observations` varchar(255) NOT NULL,
  `user_id` int(5) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `allowed_users_id` int(11) NOT NULL,
  `site_id` int(5) NOT NULL,
  `date_connection` datetime NOT NULL,
  `online` tinyint(5) UNSIGNED NOT NULL,
  `last_activity` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `allowed_users`
--
ALTER TABLE `allowed_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `free_input`
--
ALTER TABLE `free_input`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_2` (`reference`);
ALTER TABLE `products` ADD FULLTEXT KEY `reference` (`reference`);
ALTER TABLE `products` ADD FULLTEXT KEY `designation` (`designation`);

--
-- Index pour la table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock_input`
--
ALTER TABLE `stock_input`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`,`product_id`,`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `allowed_users_id` (`allowed_users_id`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `allowed_users`
--
ALTER TABLE `allowed_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `free_input`
--
ALTER TABLE `free_input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `stock_input`
--
ALTER TABLE `stock_input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `free_input`
--
ALTER TABLE `free_input`
  ADD CONSTRAINT `free_input_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `free_input_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `stock_input`
--
ALTER TABLE `stock_input`
  ADD CONSTRAINT `stock_input_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `stock_input_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stock_input_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`allowed_users_id`) REFERENCES `allowed_users` (`id`);