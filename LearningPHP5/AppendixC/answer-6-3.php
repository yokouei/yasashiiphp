<?php
$ops = array('+','-','*','/');

if ($_POST['_submit_check']) {
    // If validate_form() returns errors, pass them to show_form()
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        // The submitted data is valid, so process it
        process_form();
    }
} else {
    // The form wasn't submitted, so display
    show_form();
}

function show_form($errors = '') {
    if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    }

    // the beginning of the form
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    // the first operand
    print '<input type="text" name="operand_1" size="5" value="';
    print htmlspecialchars($_POST['operand_1']) .'"/>';

    // the operator
    print '<select name="operator">';
    foreach ($GLOBALS['ops'] as $op) {
        print '<option';
        if ($_POST['operator'] == $op) { print ' selected="selected"'; }
        print "> $op</option>";
    }
    print '</select>';

    // the second operand
    print '<input type="text" name="operand_2" size="5" value="';
    print htmlspecialchars($_POST['operand_2']) .'"/>';

    // the submit button
    print '<br/><input type="submit" value="Calculate"/>';

    // the hidden _submit_check variable
    print '<input type="hidden" name="_submit_check" value="1"/>';

    // the end of the form
    print '</form>';
}

function validate_form() {
    $errors = array();

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

function process_form() {
    if ('+' == $_POST['operator']) {
        $total = $_POST['operand_1'] + $_POST['operand_2'];
    } elseif ('-' == $_POST['operator']) {
        $total = $_POST['operand_1'] - $_POST['operand_2'];
    } elseif ('*' == $_POST['operator']) {
        $total = $_POST['operand_1'] * $_POST['operand_2'];
    } elseif ('/' == $_POST['operator']) {
        $total = $_POST['operand_1'] / $_POST['operand_2'];
    }
    print "$_POST[operand_1] $_POST[operator] $_POST[operand_2] = $total";
}
?>