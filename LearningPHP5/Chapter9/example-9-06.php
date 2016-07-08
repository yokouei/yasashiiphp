// get the values from a form
$user_date = mktime($_POST['hour'], $_POST['minute'], 0, $_POST['month'], $_POST['day'], $_POST['year']);

// 1:30 pm (and 45 seconds) on October 20, 1982
$afternoon = mktime(13,30,45,10,20,1982);

print strftime('At %I:%M:%S on %m/%d/%y, ', $afternoon);
print "$afternoon seconds have elapsed since 1/1/1970.";