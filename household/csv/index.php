<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>レシピの一覧</title>
</head>
<body>
<h1>レシピの一覧</h1>

<?php
/**
 * いちばんやさしいPHPの教本 サンプルコード
 * 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
 *
 * index.php 一覧表示処理
 */

//データベース設定の読み込み
//require_once '\xampp\db_config.php';
require_once(dirname(__FILE__)."/../db_config.php");

//try〜catchにてエラーハンドリングを行う。
try {
    //$_GET['id']が空かのチェックを行う。（id=0でもこの場合Exceptionを発生させる)
    if (empty($_GET['id'])) throw new Exception('Error');

    //取得した$_GET['id']は文字列であるため数値型に変換を行う。
    $id = (int)$_GET['id'];

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


    echo "<a href=new.php?id=" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . ">半年の分の新規登録</a>\n";

    //テーブル部分のHTMLを生成
    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<th>id</th><th>account_id</th><th>account_year</th><th>account_month</th><th>file</th>\n";
    echo "</tr>\n";
    //取得したデータが無くなるまでforeach()で処理を繰り返す。
    //取得した値は各カラムに表示を行う。
    //ループ処理の開始
    foreach ($result as $row) {
        echo "<tr>\n";
/*
        echo "<td>\n";
        echo "<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=1>update</a>\n";
        echo "|<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=2>copy</a>\n";
        echo "|<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=3>delete</a>\n";
        echo "</td>\n";
*/
        echo "<td>" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['account_id'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['account_year'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['account_month'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        if(empty($row['file'])) {
            echo "<td>\n";
            echo "<a href=upload.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">upload</a>\n";
            echo "</td>\n";
        }
        else
            echo "<td>" . htmlspecialchars($row['file'], ENT_QUOTES, 'UTF-8') . "</td>\n";


        echo "</tr>\n";
        //ループ処理の終了
    }
    //テーブルタグを閉じる
    echo "</table>\n";
    //接続を閉じる
    $dbh = null;

//try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (PDOException $e) {
    //エラーメッセージ出力
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    //処理の終了
    die();
}
//PHPが終了した後にHTMLタグが記述されているためここでは
?>

<br/>
<a href="../account/index.php">return</a>

</body>
</html>
