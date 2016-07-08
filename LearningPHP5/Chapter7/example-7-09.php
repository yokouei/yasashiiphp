require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError(db)) { die("connection error: " . $db->getMessage()); }
$q = $db->query("INSERT INTO dishes (dish_size, dish_name, price, is_spicy)
    VALUES ('large, 'Sesame Seed Puff', 2.50, 0)");
if (DB::isError($q)) { die("query error: " . $q->getMessage()); }