// Grab the first thirty characters of $_POST['comments']
print substr($_POST['comments'], 0, 30);
// Add an ellipsis
print '...';