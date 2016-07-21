<?php

$zip = 98052;

$weather_page = file_get_contents('http://www.jma.go.jp/jp/yoho/319.html');

// Just keep everything after the "Detailed Forecast" image alt text
$page = strstr($weather_page,'<pre');
// Find where the forecast <table> starts
$table_start = strpos($page, '<pre');
// Find where the <table> ends
// Need to add 8 to advance past the </table> tag
$table_end  = strpos($page, '</pre>') + strlen('</pre>');
// And get the slice of $page that holds the table
$forecast = substr($page, $table_start, $table_end - $table_start);
// Print the forecast;
print $forecast;

// Save the forecast to a file
file_put_contents("weather-$zip.txt", $forecast);

?>