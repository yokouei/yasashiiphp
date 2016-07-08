The order form page:
<?php
session_start();

require 'formhelpers.php';

$products = array('cuke'    => 'Braised Sea Cucumber',
                  'stomach' => "Sauteed Pig's Stomach",
                  'tripe'   => 'Sauteed Tripe with Wine Sauce',
                  'taro'    => 'Stewed Pork with Taro',
                  'giblets' => 'Baked Giblets with Salt', 
                  'abalone' => 'Abalone with Marrow and Duck Feet');

if ($_POST['_submit_check']) {
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        process_form();
    } 
} else {
    show_form();
}

function show_form($errors = '') {
    global $products;
    
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    if ($errors) {
        print '<ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    } 
    // Build up an array of defaults if there is an order saved
    // in the session
    if ($_SESSION['saved_order']) {
        $defaults = array();
        foreach ($products as $product => $description) {
            $defaults["dish_$product"] = $_SESSION["dish_$product"];
        }
    } else {
        $defaults = $_POST;
    }
    foreach ($products as $product => $description) {
        input_text("dish_$product", $defaults);
        print " $description<br/>";
    }
    
    input_submit('submit','Order');
    
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {
    global $products;
    $errors = array();

    foreach ($products as $product => $description) {
        // If something was entered in the text box
        if (strlen($_POST["dish_$product"]) &&
            // And it's not a valid integer
            (($_POST["dish_$product"] != strval(intval($_POST["dish_$product"]))) ||
             // Or it's less than zero
             intval($_POST["dish_$product"]) < 0)) {
            // Then it's an error
            $errors[] = "Please enter a valid quantity for $description.";
        }
    }

    return $errors;
}

function process_form() {
    global $products;
    $_SESSION['saved_order'] = 1;
    
    foreach ($products as $product => $description) {
        if (strlen($_POST["dish_$product"])) {
            $_SESSION["dish_$product"] = $_POST["dish_$product"];
        }
    }
    print 'Thank you for your order.';
}
?>

The check out page:

<?php
session_start();

require 'formhelpers.php';

$products = array('cuke'    => 'Braised Sea Cucumber',
                  'stomach' => "Sauteed Pig's Stomach",
                  'tripe'   => 'Sauteed Tripe with Wine Sauce',
                  'taro'    => 'Stewed Pork with Taro',
                  'giblets' => 'Baked Giblets with Salt', 
                  'abalone' => 'Abalone with Marrow and Duck Feet');

// Since the form just consists of one button, there's no need
// to validate the submitted form data
if ($_POST['_submit_check']) {
    process_form();
} else {
    show_form();
}

function show_form($errors = '') {
    global $products;

    if ($_SESSION['saved_order']) {
        print 'Your order: <ul>';
        foreach ($products as $product => $description) {
            if (array_key_exists("dish_$product", $_SESSION)) {
                print '<li> '.$_SESSION["dish_$product"]." $description </li>";
            }
        }
        print '</ul>';
    } else {
        print 'There is no saved order.';
    }
    print '<br/>';
    // This assumes that the order form page is saved as "orderform.php"
    print '<a href="orderform.php">Return to Order Page</a>';
    print '<br/>';
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    input_submit('submit','Check Out');
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function process_form() {
    global $products;
    unset($_SESSION['saved_order']);
    
    foreach ($products as $product => $description) {
        unset($_SESSION["dish_$product"]);
    }
    print 'Your order has been cleared.';
}

?>