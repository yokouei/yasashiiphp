$stamp = mktime(19,45,0,10,20,2004);
print 'Today is day '.date('d',$stamp).' of '.date('F',$stamp).' and day '.(date('z',$stamp)+1);
print ' of the year '.date('Y',$stamp).'. The time is '.date('h:i A',$stamp);
print ' (also known as '.date('H:i',$stamp).').';