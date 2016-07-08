The new validate_form() function that implements the addtional rule:

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
        } elseif (strcasecmp(substr($filename, -5), '.html') != 0) {
            $errors[] = 'File name must end in .html';
        }
    }

    return $errors;
}