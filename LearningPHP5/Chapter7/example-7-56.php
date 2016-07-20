<?php

// Load PEAR DB
require 'DB.php';
// Load the form helper functions.
require 'formhelpers.php';

// Connect to the database
$db = DB::connect('mysql://data_user:LsNbmtrWTZd6yh67@localhost/restaurant');
if (DB::isError($db)) { die ("Can't connect: " . $db->getMessage()); }

// Set up automatic error handling
$db->setErrorHandling(PEAR_ERROR_DIE);

// Set up fetch mode: rows as objects
$db->setFetchMode(DB_FETCHMODE_OBJECT);

// Choices for the "spicy" menu in the form
$spicy_choices = array('no','yes','either');

// The main page logic:
// - If the form is submitted, validate and then process or redisplay
// - If it's not submitted, display
//if ($_POST['_submit_check']) {
if (array_key_exists('_submit_check', $_POST)) {
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
    // If the form is submitted, get defaults from submitted parameters
//if ($_POST['_submit_check']) {
    if (array_key_exists('_submit_check', $_POST)) {
        $defaults = $_POST;
    } else {
        // Otherwise, set our own defaults
        $defaults = array('min_price' => '5.00',
                          'max_price' => '25.00');
    }
    
    // If errors were passed in, put them in $error_text (with HTML markup)
    if (is_array($errors)) {
        $error_text = '<tr><td>You need to correct the following errors:';
        $error_text .= '</td><td><ul><li>';
        $error_text .= implode('</li><li>',$errors);
        $error_text .= '</li></ul></td></tr>';
    } else {
        // No errors? Then $error_text is blank
        $error_text = '';
    }

    // Jump out of PHP mode to make displaying all the HTML tags easier
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<?php print $error_text ?>

<tr><td>Dish Name:</td>
<td><?php input_text('dish_name', $defaults) ?></td></tr>

<tr><td>Minimum Price:</td>
<td><?php input_text('min_price', $defaults) ?></td></tr>

<tr><td>Maximum Price:</td>
<td><?php input_text('max_price', $defaults) ?></td></tr>

<tr><td>Spicy:</td>
<td><?php input_select('is_spicy', $defaults, $GLOBALS['spicy_choices']); ?>
</td></tr>

<tr><td colspan="2" align="center"><?php input_submit('search','Search'); ?>
</td></tr>

</table>
<input type="hidden" name="_submit_check" value="1"/>
</form>
<?php
      } // The end of show_form()

function validate_form() {
    $errors = array();

    // minimum price must be a valid floating point number
    if ($_POST['min_price'] != strval(floatval($_POST['min_price']))) {
        $errors[] = 'Please enter a valid minimum price.';
    }

    // maximum price must be a valid floating point number
    if ($_POST['max_price'] != strval(floatval($_POST['max_price']))) {
        $errors[] = 'Please enter a valid maximum price.';
    }

    // minimum price must be less than the maximum price
    if ($_POST['min_price'] >= $_POST['max_price']) {
        $errors[] = 'The minimum price must be less than the maximum price.';
    }

    if (! array_key_exists($_POST['is_spicy'], $GLOBALS['spicy_choices'])) {
        $errors[] = 'Please choose a valid "spicy" option.';
    }
    return $errors;
}

function process_form() {
    // Access the global variable $db inside this function
    global $db;
    
    // build up the query 
    $sql = 'SELECT dish_name, price, is_spicy FROM dishes WHERE
            price >= ? AND price <= ?';

    // if a dish name was submitted, add to the WHERE clause
    // we use quoteSmart() and strtr() to prevent user-enter wildcards from working
    if (strlen(trim($_POST['dish_name']))) {
        $dish = $db->quoteSmart($_POST['dish_name']);
        $dish = strtr($dish, array('_' => '\_', '%' => '\%'));
        $sql .= " AND dish_name LIKE $dish";
    }

    // if is_spicy is "yes" or "no", add appropriate SQL
    // (if it's either, we don't need to add is_spicy to the WHERE clause)
    $spicy_choice = $GLOBALS['spicy_choices'][ $_POST['is_spicy'] ];
    if ($spicy_choice == 'yes') {
        $sql .= ' AND is_spicy = 1';
    } elseif ($spicy_choice == 'no') {
        $sql .= ' AND is_spicy = 0';
    }

    // Send the query to the database program and get all the rows back
    $dishes = $db->getAll($sql, array($_POST['min_price'],
                                      $_POST['max_price']));

    if (count($dishes) == 0) {
        print 'No dishes matched.';
    } else {
        print '<table>';
        print '<tr><th>Dish Name</th><th>Price</th><th>Spicy?</th></tr>';
        foreach ($dishes as $dish) {
            if ($dish->is_spicy == 1) {
                $spicy = 'Yes';
            } else {
                $spicy = 'No';
            }
            printf('<tr><td>%s</td><td>$%.02f</td><td>%s</td></tr>',
                   htmlentities($dish->dish_name), $dish->price, $spicy);
        }
    }
}
?>