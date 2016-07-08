Change the beginning of the program to:

<?php

require 'DB.php';
require 'formhelpers.php';

// Connect to the database
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');
if (DB::isError($db)) { die ("Can't connect: " . $db->getMessage()); }

function db_error_handler($error) {
    error_log('DATABASE ERROR: ' . $error->getDebugInfo());
    die('There is a ' . $error->getMessage());
}

// Set up automatic error handling
$db->setErrorHandling(PEAR_ERROR_CALLBACK,'db_error_handler');