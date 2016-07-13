<?php

// Logic to do the right thing based on
// the submitted form parameters
if (array_key_exists('my_name', $_POST)) {
    process_form();
} else {
    show_form();
}

// Do something when the form is submitted
function process_form()
{
    print "Hello, " . $_POST['my_name'];
}

// Display the form
function show_form()
{
    print<<<_HTML_

    <form method = "POST" action = "$_SERVER[PHP_SELF]" >
        Your name: <input type = "text" name = "my_name" >
        <br />
        <input type = "submit" value = "Say Hello" >
    </form >
    
_HTML_;
}

?>