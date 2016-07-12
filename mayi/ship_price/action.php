<?php
/**
 * いちばんやさしいPHPの教本 サンプルコード
 * 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
 *
 * add.php レシピ追加処理
 */

//データベースの設定を読み込む
require_once(dirname(__FILE__) . "/../db_config.php");

//POSTされた値を変数に代入する

//try〜catchにてエラーハンドリングを行う。
try {

    //PDOを使ったデータベースへの接続
    //$user,$passはdb_config.phpにて定義済み
    $dbh = new PDO('mysql:host=localhost;dbname=mamazon;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // EMS method = 1
    $method = 1;
    /*

    $weight_min = 1;
    $weight_max = 500;
    $price = 1400;

    while($weight_max <= 1000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 100;
        $price = $price + 140;
    }
    */

    /*
    $weight_min = 1001;
    $weight_max = 1250;
    $price = 2400;

    while($weight_max <= 2000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 250;
        $price = $price + 300;
    }
    */

    /*
    $weight_min = 2001;
    $weight_max = 2500;
    $price = 3800;

    while($weight_max <= 6000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 500;
        $price = $price + 500;
    }
    */

    /*
    $weight_min = 6001;
    $weight_max = 7000;
    $price = 8100;

    while($weight_max <= 30000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 1000;
        $price = $price + 800;
    }
    */

    // E-PACK method = 2
    $method = 2;

    /*
    $weight_min = 1;
    $weight_max = 50;
    $price = 530;

    while($weight_max <= 300) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 50;
        $price = $price + 50;
    }
    */

    /*
    $weight_min = 301;
    $weight_max = 400;
    $price = 880;

    while($weight_max <= 1000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 100;
        $price = $price + 100;
    }
    */

    /*
    $weight_min = 1001;
    $weight_max = 1250;
    $price = 1700;

    while($weight_max <= 2000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 250;
        $price = $price + 220;
    }
    */

    // AIR method = 3
    $method = 3;
    /*
        $weight_min = 1;
        $weight_max = 500;
        $price = 1700;

        while($weight_max <= 5000) {
            //INSERT用のSQLを生成
            $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
            //SQL実行の準備
            $stmt = $dbh->prepare($sql);
            //bindValueにてSQLに値を組み込む
            $stmt->bindValue(1, $method, PDO::PARAM_INT);
            $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
            $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
            $stmt->bindValue(4, $price, PDO::PARAM_INT);
            //SQLの実行
            $stmt->execute();

            $weight_min = $weight_max + 1;
            $weight_max = $weight_max + 500;
            $price = $price + 350;
        }



        $weight_min = 5001;
        $weight_max = 5500;
        $price = 5150;

        while($weight_max <= 10000) {
            //INSERT用のSQLを生成
            $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
            //SQL実行の準備
            $stmt = $dbh->prepare($sql);
            //bindValueにてSQLに値を組み込む
            $stmt->bindValue(1, $method, PDO::PARAM_INT);
            $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
            $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
            $stmt->bindValue(4, $price, PDO::PARAM_INT);
            //SQLの実行
            $stmt->execute();

            $weight_min = $weight_max + 1;
            $weight_max = $weight_max + 500;
            $price = $price + 300;
        }



        $weight_min = 10001;
        $weight_max = 11000;
        $price = 8250;

        while($weight_max <= 30000) {
            //INSERT用のSQLを生成
            $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
            //SQL実行の準備
            $stmt = $dbh->prepare($sql);
            //bindValueにてSQLに値を組み込む
            $stmt->bindValue(1, $method, PDO::PARAM_INT);
            $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
            $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
            $stmt->bindValue(4, $price, PDO::PARAM_INT);
            //SQLの実行
            $stmt->execute();

            $weight_min = $weight_max + 1;
            $weight_max = $weight_max + 1000;
            $price = $price + 400;
        }
    */

    // SAL method = 4
    $method = 4;

    /*
    $weight_min = 1;
    $weight_max = 1000;
    $price = 1800;

    while ($weight_max <= 5000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 1000;
        $price = $price + 600;
    }


    $weight_min = 5001;
    $weight_max = 6000;
    $price = 4700;

    while ($weight_max <= 10000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 1000;
        $price = $price + 500;
    }


    $weight_min = 10001;
    $weight_max = 11000;
    $price = 7000;

    while ($weight_max <= 30000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 1000;
        $price = $price + 300;
    }
    */

    // SHIP method = 5
    $method = 5;
/*
    $weight_min = 1;
    $weight_max = 1000;
    $price = 1600;

    while ($weight_max <= 10000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 1000;
        $price = $price + 300;
    }


    $weight_min = 10001;
    $weight_max = 11000;
    $price = 4550;

    while ($weight_max <= 30000) {
        //INSERT用のSQLを生成
        $sql = "INSERT INTO ship_price (method, weight_min, weight_max, price) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $method, PDO::PARAM_INT);
        $stmt->bindValue(2, $weight_min, PDO::PARAM_INT);
        $stmt->bindValue(3, $weight_max, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        $weight_min = $weight_max + 1;
        $weight_max = $weight_max + 1000;
        $price = $price + 250;
    }
*/

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
