<?php

$now = time();
$later = strtotime('Thursday',$now);
$before = strtotime('last thursday',$now);
print strftime("now: %c \n<br/>\n", $now);
print strftime("later: %c \n<br/>\n", $later);
print strftime("before: %c \n<br/>\n", $before);

?>