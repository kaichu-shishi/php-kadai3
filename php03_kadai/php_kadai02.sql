-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 12 月 26 日 11:28
-- サーバのバージョン： 10.4.21-MariaDB
-- PHP のバージョン: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `php_kadai02`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_bm_table`
--

CREATE TABLE `gs_bm_table` (
  `book_id` int(12) NOT NULL,
  `book_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `book_url` text COLLATE utf8_unicode_ci NOT NULL,
  `book_comment` text COLLATE utf8_unicode_ci NOT NULL,
  `creation_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `gs_bm_table`
--

INSERT INTO `gs_bm_table` (`book_id`, `book_name`, `book_url`, `book_comment`, `creation_time`) VALUES
(1, 'PHP本', 'http://php.jp', '読みたい本', '2022-12-18 10:12:38'),
(2, 'PHP&JS', 'http://JS.jp', '困ったら再度読みたい', '2022-12-18 10:13:32'),
(3, '21lessons+PY', 'https://www.kawade.co.jp/np/isbn/9784309227887/', 'この作者の文体はちょっと好き', '2022-12-18 10:16:37'),
(4, '人を動かす', 'https://www.sogensha.co.jp/productlist/detail?id=1587', 'カーネギー先生を尊敬します', '2022-12-18 10:18:12'),
(5, '恋愛工学の教科書', 'http://www.horei.com/book_978-4-86280-629-1.html', '男性を救う一冊', '2022-12-18 10:23:05'),
(6, '＜インターネット＞の次に来るもの', 'https://www.nhk-book.co.jp/detail/000000817042016.html', '未読だが早く読みたい', '2022-12-18 14:53:54'),
(7, 'オブジェクト指向UIデザイン+RB', 'https://gihyo.jp/book/2020/978-4-297-11351-3', '読めてよかった', '2022-12-18 14:53:54'),
(8, '［改訂版］WordPress 仕事の現場でサッと使える！ デザイン教科書 ［WordPress 5.x対応版］', 'https://gihyo.jp/book/2020/978-4-297-11185-4', '何回も読み返しています', '2022-12-18 14:53:54'),
(9, 'CSS設計完全ガイド+PY', 'https://gihyo.jp/book/2020/978-4-297-11173-1', 'クラス名の付け方のルールなどが分かって自信がついた', '2022-12-18 10:48:12'),
(10, '1週間でGoogleアナリティクス4の基礎が学べる本', 'https://book.impress.co.jp/books/1120101144', '授業で買ったはいいものの全然読めていない', '2022-12-18 10:51:15');

-- --------------------------------------------------------

--
-- テーブルの構造 `words_and_deeds_table`
--

CREATE TABLE `words_and_deeds_table` (
  `wd_id` int(12) NOT NULL,
  `wd_title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `wd_cards` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `wd_text` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `words_and_deeds_table`
--

INSERT INTO `words_and_deeds_table` (`wd_id`, `wd_title`, `wd_cards`, `wd_text`, `date`) VALUES
(1, 'テスト1', '男フォルダに入れ,タイムコンストレインメソッド,恋愛遍歴の話を引き出せ', 'テスト1', '2022-12-26 19:08:01'),
(2, 'いじりつつ笑いを生む', '男フォルダに入れ,うまくいじって上下関係を築け', '「◯◯さんって意外と話しやすいですね」と言う。', '2022-12-13 14:35:43'),
(3, 'テスト2', 'Cフェーズ,恋愛遍歴の話を引き出せ', 'テスト2', '2022-12-13 14:44:03'),
(4, '恐怖の友達フォルダ行きを回避', '男フォルダに入れ', '「髪型ソフトクリームみたいで美味しそうやな」と言う。その後「俺はそういう髪型好きだけどな」とフォローする。', '2022-12-15 15:25:10'),
(5, 'テスト', '男フォルダに入れ,Cフェーズ', '縦の長さチェック', '2022-12-26 18:55:30'),
(6, 'あ', 'うまくいじって上下関係を築け', 'あ', '2022-12-15 20:11:02'),
(7, 'あ', 'タイムコンストレインメソッド', 'あ', '2022-12-15 20:13:09'),
(8, 'あ', '男フォルダに入れ', 'あ', '2022-12-15 20:18:26'),
(9, 'あ', 'タイムコンストレインメソッド', 'あ', '2022-12-15 20:19:28'),
(10, 'あ', 'うまくいじって上下関係を築け', 'あ', '2022-12-15 20:19:55'),
(11, 'あ', '男フォルダに入れ', 'あ', '2022-12-15 20:21:37'),
(12, 'あ', 'タイムコンストレインメソッド', 'あ', '2022-12-15 20:22:06'),
(13, 'falseチェック', '男フォルダに入れ', 'falseチェック', '2022-12-15 20:26:49'),
(14, 'falseチェック2', '恋愛遍歴の話を引き出せ', 'falseチェック2', '2022-12-15 20:27:50'),
(15, 'falseチェック3', 'Cフェーズ', 'falseチェック3', '2022-12-15 20:35:30'),
(16, 'falseチェック4', 'うまくいじって上下関係を築け', 'falseチェック4', '2022-12-15 20:41:36'),
(17, 'あ', 'Cフェーズ', 'あ', '2022-12-16 12:39:09'),
(18, 'あ', 'うまくいじって上下関係を築け', 'あ', '2022-12-16 12:40:56');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `gs_bm_table`
--
ALTER TABLE `gs_bm_table`
  ADD PRIMARY KEY (`book_id`);

--
-- テーブルのインデックス `words_and_deeds_table`
--
ALTER TABLE `words_and_deeds_table`
  ADD PRIMARY KEY (`wd_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `gs_bm_table`
--
ALTER TABLE `gs_bm_table`
  MODIFY `book_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `words_and_deeds_table`
--
ALTER TABLE `words_and_deeds_table`
  MODIFY `wd_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
