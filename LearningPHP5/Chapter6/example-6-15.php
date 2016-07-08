if ($_POST['age'] != strval(intval($_POST['age']))) {
    $errors[] = "Your age must be a number.";
} elseif (($_POST['age'] < 18) || ($_POST['age'] > 65)) {
    $errors[] = "Your age must be at least 18 and no more than 65.";
}