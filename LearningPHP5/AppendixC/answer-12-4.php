Here are the errors in the program:


Line 6: Two colons are needed between DB and connect.

Lines 12 and 13: The fetch mode should be set to DB_FETCHMODE_ASSOC since rows are treated as arrays in the rest of the program. (Alternatively, you could change lines 19 and 31 - 34 so that they treat rows as objects.)

Line 19: There is an extra closing square bracket after $row['dish_id'].

Line 22: This should be a call to $db-&gt;query(), not $db-&gt;getAll(), because fetchRow() is used in line 29 to retrieve each row. The SQL query is also wrong: it should be SELECT * FROM customers ORDER BY customer_name (only one asterisk after SELECT and customer_name, not phone DESC, after ORDER BY).

Line 24: The method name that returns the number of rows retrieved by query() is numRows(), not num_rows().

Line 28: The string has mismatched delimiters. Either change the opening quote to a double quote or the closing quote to a single quote.

Line 32: The array key is misspelled. It should be customer_name, not cutsomer_name.

Line 34: $customer['favorite_dish_id'] is the integer ID of the favorite dish. To display the dish name, you need to look up the appropriate element in $dish_names. Instead of $customer['favorite_dish_id'], it should be $dish_names[ $customer['favorite_dish_id'] ].

Line 37: The curly brace to end the else code block is missing.


Here is the complete corrected program:

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

$customers = $db->query('SELECT * FROM customers ORDER BY customer_name');

if ($customers->numRows() == 0) {
    print "No customers.";
} else {
    print '<table>';
    print '<tr><th>ID</th><th>Name</th><th>Phone</th><th>Favorite Dish</th></tr>';
    while ($customer = $customers->fetchRow()) {
        printf('<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>',
               $customer['customer_id'],
               htmlentities($customer['customer_name']),
               $customer['phone'],
               $dish_names [ $customer['favorite_dish_id'] ]);
    }
    print '</table>';
}

?>