<?php
print '<select name="hour">'."\n";
for ($hour = 1; $hour <= 12; $hour++) {
    print "\t".'<option value="' . $hour . '">' . $hour ."</option>\n";
}
print "</select>:\n";

print '<select name="minute">'."\n";
for ($minute = 0; $minute < 60; $minute += 5) {
    printf("\t".'<option value="%02d">%02d</option>'."\n", $minute, $minute);
}
print "</select>\n";

print '<select name="ampm">'."\n";
print "\t".'<option value="am">am</option>'."\n";
print "\t".'<option value="pm">pm</option>'."\n";
print '</select>';

?>