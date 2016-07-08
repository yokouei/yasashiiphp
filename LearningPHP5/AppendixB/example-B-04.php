if (preg_match('/^(\d{5})(-(\d{4}))?$/',$_POST['zip'],$matches)) {
    print "The beginning of the ZIP Code is: $matches[1]\n";
    // $matches[2] contains what's in the second set of parentheses:
    // The hyphen and the last four digits
    // $matches[3] contains just the last four digits
    if (isset($matches[2])) {
        print "The ZIP+4 is: $matches[3]";
    }
}