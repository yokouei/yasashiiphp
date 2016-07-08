if ($_POST['price'] != strval(floatval($_POST['price']))) {
    $errors[] = 'Please enter a valid price.';
}