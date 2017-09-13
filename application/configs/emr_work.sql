-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2015 at 05:33 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `emr_work`
--

-- --------------------------------------------------------

--
-- Table structure for table `bsc_email`
--

CREATE TABLE IF NOT EXISTS `bsc_email` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `is_starred_from` tinyint(1) NOT NULL,
  `is_starred_to` tinyint(1) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `subject` text NOT NULL,
  `boddy` text NOT NULL,
  `date_sent` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `bsc_email`
--

INSERT INTO `bsc_email` (`email_id`, `from_id`, `to_id`, `is_starred_from`, `is_starred_to`, `is_read`, `subject`, `boddy`, `date_sent`, `is_delete`) VALUES
(1, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(2, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(3, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(4, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(5, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(6, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(7, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(8, 2, 1, 0, 1, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(9, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(10, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(11, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(12, 2, 1, 0, 1, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(13, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(14, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(15, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(16, 2, 1, 0, 1, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(17, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(18, 2, 1, 0, 0, 1, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(19, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(20, 2, 1, 0, 1, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(21, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(22, 2, 1, 0, 1, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(23, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(24, 2, 1, 0, 1, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 1),
(25, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(26, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(27, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(28, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(29, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(30, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(31, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(32, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(33, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(34, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(35, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(36, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(37, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(38, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(39, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(40, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(41, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(42, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(43, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(44, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(45, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(46, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(47, 1, 2, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(48, 2, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(49, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(50, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(51, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(52, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(53, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(54, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(55, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(56, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(57, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(58, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(59, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(60, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(61, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(62, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(63, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(64, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(65, 1, 5, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(66, 5, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(67, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(68, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(69, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(70, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(71, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(72, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(73, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(74, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(75, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(76, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(77, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(78, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(79, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(80, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(81, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(82, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(83, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(84, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(85, 1, 12, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(86, 12, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(87, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(88, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(89, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(90, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(91, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0);
INSERT INTO `bsc_email` (`email_id`, `from_id`, `to_id`, `is_starred_from`, `is_starred_to`, `is_read`, `subject`, `boddy`, `date_sent`, `is_delete`) VALUES
(92, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(93, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(94, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(95, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(96, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(97, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(98, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(99, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(100, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(101, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(102, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(103, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(104, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(105, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(106, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0),
(107, 1, 4, 0, 0, 0, 'meeting', 'eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss eah r g fuah ahq osh jsljle oirq hfl dhsdlfh ehdhsh  hf h  l sljf d lss ', '2015-06-01 14:30:47', 0),
(108, 4, 1, 0, 0, 0, 'good job', 'f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg f e sg sfa qrlkjdfoiy gsdhfkjhewut agf kjhf sdhkjshfkg ue hsdj h gjkshdjg sg ', '2015-06-16 15:50:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_email_draft`
--

CREATE TABLE IF NOT EXISTS `bsc_email_draft` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `is_starred_from` tinyint(1) NOT NULL,
  `is_starred_to` tinyint(1) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `subject` text NOT NULL,
  `boddy` text NOT NULL,
  `date_sent` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bsc_email_draft`
--

INSERT INTO `bsc_email_draft` (`email_id`, `from_id`, `to_id`, `is_starred_from`, `is_starred_to`, `is_read`, `subject`, `boddy`, `date_sent`, `is_delete`) VALUES
(1, 1, 7, 0, 0, 0, 'asfsdf', 'gsdgsgddg', '2015-06-19 17:05:21', 0),
(2, 1, 7, 1, 0, 0, 'ssdgfdh', 'cfncfhfh\r\nfhfh\r\nfdh\r\ngf\r\nu\r\ntu\r\nrst\r\ns\r\ndgf\r\nhbcngj', '2015-06-19 17:05:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_menu`
--

CREATE TABLE IF NOT EXISTS `bsc_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_menu_id` int(11) NOT NULL,
  `bc_p_menu_id` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_page_name` varchar(255) NOT NULL,
  `menu_image` varchar(255) NOT NULL,
  `menu_permission` varchar(255) NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `type` enum('M','N') NOT NULL DEFAULT 'M',
  `ordr` int(5) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `bsc_menu`
--

INSERT INTO `bsc_menu` (`menu_id`, `p_menu_id`, `bc_p_menu_id`, `menu_name`, `menu_page_name`, `menu_image`, `menu_permission`, `status`, `type`, `ordr`) VALUES
(1, 0, 0, 'Home', 'javascript:alert("WIP")', 'icon-custom-home', 'Home', 'A', 'M', 1),
(2, 0, 0, 'e-Mail', 'javascript:alert("WIP")', 'fa fa-envelope', 'Mail', 'A', 'M', 2),
(3, 0, 0, 'Appoinment', 'javascript:alert("WIP")', 'fa fa-list-ol', 'Appoinment', 'A', 'M', 3),
(4, 0, 0, 'Medical', 'javascript:alert("WIP")', 'fa fa-medkit ', 'Medical', 'A', 'M', 4),
(5, 0, 0, 'Dental', 'javascript:alert("WIP")', 'fa fa-plus-circle', 'Dental', 'A', 'M', 5),
(6, 2, 0, 'Inbox', '/Email/inbox', 'icon-custom-home', 'Inbox', 'A', 'M', 1),
(7, 2, 0, 'New Mail', '/Email/sendmail', 'icon-custom-home', 'New_Mail', 'A', 'M', 2),
(8, 2, 0, 'Sent mail', '/Email/sentmail', 'icon-custom-home', 'Sent_mail', 'A', 'M', 3),
(9, 3, 0, 'New Appoinment', 'javascript:alert("WIP")', 'icon-custom-home', 'New_Appoinment', 'A', 'M', 1),
(10, 3, 0, 'View Appoinments', 'javascript:alert("WIP")', 'icon-custom-home', 'View_Appoinments', 'A', 'M', 2),
(11, 0, 0, 'User', 'javascript:alert("WIP")', 'fa fa-users', 'User', 'A', 'M', 6),
(12, 11, 11, 'Add User', '/Accounts/manageaccount', '', 'Add_User', 'A', 'M', 1),
(13, 11, 11, 'List Users', '/Accounts/useraccounts', '', 'List_Users', 'A', 'M', 2),
(14, 11, 11, 'Edit Users', 'javascript:alert("WIP")', '', 'Edit_Users', 'A', 'N', 3),
(15, 11, 11, 'Delete Users', 'javascript:alert("WIP")', '', 'Delete_Users', 'A', 'N', 4),
(16, 11, 11, 'Deactivate User', '', '', 'Deactivate_User', 'A', 'N', 5),
(17, 11, 11, 'Set Access Permission', '', '', 'Set_Access_Permission', 'A', 'N', 6),
(18, 2, 2, 'Delete Email', '', '', 'Delete_Email', 'A', 'N', 4),
(19, 2, 2, 'Draft', '/Email/draft', '', 'Draft', 'A', 'M', 5);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_role`
--

CREATE TABLE IF NOT EXISTS `bsc_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bsc_role`
--

INSERT INTO `bsc_role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'user'),
(3, 'patient');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_role_menu_permission`
--

CREATE TABLE IF NOT EXISTS `bsc_role_menu_permission` (
  `role_permission_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`role_permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `bsc_role_menu_permission`
--

INSERT INTO `bsc_role_menu_permission` (`role_permission_id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 1, 2),
(5, 2, 2),
(6, 3, 2),
(7, 1, 3),
(8, 2, 3),
(9, 3, 3),
(10, 1, 4),
(11, 2, 4),
(12, 3, 4),
(13, 1, 5),
(14, 2, 5),
(15, 3, 5),
(16, 1, 6),
(17, 2, 6),
(18, 3, 6),
(19, 1, 7),
(20, 2, 7),
(21, 3, 7),
(22, 1, 8),
(23, 2, 8),
(24, 3, 8),
(25, 1, 9),
(26, 2, 9),
(27, 3, 9),
(28, 1, 10),
(29, 2, 10),
(30, 3, 10),
(31, 1, 11),
(32, 1, 12),
(33, 1, 13),
(34, 1, 14),
(35, 1, 15),
(36, 1, 16),
(37, 3, 16),
(38, 1, 17),
(39, 3, 17),
(40, 1, 18),
(41, 2, 18),
(42, 3, 18),
(43, 1, 19),
(44, 2, 19),
(45, 3, 19);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_user`
--

CREATE TABLE IF NOT EXISTS `bsc_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `user_fname` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `nric` varchar(20) NOT NULL,
  `DOB` date NOT NULL,
  `address` text NOT NULL,
  `add_date` datetime NOT NULL,
  `mod_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `bsc_user`
--

INSERT INTO `bsc_user` (`user_id`, `parent_user_id`, `created_by`, `user_fname`, `user_lname`, `email`, `phone`, `nric`, `DOB`, `address`, `add_date`, `mod_date`) VALUES
(1, 0, 0, 'admin', 'gk', 'g@g.com', '12345678', 'ffsdgsdgs', '2014-12-12', '', '2015-04-21 13:52:14', '2015-06-11 18:16:17'),
(2, 0, 0, 'gg', 'kk', 'goutam.webdesigncastle@gmail.com', '', '', '0000-00-00', '', '2015-04-27 16:45:53', '2015-04-27 16:45:53'),
(4, 11, 0, 'ram', 'nandi', 'ram.webdesigncastle@gmail.com', '', '', '0000-00-00', '', '2015-04-27 16:51:40', '2015-04-27 16:51:40'),
(5, 11, 0, 'papia', 'nandi', 'papia.webdesigncastle@gmail.com', '', '', '0000-00-00', '', '2015-04-27 16:55:01', '2015-04-27 16:55:01'),
(6, 11, 0, 'tap', 'hal', 'kd1.webdesigncastle@gmail.com', '', '', '0000-00-00', '', '2015-04-27 16:55:38', '2015-04-27 16:55:38'),
(7, 12, 0, 'ggg', 'kkk', 'a@a.com', '1234', '12345', '0000-00-00', '1234', '2015-04-29 14:51:12', '2015-05-27 16:26:07'),
(8, 12, 0, 'asd', 'asd', 'b@b.com', '4545435', 'sdfsdf', '0000-00-00', 'ffgggg', '2015-04-29 14:53:37', '2015-05-27 15:10:26'),
(9, 12, 0, 'ase', 'ase', 'w@w.com', '1212', 'asas', '0000-00-00', '', '2015-04-29 14:55:21', '2015-04-29 14:55:21'),
(10, 0, 0, 'dfg', 'dfg', 'c@c.com', '', '', '0000-00-00', '', '2015-04-29 15:13:25', '2015-04-29 15:13:25'),
(11, 0, 0, 'sdf', 'sdf', 'asd@asd.sdr', '', '', '0000-00-00', '', '2015-04-29 15:21:34', '2015-04-29 15:21:34'),
(12, 0, 0, 'manager', 'user', 'asd@asdd.sdr', '32543543', 'werwerwsd', '0000-00-00', 'dfsdffasa', '2015-04-29 15:21:50', '2015-05-28 16:16:22'),
(13, 0, 0, 'sdfg', 'dfg', 'fdfsg@adsf.asd', '', '', '0000-00-00', '', '2015-04-29 15:32:45', '2015-06-18 17:07:25'),
(14, 0, 0, 'dfgdfg', 'gfdg', 'zxvzxc@sdfsd.sdf', '', '', '0000-00-00', '', '2015-04-29 15:49:27', '2015-04-29 15:49:27'),
(15, 0, 0, 'dfhg', 'fdg', 'zxvzxc@sdfsgd.sdf', '', '', '0000-00-00', '', '2015-04-29 15:49:49', '2015-04-29 15:49:49'),
(16, 0, 0, 'df', 'ff', 'as@asd.asd', '', '', '0000-00-00', '', '2015-05-05 11:56:06', '2015-05-05 11:56:06'),
(17, 0, 0, 'angela', 'Baisac', 'angela@legacygroup-asia.com', '12345678', 'abcd', '0000-00-00', 'singapore', '2015-05-22 14:50:33', '2015-05-22 14:50:33'),
(18, 0, 0, 'ff', 'dd', 'd@d.com', '', '', '0000-00-00', '', '2015-05-25 16:53:59', '2015-05-25 16:53:59'),
(23, 12, 12, 'grk', 'world', 'asd@asd.sad', '12345', '12345', '0000-00-00', '12345', '2015-05-27 16:26:56', '2015-05-27 16:35:40'),
(24, 0, 1, 'abc', 'efg', 'abc@efg.com', '123123', 'asdasd', '0000-00-00', '123213', '2015-05-27 16:40:14', '2015-05-27 16:40:14'),
(25, 12, 12, 'dfgfdg', 'dfgfdg', 'dfgdfgdfg@asdf.asd', '', '', '0000-00-00', '', '2015-05-29 12:46:47', '2015-05-29 12:51:32'),
(26, 12, 12, 'uyiyui', 'yuiyui', 'yuiyui@trytuyt.gty', '', '', '0000-00-00', '', '2015-05-29 12:52:40', '2015-05-29 12:52:40'),
(27, 12, 12, 'ramran', 'ddd', 'asd@qwewqr.asd', '234324', '23432rdrgfd', '0000-00-00', '234234', '2015-06-02 13:44:31', '2015-06-02 13:44:31'),
(28, 0, 0, 'gg', 'gg', 'g@gg.com', '', '', '0000-00-00', '', '2015-06-11 20:20:48', '2015-06-11 20:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_user_login_details`
--

CREATE TABLE IF NOT EXISTS `bsc_user_login_details` (
  `user_login_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_key` char(36) NOT NULL,
  `enc_user_email` varchar(50) NOT NULL,
  `enc_user_password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `cookie_key` char(36) NOT NULL,
  `forgot_pass_key` char(36) NOT NULL,
  `forgot_pass_expire` datetime NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_login_details_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `bsc_user_login_details`
--

INSERT INTO `bsc_user_login_details` (`user_login_details_id`, `user_id`, `user_key`, `enc_user_email`, `enc_user_password`, `role_id`, `cookie_key`, `forgot_pass_key`, `forgot_pass_expire`, `is_activated`, `is_active`, `is_delete`) VALUES
(1, 1, '83ecc34d-e7ff-11e4-8752-69af31e8f925', '129e4841fab40564b32209edb984e3a3', '964242e3d0bd0b3df27b8314ee9186e0', 1, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(2, 2, 'c498e0fe-ecce-11e4-ac0c-e481d7b3facb', 'c9f7b02c0132bcaf99bbc303c87d3810', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 0, 1, 0),
(4, 4, '939146b7-eccf-11e4-ac0c-e481d7b3facb', '205a45c5d88ef43ee297aa71e90d1f35', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', 'd1f6155e-eccf-11e4-ac0c-e481d7b3facb', '2015-04-29 16:53:25', 0, 1, 0),
(5, 5, '0b49bbea-ecd0-11e4-ac0c-e481d7b3facb', '93550b00b1eeab88b92f9aff17063743', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 0, 1, 0),
(6, 6, '217b972c-ecd0-11e4-ac0c-e481d7b3facb', '504e1d1483803faeb51c51bc14aa1511', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '490b86ee-ecd0-11e4-ac0c-e481d7b3facb', '2015-04-29 16:56:45', 0, 1, 0),
(7, 7, '13de4f4a-ee51-11e4-ba96-1daf196cd5e5', '67e5b0ab8c1c11363dcb9ec54a92b5a5', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 0, 0, 0),
(8, 8, '6a9379cc-ee51-11e4-ba96-1daf196cd5e5', '2692b8484bf4a9c494d60be3d5d976c1', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(9, 9, 'a8c54037-ee51-11e4-ba96-1daf196cd5e5', '7de5e2709aff6cc9fef935e754045a0d', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(10, 10, '2e8774b1-ee54-11e4-ba96-1daf196cd5e5', 'cd0fdb85cf4a36319dc75f90e1412d98', '964242e3d0bd0b3df27b8314ee9186e0', 2, '', '', '0000-00-00 00:00:00', 0, 1, 0),
(11, 11, '5242b6e5-ee55-11e4-ba96-1daf196cd5e5', '2cf59bca77bfb20552b7caddb14d885b', '964242e3d0bd0b3df27b8314ee9186e0', 2, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(12, 12, '5bea501b-ee55-11e4-ba96-1daf196cd5e5', '54a28404fb77b8f0c0cb0432aaad8446', '964242e3d0bd0b3df27b8314ee9186e0', 2, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(13, 13, 'e1dd5837-ee56-11e4-ba96-1daf196cd5e5', 'f89120c6d7aecd99277f992699114283', '964242e3d0bd0b3df27b8314ee9186e0', 1, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(14, 14, '3786cfb1-ee59-11e4-ba96-1daf196cd5e5', '08b9172401d1e75737034ddca598c128', '964242e3d0bd0b3df27b8314ee9186e0', 1, '', '', '0000-00-00 00:00:00', 0, 1, 0),
(15, 15, '449f7bfd-ee59-11e4-ba96-1daf196cd5e5', '1a3a22e6539590f4bfcceeb2ca5b706e', '964242e3d0bd0b3df27b8314ee9186e0', 1, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(16, 16, '9cc56c06-f2ef-11e4-81f6-54d2243cc010', '6777778415d4de14b566e9c6eeb311fc', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(17, 17, 'cc61ee7f-0063-11e5-b179-12792d73b844', 'aae5dd26b0add65567972fc31df33845', 'e9b5a20c1839711c07a188a6dd0e3cbf', 3, '', '', '0000-00-00 00:00:00', 0, 0, 0),
(18, 18, '12056a0c-02d0-11e5-a368-dacf7e0bbb89', '1c9221037a00124c8f79bacfb2967b82', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 0, 1, 0),
(23, 23, '17a26119-045f-11e5-93c3-9a7eabdd5100', 'c6821d893a32a095efc360ec27aed3ac', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(24, 24, 'f3488fb5-0460-11e5-93c3-9a7eabdd5100', 'c54282e424a2384a8796767f4f2d7ef7', '964242e3d0bd0b3df27b8314ee9186e0', 2, '', '', '0000-00-00 00:00:00', 1, 1, 1),
(25, 25, 'ab1973b3-05d2-11e5-b24c-15c6a5e79537', '8ce1d77d6b0ed52c08c977df17a68b03', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 0, 1, 0),
(26, 26, '7db0d8da-05d3-11e5-b24c-15c6a5e79537', '708b2dd9000f6beb20fbfe65ad276741', '964242e3d0bd0b3df27b8314ee9186e0', 3, '', '', '0000-00-00 00:00:00', 0, 0, 0),
(27, 27, '65315215-08ff-11e5-b720-27553714bc74', '6a6b2833ac6740bed365b8745a8eefcf', '125527321bb8dec70ab8ee0a1f262ad9', 3, '', '', '0000-00-00 00:00:00', 1, 1, 0),
(28, 28, '95e296ad-1066-11e5-8326-001e3d06942b', '4791f32d05a0d8944bcca4057976eae4', '651a525d4e52472ca348e3b91b56b999', 3, '', '', '0000-00-00 00:00:00', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_user_menu_permission`
--

CREATE TABLE IF NOT EXISTS `bsc_user_menu_permission` (
  `user_permission_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`user_permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

--
-- Dumping data for table `bsc_user_menu_permission`
--

INSERT INTO `bsc_user_menu_permission` (`user_permission_id`, `user_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 13, 1),
(3, 15, 1),
(4, 11, 1),
(5, 12, 1),
(6, 24, 1),
(7, 8, 1),
(8, 9, 1),
(9, 16, 1),
(10, 23, 1),
(11, 27, 1),
(12, 1, 2),
(13, 13, 2),
(14, 15, 2),
(15, 11, 2),
(16, 12, 2),
(17, 24, 2),
(18, 8, 2),
(19, 9, 2),
(20, 16, 2),
(21, 23, 2),
(22, 27, 2),
(23, 1, 3),
(24, 13, 3),
(25, 15, 3),
(26, 11, 3),
(27, 12, 3),
(28, 24, 3),
(29, 8, 3),
(30, 9, 3),
(31, 16, 3),
(32, 23, 3),
(33, 27, 3),
(34, 1, 4),
(35, 13, 4),
(36, 15, 4),
(37, 11, 4),
(38, 12, 4),
(39, 24, 4),
(40, 8, 4),
(41, 9, 4),
(42, 16, 4),
(43, 23, 4),
(44, 27, 4),
(45, 1, 5),
(46, 13, 5),
(47, 15, 5),
(48, 11, 5),
(49, 12, 5),
(50, 24, 5),
(51, 8, 5),
(52, 9, 5),
(53, 16, 5),
(54, 23, 5),
(55, 27, 5),
(56, 1, 6),
(57, 13, 6),
(58, 15, 6),
(59, 11, 6),
(60, 12, 6),
(61, 24, 6),
(62, 8, 6),
(63, 9, 6),
(64, 16, 6),
(65, 23, 6),
(66, 27, 6),
(67, 1, 7),
(68, 13, 7),
(69, 15, 7),
(70, 11, 7),
(71, 12, 7),
(72, 24, 7),
(73, 8, 7),
(74, 9, 7),
(75, 16, 7),
(76, 23, 7),
(77, 27, 7),
(78, 1, 8),
(79, 13, 8),
(80, 15, 8),
(81, 11, 8),
(82, 12, 8),
(83, 24, 8),
(84, 8, 8),
(85, 9, 8),
(86, 16, 8),
(87, 23, 8),
(88, 27, 8),
(89, 1, 9),
(90, 13, 9),
(91, 15, 9),
(92, 11, 9),
(93, 12, 9),
(94, 24, 9),
(95, 8, 9),
(96, 9, 9),
(97, 16, 9),
(98, 23, 9),
(99, 27, 9),
(100, 1, 10),
(101, 13, 10),
(102, 15, 10),
(103, 11, 10),
(104, 12, 10),
(105, 24, 10),
(106, 8, 10),
(107, 9, 10),
(108, 16, 10),
(109, 23, 10),
(110, 27, 10),
(111, 28, 1),
(112, 28, 2),
(113, 28, 3),
(114, 28, 4),
(115, 28, 5),
(116, 28, 6),
(117, 28, 7),
(118, 28, 8),
(119, 28, 9),
(120, 28, 10),
(121, 1, 11),
(122, 13, 11),
(123, 15, 11),
(124, 1, 12),
(125, 13, 12),
(126, 15, 12),
(127, 1, 13),
(128, 13, 13),
(129, 15, 13),
(130, 1, 14),
(131, 13, 14),
(132, 15, 14),
(133, 1, 15),
(134, 13, 15),
(135, 15, 15),
(136, 1, 16),
(137, 13, 16),
(138, 15, 16),
(139, 8, 16),
(140, 9, 16),
(141, 16, 16),
(142, 23, 16),
(143, 27, 16),
(144, 1, 17),
(145, 13, 17),
(146, 15, 17),
(147, 8, 17),
(148, 9, 17),
(149, 16, 17),
(150, 23, 17),
(151, 27, 17),
(152, 1, 18),
(153, 13, 18),
(154, 15, 18),
(155, 11, 18),
(156, 12, 18),
(157, 24, 18),
(158, 8, 18),
(159, 9, 18),
(160, 16, 18),
(161, 23, 18),
(162, 27, 18),
(163, 1, 19),
(164, 13, 19),
(165, 15, 19),
(166, 11, 19),
(167, 12, 19),
(168, 24, 19),
(169, 8, 19),
(170, 9, 19),
(171, 16, 19),
(172, 23, 19),
(173, 27, 19);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bsc_user_login_details`
--
ALTER TABLE `bsc_user_login_details`
  ADD CONSTRAINT `bsc_user_login_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `bsc_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
