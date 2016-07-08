$window =& new GtkWindow();

$button =& new GTKButton('I am a button, please click me.');
$window->add($button);

$window->show_all();

function shutdown() { gtk::main_quit(); }
$window->connect('destroy','shutdown');

gtk::main();