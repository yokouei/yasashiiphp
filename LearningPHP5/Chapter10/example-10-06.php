<?php

$fh = fopen('example-10-07.php','rb');
for ($line = fgets($fh); ! feof($fh); $line = fgets($fh)) {
    $line = trim($line);
    $info = explode('|', $line);
    print '<li><a href="mailto:' . $info[0] . '">' . $info[1] ."</li>\n";
}
fclose($fh);

?>