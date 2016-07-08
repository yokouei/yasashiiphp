if (! preg_match('/^[a-z0-9]$/i', $_POST['username'])) {
    $errors[] = "Usernames must contain only letters or numbers.";
}