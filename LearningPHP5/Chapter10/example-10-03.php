$zip = 98052;

$weather_page = file_get_contents('http://www.srh.noaa.gov/zipcity.php?inputstring=' . $zip);

// Just keep everything after the "Detailed Forecast" image alt text
$page = strstr($weather_page,'Detailed Forecast');
// Find where the forecast <table> starts
$table_start = strpos($page, '<table');
// Find where the <table> ends
// Need to add 8 to advance past the </table> tag
$table_end  = strpos($page, '</table>') + 8;
// And print a slice of $page that holds the table
print substr($page, $table_start, $table_end - $table_start);