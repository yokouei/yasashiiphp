





<html>
<head>
    <title>PHP TEST</title>
</head>
<body>

<?php

/**
 * Created by PhpStorm.
 * User: rosui
 * Date: 2016/05/09
 * Time: 16:32
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

$result = mysql_query('SELECT concat("[满300包邮]", brand.chinese_name, brand.english_name, \' \', item.chinese_name, \' \', item.descripe) as title,
       if(item.ship = 5, floor((item.price_in * shop.fare  + weight / 100 * 30) * 0.063),
          floor((item.price_in * shop.fare  + weight) * 0.063)) as price, item.price_out
FROM item LEFT JOIN  brand ON item.brand = brand.id LEFT JOIN shop on item.shop = shop.id order by item.id desc');

if (!$result) {
    die('クエリーが失敗しました。'.mysql_error());
}


/*
print('<table border="1">');

print('<tr>');
//print('<td>'.'id'.'</td>');
print('<td>title</td>');
print('<td>price</td>');

print('</tr>');

while ($row = mysql_fetch_assoc($result)) {
    print('<tr>');
    
    print('<td>'.$row['title'].'</td>');
    print('<td>'.$row['price'].'</td>');

    print('</tr>');
}
print('</table>');
*/
while ($row = mysql_fetch_assoc($result)) {
    

    //print_r($row['title'].' '.$row['price']);
    //echo $row['title'].' '.$row['price'].'\n';
    print ($row['title'].'@'.$row['price'].'@'.$row['price_out']);
    print('<br/>');

   
}

print('<a href="./list.php">return</a>');

$close_flag = mysql_close($link);

if ($close_flag){
    //print('<p>切断に成功しました。</p>');
}

?>
</body>
</html>