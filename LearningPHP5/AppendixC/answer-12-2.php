function validate_form() {
    $errors = array();

    // Capture the output of var_dump() with output buffering
    ob_start();
    var_dump($_POST);
    $vars = ob_get_contents();
    ob_end_clean();
    // Send the output to the error log
    error_log($vars);

    // operand 1 must be numeric
    if (! strlen($_POST['operand_1'])) {
        $errors[] = 'Enter a number for the first operand.';
    } elseif (! floatval($_POST['operand_1']) == $_POST['operand_1']) {
        $errors[] = "The first operand must be numeric.";
    }
    // operand 2 must be numeric
    if (! strlen($_POST['operand_2'])) {
        $errors[] = 'Enter a number for the second operand.';
    } elseif (! floatval($_POST['operand_2']) == $_POST['operand_2']) {
        $errors[] = "The second operand must be numeric.";
    }
    // the operator must be valid
    if (! in_array($_POST['operator'], $GLOBALS['ops'])) {
        $errors[] = "Please select a valid operator.";
    }

    return $errors;
}