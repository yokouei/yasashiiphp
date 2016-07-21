-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 7 朁E19 日 10:27
-- サーバのバージョン： 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--
CREATE DATABASE IF NOT EXISTS `restaurant` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `restaurant`;

-- --------------------------------------------------------

--
-- テーブルの構造 `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(11) DEFAULT NULL,
  `dish_name` varchar(255) DEFAULT NULL,
  `price` decimal(4,2) DEFAULT NULL,
  `is_spicy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `dishes`
--

INSERT INTO `dishes` (`dish_id`, `dish_name`, `price`, `is_spicy`) VALUES
(1, 'Sesame Seed Puff', '2.50', 0),
(1, 'test', '5.00', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `dishes_seq`
--

CREATE TABLE `dishes_seq` (
  `id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `dishes_seq`
--

INSERT INTO `dishes_seq` (`id`) VALUES
(1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dishes_seq`
--
ALTER TABLE `dishes_seq`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dishes_seq`
--
ALTER TABLE `dishes_seq`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
