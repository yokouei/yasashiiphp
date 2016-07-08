

<html>
<head>
<title>PHP TEST</title>
</head>

<body>

<?php

/**
 * Created by PhpStorm.
 * User: rosui
 * Date: 2016/05/08
 * Time: 17:44
 */

function quote_smart($value)
{
    // 数値以外をクオートする
    if (!is_numeric($value)) {
        $value = "'" . mysql_real_escape_string($value) . "'";
    }
    return $value;
}

$link = mysql_connect('localhost', 'root', '9809136');
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

$_POST = file_get_contents('php://input');

$sql = sprintf("insert into brand (japanese_name, chinese_name, english_name, create_time, update_time) VALUES (%s, %s, %s, now(), now())"
    , quote_smart($_GET['japanese_name']), quote_smart($_GET['chinese_name']),
    quote_smart($_GET['english_name']));

print($sql);

$result_flag = mysql_query($sql);

if (!$result_flag) {
    die('UPDATEクエリーが失敗しました。'.mysql_error());
}
else
    print('<p>データを新規しました。</p>');

print('<a href="./list.php">戻る</a>');

$close_flag = mysql_close($link);

if ($close_flag){
    //print('<p>切断に成功しました。</p>');
}

?>
</body>
</html>