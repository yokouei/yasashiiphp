<?php
/**
* いちばんやさしいPHPの教本 サンプルコード
* 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
*
* update.php 更新処理
*/

//データベース設定の読み込み
require_once(dirname(__FILE__)."/../db_config.php");

//try〜catchにてエラーハンドリングを行う。
try {
	//PDOを使ったデータベースへの接続
	//$user,$passはdb_config.phpにて定義済み
	$dbh = new PDO('mysql:host=localhost;dbname=mamazon;charset=utf8', $user, $pass);

	//PDOの実行モードの設定
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/*
	 *
	 update shipping SET valid = 0 WHERE number in (
SELECT aa.number from (
SELECT a.state, a.number, b.avgs, DATEDIFF(a.receive_time, a.send_time) AS days
FROM (SELECT * FROM shipping WHERE receive_time IS NOT NULL AND ship = 5 AND valid = 1) a
  LEFT JOIN (
              SELECT state, FLOOR(AVG(DATEDIFF(receive_time, send_time))) AS avgs
              FROM shipping
              WHERE receive_time IS NOT NULL AND ship = 5 AND valid = 1
              GROUP BY state) b ON a.state = b.state
 ) aa WHERE aa.days > aa.avgs + 1 ORDER BY aa.state)
	
	 */
	//更新用のSQLを生成
	$sql = "SELECT a.state, b.EMS, c.EPACK, d.SHIP
FROM (SELECT DISTINCT state FROM shipping) a
  LEFT JOIN (
              SELECT state, FLOOR(AVG(DATEDIFF(receive_time, send_time))) AS EMS
              FROM shipping
              WHERE receive_time IS NOT NULL AND ship = 1 AND valid = 1
              GROUP BY state) b ON a.state = b.state
  LEFT JOIN (
              SELECT state, FLOOR(AVG(DATEDIFF(receive_time, send_time))) AS EPACK
              FROM shipping
              WHERE receive_time IS NOT NULL AND ship = 2 AND valid = 1
              GROUP BY state) c ON a.state = c.state
  LEFT JOIN (
              SELECT state, FLOOR(AVG(DATEDIFF(receive_time, send_time))) AS SHIP
              FROM shipping
              WHERE receive_time IS NOT NULL AND ship = 5 AND valid = 1
              GROUP BY state) d ON a.state = d.state
ORDER BY c.EPACK IS NULL ASC, c.EPACK";

	//SQLの実行
	$stmt = $dbh->query($sql);
	//SQLの結果を$resultに取得する
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	//テーブル部分のHTMLを生成
	echo "<table border='1'>\n";
	echo "<tr>\n";
	echo "<th>STATE</th><th>EPACK</th><th>SHIP</th>\n";
	echo "</tr>\n";
	//取得したデータが無くなるまでforeach()で処理を繰り返す。
	//取得した値は各カラムに表示を行う。
	//ループ処理の開始
	foreach ($result as $row) {
		echo "<tr>\n";
		echo "<td>" . htmlspecialchars($row['state'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		//echo "<td>" . htmlspecialchars($row['EMS'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		echo "<td>" . htmlspecialchars($row['EPACK'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		echo "<td>" . htmlspecialchars($row['SHIP'], ENT_QUOTES, 'UTF-8') . "</td>\n";

		echo "</tr>\n";
		//ループ処理の終了
	}
	//テーブルタグを閉じる
	echo "</table>\n";

  //接続を閉じる
	$dbh = null;
  //完了メッセージをブラウザに表示

	echo "<a href='index.php'>トップページへ戻る</a>";
  //try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (Exception $e) {
  //エラーメッセージ出力
	echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  //処理の終了
	die();
}
