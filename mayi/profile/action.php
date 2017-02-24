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
$order_id = $_POST['order_id'];
$order_date = $_POST['order_date'];
$out_price = $_POST['out_price'];
$rate = $_POST['rate'];
$in_price = $_POST['in_price'];
$ship_price = $_POST['ship_price'];
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


	
	if($action == 2) {
		
		//INSERT用のSQLを生成
		$sql = "INSERT INTO profile (order_id, order_date, out_price, rate, in_price, ship_price) VALUES (?, ?, ?, ?, ?, ?)";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $order_id, PDO::PARAM_STR);
		$stmt->bindValue(2, $order_date, PDO::PARAM_STR);
		$stmt->bindValue(3, $out_price, PDO::PARAM_INT);
		$stmt->bindValue(4, $rate, PDO::PARAM_STR);
		$stmt->bindValue(5, $in_price, PDO::PARAM_INT);
		$stmt->bindValue(6, $ship_price, PDO::PARAM_INT);
		//SQLの実行
		$stmt->execute();
	}
	elseif($action == 3) {

		//削除用のSQLを生成
		$sql = "DELETE FROM profile WHERE id = ?";
		//SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindParamにてidの値をセットする
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		//SQLの実行
		$stmt->execute();
	}
	elseif($action == 1) {

		//更新用のSQLを生成
		$sql = "UPDATE profile SET order_id = ?, order_date = ?, out_price = ?, rate = ?, in_price = ?, ship_price = ?  WHERE id = ?";
        echo $order_id;

            //SQL実行の準備
		$stmt = $dbh->prepare($sql);
		//bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $order_id, PDO::PARAM_STR);
        $stmt->bindValue(2, $order_date, PDO::PARAM_STR);
        $stmt->bindValue(3, $out_price, PDO::PARAM_INT);
        $stmt->bindValue(4, $rate, PDO::PARAM_STR);
        $stmt->bindValue(5, $in_price, PDO::PARAM_INT);
        $stmt->bindValue(6, $ship_price, PDO::PARAM_INT);
		$stmt->bindValue(7, $id, PDO::PARAM_INT);
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
