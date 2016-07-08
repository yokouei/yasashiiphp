<?php
  // Load the form element helper functions
require 'formhelpers.php';

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

    // the file name
    print' File name: ';
    input_text('filename', $_POST);
    print '<br/>';

    // the submit button
    input_submit('submit','Show File');

    // the hidden _submit_check variable
    print '<input type="hidden" name="_submit_check" value="1"/>';

    // the end of the form
    print '</form>';
}

function validate_form() {
    $errors = array();

    // filename is required
    if (! strlen(trim($_POST['filename']))) {
        $errors[] = 'Please enter a file name.';
    } else {
        // build the full file name from the web server document root
        // directory, a slash, and the submitted value
        $filename = $_SERVER['DOCUMENT_ROOT'] . '/' . $_POST['filename'];
        
        // Use realpath to resolve any .. sequences
        $filename = realpath($filename);
        
        // make sure $filename begins with the document root directory
        $docroot_len = strlen($_SERVER['DOCUMENT_ROOT']);
        if (substr($filename, 0, $docroot_len) != $_SERVER['DOCUMENT_ROOT']) {
            $errors[] = 'File name must be under the document root directory.';
        }
    }

    return $errors;
}

function process_form() {
    // reconstitute the full file name, as in validate_form()
    $filename = $_SERVER['DOCUMENT_ROOT'] . '/' . $_POST['filename'];
    $filename = realpath($filename);

    // print the contents of the file
    print file_get_contents($filename);
}
?>