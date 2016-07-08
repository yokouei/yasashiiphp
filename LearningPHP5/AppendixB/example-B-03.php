// Test the value of $_POST['zip'] against the
// pattern ^\d{5}(-\d{4}?$
if (preg_match('/^(\d{5})(-\d{4})?$/',$_POST['zip'],$matches)) {
    // $matches[0] contains the entire zip
    print "$matches[0] is a valid US ZIP Code\n";
    // $matches[1] contains the five digit part inside the first
    // set of parentheses
    print "$matches[1] is the five-digit part of the ZIP Code\n";
    // If they were present in the string, the hyphen and ZIP+4 digits
    // are in $matches[2]
    if (isset($matches[2])) {
        print "The ZIP+4 is $matches[2];";
    } else {
        print "There is no ZIP+4";
    }
}

// Test the value of $html against the pattern @<b>[^<]+</b>
// The delimiter is @ since / occurs in the pattern
$is_bold = preg_match('@<b>([^<]+)</b>@',$html,$matches);
if ($is_bold) {
    // $matches[1] contains what's inside the bold tags
    print "The bold text is: $matches[1]";
}