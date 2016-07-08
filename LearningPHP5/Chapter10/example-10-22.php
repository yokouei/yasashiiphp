$zip = 10040;
$weather_page = file_get_contents('http://www.srh.noaa.gov/zipcity.php?inputstring=' . $zip);

if ($weather_page === false) {
    print "Couldn't get weather for $zip";
} else {
    // Just keep everything after the "Detailed Forecast" image alt text
    $page = strstr($weather_page,'Detailed Forecast');
    // Find where the forecast <table> starts
    $table_start = strpos($page, '<table');
    // Find where the <table> ends
    // Need to add 8 to advance past the </table> tag
    $table_end  = strpos($page, '</table>') + 8;
    // And get the slice of $page that holds the table
    $forecast = substr($page, $table_start, $table_end - $table_start);
    // Print the forecast;
    print $forecast;
    $saved_file = file_put_contents("weather-$zip.txt", $matches[1]);
    // Need to check if file_put_contents() returns false or -1
    if (($saved_file === false) || ($saved_file == -1)) {
        print "Couldn't save weather to weather-$zip.txt";
    }
}