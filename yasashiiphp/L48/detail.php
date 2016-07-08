<?php
/**
* いちばんやさしいPHPの教本 サンプルコード
* 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
*
* detail.php レシピ追加処理
*/

//データベースの設定を読み込む
require_once(dirname(__FILE__)."/../db_config.php");

//try〜catchにてエラーハンドリングを行う。
try {
	//$_GET['id']が空かのチェックを行う。（id=0でもこの場合Exceptionを発生させる)
	if (empty($_GET['id'])) throw new Exception('Error');

	//取得した$_GET['id']は文字列であるため数値型に変換を行う。
	$id = (int) $_GET['id'];

	//PDOを使ったデータベースへの接続
	//$user,$passはdb_config.phpにて定義済み
	$dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);

	//PDOの実行モードの設定
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//更新用のSQLを生成
	$sql = "SELECT * FROM recipes WHERE id = ?";
	//SQLの実行の準備
	$stmt = $dbh->prepare($sql);
	//bindParamにてidの値をセットする
	$stmt->bindValue(1, $id, PDO::PARAM_INT);
	//SQLの実行
	$stmt->execute();

	//結果を$resultに取得する
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	//配列に格納されているデータをラベルを付けて表示する(htmlspecialcharsを使用)
	echo "料理名:" . htmlspecialchars($result['recipe_name'],ENT_QUOTES,'UTF-8') . "<br>\n";
	echo "カテゴリ:" . htmlspecialchars($result['category'],ENT_QUOTES,'UTF-8') . "<br>\n";
	echo "予算:" . htmlspecialchars($result['budget'],ENT_QUOTES,'UTF-8') . "<br>\n";
	echo "難易度:" . htmlspecialchars($result['difficulty'],ENT_QUOTES,'UTF-8') . "<br>\n";
	echo "作り方:<br>" . nl2br(htmlspecialchars($result['howto'],ENT_QUOTES,'UTF-8')) . "<br>\n";
	//接続を閉じる
	$dbh = null;
	//完了メッセージをブラウザに表示
	echo "<a href='index.php'>トップページへ戻る</a>";

	//try{}で発生したExceptionはこの部分でcatchされる
} catch (Exception $e) {
	//エラーメッセージの出力
	echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	//処理の終了
	die();
}
