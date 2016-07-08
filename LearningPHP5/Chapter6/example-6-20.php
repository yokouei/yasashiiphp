if (! array_key_exists($_POST['order'], $GLOBALS['sweets'])) {
    $errors[] = 'Please choose a valid order.';
}