The structure of the customers table:

CREATE TABLE customers (
customer_id INT UNSIGNED NOT NULL,
customer_name VARCHAR(255),
phone VARCHAR(15),
favorite_dish_id INT UNSIGNED
)

The form that inserts a new customer:
<?php
require 'DB.php';
require 'formhelpers.php';

// Connect to the database
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError($db)) { die ("Can't connect: " . $db->getMessage()); }

// Set up automatic error handling
$db->setErrorHandling(PEAR_ERROR_DIE);

// Set up fetch mode: rows as associative arrays
$db->setFetchMode(DB_FETCHMODE_ASSOC);

// get the array of dish names from the database
$dish_names = array();
$res = $db->query('SELECT dish_id,dish_name FROM dishes');
while ($row = $res->fetchRow()) {
    $dish_names[ $row['dish_id'] ] = $row['dish_name'];
}

// The main page logic:
// - If the form is submitted, validate and then process or redisplay
// - If it's not submitted, display
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
    global $dish_names;

    // If the form is submitted, get defaults from submitted variables
    if ($_POST['_submit_check']) {
        $defaults = $_POST;
    } else {
        // Otherwise, no defaults
        $defaults = array();
    }
    
    // If errors were passed in, put them in $error_text (with HTML markup)
    if ($errors) {
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

<tr><td>Customer Name:</td>
<td><?php input_text('customer_name', $defaults) ?></td></tr>

<tr><td>Phone Number:</td>
<td><?php input_text('phone', $defaults) ?></td></tr>

<tr><td>Favorite Dish:</td>
<td><?php input_select('favorite_dish_id', $defaults, $dish_names); ?></td></tr>

<tr><td colspan="2" align="center"><?php input_submit('save','Add Customer'); ?>
</td></tr>

</table>
<input type="hidden" name="_submit_check" value="1"/>
</form>
<?php
      } // The end of process_form()

function validate_form() {
    global $dish_names;

    $errors = array();

    // customer_name is required
    if (! strlen(trim($_POST['customer_name']))) {
        $errors[] = 'Please enter the customer name.';
    }

    // phone number is required and must look right
    if (! strlen(trim($_POST['phone']))) {
        $errors[] = 'Please enter a phone number';
    } elseif (! preg_match('/^\(\d{3}\) ?\d{3}-\d{4}$/', $_POST['phone'])) {
        $errors[] = 'Please enter a phone number in the format (XXX) XXX-XXXX.';
    }

    // favorite dish is required
    if (! array_key_exists($_POST['favorite_dish_id'], $dish_names)) {
        $errors[] = 'Please select a favorite dish.';
    }

    return $errors;
}

function process_form() {
    // Access the global variable $db inside this function
    global $db;

    // Get a unique ID for this customer
    $customer_id = $db->nextID('customers');

    // Insert the new customer into the table
    $db->query('INSERT INTO customers (customer_id, customer_name, phone, favorite_dish_id) VALUES (?,?,?,?)',
               array($customer_id, $_POST['customer_name'], $_POST['phone'], $_POST['favorite_dish_id']));

    // Tell the user that we added a customer.
    print 'Added ' . htmlentities($_POST['customer_name']) . ' to the database.';
}
?>