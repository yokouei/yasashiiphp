-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 7 朁E21 日 10:33
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
DROP DATABASE `household_budget`;
CREATE DATABASE IF NOT EXISTS `household_budget` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `household_budget`;

-- --------------------------------------------------------

--
-- テーブルの構造 `account`
--

CREATE TABLE `account` (
  `id` tinyint(4) NOT NULL,
  `type` int(1) DEFAULT '1',
  `name` varchar(30) NOT NULL,
  `owner` tinyint(3) DEFAULT NULL,
  `account` varchar(20) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  `debit_account` tinyint(3) DEFAULT NULL,
  `debit_day` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `account`
--

INSERT INTO `account` (`id`, `type`, `name`, `owner`, `account`, `link`, `limit`, `debit_account`, `debit_day`) VALUES
(3, 2, 'みずほ銀行', 1, NULL, NULL, NULL, NULL, NULL),
(4, 2, 'みずほ銀行', 2, NULL, NULL, NULL, NULL, NULL),
(5, 2, '三菱東京UFJ銀行', 1, NULL, NULL, NULL, NULL, NULL),
(6, 2, '三菱東京UFJ銀行', 2, NULL, NULL, NULL, NULL, NULL),
(7, 2, '新生銀行', 1, NULL, NULL, NULL, NULL, NULL),
(8, 2, '新生銀行', 2, NULL, NULL, NULL, NULL, NULL),
(9, 2, '三井住友銀行', 2, NULL, NULL, NULL, NULL, NULL),
(10, 2, '住信SBIネット銀行', 2, NULL, NULL, NULL, NULL, NULL),
(11, 1, '楽天カード', 1, NULL, NULL, NULL, NULL, NULL),
(12, 1, '楽天カード', 2, NULL, NULL, NULL, NULL, NULL),
(13, 1, 'ヤフーカード', 1, 'rosuyi', 'http://www.jaccs.co.jp/', NULL, NULL, NULL),
(14, 1, 'ヤフーカード', 2, 'yokouei', 'http://www.jaccs.co.jp/', NULL, NULL, NULL),
(15, 1, '漢方スタイルクラブカード', 1, 'rosuyi', 'http://www.jaccs.co.jp/', NULL, NULL, NULL),
(16, 1, '漢方スタイルクラブカード', 2, 'yokouei', 'http://www.jaccs.co.jp/', NULL, NULL, NULL),
(17, 1, 'エポスカード', 1, '', 'https://www.eposcard.co.jp/member/index.html?from=PCtop', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `csv`
--

CREATE TABLE `csv` (
  `id` int(11) NOT NULL,
  `account_id` tinyint(3) NOT NULL,
  `account_year` int(4) NOT NULL,
  `account_month` int(2) NOT NULL,
  `file` varchar(20) NOT NULL,
  `has_read` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `time` date NOT NULL,
  `detail` varchar(50) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `member` tinyint(3) NOT NULL DEFAULT '6',
  `type` tinyint(3) NOT NULL,
  `account_id` tinyint(3) NOT NULL,
  `account_year` int(4) DEFAULT NULL,
  `account_month` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `expense`
--

INSERT INTO income_expense (`id`, `time`, shop, `number`, `member`, `type`, csv, `account_year`, `account_month`) VALUES
(1, '2015-12-22', 'ベツタベビーストア', 8428, 6, 0, 15, 2016, 2),
(2, '2015-12-24', 'ヨドバシカメラ　通信販売', 5084, 6, 0, 15, 2016, 2),
(3, '2015-12-24', 'ヨドバシカメラ　通信販売', 2340, 6, 0, 15, 2016, 2),
(4, '2015-12-24', 'ヨドバシカメラ　通信販売', 2200, 6, 0, 15, 2016, 2),
(5, '2015-12-24', 'ヨドバシカメラ　通信販売', 2170, 6, 0, 15, 2016, 2),
(6, '2015-12-24', 'グランデュオ　蒲田', 3240, 6, 0, 15, 2016, 2),
(7, '2015-12-25', 'ベツタベビーストア', 15818, 6, 0, 15, 2016, 2),
(8, '2015-12-25', 'ヨドバシカメラ　通信販売', 12387, 6, 0, 15, 2016, 2),
(9, '2015-12-25', 'ヨドバシカメラ　通信販売', 6620, 6, 0, 15, 2016, 2),
(10, '2015-12-25', 'ベツタベビーストア', 5965, 6, 0, 15, 2016, 2),
(11, '2015-12-25', 'ベツタベビーストア', 5450, 6, 0, 15, 2016, 2),
(12, '2015-12-25', 'ベツタベビーストア', 5450, 6, 0, 15, 2016, 2),
(13, '2015-12-25', 'ベツタベビーストア', 5450, 6, 0, 15, 2016, 2),
(14, '2015-12-25', 'ベツタベビーストア', 5351, 6, 0, 15, 2016, 2),
(15, '2015-12-25', 'ベツタベビーストア', 5253, 6, 0, 15, 2016, 2),
(16, '2015-12-25', 'ベツタベビーストア', 5253, 6, 0, 15, 2016, 2),
(17, '2015-12-25', 'ベツタベビーストア', 4959, 6, 0, 15, 2016, 2),
(18, '2015-12-25', 'ヨドバシカメラ　通信販売', 4140, 6, 0, 15, 2016, 2),
(19, '2015-12-25', 'ヨドバシカメラ　通信販売', 2750, 6, 0, 15, 2016, 2),
(20, '2015-12-25', 'ヨドバシカメラ　通信販売', 2200, 6, 0, 15, 2016, 2),
(21, '2015-12-25', 'ヨドバシカメラ　通信販売', 1694, 6, 0, 15, 2016, 2),
(22, '2015-12-26', 'オーケー　サガン店', 27804, 6, 0, 15, 2016, 2),
(23, '2015-12-26', 'ウエルシア大田萩中', 16288, 6, 0, 15, 2016, 2),
(24, '2015-12-27', 'ヨドバシカメラ　マルチメディア　川崎', 61958, 6, 0, 15, 2016, 2),
(25, '2015-12-27', 'ヨドバシカメラ　通信販売（新経路）', 7530, 6, 0, 15, 2016, 2),
(26, '2015-12-27', 'ＡＭＡＺＯＮ．ＣＯ．ＪＰ', 7254, 6, 0, 15, 2016, 2),
(27, '2015-12-27', 'ヨドバシカメラ　通信販売', 3320, 6, 0, 15, 2016, 2),
(28, '2015-12-27', 'ドラッグセガミ蒲田駅前', 1316, 6, 0, 15, 2016, 2),
(29, '2015-12-27', 'オーケー　サガン店', 1283, 6, 0, 15, 2016, 2),
(30, '2015-12-28', 'ヤフー・ショッピング　トイザらス・ベビー', 46196, 6, 0, 15, 2016, 2),
(31, '2015-12-28', 'ニシマツヤチエ－ン', 28370, 6, 0, 15, 2016, 2),
(32, '2015-12-28', 'ヨドバシカメラ　マルチメディア　川崎', 5435, 6, 0, 15, 2016, 2),
(33, '2015-12-28', 'ＡＭＡＺＯＮ．ＣＯ．ＪＰ', 4189, 6, 0, 15, 2016, 2),
(34, '2015-12-28', 'ベツタベビーストア', 6664, 6, 0, 15, 2016, 2),
(35, '2015-12-30', 'ヤフー・ショッピング　トイザらス・ベビー', 80316, 6, 0, 15, 2016, 2),
(36, '2015-12-30', '犬印本舗', 16632, 6, 0, 15, 2016, 2),
(37, '2015-12-30', 'ドクタ－シ－ラボ', 13780, 6, 0, 15, 2016, 2),
(38, '2015-12-30', 'ドクタ－シ－ラボ', 10000, 6, 0, 15, 2016, 2),
(39, '2015-12-30', 'ドクタ－シ－ラボ', 10000, 6, 0, 15, 2016, 2),
(40, '2015-12-30', 'セイユウドツトコム　ソ', 9007, 6, 0, 15, 2016, 2),
(41, '2015-12-30', 'ヨドバシカメラ　マルチメディア　川崎', 6234, 6, 0, 15, 2016, 2),
(42, '2015-12-30', 'ヨドバシカメラ　通信販売', 4910, 6, 0, 15, 2016, 2),
(43, '2015-12-30', 'ヨドバシカメラ　マルチメディア　川崎', 3655, 6, 0, 15, 2016, 2),
(44, '2015-12-30', 'ヨドバシカメラ　マルチメディア　川崎', 3576, 6, 0, 15, 2016, 2),
(45, '2015-12-30', 'グランデュオ　蒲田', 1296, 6, 0, 15, 2016, 2),
(46, '2015-12-30', '川崎ルフロン', 7722, 6, 0, 15, 2016, 2),
(47, '2015-12-31', 'ヨドバシカメラ　通信販売', 2885, 6, 0, 15, 2016, 2),
(48, '2015-12-31', 'オーケー　サガン店', 13655, 6, 0, 15, 2016, 2),
(49, '2015-12-31', 'Ｓｏ－ｎｅｔ', 2322, 6, 0, 15, 2016, 2),
(50, '2015-12-31', 'Ｓｏ－ｎｅｔ', 1782, 6, 0, 15, 2016, 2),
(51, '2016-01-01', 'ヨドバシカメラ　マルチメディア　川崎', 4041, 6, 0, 15, 2016, 2),
(52, '2016-01-01', 'ＳＫＹＰＥ．ＣＯＭ', 360, 6, 0, 15, 2016, 2),
(53, '2016-01-01', 'ヨドバシカメラ　マルチメディア　川崎', 177, 6, 0, 15, 2016, 2),
(54, '2016-01-01', 'ヨドバシカメラ　通信販売', 74, 6, 0, 15, 2016, 2),
(55, '2016-01-02', '有楽町マルイ', 12409, 6, 0, 15, 2016, 2),
(56, '2016-01-02', '有楽町マルイ', 5292, 6, 0, 15, 2016, 2),
(57, '2016-01-02', 'グランデュオ　蒲田', 4470, 6, 0, 15, 2016, 2),
(58, '2016-01-02', 'Ｓｋｅｗ', 2600, 6, 0, 15, 2016, 2),
(59, '2016-01-04', '有楽町マルイ', 4104, 6, 0, 15, 2016, 2),
(60, '2016-01-04', 'グランデュオ　蒲田', 1080, 6, 0, 15, 2016, 2),
(61, '2016-01-04', '東京電力　　　　　　２０１６年　１月分', 4955, 6, 0, 15, 2016, 2),
(62, '2016-01-04', 'ヤフー・ショッピング　トイザらス・ベビー', 63930, 6, 0, 15, 2016, 2),
(63, '2016-01-04', 'ジェイアールヒガシニホン　テイキケンハツ', 15280, 6, 0, 15, 2016, 2),
(64, '2016-01-04', 'ＡＭＡＺＯＮ．ＣＯ．ＪＰ', 5618, 6, 0, 15, 2016, 2),
(65, '2016-01-04', 'ヨドバシカメラ　通信販売', 2170, 6, 0, 15, 2016, 2),
(66, '2016-01-04', 'ヨドバシカメラ　通信販売', 1992, 6, 0, 15, 2016, 2),
(67, '2016-01-04', 'ジェイアールヒガシニホン　テイキケンハツ', 6170, 6, 0, 15, 2016, 2),
(68, '2016-01-05', '犬印本舗', 8424, 6, 0, 15, 2016, 2),
(69, '2016-01-05', 'ソフトバンクＭ（１２月分）', 9026, 6, 0, 15, 2016, 2),
(70, '2016-01-05', 'オーケー　サガン店', 6239, 6, 0, 15, 2016, 2),
(71, '2016-01-05', 'ソフトバンクＭ（１２月分）', 4941, 6, 0, 15, 2016, 2),
(72, '2016-01-05', 'ヨドバシカメラ　通信販売', 2640, 6, 0, 15, 2016, 2),
(73, '2016-01-05', 'ヨドバシカメラ　通信販売', 2014, 6, 0, 15, 2016, 2),
(74, '2016-01-05', 'ＪＲヒガシニホン　ミドリノマドグチ', 13100, 6, 0, 15, 2016, 2),
(75, '2016-01-06', 'ヨドバシカメラ　通信販売', 3480, 6, 0, 15, 2016, 2),
(76, '2016-01-06', 'オーケー　サガン店', 908, 6, 0, 15, 2016, 2),
(77, '2016-01-06', 'ミニストップ　静岡御幸町店', 346, 6, 0, 15, 2016, 2),
(78, '2016-01-08', 'ベツタベビーストア', 8116, 6, 0, 15, 2016, 2),
(79, '2016-01-08', 'ココデカウ　ポンパレモール店', 6853, 6, 0, 15, 2016, 2),
(80, '2016-01-08', 'ベツタベビーストア', 6274, 6, 0, 15, 2016, 2),
(81, '2016-01-08', 'ベツタベビーストア', 5547, 6, 0, 15, 2016, 2),
(82, '2016-01-08', 'ベツタベビーストア', 5410, 6, 0, 15, 2016, 2),
(83, '2016-01-08', 'ベツタベビーストア', 5410, 6, 0, 15, 2016, 2),
(84, '2016-01-08', 'ベツタベビーストア', 4998, 6, 0, 15, 2016, 2),
(85, '2016-01-08', 'ヨドバシカメラ　通信販売', 4910, 6, 0, 15, 2016, 2),
(86, '2016-01-10', 'ＡＯＫＩ', 34866, 6, 0, 15, 2016, 2),
(87, '2016-01-13', '東京ガス　ガス料金　２０１６年　１月分', 4969, 6, 0, 15, 2016, 2);

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

INSERT INTO type (`id`, name, `valid`) VALUES
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

INSERT INTO type_detail (`id`, `type`, `name`, `valid`) VALUES
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
(4, '呂　逸帆'),
(5, '家族'),
(6, '代買');

-- --------------------------------------------------------

--
-- テーブルの構造 `type`
--

CREATE TABLE `type` (
  `id` int(1) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'カード'),
(2, '銀行');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `credit_id_uindex` (`id`),
  ADD KEY `account_fk` (`owner`),
  ADD KEY `account_type_fk` (`type`);

--
-- Indexes for table `csv`
--
ALTER TABLE `csv`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `csv_id_uindex` (`id`),
  ADD KEY `csv_fk` (`account_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE income_expense
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_id_uindex` (`id`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE type
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_type_id_uindex` (`id`);

--
-- Indexes for table `expense_type_detail`
--
ALTER TABLE type_detail
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
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_id_uindex` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `csv`
--
ALTER TABLE `csv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE income_expense
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE type
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `expense_type_detail`
--
ALTER TABLE type_detail
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
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_fk` FOREIGN KEY (`owner`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `account_type_fk` FOREIGN KEY (`type`) REFERENCES `type` (`id`);

--
-- テーブルの制約 `csv`
--
ALTER TABLE `csv`
  ADD CONSTRAINT `csv_fk` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`);

--
-- テーブルの制約 `expense_type_detail`
--
ALTER TABLE type_detail
  ADD CONSTRAINT `expense_type_detail_fk` FOREIGN KEY (`type`) REFERENCES type (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
