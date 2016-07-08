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
        $value = "'" . mysql_real_escape_string($value) . "'";
    }
    return $value;
}

$filepath = "./Shipping_history.csv";



// ファイル取得

/*
    $file = new SplFileObject($filepath);
    $file->setFlags(SplFileObject::READ_CSV);

    // ファイル内のデータループ
    foreach ($file as $key => $line) {

        foreach( $line as $str ){

            $records[ $key ][] = $str ;
        }

    }

    echo "<pre>";
    print_r( $records );
    echo "</pre>";
*/

// ファイル取得
/*
$file = new SplFileObject($filepath);
$file->setFlags(SplFileObject::READ_CSV);

// 全行のINSERTデータ格納用
$ins_values = "";



// ファイル内のデータループ

foreach ( $file as $key => $line ) {

    if( $key == 0 ){

        // headの処理
        continue;
    }

    // 配列の値がすべて空か判定
    $judge = count( array_count_values( $line ) );

    if( $judge == 0 ){

        // 配列の値がすべて空の時の処理
        continue;
    }

    // 1行毎のINSERTデータ格納用
    $values = "";

    foreach ( $line as $line_key => $str ) {

        if( $line_key > 0 ){

            $values .= ", ";
        }

        // INSERT用のデータ作成
        $values .= "'".mb_convert_encoding( $str, "utf-8", "sjis" )."'";
    }

    if( !empty( $ins_values ) ){

        $ins_values .= ", ";
    }

    $ins_values .= "(". $values . ")";
}


$sql_insert = "INSERT INTO テーブル名 ( カラム01, カラム02, カラム03 ) VALUES " . $values;
//mysql_query( $sql_insert, $connect );

*/

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

$link = mysql_connect('localhost', $user, $pass);

if (!$link) {
    die('接続失敗です。'.mysql_error());
}

//print('<p>接続に成功しました。</p>');

$db_selected = mysql_select_db('mamazon', $link);
if (!$db_selected){
    die('データベース選択失敗です。'.mysql_error());
}

//print('<p>uriageデータベースを選択しました。</p>');

mysql_set_charset('utf8');

$success = 0;
$fault = 0;

foreach ($records as $row => $line) {

/*    // 1行毎のINSERTデータ格納用
    $values = "";

    foreach( $line as $column => $value ){

        if( $line_key > 0 ){

            $values .= ", ";
        }

        // INSERT用のデータ作成
        $values .= "'".mb_convert_encoding( $str, "utf-8", "sjis" )."'";
    }

    if( !empty( $ins_values ) ){

        $ins_values .= ", ";
    }

    $ins_values .= "(". $values . ")";


    $sql_insert = "INSERT INTO shipping ( ship, number, state, send_time ) VALUES " . $values;

 */
    $sql_insert = sprintf("insert into shipping (ship, number, state, send_time) VALUES (%s, %s, %s, %s)"
        , quote_smart($line[1]), quote_smart($line[2]),quote_smart($line[3]),quote_smart($line[0]));

//    echo($sql_insert);
//    echo "<br/>";

    $result_flag = mysql_query($sql_insert);

    if (!$result_flag) {
        $fault++;
        die($sql_insert);
        die('UPDATEクエリーが失敗しました。'.mysql_error());
    }
    else
        $success++;

}


print("sucess:".$success."fault:".$fault."total:".$success+$fault);


$close_flag = mysql_close($link);

if ($close_flag){
    //print('<p>切断に成功しました。</p>');
}