-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 7 朁E15 日 10:12
-- サーバのバージョン： 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `household_budget`
--
CREATE DATABASE IF NOT EXISTS `household_budget` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `household_budget`;

-- --------------------------------------------------------

--
-- テーブルの構造 `bank`
--

CREATE TABLE `bank` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(30) NOT NULL,
  `owner` tinyint(3) DEFAULT NULL,
  `account` varchar(20) DEFAULT NULL,
  `link` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `bank`
--

INSERT INTO `bank` (`id`, `name`, `owner`, `account`, `link`) VALUES
(3, 'みずほ銀行', 1, NULL, NULL),
(4, 'みずほ銀行', 2, NULL, NULL),
(5, '三菱東京UFJ銀行', 1, NULL, NULL),
(6, '三菱東京UFJ銀行', 2, NULL, NULL),
(7, '新生銀行', 1, NULL, NULL),
(8, '新生銀行', 2, NULL, NULL),
(9, '三井住友銀行', 2, NULL, NULL),
(10, '住信SBIネット銀行', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `credit`
--

CREATE TABLE `credit` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(30) NOT NULL,
  `owner` tinyint(3) DEFAULT NULL,
  `account` varchar(20) DEFAULT NULL,
  `link` varchar(30) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  `debit_account` tinyint(3) DEFAULT NULL,
  `debit_day` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `credit`
--

INSERT INTO `credit` (`id`, `name`, `owner`, `account`, `link`, `limit`, `debit_account`, `debit_day`) VALUES
(11, '楽天カード', 1, NULL, NULL, NULL, NULL, NULL),
(12, '楽天カード', 2, NULL, NULL, NULL, NULL, NULL),
(13, 'ヤフーカード', 1, 'rosuyi', 'http://www.jaccs.co.jp/', NULL, NULL, NULL),
(14, 'ヤフーカード', 2, 'yokouei', 'http://www.jaccs.co.jp/', NULL, NULL, NULL),
(15, '漢方スタイルクラブカード', 1, NULL, NULL, NULL, NULL, NULL),
(16, '漢方スタイルクラブカード', 2, NULL, NULL, NULL, NULL, NULL),
(17, 'エポスカード', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `member` tinyint(3) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `number` int(11) NOT NULL,
  `account` tinyint(3) NOT NULL,
  `time` date NOT NULL,
  `detail` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `expense_type`
--

CREATE TABLE `expense_type` (
  `id` tinyint(3) NOT NULL,
  `type` varchar(10) NOT NULL,
  `valid` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `expense_type`
--

INSERT INTO `expense_type` (`id`, `type`, `valid`) VALUES
(1, '食費', 1),
(2, '日用雑貨', 1),
(3, '交通', 1),
(4, '交際費', 1),
(5, '教育・教養', 1),
(6, '美容・洋服', 1),
(7, '医療・保険', 1),
(8, '通信', 1),
(9, '水道・光熱', 1),
(10, '住まい', 1),
(11, '税金', 1),
(12, '大型出費', 1),
(13, '車', 1),
(14, 'その他', 1),
(15, 'エンタメ', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `expense_type_detail`
--

CREATE TABLE `expense_type_detail` (
  `id` tinyint(3) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `name` varchar(10) NOT NULL,
  `valid` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `expense_type_detail`
--

INSERT INTO `expense_type_detail` (`id`, `type`, `name`, `valid`) VALUES
(1, 1, '食料品', 1),
(2, 1, '朝御飯', 1),
(3, 1, '昼御飯', 1),
(4, 1, '晩御飯', 1),
(5, 1, 'カフェ', 1),
(6, 1, 'その他', 1),
(7, 2, '消耗品', 1),
(8, 2, '子ども関連', 1),
(9, 2, 'ペット関連', 1),
(10, 2, 'タバコ', 1),
(11, 2, 'その他', 1),
(12, 3, '電車', 1),
(13, 3, 'タクシー', 1),
(14, 3, 'バス', 1),
(15, 3, '飛行機', 1),
(16, 3, 'その他', 1),
(17, 4, '飲み会', 1),
(18, 4, 'プレゼント', 1),
(19, 4, 'ご祝儀・香典', 1),
(20, 4, 'その他', 1),
(21, 5, '習い事', 1),
(22, 5, '新聞', 1),
(23, 5, '参考書', 1),
(24, 5, '受験料', 1),
(25, 5, '学費', 1),
(26, 5, '学資保険', 1),
(27, 5, '塾', 1),
(28, 5, 'その他', 1),
(29, 6, '洋服', 1),
(30, 6, 'アクセサリー・小物', 1),
(31, 6, '下着', 1),
(32, 6, 'ジム・健康', 1),
(33, 6, '美容院', 1),
(34, 6, 'コスメ', 1),
(35, 6, 'エステ・ネイル', 1),
(36, 6, 'クリーニング', 1),
(37, 6, 'その他', 1),
(38, 7, '病院代', 1),
(39, 7, '薬代', 1),
(40, 7, '生命保険', 1),
(41, 7, '医療保険', 1),
(42, 7, 'その他', 1),
(43, 8, '携帯電話料金', 1),
(44, 8, '固定電話料金', 1),
(45, 8, 'インターネット関連費', 1),
(46, 8, '放送サービス料金', 1),
(47, 8, '宅配便', 1),
(48, 8, '切手・はがき', 1),
(49, 8, 'その他', 1),
(50, 9, '水道料金', 1),
(51, 9, '電気料金', 1),
(52, 9, 'ガス料金', 1),
(53, 9, 'その他', 1),
(54, 10, '家賃', 1),
(55, 10, '住宅ローン返済', 1),
(56, 10, '家具', 1),
(57, 10, '家電', 1),
(58, 10, 'リフォーム', 1),
(59, 10, '住宅保険', 1),
(60, 10, 'その他', 1),
(61, 11, '年金', 1),
(62, 11, '所得税', 1),
(63, 11, '消費税', 1),
(64, 11, '住民税', 1),
(65, 11, '個人事業税', 1),
(66, 11, 'その他', 1),
(67, 12, '旅行', 1),
(68, 12, '住宅', 1),
(69, 12, '自動車', 1),
(70, 12, 'バイク', 1),
(71, 12, '結婚', 1),
(72, 12, '出産', 1),
(73, 12, '介護', 1),
(74, 12, '家具', 1),
(75, 12, '家電', 1),
(76, 12, 'その他', 1),
(77, 13, 'ガソリン', 1),
(78, 13, '駐車場', 1),
(79, 13, '自動車保険', 1),
(80, 13, '自動車税', 1),
(81, 13, '自動車ローン', 1),
(82, 13, '免許教習', 1),
(83, 13, '高速料金', 1),
(84, 13, 'その他', 1),
(85, 14, '仕送り', 1),
(86, 14, 'お小遣い', 1),
(87, 14, '使途不明金', 1),
(88, 14, '立替金', 1),
(89, 14, '未分類', 1),
(90, 14, '現金の引出', 1),
(91, 14, 'カードの引落', 1),
(92, 14, '電子マネーにチャージ', 1),
(93, 14, 'その他', 1),
(94, 15, 'レジャー', 1),
(95, 15, 'イベント', 1),
(96, 15, '映画・動画', 1),
(97, 15, '音楽', 1),
(98, 15, '漫画', 1),
(99, 15, '書籍', 1),
(100, 15, 'ゲーム', 1),
(101, 15, 'その他', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `owner` tinyint(3) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT '1',
  `number` int(11) NOT NULL,
  `account` tinyint(4) NOT NULL,
  `time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `income_type`
--

CREATE TABLE `income_type` (
  `id` tinyint(3) NOT NULL,
  `name` varchar(10) NOT NULL,
  `valid` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `income_type`
--

INSERT INTO `income_type` (`id`, `name`, `valid`) VALUES
(1, '給与所得', 1),
(2, '立替金返済', 1),
(3, '賞与', 1),
(4, '臨時収入', 1),
(5, '事業所得', 1),
(6, 'その他', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `member`
--

CREATE TABLE `member` (
  `id` tinyint(3) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `member`
--

INSERT INTO `member` (`id`, `name`) VALUES
(1, '呂　帥'),
(2, '余　江英'),
(3, '呂　逸喬'),
(4, '呂　逸帆');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bank_id_uindex` (`id`);

--
-- Indexes for table `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `credit_id_uindex` (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_id_uindex` (`id`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE `expense_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_type_id_uindex` (`id`);

--
-- Indexes for table `expense_type_detail`
--
ALTER TABLE `expense_type_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_type_detail_id_uindex` (`id`),
  ADD KEY `expense_type_detail_fk` (`type`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `income_id_uindex` (`id`);

--
-- Indexes for table `income_type`
--
ALTER TABLE `income_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `income_type_id_uindex` (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_id_uindex` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `credit`
--
ALTER TABLE `credit`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE `expense_type`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `expense_type_detail`
--
ALTER TABLE `expense_type_detail`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `income_type`
--
ALTER TABLE `income_type`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `expense_type_detail`
--
ALTER TABLE `expense_type_detail`
  ADD CONSTRAINT `expense_type_detail_fk` FOREIGN KEY (`type`) REFERENCES `expense_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
