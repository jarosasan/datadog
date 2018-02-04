-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018 m. Sau 10 d. 23:12
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datadog`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `beers`
--

CREATE TABLE `beers` (
  `id` int(6) NOT NULL,
  `brewery_id` int(6) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `cat_id` int(6) NOT NULL,
  `style_id` int(6) NOT NULL,
  `abv` double DEFAULT NULL,
  `ibu` double DEFAULT NULL,
  `srm` double DEFAULT NULL,
  `upc` double DEFAULT NULL,
  `filepath` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `descript` text COLLATE utf8_bin,
  `add_user` int(6) DEFAULT NULL,
  `last_mod` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `breweries`
--

CREATE TABLE `breweries` (
  `id` int(6) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `address1` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `filepath` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `descript` text COLLATE utf8_bin,
  `add_user` int(10) DEFAULT NULL,
  `last_mod` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `categories`
--

CREATE TABLE `categories` (
  `id` int(6) NOT NULL,
  `cat_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `last_mod` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `geocodes`
--

CREATE TABLE `geocodes` (
  `id` int(6) NOT NULL,
  `brewery_id` int(6) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `accuracy` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `styles`
--

CREATE TABLE `styles` (
  `id` int(6) NOT NULL,
  `cat_id` int(6) NOT NULL,
  `style_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `last_mod` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
