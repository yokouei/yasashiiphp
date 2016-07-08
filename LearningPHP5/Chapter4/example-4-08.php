$row_color = array('red','green');
$color_index = 0;
$meal = array('breakfast' => 'Walnut Bun',
              'lunch' => 'Cashew Nuts and White Mushrooms',
              'snack' => 'Dried Mulberries',
              'dinner' => 'Eggplant with Chili Sauce');
print "<table>\n";
foreach ($meal as $key => $value) {
    print '<tr bgcolor="' . $row_color[$color_index] . '">';
    print "<td>$key</td><td>$value</td></tr>\n";
    // This switches $color_index between 0 and 1
    $color_index = 1 - $color_index;
}
print '</table>';