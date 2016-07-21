<?php
// Use the form helper functions defined in Chapter 6
require 'formhelpers.php';

$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 
                12 => 'December');

$years = array();
for ($year = date('Y') - 1, $max_year = date('Y') + 5; $year < $max_year; $year++) {
    $years[$year] = $year;
}

if (array_key_exists('_submit_check', $_POST)) {
    //if ($_POST['_submit_check']) {
    if ($errors = validate_form()) {
        show_form($errors);
    } else {
        show_form();
        process_form();
    }
} else {
    // When nothing is submitted, show the form and then
    // a calendar for the current month
    show_form();
    show_calendar(date('n'), date('Y'));
}

function validate_form() {
    global $months, $years;
    $errors = array();

    if (! array_key_exists($_POST['month'], $months)) {
        $errors[] = 'Select a valid month.';
    }

    if (! array_key_exists($_POST['year'], $years)) {
        $errors[] = 'Select a valid year.';
    }

    return $errors;
}

function show_form($errors = '') {
    global $months, $years;

    // If the form is submitted, get defaults from submitted variables
    if (array_key_exists('_submit_check', $_POST)) {
        //if ($_POST['_submit_check']) {
        $defaults = $_POST;
    } else {
        // Otherwise, set our own defaults: the current month and year
        $defaults = array('year' => date('Y'),
                          'month' => date('n'));
    }


    if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    }

    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">'."\n";
    input_select('month', $defaults, $months);
    input_select('year',  $defaults, $years);
    input_submit('submit','Show Calendar');
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print "\n".'</form>';
}

function process_form() {
    show_calendar($_POST['month'], $_POST['year']);
}

function show_calendar($month, $year) {
    global $months;
    $weekdays = array('Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa');

    // Find the epoch timestamp for midnight on the first day of the month
    $first_day = mktime(0,0,0,$month, 1, $year);
    // How many days are in the month?
    $days_in_month = date('t', $first_day);
    // What day of the week (numerically) is the first day of the month?
    // You need this to put the first table cell in the right place
    $day_offset = date('w', $first_day);


    // Print the table header and the row of weekday names
    print<<<_HTML_

<table border="0" cellspacing="0" cellpadding="2">
    <tr><th colspan="7">$months[$month] $year</th></tr>
    <tr><td align="center">
_HTML_;
    print implode('</td>'."\n\t\t".'<td align="center">', $weekdays);
    print '</td>';
    print "\n\t".'</tr>';
    print "\n\t".'<tr>';


    // If the first day of the month is, say, a Tuesday, then you
    // need to put blank table cells under "Su" and "Mo" in the first
    // row so that the day 1 table cell goes under "Tu"
    if ($day_offset > 0) {
        for ($i = 0; $i < $day_offset; $i++) { print "\n\t\t".'<td>&nbsp;</td>'; }
    }

    // Print a table cell for each day of the month
    for ($day = 1; $day <= $days_in_month; $day++ ) {
        print "\n\t\t".'<td align="center">' . $day . '</td>';
        $day_offset++;
        // If this cell was the seventh in the row, then
        // end the table row and reset $day_offset
        if ($day_offset == 7) {
            $day_offset = 0;
            print "\n\t"."</tr>\n";
            // If there are more days to come, then
            // start a new table row
            if ($day < $days_in_month) {
                print "\n\t".'<tr>';
            }
        }
    }

    // At this point, one table cell has been printed for each day
    // of the month. If the last day of the month isn't a Saturday
    // then the last row of the table needs to be padded with
    // some blank cells out to the end of the row
    if ($day_offset > 0) {
        for ($i = $day_offset; $i < 7; $i++) {
            print "\n\t\t".'<td>&nbsp;</td>';
        }
        print "\n\t".'</tr>';
    }
    print "\n".'</table>';
}
?>