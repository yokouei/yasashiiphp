require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError(db)) { die("connection error: " . $db->getMessage()); }
// Decrease the price some some dishes
$db->query("UPDATE dishes SET price=price - 5 WHERE price > 20");
print 'Changed the price of ' . $db->affectedRows() . 'rows.';