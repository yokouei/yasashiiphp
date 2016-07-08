$row_color = array('red','green');
$dinner = array('Sweet Corn and Asparagus',
                'Lemon Chicken',
                'Braised Bamboo Fungus');
print "<table>\n";

for ($i = 0, $num_dishes = count($dinner); $i < $num_dishes; $i++) {
    print '<tr bgcolor="' . $row_color[$i % 2] . '">';
    print "<td>Element $i</td><td>$dinner[$i]</td></tr>\n";
}
print '</table>';