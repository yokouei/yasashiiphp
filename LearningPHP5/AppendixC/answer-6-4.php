<?php
// load the form element printing helper functions
require 'formhelpers.php';

$us_states = array('AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona',
                   'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado',
                   'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida',
                   'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
                   'IL' => 'Illinois', 'IN'=> 'Indiana', 'IA' => 'Iowa', 
                   'KS' => 'Kansas', 'KY' => 'Kentucky','LA' => 'Louisiana',
                   'ME' => 'Maine', 'MD' => 'Maryland', 'MA' =>'Massachusetts',
                   'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' =>'Mississippi',
                   'MO' => 'Missouri', 'MT' => 'Montana', 'NE' =>'Nebraska',
                   'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey',
                   'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina',
                   'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
                   'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island',
                   'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee',
                   'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia',
                   'WA' => 'Washington', 'DC' => 'Washington D.C.', 'WV' => 'West Virginia',
                   'WI' => 'Wisconsin', 'WY' => 'Wyoming');

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

    if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    }

    // the beginning of the form
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print '<table>';

    // the first address
    print '<tr><th colspan="2">From</th></tr>';
    print '<td>Name:</td><td>';
    input_text('name_1', $_POST);
    print '</td></tr>';
    print '<tr><td>Street Address:</td><td>';
    input_text('address_1', $_POST);
    print '</td></tr>';
    print '<tr><td>City, State, Zip:</td><td>';
    input_text('city_1', $_POST);
    print ', ';
    input_select('state_1', $_POST, $GLOBALS['us_states']);
    input_text('zip_1', $_POST);
    print '</td></tr>';

    // the second address
    print '<tr><th colspan="2">To</th></tr>';
    print '<td>Name:</td><td>';
    input_text('name_2', $_POST);
    print '</td></tr>';
    print '<tr><td>Street Address:</td><td>';
    input_text('address_2', $_POST);
    print '</td></tr>';
    print '<tr><td>City, State, Zip:</td><td>';
    input_text('city_2', $_POST);
    print ', ';
    input_select('state_2', $_POST, $GLOBALS['us_states']);
    input_text('zip_2', $_POST);
    print '</td></tr>';

    // Package Info
    print '<tr><th colspan="2">Package</th></tr>';
    print '<tr><td>Height:</td><td>';
    input_text('height',$_POST);
    print '</td></tr>';
    print '<tr><td>Width:</td><td>';
    input_text('width',$_POST);
    print '</td></tr>';
    print '<tr><td>Length:</td><td>';
    input_text('length',$_POST);
    print '</td></tr>';
    print '<tr><td>Weight:</td><td>';
    input_text('weight',$_POST);
    print '</td></tr>';
    
    // form end
    print '<tr><td colspan="2"><input type="submit" value="Ship Package"></td></tr>';
    print '</table>';
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}      

function validate_form() {
    $errors = array();

    // first address:
    // name, street address, city are all required
    if (! strlen(trim($_POST['name_1']))) {
        $errors[] = 'Enter a From name';
    }
    if (! strlen(trim($_POST['address_1']))) {
        $errors[] = 'Enter a From street address';
    }
    if (! strlen(trim($_POST['city_1']))) {
        $errors[] = 'Enter a From city';
    }
    // state must be valid
    if (! array_key_exists($_POST['state_1'], $GLOBALS['us_states'])) {
        $errors[] = 'Select a valid From state';
    }
    // zip must be 5 digits or ZIP+4
    if (!preg_match('/^\d{5}(-\d{4})?$/', $_POST['zip_1'])) {
        $errors[] = 'Enter a valid From Zip code';
    }

    // second address:
    // name, street address, city are all required
    if (! strlen(trim($_POST['name_2']))) {
        $errors[] = 'Enter a To name';
    }
    if (! strlen(trim($_POST['address_2']))) {
        $errors[] = 'Enter a To street address';
    }
    if (! strlen(trim($_POST['city_2']))) {
        $errors[] = 'Enter a To city';
    }
    // state must be valid
    if (! array_key_exists($_POST['state_2'], $GLOBALS['us_states'])) {
        $errors[] = 'Select a valid To state';
    }
    // zip must be 5 digits or ZIP+4
    if (!preg_match('/^\d{5}(-\d{4})?$/', $_POST['zip_2'])) {
        $errors[] = 'Enter a valid To Zip code';
    }

    // package:
    // each dimension must be <= 36
    if (! strlen($_POST['height'])) {
        $errors[] = 'Enter a height.';
    }
    if ($_POST['height'] > 36) {
        $errors[] = 'Height must be no more than 36 inches.';
    }
    if (! strlen($_POST['length'])) {
        $errors[] = 'Enter a length.';
    }
    if ($_POST['length'] > 36) {
        $errors[] = 'Length must be no more than 36 inches.';
    }
    if (! strlen($_POST['width'])) {
        $errors[] = 'Enter a width.';
    }
    if ($_POST['width'] > 36) {
        $errors[] = 'Width must be no more than 36 inches.';
    }
    // Weight must be <= 150
    if (! strlen($_POST['weight'])) {
        $errors[] = 'Enter a weight.';
    }
    if ($_POST['weight'] > 150) {
        $errors[] = 'Weight must be no more than 150 pounds.';
    }

    return $errors;
}

function process_form() {
    print 'The package is going from: <br/>';
    print htmlentities($_POST['name_1']) . '<br/>';
    print htmlentities($_POST['address_1']) . '<br/>';
    print htmlentities($_POST['city_1']) .', '. $_POST['state_1'] . ' ' . $_POST['zip_1'] . '<br/>';
    print 'The package is going to: <br/>';
    print htmlentities($_POST['name_2']) . '<br/>';
    print htmlentities($_POST['address_2']) . '<br/>';
    print htmlentities($_POST['city_2']) .', '. $_POST['state_2'] . ' ' . $_POST['zip_2'] . '<br/>';
    print 'The package is ' . htmlentities($_POST['length']) . ' x' . 
        htmlentities($_POST['width']) . ' x ' . htmlentities($_POST['height']);
    print ' and weighs ' . htmlentities($_POST['weight']) . ' lbs.';
}
?>