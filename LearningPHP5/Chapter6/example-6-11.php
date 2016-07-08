if ($_POST['age'] != strval(intval($_POST['age'])) {
    $errors[] = 'Please enter a valid age.';
}