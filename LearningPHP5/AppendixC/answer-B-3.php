$zip = 98052;

$weather_page = file_get_contents('http://www.srh.noaa.gov/zipcity.php?inputstring=' . $zip);

if (preg_match('@<br><br>(-?\d+)&deg;F<br>\((-?\d+)&deg;C\)</td>@',$weather_page,$matches)) {
    // $matches[1] is the Fahrenheit temp
    // $matches[2] is the Celsius temp
    print "The current temperature is $matches[1] degrees.";
} else {
    print "Can't get current temperature.";
}