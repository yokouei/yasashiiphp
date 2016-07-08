require 'DB.php';
$db = DB::connect('mysql://hunter:w)mp3s@db.example.com/restaurant');

// Change the fetch mode to string-keyed arrays
$db->setFetchMode(DB_FETCHMODE_ASSOC);

print "<dishes>\n";
$q = $db->query("SELECT dish_id, dish_name, price FROM dishes WHERE is_spicy = 1");
while($row = $q->fetchRow()) {
    print ' <dish id="' . htmlentities($row['dish_id']) .'">' . "\n";
    print '  <name>' . htmlentities($row['dish_name'])."</name>\n";
    print '  <price>' . htmlentities($row['price'])."</price>\n";
    print " </dish>\n";
}
print '</dishes>';