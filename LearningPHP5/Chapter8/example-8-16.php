function validate_form() {
    $errors = array();

    // Sample users with encrypted passwords
    $users = array('alice'   => '$1$LdB0G7jx$zVu.6YDfT2M3PcIq3xUdD0',
                   'bob'     => '$1$YY/mMevB$6KEH9LLrjZnuemGml9GRE/',
                   'charlie' => '$1$q.hxaUR9$Pu/NxLQeyMgF7lmCJ3FBo/');
 
     // Make sure user name is valid
    if (! array_key_exists($_POST['username'], $users)) {
        $errors[] = 'Please enter a valid username and password.';
    }
                                   
    // See if password is correct
    $saved_password = $users[ $_POST['username'] ];
    if ($saved_password != crypt($_POST['password'], $saved_password)) {
        $errors[] = 'Please enter a valid username and password.';
    }

    return $errors;
}