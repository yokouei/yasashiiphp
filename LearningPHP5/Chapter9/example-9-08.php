<?php

// Find the epoch timestamp for November 1, 2008
$november = mktime(0,0,0,11,1,2008);
// Find the First monday on or after November 1, 2008
$monday = strtotime('Monday', $november);
// Skip ahead one day to the Tuesday after the first Monday
$election_day = strtotime('+1 day', $monday);

print strftime('Election day is %A, %B %d, %Y', $election_day);

print "\n<br/>\n";

$election_day = strtotime('Tuesday', $november);

print strftime('Election day is %A, %B %d, %Y', $election_day);


?>