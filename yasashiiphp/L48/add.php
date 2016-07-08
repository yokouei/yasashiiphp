<?php
/**
 * いちばんやさしいPHPの教本 サンプルコード
 * 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
 *
 * add.php レシピ追加処理
 */

//データベースの設定を読み込む
require_once(dirname(__FILE__)."/../db_config.php");

//POSTされた値を変数に代入する
$recipe_name = $_POST['recipe_name'];
$howto = $_POST['howto'];
$category = (int) $_POST['category'];
$difficulty = (int) $_POST['difficulty'];
$budget = (int) $_POST['budget'];

//try〜catchにてエラーハンドリングを行う。
try {
	//PDOを使ったデータベースへの接続
	//$user,$passはdb_config.phpにて定義済み
	$dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);

	//PDOの実行モードの設定
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//INSERT用のSQLを生成
	$sql = "INSERT INTO recipes (recipe_name, category, difficulty, budget, howto) VALUES (?, ?, ?, ?, ?)";
	//SQL実行の準備
	$stmt = $dbh->prepare($sql);
	//bindValueにてSQLに値を組み込む
	$stmt->bindValue(1, $recipe_name, PDO::PARAM_STR);
	$stmt->bindValue(2, $category, PDO::PARAM_INT);
	$stmt->bindValue(3, $difficulty, PDO::PARAM_INT);
	$stmt->bindValue(4, $budget, PDO::PARAM_INT);
	$stmt->bindValue(5, $howto, PDO::PARAM_STR);
	//SQLの実行
	$stmt->execute();
	//接続を閉じる
	$dbh = null;
	//完了メッセージをブラウザに表示
	echo "レシピの登録が完了しました。<br>";
	echo "<a href='index.php'>トップページへ戻る</a>";

	//try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (PDOException $e) {
	//エラーメッセージ出力
	echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	//処理の終了
	die();
}
