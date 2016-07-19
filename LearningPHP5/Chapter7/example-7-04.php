<?php
require 'DB.php';
$db = DB::connect('mysql://penguin:top^hat@db.example.com/restaurant');
if (DB::isError($db)) { die("Can't connect: " . $db->getMessage()); }
?>