A sample addresses.txt:

brilling@tweedledee.example.com
slithy@unicorn.example.com
uffish@knight.example.net
slithy@unicorn.example.com
jubjub@sheep.example.com
tumtum@queen.example.org
slithy@unicorn.example.com
uffish@knight.example.net
manxome@king.example.net
beamish@lion.example.org
uffish@knight.example.net
frumious@tweedledum.example.com
tulgey@carpenter.example.com
vorpal@crow.example.org
beamish@lion.example.org
mimsy@walrus.example.com
frumious@tweedledum.example.com
raths@owl.example.net
frumious@tweedledum.example.com

The program to count the addresses:

<?php

$in_fh = fopen('addresses.txt','rb');
if (! $in_fh) {
    die("Can't open addresses.txt: $php_errormsg");
}

// We'll count addresses with this array
$addresses = array();

for ($line = fgets($in_fh); ! feof($in_fh); $line = fgets($in_fh)) {
    if ($line === false) {
        die("Error reading line: $php_errormsg");
    } else {
        $line = trim($line);
        // Use the address as the key in $addresses
        // the value is the number of times that the
        // address has appeared
        $addresses[$line] = $addresses[$line] + 1;
    }
}

if (! fclose($in_fh)) {
    die("Can't close addresses.txt: $php_errormsg");
}

$out_fh = fopen('addresses-count.txt','wb');
if (! $out_fh) {
    die("Can't open addresses-count.txt: $php_errormsg");
}

// Reverse sort $addresses by element value
arsort($addresses);

foreach ($addresses as $address => $count) {
    // Don't forget the newline!
    if (fwrite($out_fh, "$count,$address\n") === false) {
        die("Can't write $count,$address: $php_errormsg");
    }
}

if (! fclose($out_fh)) {
    die("Can't close addresses-count.txt: $php_errormsg");
}
?>