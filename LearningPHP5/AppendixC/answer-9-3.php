<?php
print '<table>';
print '<tr><th>Year</th><th>Labor Day</th></tr>';

for ($year = 2004; $year <= 2020; $year++) {
    // Get the timestamp for September 1 of $year
    $stamp = mktime(12,0,0,9,1,$year);
    // Advance to the first monday
    $stamp = strtotime('monday', $stamp);

    print "<tr><td>$year</td><td>";
    print date('F j', $stamp);
    print "</td></tr>\n";
}

print '</table>';
?>