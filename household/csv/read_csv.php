<?php
/**
 * Created by PhpStorm.
 * User: rosui
 * Date: 2016/06/13
 * Time: 15:33
 */

//データベース設定の読み込み
//require_once '\xampp\db_config.php';
//require_once(dirname(__FILE__)."/../db_config.php");

//print a text box


function read_csv($csv_id, $type, $csv) {
    
    $file = new SplFileObject($csv);
    $file->setFlags(SplFileObject::READ_CSV);

    // ファイル内のデータループ
    $start = 0;

    // 漢方スタイルクラブカード
    if($type == 15 || $type == 16) {
        foreach ($file as $key => $line) {

            echo "<pre>";
            var_dump($line);
            echo "</pre>";

            if ($start == 0 && count($line) > 1 && $line[1] == "＜＜今回のお支払明細＞＞")
                $start = $key;
            elseif (count($line) > 1 && $line[1] == "＜＜次回以降のお支払明細＞＞")
                break;


            if ($start != 0 && count($line) == 13 && preg_match("/^\d{2}\/\d{1,2}\/\d{1,2}$/", $line[0])) {
                foreach ($line as $line_key => $str) {
                    switch ($line_key) {
                        // ご利用年月日
                        case 0:
                            $records[$key][] = $str;
                            break;
                        // ご利用店名
                        case 1:
                            $records[$key][] = $str;
                            break;
                        // 今回のお支払金額（円）
                        case 9:
                            $records[$key][] = $str;
                            break;
                    }
                }
            }
        }
    }
    // 漢方スタイルクラブカード
    elseif($type == 11 || $type == 12) {
        foreach ($file as $key => $line) {

            echo "<pre>";
            var_dump($line);
            echo "</pre>";

            if (preg_match("/^\d{2}\.\d{2}\.\d{2}$/", $line[0])) {
                foreach ($line as $line_key => $str) {
                    switch ($line_key) {
                        // 利用日
                        case 0:
                            $records[$key][] = $str;
                            break;
                        // 利用店名・商品名
                        case 3:
                            $records[$key][] = $str;
                            break;
                        // 当月請求額
                        case 9:
                            $records[$key][] = $str;
                            break;
                    }
                }
            }
        }
    }
    // SAISON
    elseif($type == 18) {
        foreach ($file as $key => $line) {

            echo "<pre>";
            var_dump($line);
            echo "</pre>";

            if (preg_match("/^\d{4}\/\d{2}\/\d{2}$/", $line[0])) {
                foreach ($line as $line_key => $str) {
                    switch ($line_key) {
                        // 利用日
                        case 0:
                            $records[$key][] = $str;
                            break;
                        // ご利用店名及び商品名
                        case 1:
                            $records[$key][] = $str;
                            break;
                        // 利用金額
                        case 5:
                            $records[$key][] = $str;
                            break;
                    }
                }
            }
        }
    }
 
    echo "<pre>";
    print_r($records);
    echo "</pre>";

    //try〜catchにてエラーハンドリングを行う。
    try {
        $user = "data_user";
        $pass = "LsNbmtrWTZd6yh67";
        // todo
        
        //PDOを使ったデータベースへの接続
        //$user,$passはdb_config.phpにて定義済み
        $dbh = new PDO('mysql:host=localhost;dbname=household_budget;charset=utf8', $user, $pass);

        //PDOの実行モードの設定
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($records as $row => $line) {

            //INSERT用のSQLを生成
            $sql = "INSERT INTO expense (time, shop, number, csv) VALUES (?, ?, ?, ?)";
            //SQL実行の準備
            $stmt = $dbh->prepare($sql);
            //bindValueにてSQLに値を組み込む
            $stmt->bindValue(1, $line[0], PDO::PARAM_STR);
            $stmt->bindValue(2, $line[1], PDO::PARAM_STR);
            $stmt->bindValue(3, $line[2], PDO::PARAM_INT);
            $stmt->bindValue(4, $csv_id, PDO::PARAM_INT);
            
            //SQLの実行
            $stmt->execute();
        }

        //更新用のSQLを生成
        $sql = "UPDATE csv SET file = ? WHERE id = ?";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, $csv, PDO::PARAM_STR);
        $stmt->bindValue(2, $csv_id, PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();

        //接続を閉じる
        $dbh = null;
        //完了メッセージをブラウザに表示
        echo "レシピの登録が完了しました。<br>";
        //echo "<a href='index.php'>トップページへ戻る</a>";

        //try{}で発生したPDOExceptionはこの部分でcatchされる
    } catch (PDOException $e) {
        //エラーメッセージ出力
        echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        //処理の終了
        die();

    }

}



