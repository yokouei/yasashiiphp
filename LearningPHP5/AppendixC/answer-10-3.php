<?php
$fh = fopen('csvdata.csv', 'rb');
if (! $fh) {
    die("Can't open csvdata.csv: $php_errormsg");
}

print "<table>\n";
       
for ($line = fgetcsv($fh, 1024); ! feof($fh); $line = fgetcsv($fh, 1024)) {
    // Use implode as in Example 4.21
    print '<tr><td>' . implode('</td><td>', $line) . "</td></tr>\n";
}

print '</table>';
?>