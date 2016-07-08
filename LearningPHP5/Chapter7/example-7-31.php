require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetchRow()) {
    print "$row[0], $row[1] \n";
}