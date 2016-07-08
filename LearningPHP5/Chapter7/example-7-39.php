require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
$cheapest_dish_info = $db->getRow('SELECT dish_name, price
                                   FROM dishes ORDER BY price LIMIT 1');
print "$cheapest_dish_info[0], $cheapest_dish_info[1]";