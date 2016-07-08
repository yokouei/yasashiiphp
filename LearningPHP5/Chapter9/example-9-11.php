$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 
                12 => 'December');

print '<select name="month">';
// One choice for each element in $months
foreach ($months as $num => $month_name) {
    print '<option value="' . $num . '">' . $month_name ."</option>\n";
}
print "</select> \n";

print '<select name="day">';
// One choice for each day from 1 to 31
for ($i = 1; $i <= 31; $i++) {
    print '<option value="' . $i . '">' . $i ."</option>\n";
}
print "</select> \n";

print '<select name="year">';
// One choice for each year from last year to five years from now
for ($year = date('Y') -1, $max_year = date('Y') + 5; $year < $max_year; $year++) {
    print '<option value="' . $year . '">' . $year ."</option>\n";
}
print "</select> \n";