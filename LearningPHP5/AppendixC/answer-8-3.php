Here is the color selection form page:

<?php
require 'formhelpers.php';

session_start();

$colors = array('#ff0000' => 'red',
                '#ff6600' => 'orange',
                '#ffff00' => 'yellow',
                '#0000ff' => 'green',
                '#00ff00' => 'blue',
                '#ff00ff' => 'purple');


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
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    if ($errors) {
        print '<ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    } 
    // Since we're not supplying any defaults of our own, it's OK
    // to pass $_POST as the defaults array to input_select and
    // input_text so that any user-entered values are preserved
    print 'Color: ';
    input_select('color', $_POST, $GLOBALS['colors']);
    print '<br/>';

    input_submit('submit','Select Color');

    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {
    $errors = array();

    // The dish selected in the menu must be valid
    if (! array_key_exists($_POST['color'], $GLOBALS['colors'])) {
        $errors[] = 'Please select a valid color.';
    }

    return $errors;
}

function process_form() {
    $_SESSION['color'] = $_POST['color'];
    print "Your favorite color is: " . $GLOBALS['colors'][ $_SESSION['color'] ];
}
?>

And here is the background-color-changing page:

<?php
session_start();

print <<<_HTML_
<html>
<body bgcolor="$_SESSION[color]">
This page has your personalized background color.
</body>
</html>
_HTML_;

?>