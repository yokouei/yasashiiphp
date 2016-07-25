<?php

if (array_key_exists('_stage', $_POST) && $_POST['_stage']) {
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

    print<<<_HTML_
<form enctype="multipart/form-data" method="POST"
      action="$_SERVER[PHP_SELF]">

File to Upload: <input name="my_file" type="file"/>

<input type="hidden" name="MAX_FILE_SIZE" value="131072"/>
<input type="hidden" name="_stage" value="1">
<input type="submit" value="Upload"/>
</form>
_HTML_;
}

function validate_form() {
    $errors = array();

    if (($_FILES['my_file']['error'] == UPLOAD_ERR_INI_SIZE)||
        ($_FILES['my_file']['error'] == UPLOAD_ERR_FORM_SIZE)) {
        $errors[] = 'Uploaded file is too big.';
    } elseif ($_FILES['my_file']['error'] == UPLOAD_ERR_PARTIAL) {
        $errors[] = 'File upload was interrupted.';
    } elseif ($_FILES['my_file']['error'] == UPLOAD_ERR_NO_FILE) {
        $errors[] = 'No file uploaded.';
    }
    
    return $errors;
}

function process_form() {
    print "You uploaded a file called {$_FILES['my_file']['name']} ";
    print "of type {$_FILES['my_file']['type']} that is ";
    print "{$_FILES['my_file']['size']} bytes long.";

    $safe_filename = str_replace('/', '', $_FILES['my_file']['name']);
    $safe_filename = str_replace('..', '', $safe_filename);

    //$destination_file = '/usr/local/uploads/' . $safe_filename;
    $destination_file = $safe_filename;
    if (move_uploaded_file($_FILES['my_file']['tmp_name'], $destination_file)) {
        print "Successfully saved file as $destination_file.";
    } else {
        print "Couldn't save file in /usr/local/uploads.";
    }
}

?>