<?php
$_POST['comments'] = "The Fresh Fish with Rice Noodle was delicious, but I didn't like the Beef Tripe";
// Grab the first thirty characters of $_POST['comments']
print substr($_POST['comments'], 0, 30);
// Add an ellipsis
print '...';
?>