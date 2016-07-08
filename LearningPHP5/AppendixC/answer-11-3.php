<?php
require 'DB.php';
require 'formhelpers.php'; // load the form element printing functions

$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError($db)) { die("Can't connect: " . $db->getMessage()); }

$db->setErrorHandling(PEAR_ERROR_DIE);
$db->setFetchMode(DB_FETCHMODE_ASSOC);

if ($_POST['_submit_check']) {
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        process_form();
    }
} else {
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

    // the price
    print '<tr><td>Price:</td><td>';
    input_text('price', $_POST);
    print '</td></tr>';
    
    // form end
    print '<tr><td colspan="2"><input type="submit" value="Search Dishes"></td></tr>';
    print '</table>';
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}      

function validate_form() {
    $errors = array();

    if (! is_numeric($_POST['price'])) {
        $errors[] = 'Please enter a valid price.';
    } elseif ($_POST['price'] <= 0) {
        $errors[] = 'Please enter a price greater than 0.';
    }
    return $errors;
}

function process_form() {
    global $db;
    header('Content-Type: text/xml');

    $dishes = $db->getAll('SELECT dish_name, price FROM dishes WHERE price >= ?',
                          array($_POST['price']));
    print "<dishes>\n";
    foreach ($dishes as $dish) {
        print " <dish>\n";
        print '  <name>'  . htmlentities($dish['dish_name']) . "</name>\n";
        print '  <price>' . htmlentities($dish['price']) . "</price>\n";
        print " </dish>\n";
    }
    print '</dishes>';
}
?>