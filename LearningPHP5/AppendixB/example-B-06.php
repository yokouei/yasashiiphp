$ok_html  = "I <b>love</b> shrimp dumplings.";
$bad_html = "I <b>love</i> shrimp dumplings.";

if (preg_match('@<[bi]>.*?</[bi]>@',$ok_html)) {
    print "Good for you! (OK, No backreferences)\n";
}
if (preg_match('@<[bi]>.*?</[bi]>@',$bad_html)) {
    print "Good for you! (Bad, No backreferences)\n";
}
if (preg_match('@<([bi])>.*?</\\1>@',$ok_html)) {
    print "Good for you! (OK, Backreferences)\n";
}
if (preg_match('@<([bi])>.*?</\\1>@',$bad_html)) {
    print "Good for you! (Bad, Backreferences)\n";
}