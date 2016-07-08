$stamp = mktime(19,45,0,10,20,2004);
print strftime('Today is day %d of %B and day %j of the year %Y. The time is %I:%M %p (also known as %H:%M).', $stamp);