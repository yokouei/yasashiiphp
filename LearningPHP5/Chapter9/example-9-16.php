<?php
require 'formhelpers.php';

// Set up arrays of months, days, years, hours, and minutes 
$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 
                12 => 'December');

$days = array();
for ($i = 1; $i <= 31; $i++) { $days[$i] = $i; }

$years = array();
for ($year = date('Y') -1, $max_year = date('Y') + 5; $year < $max_year; $year++) {
    $years[$year] = $year;
}

$hours = array();
for ($hour = 1; $hour <= 12; $hour++) { $hours[$hour] = $hour; }

$minutes = array();
for ($minute = 0; $minute < 60; $minute+=5) {
    $formatted_minute = sprintf('%02d', $minute);
    $minutes[$formatted_minute] = $formatted_minute;
}

if ($_POST['_submit_check']) {
    // If validate_form() returns errors, pass them to show_form()
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        // The submitted data is valid, so process it
        process_form();
    }
} else {
    // The form wasn't submitted, so display
    show_form();
}

function show_form($errors = '') {
    global $hours, $minutes, $months, $days, $years;

    // If the form is submitted, get defaults from submitted variables
    if ($_POST['_submit_check']) {
        $defaults = $_POST;
    } else {
        // Otherwise, set our own defaults: the current time and date parts
        $defaults = array('hour'  => date('g'),
                          'ampm'  => date('a'),
                          'month' => date('n'),
                          'day'   => date('j'),
                          'year'  => date('Y'));
        
        // Because the choices in the minute menu are in five-minute increments,
        // if the current minute isn't a multiple of five, we need to make it
        // into one.
        $this_minute = date('i');
        $minute_mod_five = $this_minute % 5;
        if ($minute_mod_five != 0) { $this_minute -= $minute_mod_five;  }
        $defaults['minute'] = sprintf('%02d', $this_minute);
    }

    // If errors were passed in, put them in $error_text (with HTML markup)
    if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    }

    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print 'Enter a date and time:';
    
    input_select('hour',$defaults,$hours);
    print ':';
    input_select('minute',$defaults,$minutes);
    input_select('ampm', $defaults,array('am' => 'am', 'pm' => 'pm'));
    input_select('month',$defaults,$months);
    print ' ';
    input_select('day',$defaults,$days);
    print ' ';
    input_select('year',$defaults,$years);
    print '<br/>';
    input_submit('submit','Find Meeting');
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {
    global $hours, $minutes, $months, $days, $years;
 
    $errors = array();
   
    if (! array_key_exists($_POST['month'], $months)) {
        $errors[] = 'Select a valid month.';
    }
    if (! array_key_exists($_POST['day'], $days)) {
        $errors[] = 'Select a valid day.';
    }
    if (! array_key_exists($_POST['year'], $years)) {
        $errors[] = 'Select a valid year.';
    }
    if (! array_key_exists($_POST['hour'], $hours)) {
        $errors[] = 'Select a valid hour.';
    }
    if (! array_key_exists($_POST['minute'], $minutes)) {
        $errors[] = 'Select a valid minute.';
    }
    if (($_POST['ampm'] != 'am') && ($_POST['ampm'] != 'pm')) {
        $errors[] = 'Select a valid am/pm choice.';
    }

    return $errors;
}

function process_form() {
    
    // Before we can feed the form parameters to mktime(), we must
    // convert the hour to a 24-hour value with influence from 
    // $_POST['ampm']
    
    if (($_POST['ampm'] == 'am') && ($_POST['hour'] == 12)) {
        // 12 am is 0 in 24-hour time
        $_POST['hour'] = 0;
    } elseif (($_POST['ampm'] == 'pm') && ($_POST['hour'] != 12)) {
        // For all pm times except 12 pm, add 12 to the hour
        // 1pm becomes 13, 11 pm becomes 23, but 12 pm (noon)
        // stays 12
        $_POST['hour'] += 12;
    }

    // Make an epoch timestamp for the user-entered date
    $timestamp = mktime($_POST['hour'], $_POST['minute'], 0,
                        $_POST['month'], $_POST['day'], $_POST['year']);


    // How to figure out the next NYPHP meeting on or after the user-entered date:
    // If $timestamp is on or before the fourth thursday of the month, then use the NYPHP meeting
    // date for $timestamp's month
    // Otherwise, use the NYPHP meeting date for the next month.

    // Midnight on the user-entered date
    $midnight  = mktime(0,0,0, $_POST['month'], $_POST['day'], $_POST['year']);
    // Midnight on the first of the user-entered month
    $first_of_the_month = mktime(0,0,0,$_POST['month'],1,$_POST['year']);
    // Midnight on the fourth thursday of the user-entered month 
    $month_nyphp = strtotime('fourth thursday',$first_of_the_month);
    
    if ($midnight < $month_nyphp) {
        // The user-entered date is before the meeting day
        print "NYPHP Meeting this month: ";
        print date('l, F j, Y', $month_nyphp);
    } elseif ($midnight == $month_nyphp) {
        // The user-entered date is a meeting day
        print "NYPHP Meeting today. ";
        $meeting_start = strtotime('6:30pm', $month_nyphp);
        // If it's afer 6:30pm, say that the meeting has already started
        if ($timestamp > $meeting_start) {
            print "It started at 6:30 but you entered ";
            print date('g:i a', $timestamp);
        }
    } else {
        // The user-entered date is after a meeting day, so find the
        // meeting day for next month
        $first_of_next_month = mktime(0,0,0,$_POST['month'] + 1,1,$_POST['year']);
        $next_month_nyphp = strtotime('fourth thursday',$first_of_next_month);
        print "NYPHP Meeting next month: ";
        print date('l, F j, Y', $next_month_nyphp);
    }
}
?>