<?php
/**
 * Created by PhpStorm.
 * User: rosui
 * Date: 2016/06/13
 * Time: 15:33
 */

function quote_smart($value)
{
    // 数値以外をクオートする
    if (!is_numeric($value)) {
//        $value = "'" . mysql_real_escape_string($value) . "'";
    }
    return $value;
}

$filepath = "./Shipping_history.csv";



// ファイル取得



$file = new SplFileObject($filepath);
$file->setFlags(SplFileObject::READ_CSV);

// ファイル内のデータループ
foreach ($file as $key => $line) {

    foreach( $line as $line_key => $str ){

        if( $key > 0 and $line_key > 0 ){

            switch ($line_key) {
                case 1:
                    $pieces = explode(" ", $str);
                    $records[ $key ][] = $pieces[0] ;
                    break;

                case 3:
                    switch ($str) {
                        case "POSTAL PARCEL":
                            $records[ $key ][] = 5 ;
                            break;

                        case "International ePacket":
                            $records[ $key ][] = 2 ;
                            break;

                        case "EMS(Goods)":
                            $records[ $key ][] = 1 ;
                            break;

                        default:
                            $records[ $key ][] = 0 ;
                            break;

                    }
                    break;

                case 4:
                    $records[ $key ][] = $str ;
                    break;
                case 21:
                    $pieces = explode(",", $str);
                    $records[ $key ][] = $pieces[0] ;
                    break;
            }


        }


    }

}

/*
echo "<pre>";
print_r( $records );
echo "</pre>";
*/
require_once(dirname(__FILE__)."/../db_config.php");


//try〜catchにてエラーハンドリングを行う。
try {
    //PDOを使ったデータベースへの接続
    //$user,$passはdb_config.phpにて定義済み
    $dbh = new PDO('mysql:host=localhost;dbname=mamazon;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    foreach ($records as $row => $line) {


        //INSERT用のSQLを生成
        $sql = "INSERT INTO shipping (ship, number, state, send_time) VALUES (?, ?, ?, ?)";
        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindValueにてSQLに値を組み込む
        $stmt->bindValue(1, quote_smart($line[1]), PDO::PARAM_STR);
        $stmt->bindValue(2, quote_smart($line[2]), PDO::PARAM_INT);
        $stmt->bindValue(3, quote_smart($line[3]), PDO::PARAM_STR);
        $stmt->bindValue(4, quote_smart($line[0]), PDO::PARAM_STR);

        //SQLの実行
        $stmt->execute();

    }

    //try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (PDOException $e) {
    //エラーメッセージ出力
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    //処理の終了
    die();
}
