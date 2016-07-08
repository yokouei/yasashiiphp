if (! preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', 
                 $_POST['email'])) {
    $errors[] = 'Please enter a valid e-mail address';
}