$fahr = -50;
$stop_fahr = 50;

print '<table>';
print '<tr><th>Fahrenheit</th><th>Celsius</th></tr>';
while ($fahr <= $stop_fahr) {
    $celsius = ($fahr - 32) * 5 / 9;
    print "<tr><td>$fahr</td><td>$celsius</td></tr>";
    $fahr += 5;
}
print '</table>';