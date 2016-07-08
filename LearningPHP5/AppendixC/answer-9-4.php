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
    global $months, $days, $years;

    // If the form is submitted, get defaults from submitted variables
    if ($_POST['_submit_check']) {
        $defaults = $_POST;
    } else {
        // Otherwise, set our own defaults: one month from now
        $default_timestamp = strtotime('+1 month');
        $defaults = array('month' => date('n', $default_timestamp),
                          'day'   => date('j', $default_timestamp),
                          'year'  => date('Y', $default_timestamp));
        
    }

    // If errors were passed in, put them in $error_text (with HTML markup)
    if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    }

    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print 'Enter a date and time:';
    
    input_select('month',$defaults,$months);
    print ' ';
    input_select('day',$defaults,$days);
    print ' ';
    input_select('year',$defaults,$years);
    print '<br/>';
    input_submit('submit','Find Tuesdays');
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {
    global $months, $days, $years;
 
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

    // Make sure the submitted date is in the future
    // Find epoch timestamp for midnight today
    // Leaving off month, day, and year arguments make them
    // default to today
    $midnight = mktime(0,0,0);
    // Find epoch timestmap for midnight on the submitted date
    $midnight_submitted = mktime(0,0,0,$_POST['month'], $_POST['day'],
                                 $_POST['year']);

    if ($midnight_submitted <= $midnight) {
        $errors[] = 'Enter a date in the future.';
    }
                                 
    return $errors;
}

function process_form() {
    // Make an epoch timestamp for the user-entered date
    $midnight_submitted = mktime(0,0,0,$_POST['month'], $_POST['day'],
                                 $_POST['year']);
    // Get the epoch timestamp for the next Tuesday (including today,
    // if today is Tuesday.
    $timestamp = strtotime('tuesday');

    if ($timestamp >= $midnight_submitted) {
        print 'There are no Tuesdays between ';
        print date('l, F j, Y');
        print ' and ';
        print date('l, F j, Y.', $midnight_submitted);
    } else {
        while ($timestamp < $midnight_submitted) {
            // Print a formatted date string for $timestamp (which is a Tuesday)
            print date('l, F j, Y', $timestamp);
            print '<br/>';
            // Add a week to $timestamp
            $timestamp = strtotime('+1 week', $timestamp);
        }
    }
}
?>