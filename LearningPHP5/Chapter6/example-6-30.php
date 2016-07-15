<?php


// setup the arrays of choices in the select menus
// these are needed in display_form(), validate_form(),
// and process_form(), so they are declared in the global scope
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

require_once(dirname(__FILE__) . "/example-6-29.php");

// The main page logic:
// - If the form is submitted, validate and then process or redisplay
// - If it's not submitted, display
//if ($_POST['_submit_check']) {
if (array_key_exists('_submit_check', $_POST)) {
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

function show_form($errors = '')
{
    // If the form is submitted, get defaults from submitted parameters
    //if ($_POST['_submit_check']) {
    if (array_key_exists('_submit_check', $_POST)) {
        $defaults = $_POST;
    } else {
        // Otherwise, set our own defaults: medium size and yes to delivery
        $defaults = array('delivery' => 'yes',
            'size' => 'medium');
    }

    // If errors were passed in, put them in $error_text (with HTML markup)
    if ($errors) {
        $error_text = '<tr><td>You need to correct the following errors:';
        $error_text .= '</td><td><ul><li>';
        $error_text .= implode('</li><li>', $errors);
        $error_text .= '</li></ul></td></tr>';
    } else {
        // No errors? Then $error_text is blank
        $error_text = '';
    }

    // Jump out of PHP mode to make displaying all the HTML tags easier
    ?>
    <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
        <table>
            <?php print $error_text ?>

            <tr>
                <td>Your Name:</td>
                <td><?php input_text('name', $defaults) ?></td>
            </tr>

            <tr>
                <td>Size:</td>
                <td><?php input_radiocheck('radio', 'size', $defaults, 'small'); ?> Small <br/>
                    <?php input_radiocheck('radio', 'size', $defaults, 'medium'); ?> Medium <br/>
                    <?php input_radiocheck('radio', 'size', $defaults, 'large'); ?> Large
                </td>
            </tr>

            <tr>
                <td>Pick one sweet item:</td>
                <td><?php input_select('sweet', $defaults, $GLOBALS['sweets']); ?>
                </td>
            </tr>

            <tr>
                <td>Pick two main dishes:</td>
                <td>
                    <?php input_select('main_dish', $defaults, $GLOBALS['main_dishes'], true) ?>
                </td>
            </tr>

            <tr>
                <td>Do you want your order delivered?</td>
                <td><?php input_radiocheck('checkbox', 'delivery', $defaults, 'yes'); ?> Yes
                </td>
            </tr>

            <tr>
                <td>Enter any special instructions.<br/>
                    If you want your order delivered, put your address here:
                </td>
                <td><?php input_textarea('comments', $defaults); ?></td>
            </tr>

            <tr>
                <td colspan="2" align="center"><?php input_submit('save', 'Order'); ?>
                </td>
            </tr>

        </table>
        <input type="hidden" name="_submit_check" value="1"/>
    </form>
    <?php
} // The end of show_form()

function validate_form()
{
    $errors = array();

    // name is required
    if (!strlen(trim($_POST['name']))) {
        $errors[] = 'Please enter your name.';
    }
    // size is required
    if (($_POST['size'] != 'small') && ($_POST['size'] != 'medium') &&
        ($_POST['size'] != 'large')
    ) {
        $errors[] = 'Please select a size.';
    }
    // sweet is required
    if (!array_key_exists($_POST['sweet'], $GLOBALS['sweets'])) {
        $errors[] = 'Please select a valid sweet item-old.';
    }
    // exactly two main dishes required
    if (count($_POST['main_dish']) != 2) {
        $errors[] = 'Please select exactly two main dishes.';
    } else {
        // We know there are two main dishes selected, so make sure they are 
        // both valid
        if (!(array_key_exists($_POST['main_dish'][0], $GLOBALS['main_dishes']) &&
            array_key_exists($_POST['main_dish'][1], $GLOBALS['main_dishes']))
        ) {
            $errors[] = 'Please select exactly two valid main dishes.';
        }
    }
    // if delivery is checked, then comments must contain something
    if (($_POST['delivery'] == 'yes') && (!strlen(trim($_POST['comments'])))) {
        $errors[] = 'Please enter your address for delivery.';
    }

    return $errors;
}

function process_form()
{
    // look up the full names of the sweet and the main dishes in
    // the $GLOBALS['sweets'] and $GLOBALS['main_dishes'] arrays
    $sweet = $GLOBALS['sweets'][$_POST['sweet']];
    $main_dish_1 = $GLOBALS['main_dishes'][$_POST['main_dish'][0]];
    $main_dish_2 = $GLOBALS['main_dishes'][$_POST['main_dish'][1]];
    if ($_POST['delivery'] == 'yes') {
        $delivery = 'do';
    } else {
        $delivery = 'do not';
    }
    // build up the text of the order message
    $message = <<<_ORDER_
Thank you for your order, $_POST[name].
You requested the $_POST[size] size of $sweet, $main_dish_1, and $main_dish_2.
You $delivery want delivery.
_ORDER_;
    if (strlen(trim($_POST['comments']))) {
        $message .= 'Your comments: ' . $_POST['comments'];
    }

    // send the message to the chef
    // XAMPPのローカル環境からメールを送信できるように設定する方法【初心者向け】
    // http://techacademy.jp/magazine/4129

    //
    if(!mail('hellodianzhu@gmail.com', 'New Order', $message))
    {
        print "fail to send mails";
    }

    /*
    //言語設定、内部エンコーディングを指定する
    mb_language("japanese");
    mb_internal_encoding("EUC-JP");

    //日本語メール送信
    $to = "hellodianzhu@gmail.com";
    $subject = "例の件について";
    $body = "どうでしょう？";
    $from = mb_encode_mimeheader(mb_convert_encoding("余　江英","JIS","EUC-JP"))."<yokouei@gmail.com>";
    */
    //$headers = 'From:".$from . "\r\n";
   // $headers .= 'Cc: qwer@hoge.co.jp' . "\r\n";

    //ちゃんと日本語メールが送信できます
    //mb_send_mail($to,$subject,$body,"From:".$from);


    // print the message, but encode any HTML entities
    // and turn newlines into <br/> tags
    print nl2br(htmlentities($message));
}

?>