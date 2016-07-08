print '<select name="hour">';
for ($hour = 1; $hour <= 12; $hour++) {
    print '<option value="' . $hour . '">' . $hour ."</option>\n";
}
print "</select>:";

print '<select name="minute">';
for ($minute = 0; $minute < 60; $minute += 5) {
    printf('<option value="%02d">%02d</option>', $minute, $minute);
}
print "</select> \n";

print '<select name="ampm">';
print '<option value="am">am</option';
print '<option value="pm">pm</option';
print '</select>';