require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// print a message and quit on future database errors
$db->setErrorHandling(PEAR_ERROR_DIE);

$q = $db->query("INSERT INTO dishes (dish_size, dish_name, price, is_spicy)
    VALUES ('large, 'Sesame Seed Puff', 2.50, 0)");
print "Query Succeeded!";