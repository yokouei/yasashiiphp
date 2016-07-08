require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError(db)) { die("connection error: " . $db->getMessage()); }
// remove expensive dishes
if ($make_things_cheaper) {
    $db->query("DELETE FROM dishes WHERE price > 19.95");
} else {
    // or, remove all dishes
    $db->query("DELETE FROM dishes");
}