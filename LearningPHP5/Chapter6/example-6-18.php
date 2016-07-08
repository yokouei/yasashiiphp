$sweets = array('Sesame Seed Puff','Coconut Milk Gelatin Square',
                 'Brown Sugar Cake','Sweet Rice and Meat');

// Display the form
function show_form() {
    print<<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Your Order: <select name="order">

_HTML_;
foreach ($GLOBALS['sweets'] as $choice) {
    print "<option>$choice</option>\n";
}
print<<<_HTML_
</select>
<br/>
<input type="submit" value="Order">
<input type="hidden" name="_submit_check" value="1">
</form>
_HTML_;
}