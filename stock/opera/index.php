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
    $dbh = new PDO('mysql:host=localhost;dbname=stock;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //前データ取得のSQLを生成
    $sql = "SELECT *
FROM opera
ORDER BY opera.id DESC";

    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //テーブル部分のHTMLを生成
    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<th>update|copy|delete</th><th>stock</th><th>type</th><th>account</th><th>buy_time</th><th>buy_price</th><th>buy_fee</th><th>buy_image</th><th>sell_time</th><th>sell_price</th><th>sell_fee</th><th>sell_image</th><th>lending_fee</th><th>income</th>\n";
    echo "</tr>\n";
    //取得したデータが無くなるまでforeach()で処理を繰り返す。
    //取得した値は各カラムに表示を行う。
    //ループ処理の開始
    foreach ($result as $row) {
        echo "<tr>\n";

        echo "<td>\n";
        echo "<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=1>update</a>\n";
        echo "|<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=2>copy</a>\n";
        echo "|<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=3>delete</a>\n";
        echo "|<a href=detail.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">detail</a>\n";
        echo "</td>\n";

        //echo "<td>" . sprintf('%010s', htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ). "</td>\n";
        echo "<td>" . htmlspecialchars($row['stock'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['account'], ENT_QUOTES, 'UTF-8') . "</td>\n";

        echo "<td>" . htmlspecialchars($row['buy_time'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['buy_price'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['buy_fee'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['buy_image'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        
        echo "<td>" . htmlspecialchars($row['sell_time'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['sell_price'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['sell_fee'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['sell_image'], ENT_QUOTES, 'UTF-8') . "</td>\n";

        echo "<td>" . htmlspecialchars($row['lending_fee'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['income'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        
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
</body>
</html>
