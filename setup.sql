-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2022 at 10:30 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rapaldarkres`
--

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `id` int(6) NOT NULL,
  `nameshort` text NOT NULL,
  `namelong` text NOT NULL,
  `placement` int(4) NOT NULL COMMENT '-1 = disabled\r\n1 = fixed\r\n2 = random'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `nameshort`, `namelong`, `placement`) VALUES
(1, 'photo', 'Photo Shoot', 2),
(2, 'acting', 'Acting', 2),
(3, 'snatch', 'Snatch Game', 1),
(4, 'bullshit', 'Bullshit', 2),
(5, 'lipsync', 'Lip Sync', 2),
(6, 'improv', 'Improv', 2),
(7, 'ball', 'Ball', 2),
(8, 'standup', 'Stand Up', 2),
(9, 'rusical', 'Rusical', 2),
(10, 'makeover', 'Makeover', 2),
(11, 'branding', 'Branding', 2),
(12, 'rumix', 'Rumix', 1),
(13, 'talentshow', 'Talent Show', 1),
(14, 'sewing', 'Sewing', 2),
(15, 'girlgroup', 'Girl Groups', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contestants`
--

CREATE TABLE `contestants` (
  `id` int(6) NOT NULL,
  `name` text NOT NULL,
  `title` text NOT NULL,
  `emoji` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contestants`
--

INSERT INTO `contestants` (`id`, `name`, `title`, `emoji`) VALUES
(3, 'Cinnamon Bunn', 'the hodgepodge sweetheart', '💖'),
(4, 'Menorah Jones', 'the broadway queen', '🎙️'),
(5, 'Perdita Daphne Jackson', 'the pageant queen', '🏆'),
(6, 'Nyx Flambé', 'the dancing assassin', '🥷'),
(7, 'Pussy McGillicuddy', 'the campy workhorse', '⛺'),
(8, 'Irresistível', 'the fashion queen', '💅'),
(9, 'Anna Eva Börk Börk Börk', 'the character queen', '🇸🇪'),
(10, 'Rhea Sunshine', 'the filler queen', '🌞');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(12) NOT NULL,
  `round` int(4) NOT NULL,
  `contestantid` int(4) NOT NULL,
  `wincount` int(4) NOT NULL,
  `starcount` int(4) NOT NULL,
  `placement` int(4) NOT NULL,
  `strategy` int(4) NOT NULL,
  `blockslanded` int(4) NOT NULL,
  `alliance` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `id` int(6) NOT NULL,
  `contestantid` int(4) NOT NULL,
  `challengeid` int(4) NOT NULL,
  `score` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`id`, `contestantid`, `challengeid`, `score`) VALUES
(321, 3, 13, 6),
(322, 3, 2, 6),
(323, 3, 3, 4),
(324, 3, 4, 10),
(325, 3, 5, 6),
(326, 3, 6, 8),
(327, 3, 7, 4),
(328, 3, 8, 8),
(329, 3, 9, 6),
(330, 3, 10, 2),
(331, 3, 11, 10),
(332, 3, 12, 6),
(333, 3, 14, 2),
(334, 3, 15, 6),
(335, 3, 1, 6),
(336, 4, 13, 4),
(337, 4, 2, 8),
(338, 4, 3, 8),
(339, 4, 4, 6),
(340, 4, 5, 4),
(341, 4, 6, 8),
(342, 4, 7, 4),
(343, 4, 8, 6),
(344, 4, 9, 10),
(345, 4, 10, 4),
(346, 4, 11, 4),
(347, 4, 12, 6),
(348, 4, 14, 8),
(349, 4, 15, 8),
(350, 4, 1, 2),
(351, 5, 13, 10),
(352, 5, 2, 6),
(353, 5, 3, 4),
(354, 5, 4, 4),
(355, 5, 5, 8),
(356, 5, 6, 2),
(357, 5, 7, 8),
(358, 5, 8, 4),
(359, 5, 9, 6),
(360, 5, 10, 8),
(361, 5, 11, 6),
(362, 5, 12, 4),
(363, 5, 14, 8),
(364, 5, 15, 4),
(365, 5, 1, 8),
(366, 6, 13, 6),
(367, 6, 2, 4),
(368, 6, 3, 2),
(369, 6, 4, 6),
(370, 6, 5, 10),
(371, 6, 6, 2),
(372, 6, 7, 6),
(373, 6, 8, 6),
(374, 6, 9, 6),
(375, 6, 10, 6),
(376, 6, 11, 6),
(377, 6, 12, 10),
(378, 6, 14, 6),
(379, 6, 15, 8),
(380, 6, 1, 6),
(381, 7, 13, 6),
(382, 7, 2, 8),
(383, 7, 3, 10),
(384, 7, 4, 8),
(385, 7, 5, 4),
(386, 7, 6, 10),
(387, 7, 7, 4),
(388, 7, 8, 10),
(389, 7, 9, 8),
(390, 7, 10, 4),
(391, 7, 11, 2),
(392, 7, 12, 4),
(393, 7, 14, 2),
(394, 7, 15, 6),
(395, 7, 1, 4),
(396, 8, 13, 4),
(397, 8, 2, 4),
(398, 8, 3, 4),
(399, 8, 4, 6),
(400, 8, 5, 8),
(401, 8, 6, 4),
(402, 8, 7, 10),
(403, 8, 8, 4),
(404, 8, 9, 2),
(405, 8, 10, 10),
(406, 8, 11, 6),
(407, 8, 12, 6),
(408, 8, 14, 10),
(409, 8, 15, 4),
(410, 8, 1, 8),
(411, 9, 13, 4),
(412, 9, 2, 6),
(413, 9, 3, 6),
(414, 9, 4, 6),
(415, 9, 5, 4),
(416, 9, 6, 8),
(417, 9, 7, 4),
(418, 9, 8, 8),
(419, 9, 9, 4),
(420, 9, 10, 6),
(421, 9, 11, 8),
(422, 9, 12, 6),
(423, 9, 14, 4),
(424, 9, 15, 6),
(425, 9, 1, 10),
(426, 10, 13, 6),
(427, 10, 2, 6),
(428, 10, 3, 6),
(429, 10, 4, 6),
(430, 10, 5, 6),
(431, 10, 6, 6),
(432, 10, 7, 6),
(433, 10, 8, 6),
(434, 10, 9, 6),
(435, 10, 10, 6),
(436, 10, 11, 6),
(437, 10, 12, 6),
(438, 10, 14, 6),
(439, 10, 15, 6),
(440, 10, 1, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contestants`
--
ALTER TABLE `contestants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contestants`
--
ALTER TABLE `contestants`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=441;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
