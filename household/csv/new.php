<?php
/**
 * いちばんやさしいPHPの教本 サンプルコード
 * 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
 *
 * add.php レシピ追加処理
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
	$dbh = new PDO('mysql:host=localhost;dbname=household_budget;charset=utf8', $user, $pass);

	//PDOの実行モードの設定
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//前データ取得のSQLを生成
	$sql = "SELECT * FROM csv WHERE account_id = ? ORDER BY account_year DESC , account_month DESC ";

	//SQL実行の準備
	$stmt = $dbh->prepare($sql);
	//bindParamにてidの値をセットする
	$stmt->bindValue(1, $id, PDO::PARAM_INT);
	//SQLの実行
	$stmt->execute();

	//SQLの結果を$resultに取得する
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if(count($result) == 0) {

		$first_day = mktime(0,0,0,date('m'),1,date('y'));

		for ($i = 0; $i < 7; $i++) {
			$timestamp = strtotime("-$i month", $first_day);
			$year = date('Y', $timestamp);
			$month = date('m', $timestamp);
			//print $year."/".$month."\n";

			//INSERT用のSQLを生成
			$sql = "INSERT INTO csv (account_id, account_year, account_month) VALUES (?, ?, ?)";
			//SQL実行の準備
			$stmt = $dbh->prepare($sql);
			//bindValueにてSQLに値を組み込む
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->bindValue(2, $year, PDO::PARAM_INT);
			$stmt->bindValue(3, $month, PDO::PARAM_INT);
			//SQLの実行
			$stmt->execute();

		}

	}
	else {
        $year = $result[0]['account_year'];
        $month = $result[0]['account_month'];

        if ($month == 12) {
            $year = $year + 1;
            $month = 1;
        }
        else
            $month = $month + 1;
        //print $year."/".$month."\n";

        //INSERT用のSQLを生成
        $sql = "INSERT INTO csv (account_id, account_year, account_month) VALUES (?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->bindValue(2, $year, PDO::PARAM_INT);
        $stmt->bindValue(3, $month, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();
    }

	//接続を閉じる
	$dbh = null;
	//完了メッセージをブラウザに表示
	echo "レシピの登録が完了しました。<br>";
	echo "<a href=index.php?id=" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . ">トップページへ戻る</a>\n";

	//try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (PDOException $e) {
	//エラーメッセージ出力
	echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	//処理の終了
	die();
}
