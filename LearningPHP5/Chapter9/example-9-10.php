<?php

require 'formhelpers.php';

$midnight_today = mktime(0,0,0);
$choices = array();
for ($i = 0; $i < 7; $i++) {
    $timestamp = strtotime("+$i day", $midnight_today);
    $display_date = strftime('%A, %B %d, %Y', $timestamp);
    $choices[$timestamp] = $display_date;
}
input_select('date', $_POST, $choices);

?>