$_POST['name'] = trim($_POST['name']);

if (strlen($_POST['name']) == 0) {
    $errors[] = "Your name is required.";
}