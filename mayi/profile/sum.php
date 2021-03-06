﻿<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>レシピの一覧</title>
</head>
<body>
<h1>レシピの一覧</h1>
<!--<a href="form.php">レシピの新規登録</a>-->
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
    //PDOを使ったデータベースへの接続
    //$user,$passはdb_config.phpにて定義済み
    $dbh = new PDO('mysql:host=localhost;dbname=mamazon;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //前データ取得のSQLを生成
    $sql = "select order_date, sum(out_price * rate -(in_price + ship_price) * 0.062) as profile_date 
from profile  
GROUP BY order_date
order by order_date DESC";

    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //テーブル部分のHTMLを生成
    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<th>order_date</th><th>profile</th>\n";
    echo "</tr>\n";
    //取得したデータが無くなるまでforeach()で処理を繰り返す。
    //取得した値は各カラムに表示を行う。
    //ループ処理の開始
    foreach ($result as $row) {
        echo "<tr>\n";

        echo "<td>" . htmlspecialchars($row['order_date'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . sprintf('%.0f', htmlspecialchars($row['profile_date'] , ENT_QUOTES, 'UTF-8')) . "</td>\n";

        echo "</tr>\n";
        //ループ処理の終了
    }



    //前データ取得のSQLを生成
    $sql = "select sum(out_price * rate -(in_price + ship_price) * 0.062) as profile_month 
from profile";

    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //ループ処理の開始
    foreach ($result as $row) {
        echo "<tr>\n";
        echo "<td>" . "合計" . "</td>\n";
        echo "<td>" . sprintf('%.0f', htmlspecialchars($row['profile_month'] , ENT_QUOTES, 'UTF-8')) . "</td>\n";

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
<a href="index.php">return</a>

</body>
</html>
