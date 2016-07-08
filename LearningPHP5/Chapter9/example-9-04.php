print 'strftime says(): ';
print strftime('%I:%M:%S', time() + 60*60);
print "\n";
print 'date() says: ';
print date('h:i:s', time() + 60*60);