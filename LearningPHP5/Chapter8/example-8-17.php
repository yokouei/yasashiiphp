function validate_form() {
    global $db;

    $errors = array();

    $encrypted_password = $db->getOne('SELECT password FROM users WHERE username = ?',
                                      array($_POST['username']));
   
    if ($encrypted_password != crypt($_POST['password'], $encrypted_password)) {
        $errors[] = 'Please enter a valid username and password.';
    }

    return $errors;
}