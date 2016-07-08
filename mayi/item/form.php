


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
 * Time: 17:11
 */

function quote_smart($value)
{
    // 数値以外をクオートする
    if (!is_numeric($value)) {
        $value = "'" . mysql_real_escape_string($value) . "'";
    }
    return $value;
}

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

//$result = mysql_query('SELECT * FROM brand WHERE id = ?');

//1
//print($_GET['id']);
//print(quote_smart($_GET['id']));


$query = sprintf("SELECT * FROM item WHERE id = %s",
    quote_smart($_GET['id']));

$result = mysql_query($query);


if (!$result) {
    die('クエリーが失敗しました。'.mysql_error());
}

print('<form method="get" action="./action.php">');

print('<table border="1">');

/*
print('<tr>');
print('<td>'.'id'.'</td>');

print('<td>'.'chinese_name'.'</td>');
print('<td>'.'english_name'.'</td>');
print('<td>'.'create_time'.'</td>');
print('<td>'.'update_time'.'</td>');
print('</tr>');
*/

while ($row = mysql_fetch_assoc($result)) {

    print('<tr>');
    print('<td>'.'brand'.'</td>');
    print('<td>');
    print('<input type="text" name="brand" required value="'.$row['brand'].'">');
    print('</td>');
    print('</tr>');
    
    print('<tr>');
    print('<td>'.'japanese_name'.'</td>');
    print('<td>');
    print('<input type="text" name="japanese_name" required size="100" value="'.$row['japanese_name'].'">');
    print('</td>');
    print('</tr>');

    print('<tr>');
    print('<td>'.'chinese_name'.'</td>');
    print('<td>');
    print('<input type="text" name="chinese_name" required size="100" value="'.$row['chinese_name'].'">');
    print('</td>');
    print('</tr>');

    print('<tr>');
    print('<td>'.'weight'.'</td>');
    print('<td>');
    print('<input type="text" name="weight" required value="'.$row['weight'].'">');
    print('</td>');
    print('</tr>');

    print('<tr>');
    print('<td>'.'shop'.'</td>');
    print('<td>');
    print('<input type="text" name="shop" required value="'.$row['shop'].'">');
    print('</td>');
    print('</tr>');

    print('<tr>');
    print('<td>'.'price_in'.'</td>');
    print('<td>');
    print('<input type="text" name="price_in" required value="'.$row['price_in'].'">');
    print('</td>');
    print('</tr>');


    print('<tr>');
    print('<td>'.'price_out'.'</td>');
    print('<td>');
    print('<input type="text" name="price_out" required value="'.$row['price_out'].'">');
    print('</td>');
    print('</tr>');

    print('<tr>');
    print('<td>'.'ship'.'</td>');
    print('<td>');
    print('<input type="text" name="ship" required value="'.$row['ship'].'">');
    print('</td>');
    print('</tr>');

    print('<tr>');
    print('<td>'.'descripe'.'</td>');
    print('<td>');
    print('<input type="text" name="descripe" size="200" value="'.$row['descripe'].'">');
    print('</td>');
    print('</tr>');
}
print('</table>');

print('<input type="hidden" name="action" value="'.$_GET['action'].'">');
print('<input type="hidden" name="id" value="'.$_GET['id'].'">');

if($_GET['action'] == 1) {
    
//print('<input type="submit" value="戻る">');
    print('<input type="submit" value="update">');  
}
elseif($_GET['action'] == 2) {

    print('<input type="submit" value="copy">');
}
else {

    print('<input type="submit" value="delete">');
}


print('<a href="./list.php">return</a>');
//print('<input type="submit" value="新規">');
    
print('</form>');

$close_flag = mysql_close($link);

if ($close_flag){
    //print('<p>切断に成功しました。</p>');
}

?>
</body>
</html>