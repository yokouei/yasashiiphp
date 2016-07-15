<?php
/**
* いちばんやさしいPHPの教本 サンプルコード
* 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
*
* update.php 更新処理
*/

//データベース設定の読み込み
require_once(dirname(__FILE__)."/../db_config.php");

//フォームからのデータを変数に置き換える
$send_time = $_POST['send_time'];
$receive_time = $_POST['receive_time'];
//$valid = $_POST['valid'];

//try〜catchにてエラーハンドリングを行う。
try {
	//$_GET['id']が空かのチェックを行う。（id=0でもこの場合Exceptionを発生させる)
  if (empty($_POST['id'])) throw new Exception('Error');

	//取得した$_GET['id']は文字列であるため数値型に変換を行う。
	$id = (int) $_POST['id'];

	//PDOを使ったデータベースへの接続
	//$user,$passはdb_config.phpにて定義済み
	$dbh = new PDO('mysql:host=localhost;dbname=mamazon;charset=utf8', $user, $pass);

	//PDOの実行モードの設定
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//更新用のSQLを生成
	$sql = "UPDATE shipping SET send_time = ?, receive_time = ? WHERE id = ?";
  //SQL実行の準備
	$stmt = $dbh->prepare($sql);
  //bindValueにてSQLに値を組み込む
	$stmt->bindValue(1, $send_time, PDO::PARAM_STR);
	$stmt->bindValue(2, $receive_time, PDO::PARAM_STR);
	//$stmt->bindValue(3, $valid, PDO::PARAM_INT);
	$stmt->bindValue(3, $id, PDO::PARAM_INT);
  //SQLの実行
	$stmt->execute();
  //接続を閉じる
	$dbh = null;
  //完了メッセージをブラウザに表示
	echo "ID: " . htmlspecialchars($id,ENT_QUOTES,'UTF-8') ."レシピの更新が完了しました。<br>";
	echo "<a href='index.php'>トップページへ戻る</a>";
  //try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (Exception $e) {
  //エラーメッセージ出力
	echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  //処理の終了
	die();
}
