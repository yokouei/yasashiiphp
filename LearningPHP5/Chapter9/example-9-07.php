$now = time();
$later = strtotime('Thursday',$now);
$before = strtotime('last thursday',$now);
print strftime("now: %c \n", $now);
print strftime("later: %c \n", $later);
print strftime("before: %c \n", $before);