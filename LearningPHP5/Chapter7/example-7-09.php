<?php
require 'DB.php';
$db = DB::connect('mysql://data_user:LsNbmtrWTZd6yh67@localhost/restaurant');

if (DB::isError($db)) { die("connection error: " . $db->getMessage()); }
$q = $db->query("INSERT INTO dishes (dish_id, dish_name, price, is_spicy)
    VALUES (1, 'Sesame Seed Puff', 2.50, 0)");
if (DB::isError($q)) { die("query error: " . $q->getMessage()); }

?>