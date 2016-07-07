<?php
/**
* いちばんやさしいPHPの教本 サンプルコード
* 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
*
* add.php レシピ追加処理
*/

//データベース設定の読み込み
require_once '\xampp\db_config.php';
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

	//削除用のSQLを生成
	$sql = "DELETE FROM recipes WHERE id = ?";
	//SQL実行の準備
	$stmt = $dbh->prepare($sql);
	//bindParamにてidの値をセットする
	$stmt->bindValue(1, $id, PDO::PARAM_INT);
	//SQLの実行
	$stmt->execute();
	//接続を閉じる
	$dbh = null;
	//完了メッセージをブラウザに表示
	echo "ID: " . htmlspecialchars($id,ENT_QUOTES,'UTF-8') ."の削除が完了しました。<br>";
	echo "<a href='index.php'>トップページへ戻る</a>";

//try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (Exception $e) {
	//エラーメッセージ出力
	echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	//処理の終了
	die();
}
