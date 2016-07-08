require 'DB.php';
// Connect to the database
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
// Open the CSV file
$fh = fopen('dishes.csv','rb');

for ($info = fgetcsv($fh, 1024); ! feof($fh); $info = fgetcsv($fh, 1024)) {
    // $info[0] is the dish name    (the  first field in a line of dishes.csv)
    // $info[1] is the price        (the second field)
    // $info[2] is the spicy status (the  third field)
    // Insert a row into the database table
    $db->query("INSERT INTO dishes (dish_name, price, is_spicy) VALUES (?, ?, ?)", 
               $info);
    print "Inserted $info[0]\n";
}
// Close the file
fclose($fh);