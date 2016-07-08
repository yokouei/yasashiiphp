print '<input type="checkbox" name="delivery" value="yes";
if ($defaults['delivery'] == 'yes') { print ' checked="checked"'; }
print '> Delivery?';

print '<input type="radio" name="size" value="small";
if ($defaults['size'] == 'small') { print ' checked="checked"'; }
print '> Small ';
print '<input type="radio" name="size" value="medium";
if ($defaults['size'] == 'medium') { print ' checked="checked"'; }
print '> Medium';
print '<input type="radio" name="size" value="large";
if ($defaults['size'] == 'large') { print ' checked="checked"'; }
print '> Large';