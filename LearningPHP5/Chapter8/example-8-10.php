<?php
require 'formhelpers.php';

session_start();

$main_dishes = array('cuke' => 'Braised Sea Cucumber',
                     'stomach' => "Sauteed Pig's Stomach",
                     'tripe' => 'Sauteed Tripe with Wine Sauce',
                     'taro' => 'Stewed Pork with Taro',
                     'giblets' => 'Baked Giblets with Salt', 
                     'abalone' => 'Abalone with Marrow and Duck Feet');

//if ($_POST['_submit_check']) {
if (array_key_exists('_submit_check', $_POST)) {
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        process_form();
    } 
} else {
    show_form();
}

function show_form($errors = '') {
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    if ($errors) {
        print '<ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    } 
    // Since we're not supplying any defaults of our own, it's OK
    // to pass $_POST as the defaults array to input_select and
    // input_text so that any user-entered values are preserved
    print 'Dish: ';
    input_select('dish', $_POST, $GLOBALS['main_dishes']);
    print '<br/>';

    print 'Quantity: ';
    input_text('quantity', $_POST);
    print '<br/>';

    input_submit('submit','Order');

    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {
    $errors = array();

    // The dish selected in the menu must be valid
    if (! array_key_exists($_POST['dish'], $GLOBALS['main_dishes'])) {
        $errors[] = 'Please select a valid dish.';
    }

    if ((! is_numeric($_POST['quantity'])) || (intval($_POST['quantity']) <= 0)) {
        $errors[] = 'Please enter a quantity.';
    }

    return $errors;
}

function process_form() {
    $_SESSION['order'][] = array('dish'     => $_POST['dish'],
                                 'quantity' => $_POST['quantity']);

    print 'Thank you for your order.';
} ?>