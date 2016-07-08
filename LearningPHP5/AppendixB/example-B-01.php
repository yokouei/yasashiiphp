$meats = "<b>Chicken</b>, <b>Beef</b>, <b>Duck</b>";

// With a non-greedy quantifier, each meat is matched separately
preg_match_all('@<b>.*?</b>@',$meats,$matches);
foreach ($matches[0] as $meat) {
    print "Meat A: $meat\n";
}

// With a greedy quantifier, the whole string is matched just once
preg_match_all('@<b>.*</b>@',$meats,$matches);
foreach ($matches[0] as $meat) {
    print "Meat B: $meat\n";
}