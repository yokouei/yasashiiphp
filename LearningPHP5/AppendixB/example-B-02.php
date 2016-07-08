// Test the value of $_POST['zip'] against the
// pattern ^\d{5}(-\d{4}?$
if (preg_match('/^\d{5}(-\d{4})?$/',$_POST['zip'])) {
    print $_POST['zip'] . ' is a valid US ZIP Code';
}

// Test the value of $html against the pattern <b>[^<]+</b>
// The delimiter is @ since / occurs in the pattern
$is_bold = preg_match('@<b>[^<]+</b>@',$html);