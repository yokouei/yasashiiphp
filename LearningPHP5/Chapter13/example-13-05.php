<?php

$browser = get_browser();

print "<pre>";
var_dump($browser);
print "</pre>";

if ($browser->platform == 'WinXP') {
    print 'You are using Windows XP.';
} elseif ($browser->platform == 'MacOSX') {
    print 'You are using Mac OS X.';
} else {
    print 'You are using a different operating system.';
}

?>