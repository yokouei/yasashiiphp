


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

$result = mysql_query('SELECT brand.chinese_name as brand, item.id, item.japanese_name, item.chinese_name, '.
    'item.weight, ship.name as ship, shop.name as shop, shop.link, item.price_in, item.price_out, '.
    'if(item.ship = 5, floor((item.price_in * shop.fare + weight / 100 * 30) * 0.065),
          floor((item.price_in * shop.fare  + weight) * 0.065)) as price FROM item '.
  'left join brand on item.brand = brand.id '.
  'LEFT JOIN shop on item.shop = shop.id '.
'LEFT JOIN ship on item.ship = ship.id order by item.brand desc, item.id desc');

if (!$result) {
    die('クエリーが失敗しました。'.mysql_error());
}

print('<a href="./output.php">output</a>');

print('<table border="1">');

print('<tr>');
print('<td>'.'id'.'</td>');
print('<td>update</td>');
print('<td>copy</td>');
print('<td>delete</td>');

print('<td>'.'brand'.'</td>');
print('<td>'.'japanese_name'.'</td>');
print('<td>'.'chinese_name'.'</td>');
print('<td>'.'weight'.'</td>');
print('<td>'.'ship'.'</td>');
print('<td>'.'shop'.'</td>');
print('<td>'.'price_in'.'</td>');
//print('<td>'.'rate'.'</td>');
print('<td>'.'price'.'</td>');

print('<td>'.'price_out'.'</td>');


print('</tr>');

while ($row = mysql_fetch_assoc($result)) {
    print('<tr>');

    print('<td>');
    print('<a href="./form.php?id='.$row['id'].'&action=1">');
    print('update');
    print('</a>');
    print('</td>');

    print('<td>');
    print('<a href="./form.php?id='.$row['id'].'&action=2">');
    print('copy');
    print('</a>');
    print('</td>');

    print('<td>');
    print('<a href="./form.php?id='.$row['id'].'&action=3">');
    print('delete');
    print('</a>');
    print('</td>');

    print('<td>'.$row['id'].'</td>');
    print('<td>'.$row['brand'].'</td>');
    print('<td>'.$row['japanese_name'].'</td>');
    print('<td>'.$row['chinese_name'].'</td>');
    print('<td>'.$row['weight'].'</td>');
    print('<td>'.$row['ship'].'</td>');

    print('<td>');
    print('<a href="'.$row['link'].'">');
    print($row['shop']);
    print('</a>');
    print('</td>');

    //print('<td>'.$row['shop'].'</td>');
    print('<td>'.$row['price_in'].'</td>');
    //print('<td>'.$row['rate'].'</td>');
    print('<td>'.$row['price'].'</td>');

    print('<td>'.$row['price_out'].'</td>');
    
    print('</tr>');
}
print('</table>');

//print('<a href="./add.html">new</a>');

$close_flag = mysql_close($link);

if ($close_flag){
    //print('<p>切断に成功しました。</p>');
}

?>
</body>
</html>