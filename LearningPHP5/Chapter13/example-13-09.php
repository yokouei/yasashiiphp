<?php
// Load the QuickForm library
require 'HTML/QuickForm.php';
// Create the form object
$form = new HTML_QuickForm();

// Define the same arrays of valid sweets and main dishes
$sweets = array('puff' => 'Sesame Seed Puff',
                'square' => 'Coconut Milk Gelatin Square',
                'cake' => 'Brown Sugar Cake',
                'ricemeat' => 'Sweet Rice and Meat');

$main_dishes = array('cuke' => 'Braised Sea Cucumber',
                     'stomach' => "Sauteed Pig's Stomach",
                     'tripe' => 'Sauteed Tripe with Wine Sauce',
                     'taro' => 'Stewed Pork with Taro',
                     'giblets' => 'Baked Giblets with Salt', 
                     'abalone' => 'Abalone with Marrow and Duck Feet');

// Set the default values for form elements
$form->setDefaults(array('delivery' => 'yes',
                         'size'     => 'medium'));

// Add each element to the form
$form->addElement('text','name','Your Name: ');
$form->addElement('radio','size','Size:','Small', 'small');
$form->addElement('radio','size','',     'Medium', 'medium');
$form->addElement('radio','size','',     'Large', 'large');

$form->addElement('select','sweet','Pick one sweet item:', $sweets);
$form->addElement('select','main_dish','Pick two main dishes:',
                  $main_dishes, 'multiple="multiple"');

$form->addElement('radio','delivery','Do you want your order delivered?',
                  'Yes','yes');

$form->addElement('textarea','comments','Enter any special instructions. <br/>
                  If you want your order delivered, put your address here:');

$form->addElement('submit','save','Order');

// Create two custom validation rules (implemented by the functions
// add the end of the script) 
$form->registerRule('check_array','function','check_array');
$form->registerRule('check_array_size','function','check_array_size');

// The name field is required
$form->addRule('name','Please enter your name.','required');
// The size field is required and its value must be
// one of "small", "medium", or "large"
$form->addRule('size','Please select a size.','required');
$form->addRule('size','Please select a size.','check_array',
               array('small' => 1, 'medium' => 1, 'large' => 1));

// The sweet field is required and its value must be in the
// $sweets array
$form->addRule('sweet','Please select a valid sweet item.','required');
$form->addRule('sweet','Please select a valid sweet item.', 'check_array',
               $sweets);

// The main_dish field is required, it must have exactly two values
// and those values must be in the $main_dishes array
$form->addRule('main_dish','Please select exactly two main dishes.',
               'required');
$form->addRule('main_dish','Please select exactly two main dishes.',
               'check_array_size', 2);
$form->addRule('main_dish','Please select exactly two main dishes.',
               'check_array', $main_dishes);

// The main logic of the page: if the submitted form parameters are
// valid, then process them by running the save_order() function.
// Otherwise, display the form.
if ($form->validate()) {
    $form->process('save_order');
} else {
    $form->display();
}

// The function to do the form processing. It is identical to process_form()
// in Chapter 6 except that it accesses the submitted form parameters through
// $form_data instead of $_POST
function save_order($form_data) {
    // look up the full names of the sweet and the main dishes in
    // the $GLOBALS['sweets'] and $GLOBALS['main_dishes'] arrays
    $sweet = $GLOBALS['sweets'][ $form_data['sweet'] ];
    $main_dish_1 = $GLOBALS['main_dishes'][ $form_data['main_dish'][0] ];
    $main_dish_2 = $GLOBALS['main_dishes'][ $form_data['main_dish'][1] ];
    if ($form_data['delivery'] == 'yes') {
        $delivery = 'do';
    } else {
        $delivery = 'do not';
    }
    // build up the text of the order message
    $message=<<<_ORDER_
Thank you for your order, $form_data[name].
You requested the $form_data[size] size of $sweet, $main_dish_1, and $main_dish_2.
You $delivery want delivery.
_ORDER_;
    if (strlen(trim($form_data['comments']))) {
        $message .= 'Your comments: '.$form_data['comments'];
    }

    // send the message to the chef
    mail('chef@restaurant.example.com', 'New Order', $message);
    // print the message, but encode any HTML entities
    // and turn newlines into <br/> tags
    print nl2br(htmlentities($message));
}

// A validation helper function to check that $param_value is
// a key in $array (or that each value in $param_value is a 
// key in $array if $param_value is an array
function check_array($param_name, $param_value, $array) { 
    if (is_array($param_value)) {
        foreach ($param_value as $submitted_value) {
            if (! array_key_exists($submitted_value, $array)) {
                return false;
            }
        }
        return true;
    } else {
        return array_key_exists($param_value, $array);
    }
}

function check_array_size($param_name, $param_value, $size) { 
    return count($param_value) == $size;
}
?>