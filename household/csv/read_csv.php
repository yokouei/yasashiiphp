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
                            $records[$key]['time'] = $str;
                            $records[$key]['detail'] = '';
                            break;
                        // ご利用店名
                        case 1:
                            $records[$key]['shop'] = $str;
                            break;
                        // 今回のお支払金額（円）
                        case 9:
                            $records[$key]['number'] = $str;
                            $records[$key]['income_expense'] = 1;
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
                            $records[$key]['time'] = $str;
                            $records[$key]['detail'] = '';
                            break;
                        // 利用店名・商品名
                        case 3:
                            $records[$key]['shop'] = $str;
                            break;
                        // 当月請求額
                        case 9:
                            $records[$key]['number'] = $str;
                            $records[$key]['income_expense'] = 1;
                            break;
                    }
                }
            }
        }
    }

    // ヤフーカード
    elseif($type == 13 || $type == 14) {
        foreach ($file as $key => $line) {

            echo "<pre>";
            var_dump($line);
            echo "</pre>";

            if (preg_match("/^\d{4}$/", $line[0])) {
                foreach ($line as $line_key => $str) {
                    switch ($line_key) {
                        // 利用日
                        case 0:
                            $records[$key]['time'] = $str;
                            $records[$key]['detail'] = '';
                            break;
                        // 利用店名・商品名
                        case 1:
                            $records[$key]['shop'] = $str;
                            break;
                        // 当月支払金額
                        case 7:
                            $records[$key]['number'] = str_replace(',', '', $str);
                            $records[$key]['income_expense'] = 1;
                            break;
                    }
                }
            }
            elseif (preg_match("/^\d{1,2}月\d{1,2}日$/", $line[0])) {
                // 利用日
                $records[$key-1][0] = str_replace('日', '', str_replace('月', '.', $records[$key-1][0].".".$line[0]));
            }
        }
    }

    // 	SAISON
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
                            $records[$key]['time'] = $str;
                            $records[$key]['detail'] = '';
                            break;
                        // ご利用店名及び商品名
                        case 1:
                            $records[$key]['shop'] = $str;
                            break;
                        // 利用金額
                        case 5:
                            $records[$key]['number'] = $str;
                            $records[$key]['income_expense'] = 1;
                            break;
                    }
                }
            }
        }
    }
    // 三井住友銀行
    elseif($type == 9) {
        foreach ($file as $key => $line) {

            echo "<pre>";
            var_dump($line);
            echo "</pre>";

            if (preg_match("/^H\d{2}\.\d{1,2}\.\d{1,2}$/", $line[0])) {
                foreach ($line as $line_key => $str) {
                    switch ($line_key) {
                        // 年月日（和暦）
                        case 0:
                            $records[$key]['time'] = str_replace('H28', '2016', $str);
                            $records[$key]['detail'] = '';
                            break;
                        // お引出し
                        case 1:
                            if($str) {
                                $records[$key]['number'] = $str;
                                $records[$key]['income_expense'] = 1;
                            }
                            break;
                        // お預入れ
                        case 2:
                            if($str) {
                                $records[$key]['number'] = $str;
                                $records[$key]['income_expense'] = 0;
                            }
                            break;
                        // お取り扱い内容
                        case 3:
                            $records[$key]['shop'] = $str;
                            break;
                    }
                }
            }
        }
    }
    // 三菱東京UFJ銀行
    elseif($type == 5 || $type == 6) {
        foreach ($file as $key => $line) {

            echo "<pre>";
            var_dump($line);
            echo "</pre>";

            if (preg_match("/^\d{4}\/\d{1,2}\/\d{1,2}$/", $line[0])) {
                foreach ($line as $line_key => $str) {
                    switch ($line_key) {
                        // 日付
                        case 0:
                            $records[$key]['time'] = $str;
                            break;
                        // 摘要
                        case 1:
                            $records[$key]['shop'] = $str;
                            break;
                        // 摘要内容
                        case 2:
                            $records[$key]['detail'] = $str;
                            break;
                        // 支払い金額
                        case 3:
                            if($str) {
                                $records[$key]['number'] = str_replace(',', '', $str);
                                $records[$key]['income_expense'] = 1;
                            }
                            break;
                        // 預かり金額
                        case 4:
                            if($str) {
                                $records[$key]['number'] = str_replace(',', '', $str);
                                $records[$key]['income_expense'] = 0;
                            }
                            break;

                    }
                }
            }
        }
    }
    else {
        echo "there is no type : $type";
        return;
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
            $sql = "INSERT INTO income_expense (time, shop, number, csv, income_expense, detail) VALUES (?, ?, ?, ?, ?, ?)";
            //SQL実行の準備
            $stmt = $dbh->prepare($sql);
            //bindValueにてSQLに値を組み込む
            $stmt->bindValue(1, $line['time'], PDO::PARAM_STR);
            $stmt->bindValue(2, $line['shop'], PDO::PARAM_STR);
            $stmt->bindValue(3, $line['number'], PDO::PARAM_INT);
            $stmt->bindValue(4, $csv_id, PDO::PARAM_INT);
            $stmt->bindValue(5, $line['income_expense'], PDO::PARAM_INT);
            $stmt->bindValue(6, $line['detail'], PDO::PARAM_STR);
            
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



