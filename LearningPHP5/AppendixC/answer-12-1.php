The error message looks like:

Parse error: parse error, unexpected T_GLOBAL in exercise-12-1.php on line 6

The global declaration has to be on a line by itself, not inside the print statement. To fix the program, separate the two:

<?php
$name = 'Umberto';

function say_hello() {
    global $name;
    print 'Hello, ';
    print $name;
}

say_hello();
?>