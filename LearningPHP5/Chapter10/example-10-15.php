<?php

require 'DB.php';
require 'example-10-12.php';
// Connect to the database
$db = DB::connect('mysql://data_user:LsNbmtrWTZd6yh67@localhost/restaurant');

// Tell the web client that a CSV file called "dishes.csv" is coming
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="dishes.csv"');

// Retrieve the info from the database table and print it
$dishes = $db->query('SELECT dish_name, price, is_spicy FROM dishes');
while ($row = $dishes->fetchRow()) {
    print make_csv_line($row);
}

?>