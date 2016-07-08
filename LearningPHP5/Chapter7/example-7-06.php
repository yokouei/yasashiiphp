require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError(db)) { die("connection error: " . $db->getMessage()); }
$q = $db->query("CREATE TABLE dishes (
	dish_id INT,
	dish_name VARCHAR(255),
	price DECIMAL(4,2),
	is_spicy INT
)");