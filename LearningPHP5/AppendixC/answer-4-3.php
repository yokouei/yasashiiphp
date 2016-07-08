// Separate the city and state name in the array so we can total by state
$population = array('New York'     => array('state' => 'NY', 'pop' => 8008278),
                    'Los Angeles'  => array('state' => 'CA', 'pop' => 3694820),
                    'Chicago'      => array('state' => 'IL', 'pop' => 2896016),
                    'Houston'      => array('state' => 'TX', 'pop' => 1953631),
                    'Philadelphia' => array('state' => 'PA', 'pop' => 1517550),
                    'Phoenix'      => array('state' => 'AZ', 'pop' => 1321045),
                    'San Diego'    => array('state' => 'CA', 'pop' => 1223400),
                    'Dallas'       => array('state' => 'TX', 'pop' => 1188580),
                    'San Antonio'  => array('state' => 'TX', 'pop' => 1144646),
                    'Detroit'      => array('state' => 'MI', 'pop' => 951270));

// Use the $state_totals array to keep track of per-state totals
$state_totals = array();
$total_population = 0;

print "<table><tr><th>City</th><th>Population</th></tr>\n";
foreach ($population as $city => $info) {
    // $info is an array with two elements: pop (city population)
    // and state (state name)
    $total_population += $info['pop'];
    // increment the $info['state'] element in $state_totals by $info['pop']
    // to keep track of the total population of state $info['state']
    $state_totals[$info['state']] += $info['pop'];
    print "<tr><td>$city, {$info['state']}</td><td>{$info['pop']}</td></tr>\n";
    
}

// Iterate through the $state_totals array to print the per-state totals
foreach ($state_totals as $state => $pop) {
    print "<tr><td>$state</td><td>$pop</td>\n";
}
print "<tr><td>Total</td><td>$total_population</td></tr>\n";
print "</table>\n";