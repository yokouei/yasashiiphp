$midnight_today = mktime(0,0,0);
print '<select name="date">';
for ($i = 0; $i < 7; $i++) {
    $timestamp = strtotime("+$i day", $midnight_today);
    $display_date = strftime('%A, %B %d, %Y', $timestamp);
    print '<option value="' . $timestamp .'">'.$display_date."</option>\n";
}
print "\n</select>";