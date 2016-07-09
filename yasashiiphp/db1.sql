-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 7 朁E07 日 10:32
-- サーバのバージョン： 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db1`
--

CREATE DATABASE IF NOT EXISTS `db1` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db1`;

-- --------------------------------------------------------

--
-- テーブルの構造 `category`
--

CREATE TABLE `category` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(2, '中華'),
(1, '和食'),
(3, '洋食');

-- --------------------------------------------------------

--
-- テーブルの構造 `difficulty`
--

CREATE TABLE `difficulty` (
  `id` tinyint(1) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `difficulty`
--

INSERT INTO `difficulty` (`id`, `name`) VALUES
(2, '普通'),
(1, '簡単'),
(3, '難しい');

-- --------------------------------------------------------

--
-- テーブルの構造 `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `recipe_name` varchar(45) NOT NULL,
  `category` tinyint(1) NOT NULL,
  `difficulty` tinyint(1) NOT NULL,
  `budget` mediumint(9) NOT NULL,
  `howto` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `recipes`
--

INSERT INTO `recipes` (`id`, `recipe_name`, `category`, `difficulty`, `budget`, `howto`) VALUES
(1, 'カレーライス', 3, 2, 1000, '1．たまねぎと鶏肉を炒める\r\n2．水800mlを加えて10分煮る\r\n3．ルーを加えてさらに10分煮る'),
(3, 'チャーハン', 2, 2, 1200, '1、スパムを切っておく。\r\n2、スパムを炒める。(油は不要。)\r\n3、焼き色ついたら、バターを入れ、冷や飯、塩・胡椒、コンソメを入れ混ぜ炒める。\r\n4、出来上がり直前にレタスをちぎって入れ、サッと炒めたら出来上がり♪'),
(4, '肉じゃが', 1, 2, 1500, '1、じゃが芋の皮をむいて４ツ切りにし、水にさらしておく。\r\n2、たまねぎは薄切りにする。\r\n3、牛薄切り肉は一口大に切る。\r\n4、鍋にサラダ油を熱し、牛肉を色が変わるまでさっと炒めたら、たまねぎと水気を切ったじゃが芋とニンジンを加える。'),
(6, 'オムライス', 1, 2, 2000, '1、チキンライスをつくります。お米はできたら硬めに炊きます。冷やご飯でも大丈夫です。\r\n2、たまねぎはみじん切りに、とり肉は一口大に、ウインナーの場合は5mmくらいの薄切りに切っておきます。');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_id_uindex` (`id`),
  ADD UNIQUE KEY `category_name_uindex` (`name`);

--
-- Indexes for table `difficulty`
--
ALTER TABLE `difficulty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `difficulty_id_uindex` (`id`),
  ADD UNIQUE KEY `difficulty_name_uindex` (`name`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `difficulty_fk` (`difficulty`),
  ADD KEY `category_fk` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `difficulty`
--
ALTER TABLE `difficulty`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `category_fk` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `difficulty_fk` FOREIGN KEY (`difficulty`) REFERENCES `difficulty` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
