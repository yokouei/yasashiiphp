function process_form() {
    print "<ul>";
    foreach ($_POST as $element => $value) {
        print "<li> \$_POST[$element] = $value</li>";
    }
    print "</ul>";
}