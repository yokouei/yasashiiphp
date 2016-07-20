<?php

session_start();

//if ($_POST['_submit_check']) {
if (array_key_exists('count', $_SESSION)) {
    $_SESSION['count'] = $_SESSION['count'] + 1;
} else {
    // Otherwise, set our own defaults
    $_SESSION['count'] = 1;
}

print "You've looked at this page " . $_SESSION['count'] . ' times.';

?>