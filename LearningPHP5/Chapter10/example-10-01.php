<?php

// Load the file from Example 10.2
$page = file_get_contents('example-10-02.php');

// Insert the title of the page
$page = str_replace('{page_title}', 'Welcome', $page);

// Make the page blue in the afternoon and
// green in the morning
if (date('H' >= 12)) {
    $page = str_replace('{color}', 'blue', $page);
} else {
    $page = str_replace('{color}', 'green', $page);
}

// Take the username from a previously saved session
// variable
if (is_array($_SESSION) && array_key_exists('username', $_SESSION)) {
    $page = str_replace('{name}', $_SESSION['username'], $page);
}

// Print the results
print $page;

?>