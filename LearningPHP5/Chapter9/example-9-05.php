<?php
print 'strftime() says: ';
print strftime('Today is %m/%d/%y and the time is %I:%M:%S');
print "\n<br/>\n";
print 'date() says: ';
print 'Today is ' . date('m/d/y') . ' and the time is ' . date('h:i:s');
?>