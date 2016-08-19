<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>item list</title>
</head>
<body>

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
    $sql = "SELECT item.id, item.sample, item.chinese_name, item.weight,  item.buying_price,
item.cost * shop.fare * 0.067 * 1.1 as cost
FROM item
  LEFT JOIN shop ON item.shop = shop.id
WHERE item.id > 260
ORDER BY item.chinese_name DESC";

    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //テーブル部分のHTMLを生成
    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<th>id</th><th>name</th><th>price</th>\n";
    echo "</tr>\n";
    //取得したデータが無くなるまでforeach()で処理を繰り返す。
    //取得した値は各カラムに表示を行う。
    //ループ処理の開始
    foreach ($result as $row) {
        echo "<tr>\n";



        echo "<td>'" . sprintf('%010s', htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ). "</td>\n";

        if($row['sample'])
        echo "<td><a href=" . htmlspecialchars($row['sample'], ENT_QUOTES, 'UTF-8') . ">".htmlspecialchars($row['chinese_name'], ENT_QUOTES, 'UTF-8')."</a></td>\n";
        else
            echo "<td>" . htmlspecialchars($row['chinese_name'], ENT_QUOTES, 'UTF-8') . "</td>\n";


        //echo "<td>" . htmlspecialchars($row['buying_price'], ENT_QUOTES, 'UTF-8') . "</td>\n";
        echo "<td>" . sprintf('%.0f', htmlspecialchars($row['cost'] , ENT_QUOTES, 'UTF-8')) . "</td>\n";


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
