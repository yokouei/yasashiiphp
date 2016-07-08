$population = array('New York, NY' => 8008278,
                    'Los Angeles, CA' => 3694820,
                    'Chicago, IL' => 2896016,
                    'Houston, TX' => 1953631,
                    'Philadelphia, PA' => 1517550,
                    'Phoenix, AZ' => 1321045,
                    'San Diego, CA' => 1223400,
                    'Dallas, TX' => 1188580,
                    'San Antonio, TX' => 1144646,
                    'Detroit, MI' => 951270);

$total_population = 0;
print "<table><tr><th>City</th><th>Population</th></tr>\n";
foreach ($population as $city => $people) {
    $total_population += $people;
    print "<tr><td>$city</td><td>$people</td></tr>\n";
    
}
print "<tr><td>Total</td><td>$total_population</td></tr>\n";
print "</table>\n";