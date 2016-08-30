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
$stock = $_POST['stock'];
$account = $_POST['account'];

$buy_time = $_POST['buy_time'];
$buy_price = $_POST['buy_price'];
$buy_fee = $_POST['buy_fee'];

$sell_time = $_POST['sell_time'];
$sell_price = $_POST['sell_price'];
$sell_fee = $_POST['sell_fee'];

$income = $_POST['income'];

$action = (int)$_POST['action'];

//try〜catchにてエラーハンドリングを行う。
try {
	//$_GET['id']が空かのチェックを行う。（id=0でもこの場合Exceptionを発生させる)
	if (empty($_POST['id'])) throw new Exception('Error');

	//取得した$_GET['id']は文字列であるため数値型に変換を行う。
	$id = (int) $_POST['id'];
	
	//PDOを使ったデータベースへの接続
	//$user,$passはdb_config.phpにて定義済み
	$dbh = new PDO('mysql:host=localhost;dbname=stock;charset=utf8', $user, $pass);

	//PDOの実行モードの設定
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//データ取得のSQLを生成
	$sql = "SELECT * FROM opera WHERE id = ?";
	//SQL実行の準備
	$stmt = $dbh->prepare($sql);
	//bindParamにてidの値をセットする
	$stmt->bindValue(1, $id, PDO::PARAM_INT);
	//SQLの実行
	$stmt->execute();
	//SQLの実行結果を$resultに取得する
	$item = $stmt->fetch(PDO::FETCH_ASSOC);

	$sell_image = "";
	$buy_image = "";
	$lending_fee = "";

	if($action == 2 || $action == 1) {

		if ($buy_time != "") {

			$buy_image = $buy_time .  "-" .  $stock . "-01.PNG";


		}
		if ($sell_time != "") {
			var_dump($buy_time);
			var_dump($stock);
			$sell_image = $sell_time .  "-" .  $stock . "-01.PNG";
			$lending_fee = $account * ($buy_price - $sell_price) - $buy_fee - $sell_fee - $income;
			var_dump($buy_image);
		}
	}



	if($action == 2) {

		/*
		//INSERT用のSQLを生成
		$sql = "INSERT INTO opera (stock, buy_time, buy_price, account, buy_image, sell_time, sell_price, sell_image,  buy_fee, sell_fee, income, lending_fee) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindValueにてSQLに値を組み込む
		$stmt->bindValue(1, $stock, PDO::PARAM_INT);
		$stmt->bindValue(2, $buy_time, PDO::PARAM_STR);
		$stmt->bindValue(3, $buy_price, PDO::PARAM_INT);
		$stmt->bindValue(4, $account, PDO::PARAM_INT);
		$stmt->bindValue(5, $buy_image, PDO::PARAM_STR);
		$stmt->bindValue(6, $sell_time, PDO::PARAM_STR);
		$stmt->bindValue(7, $sell_price, PDO::PARAM_INT);
		$stmt->bindValue(8, $sell_image, PDO::PARAM_STR);

		$stmt->bindValue(9, $buy_fee, PDO::PARAM_INT);
		$stmt->bindValue(10, $sell_fee, PDO::PARAM_INT);
		$stmt->bindValue(11, $income, PDO::PARAM_INT);
		$stmt->bindValue(12, $lending_fee, PDO::PARAM_INT);
		*/

		//INSERT用のSQLを生成
		$sql = "INSERT INTO opera (stock, buy_time, buy_price, account, buy_image, buy_fee) VALUES (?, ?, ?, ?, ?, ?)";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindValueにてSQLに値を組み込む
		$stmt->bindValue(1, $stock, PDO::PARAM_INT);
		$stmt->bindValue(2, $buy_time, PDO::PARAM_STR);
		$stmt->bindValue(3, $buy_price, PDO::PARAM_INT);
		$stmt->bindValue(4, $account, PDO::PARAM_INT);
		$stmt->bindValue(5, $buy_image, PDO::PARAM_STR);

		$stmt->bindValue(6, $buy_fee, PDO::PARAM_INT);

		//SQLの実行
		$stmt->execute();
	}
	elseif($action == 3) {

		//削除用のSQLを生成
		$sql = "DELETE FROM opera WHERE id = ?";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindParamにてidの値をセットする
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		//SQLの実行
		$stmt->execute();
	}
	elseif($action == 1) {

		//更新用のSQLを生成
		$sql = "UPDATE opera SET stock = ?, buy_time = ?, buy_price = ?, account = ?, buy_image = ? , sell_time = ?, sell_price = ?, sell_image = ? , buy_fee = ? , sell_fee = ?, income = ?, lending_fee = ? WHERE id = ?";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindValueにてSQLに値を組み込む
		$stmt->bindValue(1, $stock, PDO::PARAM_INT);
		$stmt->bindValue(2, $buy_time, PDO::PARAM_STR);
		$stmt->bindValue(3, $buy_price, PDO::PARAM_INT);
		$stmt->bindValue(4, $account, PDO::PARAM_INT);
		$stmt->bindValue(5, $buy_image, PDO::PARAM_STR);
		$stmt->bindValue(6, $sell_time, PDO::PARAM_STR);
		$stmt->bindValue(7, $sell_price, PDO::PARAM_INT);
		$stmt->bindValue(8, $sell_image, PDO::PARAM_STR);

		$stmt->bindValue(9, $buy_fee, PDO::PARAM_INT);
		$stmt->bindValue(10, $sell_fee, PDO::PARAM_INT);
		$stmt->bindValue(11, $income, PDO::PARAM_INT);
		$stmt->bindValue(12, $lending_fee, PDO::PARAM_INT);


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
