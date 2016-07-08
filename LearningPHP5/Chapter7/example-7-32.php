require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
$q = $db->query('SELECT dish_name, price FROM dishes');
print 'There are ' . $q->numrows() . ' rows in the dishes table.';