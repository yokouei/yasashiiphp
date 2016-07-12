<!DOCTYPE html>
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
    $sql = "SELECT brand.chinese_name AS brand, item.id, item.japanese_name, item.chinese_name, item.weight, ship.name AS ship, shop.name AS shop, shop.link, item.price_in, item.price_out,
  if(item.ship = 5, floor((item.price_in * shop.fare + weight / 100 * 30) * 0.067), floor((item.price_in * shop.fare  + weight) * 0.067)) AS price
FROM item 
  LEFT JOIN brand ON item.brand = brand.id 
  LEFT JOIN shop ON item.shop = shop.id 
  LEFT JOIN ship ON item.ship = ship.id 
ORDER BY item.brand DESC, item.id DESC";

    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //テーブル部分のHTMLを生成
    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<th>update|copy|delete</th><th>id</th><th>brand</th><th>japanese_name</th><th>chinese_name</th><th>weight</th><th>ship</th><th>shop</th><th>price_in</th><th>price</th><th>price_out</th>\n";
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
        echo "</td>\n";

        echo "<td>0000000" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['brand'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['japanese_name'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['chinese_name'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['weight'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['ship'], ENT_QUOTES, 'UTF-8') . "</td>\n";

        //echo "<td>" . htmlspecialchars($row['shop'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td><a href=" . htmlspecialchars($row['link'], ENT_QUOTES, 'UTF-8') . ">".htmlspecialchars($row['shop'], ENT_QUOTES, 'UTF-8')."</a></td>\n";

        echo "<td>" . htmlspecialchars($row['price_in'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . htmlspecialchars($row['price_out'], ENT_QUOTES, 'UTF-8') . "</td>\n";

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
