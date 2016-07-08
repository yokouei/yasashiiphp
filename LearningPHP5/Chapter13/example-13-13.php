require 'DB.php';

$db = DB::connect('sqlite://:@localhost/restaurant.db');
if (DB::isError($db)) { die("Can't connect: " . $db->getMessage()); }

$db->setErrorHandling(PEAR_ERROR_DIE);
$db->setFetchMode(DB_FETCHMODE_ASSOC);

$dishes = $db->getAll('SELECT dish_name,price FROM dishes ORDER BY price');

if (count($dishes) > 0) {
    print '<ul>';
    foreach ($dishes as $dish) {
        print "<li> $dish[dish_name] ($dish[price])</li>";
    }
    print '</ul>';
} else {
    print 'No dishes available.';
}