<?php
require 'DB.php';
// Connect to the database
$db = DB::connect('mysql://data_user:LsNbmtrWTZd6yh67@localhost/restaurant');

// Change the fetch mode to string-keyed arrays
$db->setFetchMode(DB_FETCHMODE_ASSOC);

print "With query() and fetchRow(): \n";
// get each row with query() and fetchRow();
$q = $db->query("SELECT dish_name, price FROM dishes");
while($row = $q->fetchRow()) {
    print "The price of $row[dish_name] is $row[price] \n";
}

print "With getAll(): \n";
// get all the rows with getAll();
$dishes = $db->getAll('SELECT dish_name, price FROM dishes');
foreach ($dishes as $dish) {
    print "The price of $dish[dish_name] is $dish[price] \n";
}

print "With getRow(): \n";
$cheap = $db->getRow('SELECT dish_name, price FROM dishes
    ORDER BY price LIMIT 1');
print "The cheapest dish is $cheap[dish_name] with price $cheap[price]";

?>