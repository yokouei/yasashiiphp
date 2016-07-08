require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
$cheapest_dish = $db->getOne('SELECT dish_name, price
                              FROM dishes ORDER BY price LIMIT 1');
print "The cheapest dish is $cheapest_dish";