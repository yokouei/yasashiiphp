require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');

// Open dishes.txt for writing
$fh = fopen('/usr/local/dishes.txt','wb');
if (! $fh) {
    print "Error opening dishes.txt: $php_errormsg";
} else {
    $q = $db->query("SELECT dish_name, price FROM dishes");
    while($row = $q->fetchRow()) {
        // Write each line (with a newline on the end) to
        // dishes.txt
        fwrite($fh, "The price of $row[0] is $row[1] \n");
    }
    if (! fclose($fh)) {
        print "Error closing dishes.txt: $php_errormsg";
    }
}