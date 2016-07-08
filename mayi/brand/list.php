


<html>
<head>
    <title>PHP TEST</title>
</head>
<body>

<?php

/**
 * Created by PhpStorm.
 * User: rosui
 * Date: 2016/05/07
 * Time: 16:40
 */

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

$result = mysql_query('SELECT * FROM brand');
if (!$result) {
    die('クエリーが失敗しました。'.mysql_error());
}

print($_POST['id']);

print('<table border="1">');

print('<tr>');
print('<td>'.'id'.'</td>');
print('<td>update</td>');
print('<td>copy</td>');
print('<td>delete</td>');
print('<td>'.'japanese_name'.'</td>');
print('<td>'.'chinese_name'.'</td>');
print('<td>'.'english_name'.'</td>');
print('<td>'.'create_time'.'</td>');
print('<td>'.'update_time'.'</td>');

print('</tr>');

while ($row = mysql_fetch_assoc($result)) {
    print('<tr>');
    print('<td>'.$row['id'].'</td>');
    print('<td>');
    print('<a href="./detail.php?id='.$row['id'].'&action=1">');
    print('update');
    print('</a>');
    print('</td>');

    print('<td>');
    print('<a href="./detail.php?id='.$row['id'].'&action=2">');
    print('copy');
    print('</a>');
    print('</td>');

    print('<td>');
    print('<a href="./detail.php?id='.$row['id'].'&action=3">');
    print('delete');
    print('</a>');
    print('</td>');

    print('<td>'.$row['japanese_name'].'</td>');
    print('<td>'.$row['chinese_name'].'</td>');
    print('<td>'.$row['english_name'].'</td>');
    print('<td>'.$row['create_time'].'</td>');
    print('<td>'.$row['update_time'].'</td>');
    print('</tr>');
}
print('</table>');

print('<a href="./add.html">new</a>');

$close_flag = mysql_close($link);

if ($close_flag){
    //print('<p>切断に成功しました。</p>');
}

?>
</body>
</html>