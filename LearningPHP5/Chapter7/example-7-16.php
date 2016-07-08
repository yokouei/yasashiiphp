require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError(db)) { die("connection error: " . $db->getMessage()); }
// Eggplant with Chili Sauce is spicy
$db->query("UPDATE dishes SET is_spicy = 1
            WHERE dish_name = 'Eggplant with Chili Sauce'");
// Lobster with Chili Sauce is spicy and pricy
$db->query("UPDATE dishes SET is_spicy = 1, price=price * 2
            WHERE dish_name = 'Lobster with Chili Sauce'");