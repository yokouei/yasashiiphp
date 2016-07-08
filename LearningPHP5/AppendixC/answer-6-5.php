The print_array() function iterates through
the array it is passed, printing out each key and value. If one of
those values is an array, then print_array() calls
itself, passing in the sub-array to be printed. A function like
print_array() that invokes itself is called a
recursive function. The
process_form() function calls
print_array() and tells it to print the contents of
$_POST.

function print_array($ar, $prefix) {
    // iterate through the array
    foreach ($ar as $key => $value) {
        // if the value of this element is an array, then 
        // call print_array() again to iterate over that sub-array
        // and tack the key name onto the prefix
        if (is_array($value)) {
            print_array($value, $prefix . "['" . $key . "']");
        } else {
            // if the value is not an array, then print it out
            // with any prefix
            print $prefix;
            print "['" . htmlentities($key) . "'] = ";
            print htmlentities($value) . '<br/>';
        }
    }
}

function process_form() {
    print_array($_POST, '$_POST');
}