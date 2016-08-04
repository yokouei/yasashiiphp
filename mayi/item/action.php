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
$descripe = $_POST['descripe'];
$brand = $_POST['brand'];
$japanese_name = $_POST['japanese_name'];
$chinese_name = $_POST['chinese_name'];
$weight = $_POST['weight'];
$shop = $_POST['shop'];
$ship = $_POST['ship'];
$buying_price = $_POST['buying_price'];
$selling_price = $_POST['selling_price'];
$link = $_POST['link'];
$sample = $_POST['sample'];
//$id = $_POST['id'];

$action = (int)$_POST['action'];

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

	//データ取得のSQLを生成
	$sql = "SELECT * FROM shop WHERE id = ?";
	//SQL実行の準備
	$stmt = $dbh->prepare($sql);
	//bindParamにてidの値をセットする
	$stmt->bindValue(1, $shop, PDO::PARAM_INT);
	//SQLの実行
	$stmt->execute();
	//SQLの実行結果を$resultに取得する
	$item = $stmt->fetch(PDO::FETCH_ASSOC);

	$cost = 0;

	if($action == 2 || $action == 1) {
		if ($ship == 5) {
			$cost = $buying_price * $item['fare'] + $weight / 100 * 30;
		} elseif ($ship == 2) {
			$cost = $buying_price * $item['fare'] + $weight;
		}
	}
	
	if($action == 2) {
		
		//INSERT用のSQLを生成
		$sql = "INSERT INTO item (descripe, brand, japanese_name, chinese_name, weight, shop, ship, buying_price, selling_price, link, sample, cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindValueにてSQLに値を組み込む
		$stmt->bindValue(1, $descripe, PDO::PARAM_STR);
		$stmt->bindValue(2, $brand, PDO::PARAM_INT);
		$stmt->bindValue(3, $japanese_name, PDO::PARAM_STR);
		$stmt->bindValue(4, $chinese_name, PDO::PARAM_STR);
		$stmt->bindValue(5, $weight, PDO::PARAM_INT);
		$stmt->bindValue(6, $shop, PDO::PARAM_INT);
		$stmt->bindValue(7, $ship, PDO::PARAM_INT);
		$stmt->bindValue(8, $buying_price, PDO::PARAM_INT);
		$stmt->bindValue(9, $selling_price, PDO::PARAM_INT);
		$stmt->bindValue(10, $link, PDO::PARAM_STR);
		$stmt->bindValue(11, $sample, PDO::PARAM_STR);
		$stmt->bindValue(12, $cost, PDO::PARAM_INT);
		//SQLの実行
		$stmt->execute();
	}
	elseif($action == 3) {

		//削除用のSQLを生成
		$sql = "DELETE FROM item WHERE id = ?";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindParamにてidの値をセットする
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		//SQLの実行
		$stmt->execute();
	}
	elseif($action == 1) {

		//更新用のSQLを生成
		$sql = "UPDATE item SET descripe = ?, brand = ?, japanese_name = ?, chinese_name = ?, weight = ? , shop = ?, ship = ?, buying_price = ?, selling_price = ?, link = ?, sample = ?, cost = ? WHERE id = ?";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindValueにてSQLに値を組み込む
		$stmt->bindValue(1, $descripe, PDO::PARAM_STR);
		$stmt->bindValue(2, $brand, PDO::PARAM_INT);
		$stmt->bindValue(3, $japanese_name, PDO::PARAM_STR);
		$stmt->bindValue(4, $chinese_name, PDO::PARAM_STR);
		$stmt->bindValue(5, $weight, PDO::PARAM_INT);
		$stmt->bindValue(6, $shop, PDO::PARAM_INT);
		$stmt->bindValue(7, $ship, PDO::PARAM_INT);
		$stmt->bindValue(8, $buying_price, PDO::PARAM_INT);
		$stmt->bindValue(9, $selling_price, PDO::PARAM_INT);
		$stmt->bindValue(10, $link, PDO::PARAM_STR);
		$stmt->bindValue(11, $sample, PDO::PARAM_STR);
		$stmt->bindValue(12, $cost, PDO::PARAM_INT);
		$stmt->bindValue(13, $id, PDO::PARAM_INT);
		//SQLの実行
		$stmt->execute();
	}
	
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
