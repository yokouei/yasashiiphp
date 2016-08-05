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
/*
	echo "<pre>";
	var_dump($result);
	echo "<pre/>";
*/
	echo "<h2 align='center'>日本直邮,全场满300包邮包税<h2/>\n";
	echo "<h2 align='center'>不满300,+40<h2/>\n";
	echo "<h3 align='center'>日本邮政+中国邮政,平均到货时间<h3/>\n";

	//テーブル部分のHTMLを生成
	echo "<table border='1' align='center' width='400'>\n";
	echo "<tr>\n";
	echo "<th>省/市</th><th>平均到货时间</th><th>省/市</th><th>平均到货时间</th>\n";
	echo "</tr>\n";
	//取得したデータが無くなるまでforeach()で処理を繰り返す。
	//取得した値は各カラムに表示を行う。
	//ループ処理の開始
/*
	foreach ($result as $row) {
		echo "<tr>\n";
		echo "<td>" . htmlspecialchars($row['state'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		//echo "<td>" . htmlspecialchars($row['EMS'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		echo "<td>" . htmlspecialchars($row['EPACK'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		echo "<td>" . htmlspecialchars($row['SHIP'], ENT_QUOTES, 'UTF-8') . "</td>\n";

		echo "</tr>\n";
		//ループ処理の終了
	}
*/
	for($i = 0; $i < count($result) / 2; $i++)
	{
		if($i % 2)
			$color = "gray";
		else
			$color = "white";

		echo "<tr bgcolor={$color}>\n";
		echo "<td>" . htmlspecialchars($result[$i]['state'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		echo "<td align='center'>" . htmlspecialchars($result[$i]['EPACK'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		//echo "<td>" . htmlspecialchars($result[$i]['SHIP'], ENT_QUOTES, 'UTF-8') . "</td>\n";

		echo "<td>" . htmlspecialchars($result[$i + count($result) / 2]['state'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		echo "<td align='center'>" . htmlspecialchars($result[$i + count($result) / 2]['EPACK'], ENT_QUOTES, 'UTF-8') . "</td>\n";
		//echo "<td>" . htmlspecialchars($result[$i + count($result) / 2]['SHIP'], ENT_QUOTES, 'UTF-8') . "</td>\n";

		echo "</tr>\n";


	}
	//テーブルタグを閉じる
	echo "</table>\n";

  //接続を閉じる
	$dbh = null;
  //完了メッセージをブラウザに表示

	echo "<br/>\n";
	echo "<br/>\n";
	echo "<br/>\n";

	echo "<a href='index.php'>トップページへ戻る</a>";
  //try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (Exception $e) {
  //エラーメッセージ出力
	echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  //処理の終了
	die();
}
