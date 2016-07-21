<?php

//print a text box
function input_text($element_name, $values) {

    print "\n".'<input type="text" name="' . $element_name .'" value="';
    if (array_key_exists($element_name, $values)) {
        print htmlentities($values[$element_name]);
    }
    print '">'."\n";
}

//print a submit button
function input_submit($element_name, $label) {
    print "\n".'<input type="submit" name="' . $element_name .'" value="';
    print htmlentities($label) .'"/>'."\n";
}

//print a textarea
function input_textarea($element_name, $values) {
    print "\n".'<textarea name="' . $element_name .'">';
    if (array_key_exists($element_name, $values)) {
        print htmlentities($values[$element_name]);
    }
    print '</textarea>'."\n";
}

//print a radio button or checkbox
function input_radiocheck($type, $element_name, $values, $element_value) {
    print "\n".'<input type="' . $type . '" name="' . $element_name .'" value="' . $element_value . '" ';
    if ($element_value == $values[$element_name]) {
        print ' checked="checked"';
    }
    print '/>'."\n";
}

//print a <select> menu
function input_select($element_name, $selected, $options, $multiple = false) {
    // print out the <select> tag
    print "\n".'<select name="' . $element_name;
    // if multiple choices are permitted, add the multiple attribute
    // and add a [] to the end of the tag name
    if ($multiple) { print '[]" multiple="multiple'; }
    print '">'."\n";

    // set up the list of things to be selected
    $selected_options = array();
    if (array_key_exists($element_name, $selected)) {
        if ($multiple) {
            foreach ($selected[$element_name] as $val) {
                $selected_options[$val] = true;
            }
        } else {
            $selected_options[$selected[$element_name]] = true;
        }
    }

    // print out the <option> tags
    foreach ($options as $option => $label) {
        print "\t".'<option value="' . htmlentities($option) . '"';
        if (array_key_exists($option, $selected_options) && $selected_options[$option]) {
            print ' selected="selected"';
        }
        print '>' . htmlentities($label) . '</option>'."\n";
    }
    print '</select>'."\n";
}

?>